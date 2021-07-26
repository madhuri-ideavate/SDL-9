<?php
namespace Drupal\tmgmt_sdllc\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tmgmt_sdllc\Datatable\DatatableSettings;
use Drupal\tmgmt_sdllc\MantraLibrary\MantraTranslationAPI;
use Drupal\tmgmt\Entity\Translator;
use Symfony\Component\HttpFoundation\Request;
use Drupal\tmgmt_sdllc\Logger\LogWriter;

/**
 * Class JobsOverviewController.
 *
 * @package Drupal\tmgmt_sdllc\Controller
 */
class JobsOverviewController extends ControllerBase
{

    /**
     * Mantra API.
     *
     * @var \Drupal\tmgmt_sdllc\Mantra\MantraLibrary\MantraTranslationAPI
     */
    protected $mantraApi;

    /**
     * The translation manager.
     *
     * @var \Drupal\tmgmt\Entity\Translator
     */
    protected $translator;

    /**
     * Initialise MantraApi.
     *
     * @return \Drupal\tmgmt_sdllc\Mantra\MantraLibrary\MantraTranslationAPI A MantraApi Class.
     */
    private function initMantraApi()
    {
        LogWriter::info('Initializing Mantra on Jobs Overview');
        try {
            $client_id = $this->translator->getSetting('sdllc_client_id');
            $client_secret = $this->translator->getSetting('sdllc_client_secret');
            $username = $this->translator->getSetting('sdllc_username');
            $password = $this->translator->getSetting('sdllc_password');
            $sdllc_url = $this->translator->getSetting('sdllc_url');

            LogWriter::info('Making Auth on Mantra API by user: ' . $username);

            $sdllc_client = new MantraTranslationAPI();

            $sdllc_client->connect($username, $password, $client_id, $client_secret, $sdllc_url);
        } catch (\Exception $e) {

            LogWriter::error('Mantra Authentification failed on Jobs Overview for user: ' . $username . 'with message: ' . $e->getMessage());

            throw new \Exception('Mantra Authentification failed: ' . $e->getMessage(), 0, $e);
            return;
        }

        LogWriter::info('Finish initializing Mantra on Jobs Overview');

        return $sdllc_client;
    }

    /**
     * Gets a list of projects.
     *
     * @return array|void Array of Drupal\tmgmt_sdllc\Mantra\Model\PortalJobStatus.
     */
    private function getProjects()
    {
        LogWriter::info('Getting projects from Mantra on Jobs Overview');
        try {
            return $this->mantraApi->getProjectsList();
        } catch (\Exception $e) {

            LogWriter::error('Failed to get project list with message: ' . $e->getMessage());

            throw new \Exception('Failed to get project list: ' . $e->getMessage(), 0, $e);

            return;
        }
        LogWriter::info('Finished getting projects from Mantra on Jobs Overview');
    }

    /**
     * Returns an overview table with all Mantra projects.
     *
     * @return array The render array for the string search screen.
     */
    public function jobOverView(Request $request)
    {
        LogWriter::info('Start Jobs Overview page');
        $params = $request->query->all();
        $requestVariables = $request->attributes->all();
        $build = [];

        $dataTable = new DatatableSettings();

        $build['table'] = $dataTable->returnTableSettings();

        $build['table']['#header'] = $dataTable->returnHeaderSettings();
        try {
            $translators = Translator::loadMultiple();

            if (isset($requestVariables['tmgmt_id']) && $translators[$requestVariables['tmgmt_id']]) {
                $this->translator = $translators[$requestVariables['tmgmt_id']];
            } else {
                throw new \Exception('Translator machine name not found.');
            }
            $this->mantraApi = $this->initMantraApi();

            $projects = $this->getProjects();
            foreach ($projects as $project) {
                $language = '';
                $i = 0;
                foreach ($project->getLanguagePairDetails() as $pair) {
                    $language .= $pair->getLanguage()->getShortName();
                    if ($i < count($project->getLanguagePairDetails()) && count($project->getLanguagePairDetails()) > 1) {
                        $language .= ', ';
                    }
                    $i ++;
                }
                $delivery_date = $project->getStatus() > 2 ? date('M j, Y', strtotime($project->getDeliveredDate())) : '';
                $build['table']['#rows'][] = [
                    $project->getProviderJobId(),
                    $project->getName(),
                    $project->getCreatedByUserName(),
                    $language,
                    $project->getJobOptionsName(),
                    date('M j, Y', strtotime($project->getDueDate())),
                    $delivery_date,
                    $project->getStatusName(),
                    $project->getCurrency()->getSymbol() . number_format($project->getCost(), 2)
                ];
            }
        } catch (\Exception $e) {

            LogWriter::error('Failed to show Jobs Overview page');

          \Drupal::messenger()->addMessage($this->t($e->getMessage()), 'error');

            return array(
                '#type' => 'markup',
                '#markup' => ''
            );
        }

        LogWriter::info('Finished Jobs Overview page');

        return $build;
    }
}
