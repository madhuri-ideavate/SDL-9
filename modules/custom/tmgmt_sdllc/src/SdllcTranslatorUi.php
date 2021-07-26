<?php

namespace Drupal\tmgmt_sdllc;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tmgmt\JobInterface;
use Drupal\tmgmt\TranslatorPluginUiBase;
use Drupal\tmgmt_sdllc\Plugin\tmgmt\Format\SdlXliff;
use Drupal\tmgmt\Entity\Job;
use Drupal\tmgmt_sdllc\Model\Credentials;
use Drupal\tmgmt_sdllc\FormModel\ConfigurationFormModel;
use Drupal\tmgmt_sdllc\Helper\LanguageMapHelper;
use Drupal\tmgmt_sdllc\Helper\JobHelper;
use Drupal\tmgmt_sdllc\FormModel\CheckoutSettingsFormModel;
use Drupal\tmgmt_sdllc\Logger\LogWriter;

/**
 * Sdllc translator UI.
 */
class SdllcTranslatorUi extends TranslatorPluginUiBase
{

  /**
   *
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    LogWriter::info('Initializing SDL Configuration for Provider page');

    $form = parent::buildConfigurationForm($form, $form_state);

    $translator = $form_state->getFormObject()->getEntity();
    $configModel = new ConfigurationFormModel($translator);

    $form['sdllc_url'] = $configModel->sdllc_url;
    $form['sdllc_client_id'] = $configModel->sdllc_client_id;
    $form['sdllc_client_secret'] = $configModel->sdllc_client_secret;
    $form['sdllc_username'] = $configModel->sdllc_username;
    $form['sdllc_password'] = $configModel->sdllc_password;
    $form['sdllc_previously_translated_fields_options'] = $configModel->sdllc_previously_translated_fields_options;
    $form['xliff_processing'] = $configModel->xliff_processing;
    $form['sdllc_download_as_zip'] = $configModel->sdllc_download_as_zip;

    LogWriter::info('Finishing SDL Configuration for Provider page');

    return $form;
  }

  /**
   *
   * {@inheritdoc}
   */
  public function checkoutSettingsForm(array $form, FormStateInterface $form_state, JobInterface $job)
  {
    try {
      LogWriter::info('Start checkout settings form on job page');
      $sdllcProjectOptions = $job->getSetting("sdllc_project_options");
      $sdllcDueDate = $job->getSetting("sdllc_job_due_date");
      /*
       * Get the translator for the job
       */
      $translator = $job->getTranslator();
      /*
       * Set all the credentials
       */
      $credentials = new Credentials($job);
      /*
       * get job label and sanitize the name
       */
      $label = LanguageMapHelper::sdllc_helper_sanitize_name($job->label(), 50);
      $job->set('label', $label);
      /*
       * Get job project options
       */
      $project_creation_options = sdllc_helper_get_project_creation_options($credentials);

      $sdllc_project_options = [];
      if (isset($project_creation_options)) {
        foreach ($project_creation_options as $value) {
          $sdllc_project_options[$value->getId()] = $value->getName();
        }
      }

      $checkoutModel = new CheckoutSettingsFormModel();

      $form['sdllc_project_options'] = $checkoutModel->sdllcProjectOptions($sdllc_project_options, $sdllcProjectOptions);

      $form['sdllc_job_name'] = $checkoutModel->sdllcJobName($label);

      $form['sdllc_job_description'] = $checkoutModel->sdllcJobDescription();

      $form['sdllc_job_due_date'] = $checkoutModel->sdllcJobDueDate($sdllcDueDate);

      $form['sdllc_previously_translated_fields_options'] = [
        '#type' => 'select',
        '#title' => t('Field Export options'),
        '#options' => [
          0 => t('Do not include previously translated field content'),
          1 => t('Include previously translated field content')
        ],
        '#default_value' => $translator->getSetting('sdllc_previously_translated_fields_options'),
        '#description' => t('Export options for previously translated field contents.'),
        '#required' => FALSE
      ];

      LogWriter::info('Start checkout settings form on job page');

      return parent::checkoutSettingsForm($form, $form_state, $job);
    } catch (\Exception $e) {

      LogWriter::error('Failed to show checkout Settings Form');

      \Drupal::messenger()->addMessage(t($e->getMessage()), 'error');
    }
  }

