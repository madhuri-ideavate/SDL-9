<?php

namespace MantraLibrary\Model;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * PortalPromotionalDiscount class.
 *
 * This is an empty class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalPromotionalDiscount extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'id' => 'int',
    'objectId' => 'string',
    'userId' => 'int',
    'externalJobId' => 'string',
    'jobId' => 'int',
    'organizationId' => 'int',
    'organizationName' => 'string',
    'code' => 'string',
    'description' => 'string',
    'percentage' => 'double',
    'startDate' => '\DateTime',
    'endDate' => '\DateTime',
    'createdByUserId' => 'int',
    'createdByUserName' => 'string',
    'createdDate' => '\DateTime',
    'modifiedByUserId' => 'int',
    'modifiedByUserName' => 'string',
    'modifiedDate' => '\DateTime',
    'active' => 'bool',
    'static' => 'bool',
    'private' => 'bool',
    'inUse' => 'bool',
  ];

  /**
   * Array of attributes. The key is the localm the value is the original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'id' => 'Id',
    'objectId' => 'ObjectId',
    'userId' => 'UserId',
    'externalJobId' => 'ExternalJobId',
    'jobId' => 'JobId',
    'organizationId' => 'OrganizationId',
    'organizationName' => 'OrganizationName',
    'code' => 'Code',
    'description' => 'Description',
    'percentage' => 'Percentage',
    'startDate' => 'StartDate',
    'endDate' => 'EndDate',
    'createdByUserId' => 'CreatedByUserId',
    'createdByUserName' => 'CreatedByUserName',
    'createdDate' => 'CreatedDate',
    'modifiedByUserId' => 'ModifiedByUserId',
    'modifiedByUserName' => 'ModifiedByUserName',
    'modifiedDate' => 'ModifiedDate',
    'active' => 'Active',
    'static' => 'Static',
    'private' => 'Private',
    'inUse' => 'InUse',
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
   * Property $objectId.
   *
   * @var string
   */
  protected $objectId;

  /**
   * Property $userId.
   *
   * @var int
   */
  protected $userId;

  /**
   * Property $externalJobId.
   *
   * @var string
   */
  protected $externalJobId;

  /**
   * Property $jobId.
   *
   * @var int
   */
  protected $jobId;

  /**
   * Property $organizationId.
   *
   * @var int
   */
  protected $organizationId;

  /**
   * Property $organizationName.
   *
   * @var string
   */
  protected $organizationName;

  /**
   * Property $code.
   *
   * @var string
   */
  protected $code;

  /**
   * Property $description.
   *
   * @var string
   */
  protected $description;

  /**
   * Property $percentage.
   *
   * @var double
   */
  protected $percentage;

  /**
   * Property $startDate.
   *
   * @var \DateTime
   */
  protected $startDate;

  /**
   * Property $endDate.
   *
   * @var \DateTime
   */
  protected $endDate;

  /**
   * Property $createdByUserId.
   *
   * @var string
   */
  protected $createdByUserId;

  /**
   * Property $createdByUserName.
   *
   * @var string
   */
  protected $createdByUserName;

  /**
   * Property $createdDate.
   *
   * @var \DateTime
   */
  protected $createdDate;

  /**
   * Property $modifiedByUserId.
   *
   * @var int
   */
  protected $modifiedByUserId;

  /**
   * Property $modifiedByUserName.
   *
   * @var string
   */
  protected $modifiedByUserName;

  /**
   * Property $modifiedDate.
   *
   * @var \DateTime
   */
  protected $modifiedDate;

  /**
   * Property $active.
   *
   * @var bool
   */
  protected $active;

  /**
   * Property $static.
   *
   * @var bool
   */
  protected $static;

  /**
   * Property $private.
   *
   * @var bool
   */
  protected $private;

  /**
   * Property $inUse.
   *
   * @var bool
   */
  protected $inUse;

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
              'id',
              'userId',
              'jobId',
              'organizationId',
              'percentage',
              'createdByUserId',
              'modifiedByUserId',
              'active',
              'static',
              'private',
              'inUse',
            ])) {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      elseif (in_array($object_property,
                [
                  'startDate',
                  'endDate',
                  'createdDate',
                  'modifiedDate',
                ])) {

        $this->$object_property = new DrupalDateTime($value);
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
   *   The discount ID.
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Sets id.
   *
   * @param string $id
   *   The discount ID.
   *
   * @return $this
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * Gets objectId.
   *
   * @return string
   *   The ObjectId.
   */
  public function getObjectId() {
    return $this->objectId;
  }

  /**
   * Sets objectId.
   *
   * @param string $objectId
   *   The ObjectId.
   *
   * @return $this
   */
  public function setObjectId($objectId) {
    $this->objectId = $objectId;
    return $this;
  }

  /**
   * Gets userId.
   *
   * @return int
   *   The User Id.
   */
  public function getUserId() {
    return $this->userId;
  }

  /**
   * Sets userId.
   *
   * @param int $userId
   *   The User Id.
   *
   * @return $this
   */
  public function setUserId($userId) {
    $this->userId = $userId;
    return $this;
  }

  /**
   * Gets externalJobId.
   *
   * @return string
   *   The job Id.
   */
  public function getExternalJobId() {
    return $this->externalJobId;
  }

  /**
   * Sets externalJobId.
   *
   * @param string $externalJobId
   *   The job Id.
   *
   * @return $this
   */
  public function setExternalJobId($externalJobId) {
    $this->externalJobId = $externalJobId;
    return $this;
  }

  /**
   * Gets jobId.
   *
   * @return int
   *   The job Id.
   */
  public function getJobId() {
    return $this->jobId;
  }

  /**
   * Sets jobId.
   *
   * @param int $jobId
   *   The job Id.
   *
   * @return $this
   */
  public function setJobId($jobId) {
    $this->jobId = $jobId;
    return $this;
  }

  /**
   * Gets organizationId.
   *
   * @return int
   *   The organization id.
   */
  public function getOrganizationId() {
    return $this->organizationId;
  }

  /**
   * Sets organizationId.
   *
   * @param int $organizationId
   *   The organization id.
   *
   * @return $this
   */
  public function setOrganizationId($organizationId) {
    $this->organizationId = $organizationId;
    return $this;
  }

  /**
   * Gets organizationName.
   *
   * @return string
   *   The organization name.
   */
  public function getOrganizationName() {
    return $this->organizationName;
  }

  /**
   * Sets organizationName.
   *
   * @param string $organizationName
   *   The organization name.
   *
   * @return $this
   */
  public function setOrganizationName($organizationName) {
    $this->organizationName = $organizationName;
    return $this;
  }

  /**
   * Gets code.
   *
   * @return string
   *   The code.
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Sets code.
   *
   * @param string $code
   *   The code.
   *
   * @return $this
   */
  public function setCode($code) {
    $this->code = $code;
    return $this;
  }

  /**
   * Gets description.
   *
   * @return string
   *   The Description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Sets description.
   *
   * @param string $description
   *   The Description.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Gets percentage.
   *
   * @return double
   *   The percentage.
   */
  public function getPercentage() {
    return $this->percentage;
  }

  /**
   * Sets percentage.
   *
   * @param double $percentage
   *   The percentage.
   *
   * @return $this
   */
  public function setPercentage(double $percentage) {
    $this->percentage = $percentage;
    return $this;
  }

  /**
   * Gets startDate.
   *
   * @return \DateTime
   *   The Start date.
   */
  public function getStartDate() {
    return $this->startDate;
  }

  /**
   * Sets startDate.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $startDate
   *   The Start date.
   *
   * @return $this
   */
  public function setStartDate(DrupalDateTime $startDate) {
    $this->startDate = $startDate;
    return $this;
  }

  /**
   * Gets endDate.
   *
   * @return \DateTime
   *   The end date.
   */
  public function getEndDate() {
    return $this->endDate;
  }

  /**
   * Sets endDate.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $endDate
   *   The end date.
   *
   * @return $this
   */
  public function setEndDate(DrupalDateTime $endDate) {
    $this->endDate = $endDate;
    return $this;
  }

  /**
   * Gets createdByUserId.
   *
   * @return string
   *   The user Id.
   */
  public function getCreatedByUserId() {
    return $this->createdByUserId;
  }

  /**
   * Sets createdByUserId.
   *
   * @param string $createdByUserId
   *   The user Id.
   *
   * @return $this
   */
  public function setCreatedByUserId($createdByUserId) {
    $this->createdByUserId = $createdByUserId;
    return $this;
  }

  /**
   * Gets createdByUserName.
   *
   * @return string
   *   The user name
   */
  public function getCreatedByUserName() {
    return $this->createdByUserName;
  }

  /**
   * Sets createdByUserName.
   *
   * @param string $createdByUserName
   *   The user name.
   *
   * @return $this
   */
  public function setCreatedByUserName($createdByUserName) {
    $this->createdByUserName = $createdByUserName;
    return $this;
  }

  /**
   * Gets createdDate.
   *
   * @return \DateTime
   *   The creation date.
   */
  public function getCreatedDate() {
    return $this->createdDate;
  }

  /**
   * Sets createdDate.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $createdDate
   *   The creation date.
   *
   * @return $this
   */
  public function setCreatedDate(DrupalDateTime $createdDate) {
    $this->createdDate = $createdDate;
    return $this;
  }

  /**
   * Gets modifiedByUserId.
   *
   * @return int
   *   The user id.
   */
  public function getModifiedByUserId() {
    return $this->modifiedByUserId;
  }

  /**
   * Sets modifiedByUserId.
   *
   * @param int $modifiedByUserId
   *   The user id.
   *
   * @return $this
   */
  public function setModifiedByUserId($modifiedByUserId) {
    $this->modifiedByUserId = $modifiedByUserId;
    return $this;
  }

  /**
   * Gets modifiedByUserName.
   *
   * @return string
   *   The user name.
   */
  public function getModifiedByUserName() {
    return $this->modifiedByUserName;
  }

  /**
   * Sets modifiedByUserName.
   *
   * @param string $modifiedByUserName
   *   The user name.
   *
   * @return $this
   */
  public function setModifiedByUserName($modifiedByUserName) {
    $this->modifiedByUserName = $modifiedByUserName;
    return $this;
  }

  /**
   * Gets modifiedDate.
   *
   * @return \DateTime
   *   The modified date.
   */
  public function getModifiedDate() {
    return $this->modifiedDate;
  }

  /**
   * Sets modifiedDate.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $modifiedDate
   *   The modified date.
   *
   * @return $this
   */
  public function setModifiedDate(DrupalDateTime $modifiedDate) {
    $this->modifiedDate = $modifiedDate;
    return $this;
  }

  /**
   * Gets active.
   *
   * @return bool
   *   True if active, False otherwise.
   */
  public function getActive() {
    return $this->active;
  }

  /**
   * Sets active.
   *
   * @param bool $active
   *   True if active, False otherwise.
   *
   * @return $this
   */
  public function setActive($active) {
    $this->active = $active;
    return $this;
  }

  /**
   * Gets static.
   *
   * @return bool
   *   True if static, False otherwise.
   */
  public function getStatic() {
    return $this->static;
  }

  /**
   * Sets static.
   *
   * @param bool $static
   *   True if static, False otherwise.
   *
   * @return $this
   */
  public function setStatic($static) {
    $this->static = $static;
    return $this;
  }

  /**
   * Gets private.
   *
   * @return bool
   *   True if private, False otherwise.
   */
  public function getPrivate() {
    return $this->private;
  }

  /**
   * Sets private.
   *
   * @param bool $private
   *   True if private, False otherwise.
   *
   * @return $this
   */
  public function setPrivate($private) {
    $this->private = $private;
    return $this;
  }

  /**
   * Gets inUse.
   *
   * @return bool
   *   True if inUse, False otherwise.
   */
  public function getInUse() {
    return $this->inUse;
  }

  /**
   * Sets inUse.
   *
   * @param bool $inUse
   *   True if inUse, False otherwise.
   *
   * @return $this
   */
  public function setInUse($inUse) {
    $this->inUse = $inUse;
    return $this;
  }

}
