<?php

namespace MantraLibrary\Model;

/**
 * Cost class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class Cost extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'currency' => '\MantraLibrary\Model\PortalCurrency',
    'value' => 'double',
  ];

  /**
   * Array of attributes. The key is the local,the value is the original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'currency' => 'Currency',
    'value' => 'Value',
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
   * Variable $currency.
   *
   * @var \MantraLibrary\Model\PortalCurrency
   */
  protected $currency;

  /**
   * Variable $value.
   *
   * @var double
   */
  protected $value;

  /**
   * Constructor.
   *
   * @param mixed[] $data
   *   Associated array of property value initializing the model.
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
   *   Associated array of property value initializing the model.
   */
  private function populate(array $data) {
    foreach ($data as $property => $value) {
      $object_property = $this->getProperty($property);
      $object_type = $this->getPropertyType($object_property);

      if (!property_exists($this, $object_property)) {
        continue;
      }

      if ($object_property == 'currency') {

        $this->$object_property = new PortalCurrency($value);
      }
      else {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
    }
  }

  /**
   * Gets currency.
   *
   * @return \MantraLibrary\Model\PortalCurrency
   *   PortalCurrency Object.
   */
  public function getCurrency() {
    return $this->currency;
  }

  /**
   * Sets currency.
   *
   * @param \MantraLibrary\Model\PortalCurrency $currency
   *   PortalCurrency Object.
   *
   * @return $this
   */
  public function setCurrency(PortalCurrency $currency) {
    $this->currency = $currency;
    return $this;
  }

  /**
   * Gets value.
   *
   * @return double
   *   Cost of translation.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Sets value.
   *
   * @param double $value
   *   Cost of translation.
   *
   * @return $this
   */
  public function setValue(double $value) {
    $this->value = $value;
    return $this;
  }

}
