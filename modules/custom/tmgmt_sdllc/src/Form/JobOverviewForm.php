<?php

namespace Drupal\tmgmt_sdllc\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tmgmt\Entity\Translator;
use Drupal\tmgmt_sdllc\Datatable\DatatableSettings;
use Drupal\tmgmt_sdllc\Logger\LogWriter;
use Drupal\tmgmt_sdllc\MantraLibrary\MantraTranslationAPI;

class JobOverviewForm extends FormBase
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
      $data = $this->mantraApi->getProjectsList();
      LogWriter::info('Finished getting projects from Mantra on Jobs Overview');
      return $data;
    } catch (\Exception $e) {

      LogWriter::error('Failed to get project list with message: ' . $e->getMessage());

      throw new \Exception('Failed to get project list: ' . $e->getMessage(), 0, $e);

    }

  }

  /**
   * Returns an overview table with all Mantra projects.
   *
   * @return array The render array for the string search screen.
   */
  public function getPageData()
  {
    LogWriter::info('Start Jobs Overview page');
    $build = [];

    try {
      $translators = Translator::loadMultiple();

      if (isset($_GET['sdllc_translator_select']) && !empty($_GET['sdllc_translator_select'])) {
        if (isset($translators[$_GET['sdllc_translator_select']])) {
          $this->translator = $translators[$_GET['sdllc_translator_select']];
        } else {
          throw new \Exception('Translator machine name not found.');
        }
      } else {
        return $build;
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
          $i++;
        }
        $delivery_date = $project->getStatus() > 2 ? date('M j, Y', strtotime($project->getDeliveredDate())) : '';
        $build[] = [
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
    }

    LogWriter::info('Finished Jobs Overview page');

    return $build;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @return type
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    /*
     * Add translator provider select
     */
    $translators = Translator::loadMultiple();
    $options = ["--- Select ---"];
    /*
     * Remap all the provider select options
     */
    foreach ($translators as $index => $trans) {
      $options[$index] = $trans->label();
    }
    /*
     * Select default value to first if no was selected
     */
    $selected = !empty($form_state->getValue('sdllc_translator_select')) ? $form_state->getValue('sdllc_translator_select') : key($options);

    $form['sdllc_translator_select'] = array(
      '#type' => 'select',
      '#options' => $options,
      '#default_value' => $selected
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#name' => 'submit',
      '#value' => t('Submit'),
    );

    $dataTable = new DatatableSettings();
    $form['table'] = $dataTable->returnTableSettings();
    $form['table']['#rows'] = $this->getPageData();

    return $form;
  }

  public function getFormId()
  {
    return 'tmgmt_sdllc_job';
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect('tmgmt_sdllc.tmgmt_sdllc_job_overview', ['sdllc_translator_select' => $_POST['sdllc_translator_select']], []);
  }

}