  /**
   *
   * {@inheritdoc}
   */
  public function checkoutInfo(JobInterface $job)
  {
    // If the job is finished, it's not possible to import translations
    // anymore.
    if (!$job->isFinished() && !$job->isAborted()) {
      $job_status = $this->getProjectStatus($job);

      if ($job_status) {

        $job->get('settings')->__set('sdllc_job_id', $job_status->getProviderJobId());
        $job->get('settings')->__set('sdllc_job_name', $job_status->getName());
        $job->get('settings')->__set('sdllc_job_description', $job_status->getDescription());
        $job->get('settings')->__set('sdllc_project_options', $job_status->getJobOptionsName());
        $job->get('settings')->__set('sdllc_job_status', $job_status->getStatus());
        $job->get('settings')->__set('sdllc_job_status_name', $job_status->getStatusName());

        $job->get('settings')->__set('sdllc_job_summary', $this->getJobSummary($job_status));

        $job->get('settings')->__set('sdllc_cost_summary', $this->getCostSummary($job_status));

        $job->get('settings')->__set('sdllc_file_costs', $this->getFileCost($job_status));

        $job->save();
      }
    }

    $form = [
      '#type' => 'details',
      '#title' => t('SDL Translation Management Information'),
      '#open' => TRUE
    ];

    $project_status = $job->getSetting('sdllc_job_status');

    $project_info_rows = $job->getSetting('sdllc_job_summary');

    $form['project_info'] = [
      '#type' => 'table',
      '#name' => 'project-info',
      '#rows' => $project_info_rows,
      '#attributes' => [
        'class' => [
          'tmgmt-sdllc-project-info'
        ]
      ]
    ];

    $form['description_info'] = [
      '#type' => 'table',
      '#name' => 'description-info',
      '#rows' => [
        [
          'name' => 'Description',
          'value' => $job->getSetting('sdllc_job_description')
        ],
        [
          'name' => 'Field Export Option',
          'value' => $job->getSetting('sdllc_previously_translated_fields_options') == 1 ? 'Include previously translated field content' : 'Do not include previously translated field content'
        ]
      ],
      '#attributes' => [
        'class' => [
          'tmgmt-sdllc-description-info'
        ]
      ]
    ];

    $form['stat_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => t('Cost Summary')
    ];

    $cost_rows = $job->getSetting('sdllc_cost_summary');

    $form['stat_fieldset']['cost_summary'] = [
      '#type' => 'table',
      '#name' => 'cost-summary',
      '#rows' => $cost_rows,
      '#attributes' => [
        'class' => [
          'tmgmt-sdllc-cost-summary'
        ]
      ]
    ];

    $form['wc_file_info_defail'] = [
      '#type' => 'details',
      '#name' => 'wc-cost-info',
      '#title' => t('Cost Details')
    ];

    $wc_cost_file_header = [
      'file' => 'Filename',
      'lp' => t('Language'),
      'pm' => t('PerfectMatch'),
      'hw' => t('Hundred'),
      'fw' => t('Fuzzy'),
      'nw' => t('New'),
      'tw' => t('Total Words'),
      'tl' => t('TM Leverage'),
      'ts' => t('TM Savings'),
      'tc' => t('Total Cost')
    ];

    $wc_cost_file_rows = $job->getSetting('sdllc_file_costs');

    $form['wc_file_info_defail']['wc_cost_info'] = [
      '#type' => 'table',
      '#name' => 'wc-cost-file-info',
      '#header' => $wc_cost_file_header,
      '#rows' => $wc_cost_file_rows
    ];

    // Buttons.
    if ((!$job->isFinished() && !$job->isAborted()) || ($job->isFinished() && $project_status != 4)) {
      $form['actions']['update_status'] = [
        '#type' => 'submit',
        '#value' => t('Update Status'),
        '#submit' => [
          [
            $this,
            'updateStatusSubmit'
          ]
        ],
        '#executes_submit_callback' => TRUE
      ];

      $form['actions']['download_quote'] = [
        '#type' => 'submit',
        '#value' => t('Download Quote'),
        '#disabled' => $project_status > 0 ? FALSE : TRUE,
        '#submit' => [
          [
            $this,
            'downloadQuoteSubmit'
          ]
        ],
        '#executes_submit_callback' => TRUE
      ];

      $form['actions']['approve'] = [
        '#type' => 'submit',
        '#value' => t('Approve Project'),
        '#disabled' => $project_status == 1 ? FALSE : TRUE,
        '#submit' => [
          [
            $this,
            'approveSubmit'
          ]
        ],
        '#executes_submit_callback' => TRUE
      ];
      $form['actions']['retrieve_translation'] = [
        '#type' => 'submit',
        '#value' => t('Retrieve Translation'),
        '#disabled' => $project_status == 3 || $project_status == 4 ? FALSE : TRUE,
        '#submit' => [
          [
            $this,
            'retrieveTranslationSubmit'
          ]
        ],
        '#executes_submit_callback' => TRUE
      ];
      /*
       * For SDL Language Cloud, the cancel and complete are the same.
       */
      $can_close = $job->getSetting('sdllc_allow_close');
      $disable_complete = TRUE;
      if (isset($can_close) && $can_close && $project_status > 2) {
        $disable_complete = FALSE;
      }
      if ($project_status <= 2) {
        $disable_complete = FALSE;
      }
      $form['actions']['cancel'] = [
        '#type' => 'submit',
        '#value' => $project_status > 2 ? t('Complete Project') : t('Cancel Project'),
        '#disabled' => $disable_complete,
        '#submit' => [
          [
            $this,
            'cancelSubmit'
          ]
        ],
        '#executes_submit_callback' => TRUE
      ];
    }

    $form['#attached']['library'][] = 'tmgmt_sdllc/jobinfo';

    return $this->checkoutInfoWrapper($job, $form);
  }

