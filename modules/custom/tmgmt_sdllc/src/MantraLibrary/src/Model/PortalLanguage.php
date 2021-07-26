<?php

namespace MantraLibrary\Model;

/**
 * PortalLanguage class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalLanguage extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'code' => 'string',
    'name' => 'string',
    'shortName' => 'string',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'code' => 'Code',
    'name' => 'Name',
    'shortName' => 'ShortName',
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
   * Property $code.
   *
   * @var string
   */
  protected $code;

  /**
   * Property $name.
   *
   * @var string
   */
  protected $name;

  /**
   * Property $shortName.
   *
   * @var string
   */
  protected $shortName;

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

      $this->$object_property = $value;
    }
  }

  /**
   * Gets code.
   *
   * @return string
   *   The language code.
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Sets code.
   *
   * @param string $code
   *   The language code.
   *
   * @return $this
   */
  public function setCode($code) {
    $this->code = $code;
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
   * Gets shortName.
   *
   * @return string
   *   The short name.
   */
  public function getShortName() {
    return $this->shortName;
  }

  /**
   * Sets shortName.
   *
   * @param string $shortName
   *   The short name.
   *
   * @return $this
   */
  public function setShortName($shortName) {
    $this->shortName = $shortName;
    return $this;
  }

}
