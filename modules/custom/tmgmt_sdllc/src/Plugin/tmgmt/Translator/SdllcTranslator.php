<?php
namespace Drupal\tmgmt_sdllc\Plugin\tmgmt\Translator;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\tmgmt\Entity\Job;
use Drupal\tmgmt\JobInterface;
use Drupal\tmgmt\Translator\AvailableResult;
use Drupal\tmgmt\Translator\TranslatableResult;
use Drupal\tmgmt\TranslatorInterface;
use Drupal\tmgmt\TranslatorPluginBase;
use Drupal\tmgmt_sdllc\Plugin\tmgmt\Format\SdlXliff;
use Drupal\Core\Datetime\DrupalDateTime;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\tmgmt\ContinuousTranslatorInterface;
use Drupal\tmgmt_sdllc\Model\Credentials;
use Drupal\tmgmt_sdllc\Helper\LanguageMapHelper;
use Drupal\tmgmt_sdllc\Helper\JobHelper;
use Drupal\tmgmt_sdllc\Model\ProjectId;
//SDLCON-32
use Drupal\Core\File\FileSystemInterface;

/**
 * SDL Language Cloud translator plugin.
 *
 * @TranslatorPlugin(
 * id = "sdllc",
 * label = @Translation("SDL Translation Management"),
 * description = @Translation("SDL Translation Management connector."),
 * ui = "Drupal\tmgmt_sdllc\SdllcTranslatorUi"
 * )
 */
class SdllcTranslator extends TranslatorPluginBase implements ContainerFactoryPluginInterface, ContinuousTranslatorInterface
{

    /**
     *
     * {@inheritdoc}
     */
    public function requestJobItemsTranslation(array $job_items)
    {
        /** @var \Drupal\tmgmt\JobInterface $job */
        $job = reset($job_items)->getJob();

        $this->requestTranslation($job);
    }

    /**
     * Guzzle HTTP client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * SDL Language Cloud Project Options.
     *
     * @var \Drupal\tmgmt_sdllc\Mantra\Model\PortalJobOptions
     */
    protected $projectOptions;

    /**
     * Constructs a LocalActionBase object.
     *
     * @param \GuzzleHttp\ClientInterface $client
     *            The Guzzle HTTP client.
     * @param array $configuration
     *            A configuration array containing information about the plugin
     *            instance.
     * @param string $plugin_id
     *            The plugin_id for the plugin instance.
     * @param array $plugin_definition
     *            The plugin implementation definition.
     */
    //SDLCON-32
    protected $fileSystem;

