<?php

namespace MantraLibrary\Model;

/**
 * PortalFileType class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalFileType extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'name' => 'string',
    'extensions' => 'string[]',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'name' => 'Name',
    'extensions' => 'Extensions',
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
   * Property $name.
   *
   * @var string
   */
  protected $name;

  /**
   * Property $extensions.
   *
   * @var string[]
   */
  protected $extensions;

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
      // $object_type = $this->getPropertyType($object_property);
      if (!property_exists($this, $object_property)) {
        continue;
      }

      if ($object_property == 'extensions') {
        $this->$object_property = [];

        foreach ($value as $v) {
          $object_array = [];
          $object_array[] = $v;
        }

        $this->$object_property = $object_array;
      }
      else {
        $this->$object_property = $value;
      }
    }
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
   * Gets extensions.
   *
   * @return string[]
   *   Array of extensions.
   */
  public function getExtensions() {
    return $this->extensions;
  }

  /**
   * Sets extensions.
   *
   * @param string[] $extensions
   *   Array of extensions.
   *
   * @return $this
   */
  public function setExtensions(array $extensions) {
    $this->extensions = $extensions;
    return $this;
  }

}
