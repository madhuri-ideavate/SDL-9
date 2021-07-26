<?php

namespace MantraLibrary\Model;

/**
 * PortalMetadata class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalMetadata extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'id' => 'string',
    'name' => 'string',
    'description' => 'string',
    'value' => 'string',
    'language' => '\MantraLibrary\Model\PortalLanguage',
    'defaultValue' => 'string',
    'watermark' => 'string',
    'type' => 'int',
    'control' => 'int',
    'options' => 'string[]',
    'maximumLength' => 'int',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'id' => 'Id',
    'name' => 'Name',
    'description' => 'Description',
    'value' => 'Value',
    'language' => 'Language',
    'defaultValue' => 'DefaultValue',
    'watermark' => 'Watermark',
    'type' => 'Type',
    'control' => 'Control',
    'options' => 'Options',
    'maximumLength' => 'MaximumLength',
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
   * Property $id.
   *
   * @var string
   */
  protected $id;

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
   * Property $value.
   *
   * @var string
   */
  protected $value;

  /**
   * Property $language.
   *
   * @var \MantraLibrary\Model\PortalLanguage
   */
  protected $language;

  /**
   * Property $defaultValue.
   *
   * @var string
   */
  protected $defaultValue;

  /**
   * Property $watermark.
   *
   * @var string
   */
  protected $watermark;

  /**
   * Property $type.
   *
   * @var int
   *   Enum type: 0 => Job, 1 => Language.
   */
  protected $type;

  /**
   * For $type mapping.
   *
   * @var array
   */
  const METADATA_TYPE = [
    'Job',
    'Language',
  ];

  /**
   * Property $control.
   *
   * @var int
   *   enum type: 0 => Input, 1 => TextArea, 2 => Calendar, 3 => Checkbox, 4 =>
   * PickList, 5 => LanguagePickList, 6 => Numeric.
   */
  protected $control;

  /**
   * For $control mapping.
   *
   * @var array
   */
  const METADATA_UI_CONTROL = [
    'Input',
    'TextArea',
    'Calendar',
    'Checkbox',
    'PickList',
    'LanguagePickList',
    'Numeric',
  ];

  /**
   * Property $options.
   *
   * @var string[]
   */
  protected $options;

  /**
   * Property $maximumLength.
   *
   * @var int
   */
  protected $maximumLength;

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
      $object_type = $this->getPropertyType($property);

      if (!property_exists($this, $object_property)) {
        continue;
      }

      if ($object_property == 'options') {
        $this->$object_property = [];

        foreach ($value as $k => $v) {
          $this->$object_property[$k] = $v;
        }
      }
      elseif ($object_property == 'language') {
        $this->$object_property = new PortalLanguage($value);
      }
      elseif (in_array($object_property,
        [
          'type',
          'control',
          'maximumLength',
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
   * Gets id.
   *
   * @return string
   *   The id.
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Sets id.
   *
   * @param string $id
   *   The id.
   *
   * @return $this
   */
  public function setId($id) {
    $this->id = $id;
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
   * Gets value.
   *
   * @return string
   *   The value.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Sets value.
   *
   * @param string $value
   *   The value.
   *
   * @return $this
   */
  public function setValue($value) {
    $this->value = $value;
    return $this;
  }

  /**
   * Gets language.
   *
   * @return \MantraLibrary\Model\PortalLanguage
   *   The PortalLanguage object.
   */
  public function getLanguage() {
    return $this->language;
  }

  /**
   * Sets language.
   *
   * @param \MantraLibrary\Model\PortalLanguage $language
   *   The PortalLanguage object.
   *
   * @return $this
   */
  public function setLanguage(PortalLanguage $language) {
    $this->language = $language;
    return $this;
  }

  /**
   * Gets defaultValue.
   *
   * @return string
   *   The default value.
   */
  public function getDefaultValue() {
    return $this->defaultValue;
  }

  /**
   * Sets defaultValue.
   *
   * @param string $defaultValue
   *   The default value.
   *
   * @return $this
   */
  public function setDefaultValue($defaultValue) {
    $this->defaultValue = $defaultValue;
    return $this;
  }

  /**
   * Gets watermark.
   *
   * @return string
   *   The watermark.
   */
  public function getWatermark() {
    return $this->watermark;
  }

  /**
   * Sets watermark.
   *
   * @param string $watermark
   *   The watermark.
   *
   * @return $this
   */
  public function setWatermark($watermark) {
    $this->watermark = $watermark;
    return $this;
  }

  /**
   * Gets type.
   *
   * @return int
   *   The type.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Gets type mapping.
   *
   * @return string
   *   The type name.
   */
  public function getTypeName() {
    if (in_array($this->type, self::METADATA_TYPE)) {
      return self::METADATA_TYPE[$this->type];
    }

    return '';
  }

  /**
   * Sets type.
   *
   * @param int $type
   *   The type name.
   *
   * @return $this
   */
  public function setType($type) {
    $this->type = $type;
    return $this;
  }

  /**
   * Gets control.
   *
   * @return int
   *   The control.
   */
  public function getControl() {
    return $this->control;
  }

  /**
   * Gets control mapping.
   *
   * @return string
   *   The control name.
   */
  public function getControlName() {
    if (in_array($this->control, self::METADATA_UI_CONTROL)) {
      return self::METADATA_UI_CONTROL[$this->control];
    }

    return '';
  }

  /**
   * Sets control.
   *
   * @param int $control
   *   The control id.
   *
   * @return $this
   */
  public function setControl($control) {
    $this->control = $control;
    return $this;
  }

  /**
   * Gets options.
   *
   * @return string[]
   *   The options.
   */
  public function getOptions() {
    return $this->options;
  }

  /**
   * Sets options.
   *
   * @param string[] $options
   *   The options.
   *
   * @return $this
   */
  public function setOptions(array $options) {
    $this->options = $options;
    return $this;
  }

  /**
   * Gets maximumLength.
   *
   * @return int
   *   The maximum lenght.
   */
  public function getMaximumLength() {
    return $this->maximumLength;
  }

  /**
   * Sets maximumLength.
   *
   * @param int $maximumLength
   *   The max length.
   *
   * @return $this
   */
  public function setMaximumLength($maximumLength) {
    $this->maximumLength = $maximumLength;
    return $this;
  }

}
