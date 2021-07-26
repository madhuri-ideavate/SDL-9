<?php

namespace Drupal\tmgmt_sdllc\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\CronInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Component\Datetime\Time;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form with examples on how to use cron.
 */
class AutoRetrievalSettingsForm extends ConfigFormBase {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The cron service.
   *
   * @var \Drupal\Core\CronInterface
   */
  protected $cron;

  /**
   * The state keyvalue collection.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The state keyvalue collection.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory, AccountInterface $current_user, CronInterface $cron, StateInterface $state, TimeInterface $time) {
    parent::__construct($config_factory);
    $this->currentUser = $current_user;
    $this->cron = $cron;
    $this->state = $state;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('current_user'),
      $container->get('cron'),
      $container->get('state'),
      $container->get('datetime.time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tmgmt_sdllc_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->configFactory->get('tmgmt_sdllc.settings');

    $form['status'] = [
      '#type' => 'details',
      '#title' => $this->t('Cron status information'),
      '#open' => TRUE,
    ];

    $next_execution = $this->state->get('tmgmt_sdllc.next_execution');
    
    
    $next_execution = !empty($next_execution) ? $next_execution : $this->time
      ->getRequestTime();

    $args = [
      '%time' => date_iso8601($this->state
        ->get('tmgmt_sdllc.next_execution')),
      '%seconds' => $next_execution - $this->time->getRequestTime(),
    ];
    $form['status']['last'] = [
      '#type' => 'item',
      '#markup' => $this->t('Auto retrieval of translations will next execute the first time cron runs after %time (%seconds seconds from now)', $args),
    ];

    $form['configuration'] = [
      '#type' => 'details',
      '#title' => $this->t('Configuration of Translation Auto-retrieval Cron'),
      '#open' => TRUE,
    ];

    $form['configuration']['tmgmt_sdllc_autoretrieval'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable auto retrieval of translations'),
      '#default_value' => $config->get('autoretrieval'),
    ];

    $form['configuration']['tmgmt_sdllc_interval'] = [
      '#type' => 'select',
      '#title' => $this->t('Cron interval'),
      '#default_value' => $config->get('interval'),
      '#options' => [
        60 => $this->t('1 minute'),
        300 => $this->t('5 minutes'),
        3600 => $this->t('1 hour'),
        86400 => $this->t('1 day'),
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('tmgmt_sdllc.settings')
      ->set('autoretrieval', $form_state->getValue('tmgmt_sdllc_autoretrieval'))
      ->save();

    $this->configFactory->getEditable('tmgmt_sdllc.settings')
      ->set('interval', $form_state->getValue('tmgmt_sdllc_interval'))
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['tmgmt_sdllc.settings'];
  }

}
