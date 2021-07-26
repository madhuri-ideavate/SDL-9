<?php

namespace MantraLibrary\Model;

/**
 * PortalLanguagePairWordCount class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalLanguagePairWordCount extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'wordCount' => 'int',
    'source' => '\MantraLibrary\Model\PortalLanguage',
    'target' => '\MantraLibrary\Model\PortalLanguage',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'wordCount' => 'WordCount',
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
   * Property $wordCount.
   *
   * @var int
   */
  protected $wordCount;

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
      $object_type = $this->getPropertyType($object_property);

      if (!property_exists($this, $object_property)) {
        continue;
      }

      if ($object_property == 'wordCount') {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      else {
        $this->$object_property = new PortalLanguage($value);
      }
    }
  }

  /**
   * Gets wordCount.
   *
   * @return int
   *   The word count.
   */
  public function getWordCount() {
    return $this->wordCount;
  }

  /**
   * Sets wordCount.
   *
   * @param int $wordCount
   *   The word count.
   *
   * @return $this
   */
  public function setWordCount($wordCount) {
    $this->wordCount = $wordCount;
    return $this;
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
