<?php

namespace MantraLibrary\Model;

/**
 * File class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalFile extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'isReference' => 'bool',
    'unsupportedFilesInArchive' => 'bool',
    'unsupportedAreReference' => 'bool',
    'isTranslatable' => 'bool',
    'fileName' => 'string',
    'fileId' => 'string',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'isReference' => 'IsReference',
    'unsupportedFilesInArchive' => 'UnsupportedFilesInArchive',
    'unsupportedAreReference' => 'UnsupportedAreReference',
    'isTranslatable' => 'IsTranslatable',
    'fileName' => 'FileName',
    'fileId' => 'FileId',
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
   * Constructor.
   *
   * @param mixed[] $data
   *   Associated array of property value initalizing the model.
   */
  public function __construct(array $data = NULL) {
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
              'isReference',
              'unsupportedFilesInArchive',
              'unsupportedAreReference',
              'isTranslatable',
            ])) {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      else {
        $this->$object_property = $value;
      }
    }
  }

  /**
   * Gets isReference.
   *
   * @return bool
   *   True if reference, False otherwise.
   */
  public function getIsReference() {
    return $this->isReference;
  }

  /**
   * Sets isReference.
   *
   * @param bool $isReference
   *   True if reference, False otherwise.
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
   *   True if unsupported files found, false otherwise.
   */
  public function getUnsupportedFilesInArchive() {
    return $this->unsupportedFilesInArchive;
  }

  /**
   * Sets unsupportedFilesInArchive.
   *
   * @param bool $unsupportedFilesInArchive
   *   True if unsupported files found, false otherwise.
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
   *   True if unsupported files found, false otherwise.
   */
  public function getUnsupportedAreReference() {
    return $this->unsupportedAreReference;
  }

  /**
   * Sets unsupportedAreReference.
   *
   * @param bool $unsupportedAreReference
   *   True if unsupported files found, false otherwise.
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
   *   True if translatable, false otherwise.
   */
  public function getIsTranslatable() {
    return $this->isTranslatable;
  }

  /**
   * Sets isTranslatable.
   *
   * @param bool $isTranslatable
   *   True if translatable, false otherwise.
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
   *   The file name.
   */
  public function getFileName() {
    return $this->fileName;
  }

  /**
   * Sets fileName.
   *
   * @param string $fileName
   *   The file name.
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

}
