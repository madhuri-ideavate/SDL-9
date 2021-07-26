<?php

namespace MantraLibrary\Model;

/**
 * Cost class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalJobCostDetail extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'name' => 'string',
    'comment' => 'string',
    'language' => '\MantraLibrary\Model\PortalLanguage',
    'value' => 'double',
    'isPromoDisc' => 'bool',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'name' => 'Name',
    'comment' => 'Comment',
    'language' => 'Language',
    'value' => 'Value',
    'isPromoDisc' => 'IsPromoDisc',
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
   * Property $comment.
   *
   * @var string
   */
  protected $comment;

  /**
   * Property $language.
   *
   * @var \MantraLibrary\Model\PortalLanguage
   */
  protected $language;

  /**
   * Property $value.
   *
   * @var double
   */
  protected $value;

  /**
   * Property $isPromoDisc.
   *
   * @var bool
   */
  protected $isPromoDisc;

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

      if (in_array($object_property, [
        'value',
        'isPromoDisc',
      ])) {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      elseif ($object_property == 'language') {
        $this->$object_property = new PortalLanguage($value);
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
   * Gets comment.
   *
   * @return string
   *   The comment.
   */
  public function getComment() {
    return $this->comment;
  }

  /**
   * Sets comment.
   *
   * @param string $comment
   *   The comment.
   *
   * @return $this
   */
  public function setComment($comment) {
    $this->comment = $comment;
    return $this;
  }

  /**
   * Gets language.
   *
   * @return \MantraLibrary\Model\PortalLanguage
   *   The PortalLanguage.
   */
  public function getLanguage() {
    return $this->language;
  }

  /**
   * Sets language.
   *
   * @param \MantraLibrary\Model\PortalLanguage $language
   *   The PortalLanguage.
   *
   * @return $this
   */
  public function setLanguage(PortalLanguage $language) {
    $this->language = $language;
    return $this;
  }

  /**
   * Gets value.
   *
   * @return double
   *   The value.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Sets value.
   *
   * @param double $value
   *   The value.
   *
   * @return $this
   */
  public function setValue(double $value) {
    $this->value = $value;
    return $this;
  }

  /**
   * Gets isPromoDisc.
   *
   * @return bool
   *   True if is promo disc, false otherwise.
   */
  public function getIsPromoDisc() {
    return $this->isPromoDisc;
  }

  /**
   * Sets isPromoDisc.
   *
   * @param bool $isPromoDisc
   *   True if is promo disc, false otherwise.
   *
   * @return $this
   */
  public function setIsPromoDisc($isPromoDisc) {
    $this->isPromoDisc = $isPromoDisc;
    return $this;
  }

}
