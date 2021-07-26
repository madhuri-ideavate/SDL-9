<?php

namespace MantraLibrary\Model;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * PortalUploadedFile class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalUploadedFile extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'wordCount' => 'int',
    'isReference' => 'bool',
    'unsupportedFilesInArchive' => 'bool',
    'unsupportedAreReference' => 'bool',
    'isTranslatable' => 'bool',
    'fileName' => 'string',
    'fileId' => 'string',
    'expiryDate' => '\DateTime',
    'isEncrypted' => 'bool',
    'isHidden' => 'bool',
    'properties' => 'array[]',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'wordCount' => 'WordCount',
    'isReference' => 'IsReference',
    'unsupportedFilesInArchive' => 'UnsupportedFilesInArchive',
    'unsupportedAreReference' => 'UnsupportedAreReference',
    'isTranslatable' => 'IsTranslatable',
    'fileName' => 'FileName',
    'fileId' => 'FileId',
    'expiryDate' => 'ExpiryDate',
    'isEncrypted' => 'IsEncrypted',
    'isHidden' => 'IsHidden',
    'properties' => 'Properties',
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
   * Property $wordCount.
   *
   * @var int
   */
  protected $wordCount;

  /**
   * Property $isReference.
   *
   * @var bool
   */
  protected $isReference;

  /**
   * Property $unsupportedFilesInArchive.
   *
   * @var bool
   */
  protected $unsupportedFilesInArchive;

  /**
   * Property $unsupportedAreReference.
   *
   * @var bool
   */
  protected $unsupportedAreReference;

  /**
   * Property $isTranslatable.
   *
   * @var bool
   */
  protected $isTranslatable;

  /**
   * Property $fileName.
   *
   * @var string
   */
  protected $fileName;

  /**
   * Property $fileId.
   *
   * @var string
   */
  protected $fileId;

  /**
   * Property $expiryDate.
   *
   * @var \DateTime
   */
  protected $expiryDate;

  /**
   * Property $isEncrypted.
   *
   * @var bool
   */
  protected $isEncrypted;

  /**
   * Property $isHidden.
   *
   * @var bool
   */
  protected $isHidden;

  /**
   * Property $properties.
   *
   * @var array
   */
  protected $properties;

  /**
   * Initialize.
   */
  private function initialize() {
    $this->isEncrypted = FALSE;
    $this->isHidden = FALSE;
    $this->isReference = FALSE;
    $this->isTranslatable = TRUE;
    $this->unsupportedAreReference = FALSE;
    $this->unsupportedFilesInArchive = FALSE;
    $this->wordCount = 0;
  }

  /**
   * Updates properties.
   */
  private function updateProperties() {
    if (!isset($this->properties)) {
      $this->properties = [];
    }

    $props = [
      'IsTranslatable' => $this->isTranslatable,
      'IsReference' => $this->isReference,
      'UnsupportedFilesInArchive' => $this->unsupportedFilesInArchive,
      'UnsupportedAreReference' => $this->unsupportedAreReference,
    ];

    $this->properties = $props;
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

      if (in_array($object_property,
            [
              'wordCount',
              'isReference',
              'unsupportedFilesInArchive',
              'unsupportedAreReference',
              'isTranslatable',
              'isEncrypted',
              'isHidden',
            ])) {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      elseif ($object_property == 'expiryDate') {

        $this->$object_property = new DrupalDateTime($value);
      }
      elseif ($object_property == 'properties') {
        $object_array = [];

        foreach ($value as $k => $v) {
          $object_array[$k] = $v;
        }
        $this->$object_property = $object_array;
      }
      else {
        $this->$object_property = $value;
      }
    }

    $this->updateProperties();
  }

  /**
   * Gets wordCount.
   *
   * @return int
   *   The word count.
   */
  public function getWordCount() {
    return $this->wordCount;
  }

  /**
   * Sets wordCount.
   *
   * @param int $wordCount
   *   The word count.
   *
   * @return $this
   */
  public function setWordCount($wordCount) {
    $this->wordCount = $wordCount;
    return $this;
  }

  /**
   * Gets isReference.
   *
   * @return bool
   *   True if is reference, false otherwise.
   */
  public function getIsReference() {
    return $this->isReference;
  }

  /**
   * Sets isReference.
   *
   * @param bool $isReference
   *   True if is reference, false otherwise.
   *
   * @return $this
   */
  public function setIsReference($isReference) {
    $this->isReference = $isReference;
    return $this;
  }

  /**
   * Gets unsupportedFilesInArchive.
   *
   * @return bool
   *   True if is file is unsupported, false otherwise.
   */
  public function getUnsupportedFilesInArchive() {
    return $this->unsupportedFilesInArchive;
  }

  /**
   * Sets unsupportedFilesInArchive.
   *
   * @param bool $unsupportedFilesInArchive
   *   True if is file is unsupported, false otherwise.
   *
   * @return $this
   */
  public function setUnsupportedFilesInArchive($unsupportedFilesInArchive) {
    $this->unsupportedFilesInArchive = $unsupportedFilesInArchive;
    return $this;
  }

  /**
   * Gets unsupportedAreReference.
   *
   * @return bool
   *   True if is file is unsupported, false otherwise.
   */
  public function getUnsupportedAreReference() {
    return $this->unsupportedAreReference;
  }

  /**
   * Sets unsupportedAreReference.
   *
   * @param bool $unsupportedAreReference
   *   True if is file is unsupported, false otherwise.
   *
   * @return $this
   */
  public function setUnsupportedAreReference($unsupportedAreReference) {
    $this->unsupportedAreReference = $unsupportedAreReference;
    return $this;
  }

  /**
   * Gets isTranslatable.
   *
   * @return bool
   *   True if is file is translatable, false otherwise.
   */
  public function getIsTranslatable() {
    return $this->isTranslatable;
  }

  /**
   * Sets isTranslatable.
   *
   * @param bool $isTranslatable
   *   True if is file is translatable, false otherwise.
   *
   * @return $this
   */
  public function setIsTranslatable($isTranslatable) {
    $this->isTranslatable = $isTranslatable;
    return $this;
  }

  /**
   * Gets fileName.
   *
   * @return string
   *   The name of the file.
   */
  public function getFileName() {
    return $this->fileName;
  }

  /**
   * Sets fileName.
   *
   * @param string $fileName
   *   The name of the file.
   *
   * @return $this
   */
  public function setFileName($fileName) {
    $this->fileName = $fileName;
    return $this;
  }

  /**
   * Gets fileId.
   *
   * @return string
   *   The file id.
   */
  public function getFileId() {
    return $this->fileId;
  }

  /**
   * Sets fileId.
   *
   * @param string $fileId
   *   The file id.
   *
   * @return $this
   */
  public function setFileId($fileId) {
    $this->fileId = $fileId;
    return $this;
  }

  /**
   * Gets expiryDate.
   *
   * @return \DateTime
   *   The expiry date.
   */
  public function getExpiryDate() {
    return $this->expiryDate;
  }

  /**
   * Sets expiryDate.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $expiryDate
   *   The expiry date.
   *
   * @return $this
   */
  public function setExpiryDate(DrupalDateTime $expiryDate) {
    $this->expiryDate = $expiryDate;
    return $this;
  }

  /**
   * Gets isEncrypted.
   *
   * @return bool
   *   True if is encrypted, false otherwise.
   */
  public function getIsEncrypted() {
    return $this->isEncrypted;
  }

  /**
   * Sets isEncrypted.
   *
   * @param bool $isEncrypted
   *   True if is encrypted, false otherwise.
   *
   * @return $this
   */
  public function setIsEncrypted($isEncrypted) {
    $this->isEncrypted = $isEncrypted;
    return $this;
  }

  /**
   * Gets isHidden.
   *
   * @return bool
   *   True if is hidden, false otherwise.
   */
  public function getIsHidden() {
    return $this->isHidden;
  }

  /**
   * Sets isHidden.
   *
   * @param bool $isHidden
   *   True if is hidden, false otherwise.
   *
   * @return $this
   */
  public function setIsHidden($isHidden) {
    $this->isHidden = $isHidden;
    return $this;
  }

  /**
   * Gets properties.
   *
   * @return array
   *   The file properties.
   */
  public function getProperties() {
    return $this->properties;
  }

  /**
   * Sets properties.
   *
   * @param array $properties
   *   The file properties.
   *
   * @return $this
   */
  public function setProperties(array $properties) {
    $this->properties = $properties;
    return $this;
  }

}
