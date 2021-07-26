<?php

namespace MantraLibrary\Model;

/**
 * PortalCurrency class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalCurrency extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'code' => 'string',
    'decimalPlaces' => 'int',
    'description' => 'string',
    'spaceInFormat' => 'boolean',
    'symbol' => 'string',
    'symbolLast' => 'boolean',
  ];

  /**
   * Array of attributes. The key is the local, the value is the original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'code' => 'Code',
    'decimalPlaces' => 'DecimalPlaces',
    'description' => 'Description',
    'spaceInFormat' => 'SpaceInFormat',
    'symbol' => 'Symbol',
    'symbolLast' => 'SymbolLast',
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
   * Property $decimalPlaces.
   *
   * @var int
   */
  protected $decimalPlaces;

  /**
   * Property $description.
   *
   * @var string
   */
  protected $description;

  /**
   * Property $spaceInFormat.
   *
   * @var bool
   */
  protected $spaceInFormat;

  /**
   * Property $symbol.
   *
   * @var string
   */
  protected $symbol;

  /**
   * Property $symbolLast.
   *
   * @var bool
   */
  protected $symbolLast;

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

      if (in_array($object_property,
            [
              'decimalPlaces',
              'spaceInFormat',
              'symbolLast',
            ])) {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      else {
        $this->$object_property = $value;
      }
    }
  }

  /**
   * Gets code.
   *
   * @return string
   *   Currency code.
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Sets code.
   *
   * @param string $code
   *   Currency code.
   *
   * @return $this
   */
  public function setCode($code) {
    $this->code = $code;
    return $this;
  }

  /**
   * Gets decimalPlaces.
   *
   * @return int
   *   Decimal places.
   */
  public function getDecimalPlaces() {
    return $this->decimalPlaces;
  }

  /**
   * Sets decimalPlaces.
   *
   * @param int $decimalPlaces
   *   Decimal places.
   *
   * @return $this
   */
  public function setDecimalPlaces($decimalPlaces) {
    $this->decimalPlaces = $decimalPlaces;
    return $this;
  }

  /**
   * Gets description.
   *
   * @return string
   *   Currency description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Sets description.
   *
   * @param string $description
   *   Currency description.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Gets spaceInFormat.
   */
  public function getSpaceInFormat() {
    return $this->spaceInFormat;
  }

  /**
   * Sets spaceInFormat.
   *
   * @param bool $spaceInFormat
   *   TRUE if spaceInFormat.
   *
   * @return $this
   */
  public function setSpaceInFormat($spaceInFormat) {
    $this->spaceInFormat = $spaceInFormat;
    return $this;
  }

  /**
   * Gets symbol.
   *
   * @return string
   *   Currency symbol.
   */
  public function getSymbol() {
    return $this->symbol;
  }

  /**
   * Sets symbol.
   *
   * @param string $symbol
   *   Currency symbol.
   *
   * @return $this
   */
  public function setSymbol($symbol) {
    $this->symbol = $symbol;
    return $this;
  }

  /**
   * Gets symbolLast.
   *
   * @return bool
   *   True if last symbol.
   */
  public function getSymbolLast() {
    return $this->symbolLast;
  }

  /**
   * Sets symbolLast.
   *
   * @param bool $symbolLast
   *   True if last symbol.
   *
   * @return $this
   */
  public function setSymbolLast($symbolLast) {
    $this->symbolLast = $symbolLast;
    return $this;
  }

}
