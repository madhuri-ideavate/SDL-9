<?php

namespace MantraLibrary\Model;

/**
 * CancellationToken class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class CancellationToken extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'isCancellationRequested' => 'bool',
    'canBeCanceled' => 'bool',
    'waitHandle' => '\MantraLibrary\Model\WaitHandle',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'isCancellationRequested' => 'IsCancellationRequested',
    'canBeCanceled' => 'CanBeCanceled',
    'waitHandle' => 'WaitHandle',
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
   * Variable $isCancellationRequested.
   *
   * @var bool
   */
  protected $isCancellationRequested;

  /**
   * Variable $canBeCanceled.
   *
   * @var bool
   */
  protected $canBeCanceled;

  /**
   * Variable $waitHandle.
   *
   * @var \MantraLibrary\Model\WaitHandle
   */
  protected $waitHandle;

  /**
   * Constructor.
   *
   * @param mixed[] $data
   *   Associated array of property value initalizing the model.
   */
  public function __construct(array $data = NULL) {
    if ($data != NULL) {
      $this->populate(@data);
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

      if ($object_property == 'waitHandle') {
        $this->$object_property = new WaitHandle($value);
      }
      else {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
    }
  }

  /**
   * Gets $isCancellationRequested.
   *
   * @return bool
   *   TRUE if request is cancellation, FALSE otherwise.
   */
  public function getIsCancellationRequested() {
    return $this->isCancellationRequested;
  }

  /**
   * Sets $isCancellationRequested.
   *
   * @param bool $isCancellationRequested
   *   TRUE if request is cancellation, FALSE otherwise.
   *
   * @return $this
   */
  public function setIsCancellationRequested($isCancellationRequested) {
    $this->isCancellationRequested = $isCancellationRequested;
    return $this;
  }

  /**
   * Gets can_be_canceled.
   *
   * @return bool
   *   TRUE if request can be cancelled, FALSE otherwise.
   */
  public function getCanBeCanceled() {
    return $this->can_be_canceled;
  }

  /**
   * Sets can_be_canceled.
   *
   * @param bool $canBeCanceled
   *   TRUE if request can be cancelled, FALSE otherwise.
   *
   * @return $this
   */
  public function setCanBeCanceled($canBeCanceled) {
    $this->canBeCanceled = $canBeCanceled;
    return $this;
  }

  /**
   * Gets $waitHandle.
   *
   * @return \MantraLibrary\Model\WaitHandle
   *   WaitHandle class.
   */
  public function getWaitHandle() {
    return $this->waitHandle;
  }

  /**
   * Sets $waitHandle.
   *
   * @param \MantraLibrary\Model\WaitHandle $waitHandle
   *   WaitHandle class.
   *
   * @return $this
   */
  public function setWaitHandle(WaitHandle $waitHandle) {
    $this->waitHandle = $waitHandle;
    return $this;
  }

}