    public function __construct(ClientInterface $client, array $configuration, $plugin_id, array $plugin_definition,FileSystemInterface $file_system)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);

        $this->client = $client;
        $this->fileSystem = $file_system; //SDLCON-32
    }

    /**
     *
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static($container->get('http_client'), $configuration, $plugin_id, $plugin_definition);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function checkTranslatable(TranslatorInterface $translator, JobInterface $job)
    {
        return TranslatableResult::yes();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function defaultSettings()
    {
        return [
            'sdllc_url' => 'https://languagecloud.sdl.com',
            'sdllc_client_id' => '',
            'sdllc_client_secret' => '',
            'sdllc_username' => '',
            'sdllc_password' => '',
            // 'sdllc_project_options_name' => '',
            // 'sdllc_project_options_id' => 'id',.
            'sdllc_export_format' => 'xlf',
            'xliff_processing' => FALSE,
            'sdllc_suppress_check' => '1',
            'scheme' => 'public'
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getSupportedTargetLanguages(TranslatorInterface $translator, $source_language)
    {
        if (isset($this->projectOptions)) {
            $target_languages = [];

            $language_pairs = $this->projectOptions->getLanguagePairs();
            $sdl_source_language = sdllc_helper_map_language_drupal_to_sdllc($source_language);

            foreach ($language_pairs as $lp) {
                if ($lp->getSource()->getCode() == $sdl_source_language) {
                    $target_languages[] = LanguageMapHelper::sdllc_helper_map_language_sdllc_to_drupal($lp->getTarget()->getCode());
                }
            }
        }

        return drupal_map_assoc($target_languages);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function checkAvailable(TranslatorInterface $translator)
    {
        if ($translator->getSetting('sdllc_url')) {
            return AvailableResult::yes();
        }
        return AvailableResult::no(t('@translator has not been configured yet.'));
    }

    /**
     * Gets remote language mappings.
     */
    public function getRemoteLanguagesMappings()
    {
        $local_list = \Drupal::languageManager()->getLanguages();
        $remote_list = [];

        foreach ($local_list as $local) {
            $remote_list[$local->getId()] = sdllc_helper_map_language_drupal_to_sdllc($local->getId());
        }

        return $remote_list;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getDefaultRemoteLanguagesMappings()
    {
        return LanguageMapHelper::sdllc_helper_get_language_map_drupal_to_sdllc();
    }

    /**
     * Gets the job's composite name.
     */
    protected function getJobNameStem(JobInterface $job)
    {
        return $job->id() . '_' . $job->getRemoteSourceLanguage() . '_' . $job->getRemoteTargetLanguage();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function requestTranslation(JobInterface $job)
    {
        try {

            $credentials = new Credentials($job);

            $job_name = LanguageMapHelper::sdllc_helper_sanitize_name($job->getSetting('sdllc_job_name'));
            $job_description = $job->getSetting('sdllc_job_description');

            $project_options_id = strtolower($job->getSetting('sdllc_project_options'));
            $source_language = strtoupper($job->getRemoteSourceLanguage());
            $target_language = strtoupper($job->getRemoteTargetLanguage());

            $xxx = $job->getSetting('sdllc_job_due_date');
            $xxx2 = $job->getData();

            $required_date = $this->convertToUtc($xxx);
            $suppress_option = $job->getSetting('sdllc_suppress_check');

            $source_files = $this->prepareSource($job);

            if (count($source_files) == 0) {

                $job->setState(Job::STATE_REJECTED, 'Error submitting jobs. Failed to prepare source files.', [], 'error');
                return;
            }

            $uploaded_files = sdllc_helper_upload_source_file($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project_options_id, $source_files);

            if (count($uploaded_files) == 0) {
                $job->setState(Job::STATE_UNPROCESSED, 'Error submitting jobs. Failed to upload source files.', [], 'error');
                return;
            }

            foreach ($uploaded_files as $file) {
                $file->setExpiryDate($required_date);
            }

            $job_params = new \StdClass();
            $job_params->project_options_id = $project_options_id;
            $job_params->name = $job_name;
            $job_params->description = $job_description;
            $job_params->dueDate = $required_date;
            $job_params->srcLang = $source_language;

            $job_params->fileIds = $uploaded_files;
            $job_params->targetLanguage = $target_language;

            $create_project_response = sdllc_helper_create_project($credentials->username, $credentials->password, $credentials->clientId, $credentials->clientSecret, $credentials->sdllcUrl, $job_params);

            if ($job->isContinuous()) {

                $listOfProjectIds = [];
                $jobSettings = $job->getSetting('sdllc_project_id');
                
                $items = $job->getItems();
                $item = end($items);
                $nodeId = $item->id();
                
                $project = new ProjectId();
                $project->projectId = $create_project_response->getProjectId();
                $project->nodeId = $nodeId;
                $project->status = 'Pending';

                if ($jobSettings == NULL) {
                    array_push($listOfProjectIds, $project);
                } else {
                    $listOfProjectIds = json_decode($jobSettings);

                    array_push($listOfProjectIds, $project);
                }

                $sdlProjectIds = json_encode($listOfProjectIds);
            } else {
                $sdlProjectIds = $create_project_response->getProjectId();
            }

            $job->get('settings')->__set('sdllc_project_id', $sdlProjectIds);
            $job->get('settings')->__set('sdllc_suppress_check', $suppress_option);
            $this->giveSuccessMessages($job);
            $job->submitted();
            return;
        } catch (\Exception $e) {
            $job->setState(Job::STATE_UNPROCESSED, 'Failed to create project. Error: ' . $e->getMessage(), [], 'error');
        }
    }

    /**
     * After the job has been with success give all the green messages
     *
     * @param \Drupal\tmgmt\JobInterface $job
     *            The tmgmt_job object.
     */
    public function giveSuccessMessages(JobInterface $job)
    {
        foreach ($job->getItems() as $item) {
            if ($item->getState() == "0") {
                $item->active();

                $name = $item->label() ? $item->label() : $item->getItemId();

                $name = LanguageMapHelper::sdllc_helper_sanitize_name($name);

                $name = $name . '_' . $item->getItemId();

                $path_xlf = JobHelper::sdllc_helper_get_job_folder($job) . '/' . $name . '.' . 'xlf';

                $job->addMessage('Exported file for item (@itemlabel) can be downloaded <a href="@link_xlf">here</a>.', [
                    '@itemlabel' => $item->label(),
                    '@link_xlf' => file_create_url($path_xlf)
                ]);
            }
        }
    }

    /**
     * Convert DateTime value from user time zone to UTC.
     *
     * @param \Drupal\Core\Datetime\DrupalDateTime $time
     *            DateTime object.
     *            
     * @return \Drupal\Core\Datetime\DrupalDateTime DateTime object.
     */
    private function convertToUtc($time)
    {
        $date = new DrupalDateTime($time, new \DateTimeZone(drupal_get_user_timezone()));
        $date->setTimezone(new \DateTimeZone('UTC'));

        return $date;
    }

    /**
     * Prepare source files for translation.
     *
     * @param \Drupal\tmgmt\JobInterface $job
     *            The tmgmt_job object.
     *            
     * @return array Array of file paths.
     */
    private function prepareSource(JobInterface $job)
    {
        $export = new SdlXliff();
        $files = [];
        foreach ($job->getItems() as $item) {
            if ($item->getState() == "0") {

                $name = $item->label() ? $item->label() : $item->getItemId();

                $name = LanguageMapHelper::sdllc_helper_sanitize_name($name);
                
                $name = $name . '_' . $item->getItemId();

                $path_xlf = JobHelper::sdllc_helper_get_job_folder($job) . '/' . $name . '.' . 'xlf';

                $dirname = dirname($path_xlf);

                if ($this->fileSystem->prepareDirectory($dirname, FileSystemInterface::CREATE_DIRECTORY)) {                    $itemData = $export->exportJobItem($item);
                    //SDLCON-33 : FILE_EXISTS_REPLACE is depricated 
                    $file_xlf = file_save_data($itemData, $path_xlf, \Drupal::service('file_system')::EXISTS_REPLACE);
                    \Drupal::service('file.usage')->add($file_xlf, 'tmgmt_sdllc', 'tmgmt_job', $job->id());

                    $files[$file_xlf->getFilename()] = $path_xlf;
                }
            }
        }

        return $files;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function mapToLocalLanguage($language)
    {
        return LanguageMapHelper::sdllc_helper_map_language_sdllc_to_drupal(strtolower($language));
    }

    /**
     *
     * {@inheritdoc}
     */
    public function mapToRemoteLanguage($language)
    {
        return strtoupper(sdllc_helper_map_language_drupal_to_sdllc($language));
    }

    /**
     *
     * {@inheritdoc}
     */
    public function hasCheckoutSettings(JobInterface $job)
    {
        return TRUE;
    }

    /**
     * Gets the Http Client.
     *
     * @return \GuzzleHttp\ClientInterface The Http Client.
     */
    public function getHttpClient()
    {
        return $this->client;
    }

    /**
     * Gets the project options.
     *
     * @return \Drupal\tmgmt_sdllc\Mantra\Model\PortalJobOptions The PortalJobOptions object.
     */
    public function getProjectOptions()
    {
        return $this->projectOptions;
    }
}
