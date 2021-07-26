<?php

namespace MantraLibrary\Model;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * PortalJobOptions class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalJobOptions extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'id' => 'string',
    'contentType' => 'int',
    'name' => 'string',
    'description' => 'string',
    'dueDateOffset' => 'int',
    'dueDateMinimum' => 'int',
    'disabledDates' => '\DateTime[]',
    'languagePairs' => '\MantraLibrary\Model\PortalLanguagePair[]',
    'fileTypes' => '\MantraLibrary\Model\PortalFileType[]',
    'metadata' => '\MantraLibrary\Model\PortalMetadata[]',
    'supportsJobName' => 'bool',
    'supportsJobDescription' => 'bool',
    'supportsDueDate' => 'bool',
    'supportsReferenceFiles' => 'bool',
    'allowWildcardExtensions' => 'bool',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'id' => 'Id',
    'contentType' => 'ContentType',
    'name' => 'Name',
    'description' => 'Description',
    'dueDateOffset' => 'DueDateOffset',
    'dueDateMinimum' => 'DueDateMinimum',
    'disabledDates' => 'DisabledDates',
    'languagePairs' => 'LanguagePairs',
    'fileTypes' => 'FileTypes',
    'metadata' => 'Metadata',
    'supportsJobName' => 'SupportsJobName',
    'supportsJobDescription' => 'SupportsJobDescription',
    'supportsDueDate' => 'SupportsDueDate',
    'supportsReferenceFiles' => 'SupportsReferenceFiles',
    'allowWildcardExtensions' => 'AllowWildcardExtensions',
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
   * Property $id.
   *
   * @var string
   */
  protected $id;

  /**
   * Property $contentType.
   *
   * @var int
   *   enum type 0 => Unknown, 1 => Documents, 2 => VideoLink.
   */
  protected $contentType;

  /**
   * For $contentType mapping.
   *
   * @var array
   */
  public static $portalContentType = [
    'Unknown',
    'Document',
    'VideoLink',
  ];

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
   * Property $dueDateOffset.
   *
   * @var int
   */
  protected $dueDateOffset;

  /**
   * Property $dueDateMinimum.
   *
   * @var int
   */
  protected $dueDateMinimum;

  /**
   * Property $disabledDates.
   *
   * @var \DateTime[]
   */
  protected $disabledDates;

  /**
   * Property $languagePairs.
   *
   * @var \MantraLibrary\Model\PortalLanguagePair[]
   */
  protected $languagePairs;

  /**
   * Property $fileTypes.
   *
   * @var \MantraLibrary\Model\PortalFileType[]
   */
  protected $fileTypes;

  /**
   * Property $metadata.
   *
   * @var \MantraLibrary\Model\PortalMetadata[]
   */
  protected $metadata;

  /**
   * Property $supportsJobName.
   *
   * @var bool
   */
  protected $supportsJobName;

  /**
   * Property $supportsJobDescription.
   *
   * @var bool
   */
  protected $supportsJobDescription;

  /**
   * Property $supportsDueDate.
   *
   * @var bool
   */
  protected $supportsDueDate;

  /**
   * Property $supportsReferenceFiles.
   *
   * @var bool
   */
  protected $supportsReferenceFiles;

  /**
   * Property $allowWildcardExtensions.
   *
   * @var bool
   */
  protected $allowWildcardExtensions;

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

      if ($object_property == 'disabledDates') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new DrupalDateTime($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'languagePairs') {
        $object_array = [];
        foreach ($value as $v) {
          $object_array[] = new PortalLanguagePair($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'fileTypes') {
        $object_array = [];
        foreach ($value as $v) {
          $object_array[] = new PortalFileType($v);
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
      elseif (in_array($object_property,
                            [
                              'contentType',
                              'dueDateOffset',
                              'dueDateMinimum',
                              'supportsJobName',
                              'supportsJobDescription',
                              'supportsDueDate',
                              'supportsReferenceFiles',
                              'allowWildcardExtensions',
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
   * Gets id.
   *
   * @return string
   *   The id.
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Sets id.
   *
   * @param string $id
   *   The id.
   *
   * @return $this
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * Gets contentType.
   *
   * @return int
   *   The content type.
   */
  public function getContentType() {
    return $this->contentType;
  }

  /**
   * Gets contentType mapping.
   *
   * @return string
   *   The content type.
   */
  public function getContentTypeName() {
    if (in_array($this->contentType, $this->portalContentType)) {
      return $this->portalContentType[$this->contentType];
    }

    return '';
  }

  /**
   * Sets contentType.
   *
   * @param int $contentType
   *   The content type.
   *
   * @return $this
   */
  public function setContentType($contentType) {
    $allowed_values = [
      "0",
      "1",
      "2",
    ];
    if (!in_array($contentType, $allowed_values)) {
      throw new \InvalidArgumentException(
            "Invalid value for 'contentType', must be one of '0', '1', '2'");
    }
    $this->contentType = $contentType;
    return $this;
  }

  /**
   * Gets name.
   *
   * @return string
   *   The content name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Sets name.
   *
   * @param string $name
   *   The content name.
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
   *   The content description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Sets description.
   *
   * @param string $description
   *   The content description.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Gets dueDateOffset.
   *
   * @return int
   *   The due date offset.
   */
  public function getDueDateOffset() {
    return $this->dueDateOffset;
  }

  /**
   * Sets dueDateOffset.
   *
   * @param int $dueDateOffset
   *   The due date offset.
   *
   * @return $this
   */
  public function setDueDateOffset($dueDateOffset) {
    $this->dueDateOffset = $dueDateOffset;
    return $this;
  }

  /**
   * Gets dueDateMinimum.
   *
   * @return int
   *   The min due date.
   */
  public function getDueDateMinimum() {
    return $this->dueDateMinimum;
  }

  /**
   * Sets dueDateMinimum.
   *
   * @param int $dueDateMinimum
   *   The min due date.
   *
   * @return $this
   */
  public function setDueDateMinimum($dueDateMinimum) {
    $this->dueDateMinimum = $dueDateMinimum;
    return $this;
  }

  /**
   * Gets disabledDates.
   *
   * @return \DateTime[]
   *   The disabled dates.
   */
  public function getDisabledDates() {
    return $this->disabledDates;
  }

  /**
   * Sets disabledDates.
   *
   * @param \DateTime[] $disabledDates
   *   Array of disabled dates.
   *
   * @return $this
   */
  public function setDisabledDates(array $disabledDates) {
    $this->disabledDates = $disabledDates;
    return $this;
  }

  /**
   * Gets languagePairs.
   *
   * @return \MantraLibrary\Model\PortalLanguagePair[]
   *   Array of PortalLanguagePair object.
   */
  public function getLanguagePairs() {
    return $this->languagePairs;
  }

  /**
   * Sets languagePairs.
   *
   * @param \MantraLibrary\Model\PortalLanguagePair[] $languagePairs
   *   Array of PortalLanguagePair object.
   *
   * @return $this
   */
  public function setLanguagePairs(array $languagePairs) {
    $this->languagePairs = $languagePairs;
    return $this;
  }

  /**
   * Gets fileTypes.
   *
   * @return \MantraLibrary\Model\PortalFileType[]
   *   Array of PortalFileType object.
   */
  public function getFileTypes() {
    return $this->fileTypes;
  }

  /**
   * Sets fileTypes.
   *
   * @param \MantraLibrary\Model\PortalFileType[] $fileTypes
   *   Array of PortalFileType object.
   *
   * @return $this
   */
  public function setFileTypes(array $fileTypes) {
    $this->fileTypes = $fileTypes;
    return $this;
  }

  /**
   * Gets metadata.
   *
   * @return \MantraLibrary\Model\PortalMetadata[]
   *   Array of PortalMetadata object.
   */
  public function getMetadata() {
    return $this->metadata;
  }

  /**
   * Sets metadata.
   *
   * @param \MantraLibrary\Model\PortalMetadata[] $metadata
   *   Array of PortalMetadata object.
   *
   * @return $this
   */
  public function setMetadata(array $metadata) {
    $this->metadata = $metadata;
    return $this;
  }

  /**
   * Gets supportsJobName.
   *
   * @return bool
   *   True is job name is supported, false otherwise.
   */
  public function getSupportsJobName() {
    return $this->supportsJobName;
  }

  /**
   * Sets supportsJobName.
   *
   * @param bool $supportsJobName
   *   True is job name is supported, false otherwise.
   *
   * @return $this
   */
  public function setSupportsJobName($supportsJobName) {
    $this->supportsJobName = $supportsJobName;
    return $this;
  }

  /**
   * Gets supportsJobDescription.
   *
   * @return bool
   *   True is job description is supported, false otherwise.
   */
  public function getSupportsJobDescription() {
    return $this->supportsJobDescription;
  }

  /**
   * Sets supportsJobDescription.
   *
   * @param bool $supportsJobDescription
   *   True is job description is supported, false otherwise.
   *
   * @return $this
   */
  public function setSupportsJobDescription($supportsJobDescription) {
    $this->supportsJobDescription = $supportsJobDescription;
    return $this;
  }

  /**
   * Gets supportsDueDate.
   *
   * @return bool
   *   True is job due date is supported, false otherwise.
   */
  public function getSupportsDueDate() {
    return $this->supportsDueDate;
  }

  /**
   * Sets supportsDueDate.
   *
   * @param bool $supportsDueDate
   *   True is job due date is supported, false otherwise.
   *
   * @return $this
   */
  public function setSupportsDueDate($supportsDueDate) {
    $this->supportsDueDate = $supportsDueDate;
    return $this;
  }

  /**
   * Gets supportsReferenceFiles.
   *
   * @return bool
   *   True if reference files are supported, false otherwise.
   */
  public function getSupportsReferenceFiles() {
    return $this->supportsReferenceFiles;
  }

  /**
   * Sets supportsReferenceFiles.
   *
   * @param bool $supportsReferenceFiles
   *   True if reference files are supported, false otherwise.
   *
   * @return $this
   */
  public function setSupportsReferenceFiles($supportsReferenceFiles) {
    $this->supportsReferenceFiles = $supportsReferenceFiles;
    return $this;
  }

  /**
   * Gets allowWildcardExtensions.
   *
   * @return bool
   *   True if wildcard extensions are supported, false otherwise.
   */
  public function getAllowWildcardExtensions() {
    return $this->allowWildcardExtensions;
  }

  /**
   * Sets allowWildcardExtensions.
   *
   * @param bool $allowWildcardExtensions
   *   True if wildcard extensions are supported, false otherwise.
   *
   * @return $this
   */
  public function setAllowWildcardExtensions($allowWildcardExtensions) {
    $this->allowWildcardExtensions = $allowWildcardExtensions;
    return $this;
  }

}