  /**
   * Gets the cost for a file.
   *
   * @param \Drupal\tmgmt_sdllc\Mantra\Model\PortalJobStatus $job_status
   *            PortalJobStatus object.
   *
   * @return array A cost array.
   */
  private function getFileCost($job_status)
  {
    $cost = [];

    foreach ($job_status->getLanguagePairDetails() as $lp_cost) {
      foreach ($lp_cost->getFiles() as $file) {
        $cost[] = [
          'file' => $file->getName(),
          'lp' => $file->getLanguage(),
          'pm' => number_format($file->getPerfectMatchWords()),
          'hw' => number_format($file->getHundredWords()),
          'fw' => number_format($file->getFuzzyWords()),
          'nw' => number_format($file->getNewWords()),
          'tw' => number_format($file->getTotalWords()),
          'tl' => number_format($file->getTmLeverage(), 2),
          'ts' => number_format($file->getTmSavings(), 2),
          'tc' => number_format($file->getCost(), 2)
        ];
      }
    }

    return $cost;
  }

  /**
   *
   * {@inheritdoc}
   */
  private function getFileIds($job_status)
  {
    $file_ids = [];

    foreach ($job_status->getLanguagePairDetails() as $lp_cost) {
      foreach ($lp_cost->getFiles() as $file) {
        $file_ids[$file->getId()] = [
          'name' => $file->getName(),
          'language' => $file->getLanguage()
        ];
      }
    }

    return $file_ids;
  }

