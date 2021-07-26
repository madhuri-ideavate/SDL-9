<?php

namespace MantraLibrary\Model;

/**
 * PortalInstantQuoteOption class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalInstantQuoteOption extends PortalObject {
  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'optionId' => 'string',
    'name' => 'string',
    'description' => 'string',
    'currency' => '\MantraLibrary\Model\PortalCurrency',
    'languagePairs' => '\MantraLibrary\Model\PortalLanguagePair[]',
    'extensions' => 'string',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'optionId' => 'OptionId',
    'name' => 'Name',
    'description' => 'Description',
    'currency' => 'Currency',
    'languagePairs' => 'LanguagePairs',
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
   * Property $optionId.
   *
   * @var string
   */
  protected $optionId;

  /**
   * Property $name.
   *
   * @var string
   */
  protected $name;

  /**
   * Property $description.
   *
   * @var string
   */
  protected $description;

  /**
   * Property $currency.
   *
   * @var \MantraLibrary\Model\PortalCurrency
   */
  protected $currency;

  /**
   * Property $languagePairs.
   *
   * @var \MantraLibrary\Model\PortalLanguagePair[]
   */
  protected $languagePairs;

  /**
   * Property $extensions.
   *
   * @var string
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

      if ($object_property == 'languagePairs') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new PortalLanguagePair($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'currency') {
        $this->$object_property = new PortalCurrency($value);
      }
      else {
        $this->$object_property = $value;
      }
    }
  }

  /**
   * Gets optionId.
   *
   * @return string
   *   The option id.
   */
  public function getOptionId() {
    return $this->optionId;
  }

  /**
   * Sets optionId.
   *
   * @param string $optionId
   *   The option id.
   *
   * @return $this
   */
  public function setOptionId($optionId) {
    $this->optionId = $optionId;
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
   * Gets description.
   *
   * @return string
   *   The description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Sets description.
   *
   * @param string $description
   *   The description.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Gets currency.
   *
   * @return \MantraLibrary\Model\PortalCurrency
   *   The PortalCurrency object.
   */
  public function getCurrency() {
    return $this->currency;
  }

  /**
   * Sets currency.
   *
   * @param \MantraLibrary\Model\PortalCurrency $currency
   *   The PortalCurrency object.
   *
   * @return $this
   */
  public function setCurrency(PortalCurrency $currency) {
    $this->currency = $currency;
    return $this;
  }

  /**
   * Gets languagePairs.
   *
   * @return \MantraLibrary\Model\PortalLanguagePair[]
   *   Array of PortalLanguagePair.
   */
  public function getLanguagePairs() {
    return $this->languagePairs;
  }

  /**
   * Sets languagePairs.
   *
   * @param \MantraLibrary\Model\PortalLanguagePair[] $languagePairs
   *   Array of PortalLanguagePair.
   *
   * @return $this
   */
  public function setLanguagePairs(array $languagePairs) {
    $this->languagePairs = $languagePairs;
    return $this;
  }

  /**
   * Gets extensions.
   *
   * @return string
   *   The extension.
   */
  public function getExtensions() {
    return $this->extensions;
  }

  /**
   * Sets extensions.
   *
   * @param string $extensions
   *   The extension.
   *
   * @return $this
   */
  public function setExtensions($extensions) {
    $this->extensions = $extensions;
    return $this;
  }

}
