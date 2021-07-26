<?php

namespace MantraLibrary\Model;

/**
 * PortalLanguagePair class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalLanguagePair extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'source' => '\MantraLibrary\Model\PortalLanguage',
    'target' => '\MantraLibrary\Model\PortalLanguage',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'source' => 'Source',
    'target' => 'Target',
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
   * Property $source.
   *
   * @var \MantraLibrary\Model\PortalLanguage
   */
  protected $source;

  /**
   * Property $target.
   *
   * @var \MantraLibrary\Model\PortalLanguage
   */
  protected $target;

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

      $this->$object_property = new PortalLanguage($value);
    }
  }

  /**
   * Gets source.
   *
   * @return \MantraLibrary\Model\PortalLanguage
   *   The PortalLanguage object.
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * Sets source.
   *
   * @param \MantraLibrary\Model\PortalLanguage $source
   *   The PortalLanguage object.
   *
   * @return $this
   */
  public function setSource(PortalLanguage $source) {
    $this->source = $source;
    return $this;
  }

  /**
   * Gets target.
   *
   * @return \MantraLibrary\Model\PortalLanguage
   *   The PortalLanguage object.
   */
  public function getTarget() {
    return $this->target;
  }

  /**
   * Sets target.
   *
   * @param \MantraLibrary\Model\PortalLanguage $target
   *   The PortalLanguage object.
   *
   * @return $this
   */
  public function setTarget(PortalLanguage $target) {
    $this->target = $target;
    return $this;
  }

}