  /**
   *
   * {@inheritdoc}
   */
  private function getCostSummary($job_status)
  {
    $cost = [];
    $symbol = $job_status->getCurrency()->getSymbol();

    foreach ($job_status->getCostDetails() as $cd) {
      $lp = $cd->getLanguage()->getName();
      $comment = $cd->getComment();
      $name = $cd->getName();
      $name = $comment ? $name . ' - ' . $comment : $name;
      $name = $lp ? $name . ' - ' . $lp : $name;
      $name = $symbol ? $name . ' (' . $symbol . ')' : $name;

      $cost[] = [
        'name' => $name,
        'value' => number_format($cd->getValue(), 2)
      ];
    }

    $cost[] = [
      'name' => $symbol ? 'Total Cost (' . $symbol . ')' : 'Total Cost',
      'value' => number_format($job_status->getCost(), 2)
    ];
    return $cost;
  }

  /**
   *
   * {@inheritdoc}
   */
  private function getJobSummary($job_status)

  {
    $summary = [];

    $summary[] = [
      'c1' => 'Name',
      'c2' => $job_status->getName(),
      'c3' => 'PerfectMatch Words',
      'c4' => number_format($job_status->getPerfectMatchWords())
    ];

    $summary[] = [
      'c1' => 'ID',
      'c2' => $job_status->getProviderJobId(),
      'c3' => 'Hundred Words',
      'c4' => number_format($job_status->getHundredWords())
    ];

    $summary[] = [
      'c1' => 'Project Options',
      'c2' => $job_status->getJobOptionsName(),
      'c3' => 'Fuzzy Words',
      'c4' => number_format($job_status->getFuzzyWords())
    ];

    $summary[] = [
      'c1' => 'Created Date',
      'c2' => date('Y-m-d H:i:s', strtotime($job_status->getCreatedDate())),
      'c3' => 'New Words',
      'c4' => number_format($job_status->getNewWords())
    ];

    $summary[] = [
      'c1' => 'Due Date',
      'c2' => date('Y-m-d H:i:s', strtotime($job_status->getDueDate())),
      'c3' => 'Repeated Words',
      'c4' => number_format($job_status->getRepeatedWords())
    ];

    $summary[] = [
      'c1' => 'Status',
      'c2' => $job_status->getStatusName(),
      'c3' => 'Total Words',
      'c4' => number_format($job_status->getWordCount())
    ];

    return $summary;
  }

  /**
   * Retrieve project status.
   *
   * @param \Drupal\tmgmt\JobInterface $job
   *            The JobInterface object.
   *
   * @return null|\Drupal\tmgmt_sdllc\Mantra\Model\R PortalJobStatus object.
   */
  private function getProjectStatus(JobInterface $job)
  {
    $credentials = new Credentials($job);

    $project_id = $job->getSetting('sdllc_project_id');

    if ($job->isContinuous()) {
      $listOfProjectsFromMemory = json_decode($project_id);
      $listOfProjectsFromManTra = [];
      $listOfProjectsChanged = [];

      foreach ($listOfProjectsFromMemory as $project) {
        if ($project->status == "Pending" || $project->status == "ForDownload") {
          $job_status = sdllc_helper_get_project_status($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project->projectId);

          if ($job_status->getStatus() == 3) {
            $project->status = "ForDownload";
            array_push($listOfProjectsFromManTra, $job_status);
          }

          array_push($listOfProjectsChanged, $project);
        } else {
          array_push($listOfProjectsChanged, $project);
        }
      }

      $cacheProjectIds = json_encode($listOfProjectsChanged);

      $job->get('settings')->__set('sdllc_project_id', $cacheProjectIds);
      $job->submitted();

      if (!isset($listOfProjectsFromManTra)) {
        $job->addMessage('Failed to retrieve project statuses from SDL Translation Management.');
      }

      return $listOfProjectsFromManTra;
    } else {
      if (!$project_id) {
        $job->addMessage('Failed to retrieve SDL Translation Management Project ID.');
        return NULL;
      }

      $job_status = sdllc_helper_get_project_status($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project_id);

      if (!isset($job_status)) {
        $job->addMessage('Failed to retrieve project status from SDL Translation Management.');
        return NULL;
      }

      return $job_status;
    }
  }

