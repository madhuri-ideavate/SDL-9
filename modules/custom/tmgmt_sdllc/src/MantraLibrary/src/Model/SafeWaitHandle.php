<?php

namespace MantraLibrary\Model;

/**
 * SafeWaitHandle class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class SafeWaitHandle extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'isInvalid' => 'bool',
    'isClosed' => 'bool',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'isInvalid' => 'IsInvalid',
    'isClosed' => 'IsClosed',
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
   * Property $isInvalid.
   *
   * @var bool
   */
  protected $isInvalid;

  /**
   * Property $isClosed.
   *
   * @var bool
   */
  protected $isClosed;

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

      settype($value, $object_type);
      $this->$object_property = $value;
    }
  }

  /**
   * Gets isInvalid.
   *
   * @return bool
   *   True if invalid, false otherwise.
   */
  public function getIsInvalid() {
    return $this->isInvalid;
  }

  /**
   * Sets isInvalid.
   *
   * @param bool $isInvalid
   *   True if invalid, false otherwise.
   *
   * @return $this
   */
  public function setIsInvalid($isInvalid) {
    $this->isInvalid = $isInvalid;
    return $this;
  }

  /**
   * Gets isClosed.
   *
   * @return bool
   *   True if is closed, false otherwise.
   */
  public function getIsClosed() {
    return $this->isClosed;
  }

  /**
   * Sets isClosed.
   *
   * @param bool $isClosed
   *   True if is closed, false otherwise.
   *
   * @return $this
   */
  public function setIsClosed($isClosed) {
    $this->isClosed = $isClosed;
    return $this;
  }

}
