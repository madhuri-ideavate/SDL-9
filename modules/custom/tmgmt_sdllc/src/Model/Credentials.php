<?php

namespace Drupal\tmgmt_sdllc\Model;

use Drupal\tmgmt\Entity\Job;

/**
 * Class Credentials.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class Credentials {

  /**
   * Property $clientId.
   *
   * @var string
   */
  public $clientId;

  /**
   * Property $clientSecret.
   *
   * @var string
   */
  public $clientSecret;

  /**
   * Property $username.
   *
   * @var string
   */
  public $username;

  /**
   * Property $password.
   *
   * @var string
   */
  public $password;

  /**
   * Property $sdllcUrl.
   *
   * @var string
   */
  public $sdllcUrl;

  /**
   * Constructor.
   *
   * @param \Drupal\tmgmt\Entity\Job $job
   *   Job entity.
   */
  public function __construct(Job $job) {
    $this->clientId = $job->getSetting('sdllc_client_id');
    $this->clientSecret = $job->getSetting('sdllc_client_secret');
    $this->username = $job->getSetting('sdllc_username');
    $this->password = $job->getSetting('sdllc_password');
    $this->sdllcUrl = $job->getSetting('sdllc_url');
  }

}
