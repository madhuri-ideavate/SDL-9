<?php

namespace MantraLibrary\Model;

/**
 * WaitHandle class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class WaitHandle extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'safeWaitHandle' => '\MantraLibrary\Model\SafeWaitHandle',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'safeWaitHandle' => 'SafeWaitHandle',
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
   * Property $safeWaitHandle.
   *
   * @var \MantraLibrary\Model\SafeWaitHandle
   */
  protected $safeWaitHandle;

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

      if (!property_exists($this, $object_property)) {
        continue;
      }

      $this->$object_property = new SafeWaitHandle($value);
    }
  }

  /**
   * Gets safeWaitHandle.
   *
   * @return \MantraLibrary\Model\SafeWaitHandle
   *   The safe wait handle.
   */
  public function getSafeWaitHandle() {
    return $this->safeWaitHandle;
  }

  /**
   * Sets safeWaitHandle.
   *
   * @param \MantraLibrary\Model\SafeWaitHandle $safeWaitHandle
   *   The safe wait handle.
   *
   * @return $this
   */
  public function setSafeWaitHandle(SafeWaitHandle $safeWaitHandle) {
    $this->safeWaitHandle = $safeWaitHandle;
    return $this;
  }

}
