<?php

namespace MantraLibrary\Model;

/**
 * PortalInstantQuote class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalInstantQuote extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'quoteId' => 'string',
    'cost' => 'double',
    'optionId' => 'string',
    'currencyCode' => 'string',
    'minimumChargeApplied' => 'bool',
    'showPdfWarning' => 'bool',
    'files' => '\MantraLibrary\Model\PortalUploadedFile[]',
    'options' => '\MantraLibrary\Model\PortalInstantQuoteOption[]',
    'languagePairs' => '\MantraLibrary\Model\PortalLanguagePair[]',
    'extensions' => 'string',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'quoteId' => 'QuoteId',
    'cost' => 'Cost',
    'optionId' => 'OptionId',
    'currencyCode' => 'CurrencyCode',
    'minimumChargeApplied' => 'MinimumChargeApplied',
    'showPdfWarning' => 'ShowPdfWarning',
    'files' => 'Files',
    'options' => 'Options',
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
   * Property $quoteId.
   *
   * @var string
   */
  protected $quoteId;

  /**
   * Property $cost.
   *
   * @var double
   */
  protected $cost;

  /**
   * Property $optionId.
   *
   * @var string
   */
  protected $optionId;

  /**
   * Property $currencyCode.
   *
   * @var string
   */
  protected $currencyCode;

  /**
   * Property $minimumChargeApplied.
   *
   * @var bool
   */
  protected $minimumChargeApplied;

  /**
   * Property $showPdfWarning.
   *
   * @var bool
   */
  protected $showPdfWarning;

  /**
   * Property $files.
   *
   * @var \MantraLibrary\Model\PortalUploadedFile[]
   */
  protected $files;

  /**
   * Property $options.
   *
   * @var \MantraLibrary\Model\PortalInstantQuoteOption[]
   */
  protected $options;

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
      $object_type = $this->getPropertyType($object_property);

      if (!property_exists($this, $object_property)) {
        continue;
      }

      if (in_array($object_property,
            [
              'cost',
              'minimumChargeApplied',
              'showPdfWarning',
            ])) {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
      elseif ($object_property == 'languagePairs') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new PortalLanguagePair($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'options') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new PortalInstantQuoteOption($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'files') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new PortalUploadedFile($v);
        }

        $this->$object_property = $object_array;
      }
      else {
        $this->$object_property = $value;
      }
    }
  }

  /**
   * Gets quoteId.
   *
   * @return string
   *   The quote Id.
   */
  public function getQuoteId() {
    return $this->quoteId;
  }

  /**
   * Sets quoteId.
   *
   * @param string $quoteId
   *   The quote Id.
   *
   * @return $this
   */
  public function setQuoteId($quoteId) {
    $this->quoteId = $quoteId;
    return $this;
  }

  /**
   * Gets cost.
   *
   * @return double
   *   The cost.
   */
  public function getCost() {
    return $this->cost;
  }

  /**
   * Sets cost.
   *
   * @param double $cost
   *   The cost.
   *
   * @return $this
   */
  public function setCost(double $cost) {
    $this->cost = $cost;
    return $this;
  }

  /**
   * Gets optionId.
   *
   * @return string
   *   The option Id.
   */
  public function getOptionId() {
    return $this->optionId;
  }

  /**
   * Sets optionId.
   *
   * @param string $optionId
   *   The option Id.
   *
   * @return $this
   */
  public function setOptionId($optionId) {
    $this->optionId = $optionId;
    return $this;
  }

  /**
   * Gets currencyCode.
   *
   * @return string
   *   The Currency Code.
   */
  public function getCurrencyCode() {
    return $this->currencyCode;
  }

  /**
   * Sets currencyCode.
   *
   * @param string $currencyCode
   *   The Currency Code.
   *
   * @return $this
   */
  public function setCurrencyCode($currencyCode) {
    $this->currencyCode = $currencyCode;
    return $this;
  }

  /**
   * Gets minimumChargeApplied.
   *
   * @return bool
   *   True if minimum charge is applied, false otherwise.
   */
  public function getMinimumChargeApplied() {
    return $this->minimumChargeApplied;
  }

  /**
   * Sets minimumChargeApplied.
   *
   * @param bool $minimumChargeApplied
   *   True if minimum charge is applied, false otherwise.
   *
   * @return $this
   */
  public function setMinimumChargeApplied($minimumChargeApplied) {
    $this->minimumChargeApplied = $minimumChargeApplied;
    return $this;
  }

  /**
   * Gets showPdfWarning.
   *
   * @return bool
   *   True if show pdf warning, false otherwise.
   */
  public function getShowPdfWarning() {
    return $this->showPdfWarning;
  }

  /**
   * Sets showPdfWarning.
   *
   * @param bool $showPdfWarning
   *   True if show pdf warning, false otherwise.
   *
   * @return $this
   */
  public function setShowPdfWarning($showPdfWarning) {
    $this->showPdfWarning = $showPdfWarning;
    return $this;
  }

  /**
   * Gets files.
   *
   * @return \MantraLibrary\Model\PortalUploadedFile[]
   *   Array of PortalUploadedFile object.
   */
  public function getFiles() {
    return $this->files;
  }

  /**
   * Sets files.
   *
   * @param \MantraLibrary\Model\PortalUploadedFile[] $files
   *   Array of PortalUploadedFile object.
   *
   * @return $this
   */
  public function setFiles(array $files) {
    $this->files = $files;
    return $this;
  }

  /**
   * Gets options.
   *
   * @return \MantraLibrary\Model\PortalInstantQuoteOption[]
   *   Array of PortalInstantQuoteOption object.
   */
  public function getOptions() {
    return $this->options;
  }

  /**
   * Sets options.
   *
   * @param \MantraLibrary\Model\PortalInstantQuoteOption[] $options
   *   Array of PortalInstantQuoteOption object.
   *
   * @return $this
   */
  public function setOptions(array $options) {
    $this->options = $options;
    return $this;
  }

  /**
   * Gets languagePairs.
   *
   * @return \MantraLibrary\Model\PortalLanguagePair[]
   *   Array of PortalLanguagePair object.
   */
  public function getLanguagePairs() {
    return $this->languagePairs;
  }

  /**
   * Sets languagePairs.
   *
   * @param \MantraLibrary\Model\PortalLanguagePair[] $languagePairs
   *   Array of PortalLanguagePair object.
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
   *   The extensions.
   */
  public function getExtensions() {
    return $this->extensions;
  }

  /**
   * Sets extensions.
   *
   * @param string $extensions
   *   The extensions.
   *
   * @return $this
   */
  public function setExtensions($extensions) {
    $this->extensions = $extensions;
    return $this;
  }

}