  /**
   * Download project quote.
   *
   * @param \Drupal\tmgmt\JobInterface $job
   *            The tmgmt_job entity.
   *
   * @return null|string The filepath where the quote is downloaded.
   */
  private function downloadQuote(JobInterface $job)
  {
    $project_id = $job->getSetting('sdllc_project_id');

    $credentials = new Credentials($job);

    if (!$project_id) {
      $job->addMessage('Failed to retrieve SDL Translation Management Project ID.');
      return NULL;
    }

    $quote_filename = 'Quote_' . $job->id() . '.xls';
    $quote_file_path = JobHelper::sdllc_helper_get_job_folder($job) . '/' . $quote_filename;

    $saved_quote_file_path = sdllc_helper_download_project_quote($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project_id, $quote_file_path);

    if (!$saved_quote_file_path) {
      $job->addMessage('Failed to download project quote from SDL Translation Management.');
      return NULL;
    }

    \Drupal::service('file.usage')->add($saved_quote_file_path, 'tmgmt_sdllc', 'tmgmt_job', $job->id());

    $job->addMessage('Translation quote downloaded successfully. Quote file can be retrieved <a href="@link_quote">here</a>.', [
      '@link_quote' => file_create_url($quote_file_path)
    ]);

    return $saved_quote_file_path;
  }

  /**
   * Download target file.
   *
   * @param \Drupal\tmgmt\JobInterface $job
   *            The tmgmt_job entity.
   *
   * @return null|string The downloaded target file path.
   */
  private function downloadTarget(JobInterface $job)
  {
    $project_id = $job->getSetting('sdllc_project_id');

    $credentials = new Credentials($job);

    if (!$project_id) {
      $job->addMessage('Failed to retrieve SDL Translation Management Project ID.');
      return NULL;
    }

    $target_filename = 'Target_' . $job->id() . '.zip';
    $target_file_path = JobHelper::sdllc_helper_get_job_folder($job) . '/' . $target_filename;

    if ($job->isContinuous()) {
      $listOfProjects = json_decode($project_id);

      $saved_target_file_path = sdllc_helper_download_target($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $listOfProjects[0]->projectId, $target_file_path);

      $firstProject = array_shift($listOfProjects);

      array_push($listOfProjects, $firstProject);

      $cacheProjectIds = json_encode($listOfProjects);

      $job->get('settings')->__set('sdllc_project_id', $cacheProjectIds);
      $job->submitted();
    } else {
      $saved_target_file_path = sdllc_helper_download_target($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project_id, $target_file_path);

      if (!$saved_target_file_path) {
        $job->addMessage('Failed to download target file from SDL Translation Management.');
        return NULL;
      }

      \Drupal::service('file.usage')->add($saved_target_file_path, 'tmgmt_sdllc', 'tmgmt_job', $job->id());

      $job->addMessage('Translated files downloaded successfully. Translated can be retrieved <a href="@link_quote">here</a>.', [
        '@link_quote' => file_create_url($target_file_path)
      ]);
    }

    return $saved_target_file_path;
  }

