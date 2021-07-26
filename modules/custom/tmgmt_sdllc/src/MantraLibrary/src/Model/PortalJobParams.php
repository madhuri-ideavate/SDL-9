<?php

namespace MantraLibrary\Model;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * PortalJobParams class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalJobParams extends PortalObject {
  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'description' => 'string',
    'dueDate' => '\DateTime',
    'fileIds' => 'array',
    'projectOptionsId' => 'string',
    'metadata' => '\MantraLibrary\Model\PortalMetadata[]',
    'name' => 'string',
    'srcLang' => 'string',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'description' => 'Description',
    'dueDate' => 'DueDate',
    'fileIds' => 'Files',
    'projectOptionsId' => 'ProjectOptionsId',
    'metadata' => 'Metadata',
    'name' => 'Name',
    'srcLang' => 'SrcLang',
  ];

  /**
   * Gets the property type map.
   *
   * {@inheritdoc}
   *
   * @see \MantraLibrary\Model\PortalObject::getPropertyTypes()
   */
  protected function getPropertyTypes() {
    return self::$propertyTypes;
  }

  /**
   * Gets the property name map.
   *
   * {@inheritdoc}
   *
   * @see \MantraLibrary\Model\PortalObject::getPropertyMaps()
   */
  protected function getPropertyMaps() {
    return self::$attributeMap;
  }

  /**
   * Property $job_options.
   *
   * @var string
   */
  protected $projectOptionsId;

  /**
   * Property $name.
   *
   * @var string
   */
  protected $name;

  /**
   * Property $description.
   *
   * @var string
   */
  protected $description;

  /**
   * Property $srcLang.
   *
   * @var string
   */
  protected $srcLang;

  /**
   * Property $fileIds.
   *
   * @var array
   */
  protected $fileIds;

  /**
   * Property $metadata.
   *
   * @var \MantraLibrary\Model\PortalMetadata[]
   */
  protected $metadata;

  /**
   * Property $dueDate.
   *
   * @var \DateTime
   */
  protected $dueDate;

  /**
   * Initialize.
   */
  private function initialize() {
    $this->metadata = [];
  }

  /**
   * Constructor.
   *
   * @param mixed[] $data
   *   Associated array of property value initalizing the model.
   */
  public function __construct(array $data = NULL) {
    $this->initialize();

    if ($data != NULL) {
      $this->populate($data);
    }
  }

  /**
   * For deserialization from Json data.
   *
   * @param array $data
   *   Associated array of property value initalizing the model.
   */
  private function populate(array $data) {
    foreach ($data as $property => $value) {
      $object_property = $this->getProperty($property);
      $object_type = $this->getPropertyType($object_property);

      if (!property_exists($this, $object_property)) {
        continue;
      }

      if ($object_property == 'dueDate') {

        $this->$object_property = new DrupalDateTime($value);
      }
      elseif ($object_property == 'fileIds') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new PortalUploadeFile($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'metadata') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new PortalMetadata($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'tgt_langs') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = $v;
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'is_new_user') {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      else {
        $this->$object_property = $value;
      }
    }
  }

  /**
   * Gets is_new_user.
   *
   * @return bool
   *   True if new user, false otherwise.
   */
  public function getIsNewUser() {
    return $this->is_new_user;
  }

  /**
   * Sets is_new_user.
   *
   * @param bool $is_new_user
   *   True if new user, false otherwise.
   *
   * @return $this
   */
  public function setIsNewUser($is_new_user) {
    $this->is_new_user = $is_new_user;
    return $this;
  }

  /**
   * Gets job_options.
   *
   * @return string
   *   The job options.
   */
  public function getJobOptions() {
    return $this->projectOptionsId;
  }

  /**
   * Sets job_options.
   *
   * @param string $job_options
   *   The job options.
   *
   * @return $this
   */
  public function setJobOptions($job_options) {
    $this->projectOptionsId = $job_options;
    return $this;
  }

  /**
   * Gets name.
   *
   * @return string
   *   The name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Sets name.
   *
   * @param string $name
   *   The name.
   *
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * Gets description.
   *
   * @return string
   *   The description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Sets description.
   *
   * @param string $description
   *   The description.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Gets srcLang.
   *
   * @return string
   *   The source language.
   */
  public function getSrcLang() {
    return $this->srcLang;
  }

  /**
   * Sets srcLang.
   *
   * @param string $srcLang
   *   The source language.
   *
   * @return $this
   */
  public function setSrcLang($srcLang) {
    $this->srcLang = $srcLang;
    return $this;
  }

  /**
   * Gets tgt_langs.
   *
   * @return string[]
   *   Array of target languages.
   */
  public function getTgtLangs() {
    return $this->tgt_langs;
  }

  /**
   * Sets tgt_langs.
   *
   * @param string[] $tgt_langs
   *   Array of target languages.
   *
   * @return $this
   */
  public function setTgtLangs(array $tgt_langs) {
    $this->tgt_langs = $tgt_langs;
    return $this;
  }

  /**
   * Gets fileIds.
   *
   * @return array
   *   Array of file ids.
   */
  public function getFileIds() {
    return $this->fileIds;
  }

  /**
   * Sets fileIds.
   *
   * @param \MantraLibrary\Model\PortalUploadedFile[] $fileIds
   *   Array of PortalUploadedFile objects.
   * @param string $target_language
   *   The target language.
   *
   * @return $this
   */
  public function setFileIds(array $fileIds, $target_language) {
    foreach ($fileIds as $file_id) {
      $this->fileIds[] = [
        'FileId' => $file_id->getFileId(),
        'targets' => is_array($target_language) ? $target_language : [$target_language],
      ];
    }
    return $this;
  }

  /**
   * Gets metadata.
   *
   * @return \MantraLibrary\Model\PortalMetadata[]
   *   Array of PortalMetadata.
   */
  public function getMetadata() {
    return $this->metadata;
  }

  /**
   * Sets metadata.
   *
   * @param \MantraLibrary\Model\PortalMetadata[] $metadata
   *   Array of PortalMetadata.
   *
   * @return $this
   */
  public function setMetadata(array $metadata) {
    $this->metadata = $metadata;
    return $this;
  }

  /**
   * Gets dueDate.
   *
   * @return \DateTime
   *   The due date.
   */
  public function getDueDate() {
    return $this->dueDate;
  }

  /**
   * Sets dueDate.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $dueDate
   *   The due date.
   *
   * @return $this
   */
  public function setDueDate($dueDate) {
    $this->dueDate = $dueDate;
    return $this;
  }

  /**
   * Gets authorization_callback_url.
   *
   * @return string
   *   The authorization callback url.
   */
  public function getAuthorizationCallbackUrl() {
    return $this->authorization_callback_url;
  }

  /**
   * Sets authorization_callback_url.
   *
   * @param string $authorization_callback_url
   *   The authorization callback url.
   *
   * @return $this
   */
  public function setAuthorizationCallbackUrl($authorization_callback_url) {
    $this->authorization_callback_url = $authorization_callback_url;
    return $this;
  }

  /**
   * Gets retrieval_callback_url.
   *
   * @return string
   *   The retrieveal callback url.
   */
  public function getRetrievalCallbackUrl() {
    return $this->retrieval_callback_url;
  }

  /**
   * Sets retrieval_callback_url.
   *
   * @param string $retrieval_callback_url
   *   The retrieveal callback url.
   *
   * @return $this
   */
  public function setRetrievalCallbackUrl($retrieval_callback_url) {
    $this->retrieval_callback_url = $retrieval_callback_url;
    return $this;
  }

  /**
   * Gets callback_key.
   *
   * @return string
   *   The callback key.
   */
  public function getCallbackKey() {
    return $this->callback_key;
  }

  /**
   * Sets callback_key.
   *
   * @param string $callback_key
   *   The callback key.
   *
   * @return $this
   */
  public function setCallbackKey($callback_key) {
    $this->callback_key = $callback_key;
    return $this;
  }

}
