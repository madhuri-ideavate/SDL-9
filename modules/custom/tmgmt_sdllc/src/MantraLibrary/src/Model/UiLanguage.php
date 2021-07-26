<?php

namespace MantraLibrary\Model;

/**
 * UiLanguage class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class UiLanguage extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'langId' => 'string',
    'name' => 'string',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'langId' => 'LangId',
    'name' => 'Name',
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
   * Property $langId.
   *
   * @var string
   */
  protected $langId;

  /**
   * Property $name.
   *
   * @var string
   */
  protected $name;

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
   * Gets langId.
   *
   * @return string
   *   The language Id.
   */
  public function getLangId() {
    return $this->langId;
  }

  /**
   * Sets langId.
   *
   * @param string $langId
   *   The language Id.
   *
   * @return $this
   */
  public function setLangId($langId) {
    $this->langId = $langId;
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

}