  /**
   * Download target file no zip.
   *
   * @param \Drupal\tmgmt\JobInterface $job
   *            The tmgmt_job entity.
   *
   * @return null|array Array of file paths.
   */
  private function downloadTargetNoZip(JobInterface $job)
  {
    $project_id = $job->getSetting('sdllc_project_id');

    $credentials = new Credentials($job);

    $target_file_path = JobHelper::sdllc_helper_get_job_folder($job) . '/' . 'translated';
    $job_status = $this->getProjectStatus($job);

    if ($job->isContinuous()) {
      $savedTargetFilePaths = [];

      foreach ($job_status as $status) {
        $file_ids = $this->getFileIds($status);

        $projectId = $status->getId();

        $saved_target_file_paths = sdllc_helper_download_target_no_zip($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $projectId, $file_ids, $target_file_path);
        array_push($savedTargetFilePaths, $saved_target_file_paths);
      }

      if (count($savedTargetFilePaths) < 1) {
        $job->addMessage('No target file saved from SDL Translation Management.');
      }

      $target_files = [];
      foreach ($savedTargetFilePaths as $saved_target_file_paths) {
        foreach ($saved_target_file_paths as $file_path) {
          \Drupal::service('file.usage')->add($file_path, 'tmgmt_sdllc', 'tmgmt_job', $job->id());

          $job->addMessage('Translated files downloaded successfully. Translated can be retrieved <a href="@link_quote">here</a>.', [
            '@link_quote' => file_create_url($file_path->getFileUri())
          ]);

          $file_system = \Drupal::service('file_system');
          $target_files[] = $file_system->realpath($file_path->getFileUri());
        }
      }
      return $target_files;
    } else {
      if (!$project_id) {
        $job->addMessage('Failed to retrieve SDL Translation Management Project ID.');
        return NULL;
      }

      if (!$job_status) {
        $job->addMessage('Failed to retrieve the project status from SDL Translation Management for download.');
        return NULL;
      }

      $file_ids = $this->getFileIds($job_status);

      if (count($file_ids) < 0) {
        $job->addMessage('No target file retrieved from cach or SDL Translation Management.');
        return NULL;
      }
      $saved_target_file_paths = sdllc_helper_download_target_no_zip($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project_id, $file_ids, $target_file_path);

      if (count($saved_target_file_paths) < 1) {
        $job->addMessage('No target file saved from SDL Translation Management.');
        return NULL;
      }

      $target_files = [];

      foreach ($saved_target_file_paths as $file_path) {

        \Drupal::service('file.usage')->add($file_path, 'tmgmt_sdllc', 'tmgmt_job', $job->id());

        $job->addMessage('Translated files downloaded successfully. Translated can be retrieved <a href="@link_quote">here</a>.', [
          '@link_quote' => file_create_url($file_path->getFileUri())
        ]);
        $file_system = \Drupal::service('file_system');
        $target_files[] = $file_system->realpath($file_path->getFileUri());
      }

      return $target_files;
    }
  }

  /**
   * We will make the import and save of the content
   */
  private function importTranslation(JobInterface $job, array $files)
  {
    //check the credentials based on the job
    $credentials = new Credentials($job);
    //have all the nodes that are going to be modified
    $nodeIds = [];
    //check all the files
    foreach ($files as $file) {
      $import = new SdlXliff();
      //we must validate the import
      $validate = $import->validateImport($file, $job);

      if (!$validate) {
        $job->addMessage('Failed to validate file (@file) for import.', [
          '@file' => file_create_url($file)
        ]);
      } else {

        try {
          // Validation successful, start import.
          $data = $import->import($file);
          //get the file item
          $fileData = reset($data);
          $fileDataKey = key($data);
          // get the target language
          $target_lang = $job->get('target_language')->getString();

          $items = $job->getItems();
          foreach ($items as $item_id => $job_item) {
            if ($fileDataKey == $item_id) {
              // Mark outdated translations as up-top.
              if ($job_item->getItemType() == 'node') {
                $entity = \Drupal::entityTypeManager()->getStorage($job_item->getItemType())->load($job_item->getItemId());
                $available_languages = $entity->getTranslationLanguages();
                if (array_key_exists($target_lang, $available_languages)) {
                  $translation = $entity->getTranslation($target_lang);
                  $translation->content_translation_outdated->value = 0;
                  $translation->save();
                }
              }
              $translated_data[$item_id] = $fileData;

              array_push($nodeIds, $item_id);
            }

          }
          if (!empty($translated_data)) {
            $job->addTranslatedData($translated_data);
            $job->addMessage('Successfully imported file (@file).', [
              '@file' => drupal_basename($file)
            ]);
          } else {
            $job->addMessage('File import failed with the following message: @message', [
              '@message' => "The file was not provided"
            ], 'error');
          }

          if ($job->isContinuous()) {
            $project_id = $job->getSetting('sdllc_project_id');
            $project_ids = json_decode($project_id);

            foreach ($project_ids as $key => $value) {
              if (in_array($value->nodeId, $nodeIds)) {
                sdllc_helper_cancel_project($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $value->projectId);

                unset($project_ids[$key]);
              }
            }

            $resetArrayKeys = array_values($project_ids);
            $cacheProjectIds = json_encode($resetArrayKeys);
            $job->get('settings')->__set('sdllc_project_id', $cacheProjectIds);
            $job->submitted();

            file_unmanaged_delete($file);
          }
        } catch (Exception $e) {
          $job->addMessage('File import failed with the following message: @message', [
            '@message' => $e->getMessage()
          ], 'error');
        }
      }

      unset($import);
    }
  }

  /**
   *
   * {@inheritdoc}
   */
  private function retrieveTranslation(JobInterface $job)
  {
    $option = $job->getTranslator()->getSetting('sdllc_download_as_zip');
    $extracted_files = [];

    if ($option) {
      $project_id = $job->getSetting('sdllc_project_id');

      if ($job->isContinuous()) {
        $projectIds = json_decode($project_id);
      } else {
        $projectIds = [];

        array_push($projectIds, $project_id);
      }

      foreach ($projectIds as $projectId) {
        $save_target_zip = $this->downloadTarget($job);

        if (!$save_target_zip || empty($projectId)) {
          return;
        }

        $target_folder = JobHelper::sdllc_helper_get_job_folder($job);

        $extracted_path = $target_folder . '/translated';

        $file_system = \Drupal::service('file_system');
        $zip_file_path = $file_system->realpath($save_target_zip->getFileUri());

        $extracted_files = sdllc_helper_extract_zip($zip_file_path, $extracted_path);
      }
    } else {
      $extracted_files = $this->downloadTargetNoZip($job);
    }

    $this->importTranslation($job, $extracted_files);
  }

  /**
   *
   * {@inheritdoc}
   */
  private function approveProject(JobInterface $job)
  {
    $project_id = $job->getSetting('sdllc_project_id');

    $credentials = new Credentials($job);

    if (!$project_id) {
      $job->addMessage('Failed to retrieve SDL Translation Management Project ID.');
      return NULL;
    }

    $approve_result = sdllc_helper_approve_project($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project_id);

    if ($approve_result != 1) {
      $job->addMessage('Failed to approve the project from SDL Translation Management.');
      return NULL;
    }

    $job->addMessage('Project have been successfully approved.');

    return $approve_result;
  }

  /**
   *
   * {@inheritdoc}
   */
  private function cancelProject(JobInterface $job)
  {
    $project_id = $job->getSetting('sdllc_project_id');
    $project_status = $job->getSetting('sdllc_job_status');

    $credentials = new Credentials($job);

    if (!$project_id) {
      $job->addMessage('Failed to retrieve SDL Translation Management Project ID.');
      return NULL;
    }

    $cancel_result = sdllc_helper_cancel_project($credentials->clientId, $credentials->clientSecret, $credentials->username, $credentials->password, $credentials->sdllcUrl, $project_id);

    if ($cancel_result != 1) {
      $job->addMessage(t('Failed to cancel the project from SDL Translation Management.', [
        '@op' => $project_status > 2 ? t('completed') : t('cancelled')
      ]));
      return NULL;
    }

    $job->addMessage(t('Project have been successfully @op.', [
      '@op' => $project_status > 2 ? t('completed') : t('cancelled')
    ]));

    if ($project_status > 2) {

      // Try to retrieve the status one last time after complete.
      $job_status = $this->getProjectStatus($job);

      if ($job_status) {
        // Update the final status before Finishing the project.
        $job->get('settings')->__set('sdllc_job_status', 4);
        $job->get('settings')->__set('sdllc_job_summary', $this->getJobSummary($job_status));

        $job->get('settings')->__set('sdllc_cost_summary', $this->getCostSummary($job_status));

        $job->get('settings')->__set('sdllc_file_costs', $this->getFileCost($job_status));

        $job->save();
      }

      $job->finished(t('Project has been @op in SDL Translation Management.', [
        '@op' => t('completed')
      ]), [], 'Completed');
    } else {
      $job->aborted(t('Project has been @op in SDL Translation Management.', [
        '@op' => t('cancelled')
      ]), [], 'Cancelled');
    }

    return $cancel_result;
  }

  /**
   * Handles submit call of "Update Status" button.
   */
  public function updateStatusSubmit(array $form, FormStateInterface $form_state)
  {
    $form_state->setRebuild();
  }

  /**
   * Handles submit call of "Download Quote" button.
   */
  public function downloadQuoteSubmit(array $form, FormStateInterface $form_state)
  {

    /* @var \Drupal\tmgmt\JobItemInterface $job */
    $job = $form_state->getFormObject()->getEntity();
    $this->downloadQuote($job);
    $form_state->setRebuild();
  }

  /**
   * Handles submit call of "Approve Project" button.
   */
  public function approveSubmit(array $form, FormStateInterface $form_state)
  {

    /* @var \Drupal\tmgmt\JobItemInterface $job */
    $job = $form_state->getFormObject()->getEntity();

    $this->approveProject($job);

    $form_state->setRebuild();
  }

  /**
   * Handles submit call of "Retrieve Translation" button.
   */
  public function retrieveTranslationSubmit(array $form, FormStateInterface $form_state)
  {

    /* @var \Drupal\tmgmt\JobItemInterface $job */
    $job = $form_state->getFormObject()->getEntity();

    $project_id = $job->getSetting('sdllc_project_id');
    $jobs_affected = [];
    $active_jobs = \Drupal::entityQuery('tmgmt_job')->condition('state', [
      Job::STATE_ACTIVE,
      Job::STATE_CONTINUOUS
    ], 'IN')->execute();
    foreach ($active_jobs as $active_job_id) {
      $active_job = Job::load($active_job_id);
      $job_project_id = $active_job->get('settings')->__get('sdllc_project_id');
      if ($job_project_id == $project_id) {
        $jobs_affected[] = $active_job;
      }
    }
    foreach ($jobs_affected as $job_affected) {
      $this->retrieveTranslation($job_affected);
    }
    $job->get('settings')->__set('sdllc_allow_close', 1);
    $job->save();
    // $this->retrieveTranslation($job);
    $form_state->setRebuild();
  }

  /**
   * Handles submit call of "Cancel Project" button.
   */
  public function cancelSubmit(array $form, FormStateInterface $form_state)
  {
    /* @var \Drupal\tmgmt\JobItemInterface $job */
    $job = $form_state->getFormObject()->getEntity();

    $this->cancelProject($job);

    $form_state->setRebuild();
  }

  /**
   * Retrieves translations for multiple jobs.
   *
   * @param array $jobs
   *            Array of tmgmt_job entities.
   */
  public function autoRetrieveTranslation(array $jobs)
  {
    foreach ($jobs as $job) {

      if ($job->isContinuous()) {
        $this->retrieveTranslation($job);
      } else {
        $project_status = $this->getProjectStatus($job);

        if ($project_status->getStatus() == 3) {
          $this->retrieveTranslation($job);
        }
      }
    }
  }
}
