<?php

namespace MantraLibrary\Model;

/**
 * PortalJobLanguageStatus class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalJobLanguageStatus extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'language' => '\MantraLibrary\Model\PortalLanguage',
    'files' => '\MantraLibrary\Model\PortalJobFileDetails[]',
    'perfectMatchWords' => 'int',
    'hundredWords' => 'int',
    'fuzzyWords' => 'int',
    'newWords' => 'int',
    'repeatedWords' => 'int',
    'tmLeverage' => 'double',
    'tmSavings' => 'double',
    'totalCost' => 'double',
    'percentComplete' => 'int',
    'totalWords' => 'int',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'language' => 'Language',
    'files' => 'Files',
    'perfectMatchWords' => 'PerfectMatchWords',
    'hundredWords' => 'HundredWords',
    'fuzzyWords' => 'FuzzyWords',
    'newWords' => 'NewWords',
    'repeatedWords' => 'RepeatedWords',
    'tmLeverage' => 'TMLeverage',
    'tmSavings' => 'TMSavings',
    'totalCost' => 'TotalCost',
    'percentComplete' => 'PercentComplete',
    'totalWords' => 'TotalWords',
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
   * Property $language.
   *
   * @var \MantraLibrary\Model\PortalLanguage
   */
  protected $language;

  /**
   * Property  $files.
   *
   * @var \MantraLibrary\Model\PortalJobFileDetails[]
   */
  protected $files;

  /**
   * Property $perfectMatchWords.
   *
   * @var int
   */
  protected $perfectMatchWords;

  /**
   * Property $hundredWords.
   *
   * @var int
   */
  protected $hundredWords;

  /**
   * Property $fuzzyWords.
   *
   * @var int
   */
  protected $fuzzyWords;

  /**
   * Property $newWords.
   *
   * @var int
   */
  protected $newWords;

  /**
   * Property $repeatedWords.
   *
   * @var int
   */
  protected $repeatedWords;

  /**
   * Property $tmLeverage.
   *
   * @var double
   */
  protected $tmLeverage;

  /**
   * Property $tmSavings.
   *
   * @var double
   */
  protected $tmSavings;

  /**
   * Property $totalCost.
   *
   * @var double
   */
  protected $totalCost;

  /**
   * Property $percentComplete.
   *
   * @var int
   */
  protected $percentComplete;

  /**
   * Property $totalWords.
   *
   * @var int
   */
  protected $totalWords;

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

      if ($object_property == 'language') {

        $this->$object_property = new PortalLanguage($value);
      }
      elseif ($object_property == 'files') {
        $object_array = [];

        foreach ($value as $v) {
          $object_array[] = new PortalJobFileDetails($v);
        }

        $this->$object_property = $object_array;
      }
      else {
        settype($value, $object_type);
        $this->$object_property = $value;
      }
    }
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
   * Gets files.
   *
   * @return \MantraLibrary\Model\PortalJobFileDetails[]
   *   Array of PortalJobFileDetails object.
   */
  public function getFiles() {
    return $this->files;
  }

  /**
   * Sets files.
   *
   * @param \MantraLibrary\Model\PortalJobFileDetails[] $files
   *   Array of PortalJobFileDetails object.
   *
   * @return $this
   */
  public function setFiles(array $files) {
    $this->files = $files;
    return $this;
  }

  /**
   * Gets perfectMatchWords.
   *
   * @return int
   *   The number of matched words.
   */
  public function getPerfectMatchWords() {
    return $this->perfectMatchWords;
  }

  /**
   * Sets perfectMatchWords.
   *
   * @param int $perfectMatchWords
   *   The number of matched words.
   *
   * @return $this
   */
  public function setPerfectMatchWords($perfectMatchWords) {
    $this->perfectMatchWords = $perfectMatchWords;
    return $this;
  }

  /**
   * Gets hundredWords.
   *
   * @return int
   *   The hundred work count.
   */
  public function getHundredWords() {
    return $this->hundredWords;
  }

  /**
   * Sets hundredWords.
   *
   * @param int $hundredWords
   *   The hundred work count.
   *
   * @return $this
   */
  public function setHundredWords($hundredWords) {
    $this->hundredWords = $hundredWords;
    return $this;
  }

  /**
   * Gets fuzzyWords.
   *
   * @return int
   *   The fuzzy work count.
   */
  public function getFuzzyWords() {
    return $this->fuzzyWords;
  }

  /**
   * Sets fuzzyWords.
   *
   * @param int $fuzzyWords
   *   The fuzzy work count.
   *
   * @return $this
   */
  public function setFuzzyWords($fuzzyWords) {
    $this->fuzzyWords = $fuzzyWords;
    return $this;
  }

  /**
   * Gets newWords.
   *
   * @return int
   *   The new word count.
   */
  public function getNewWords() {
    return $this->newWords;
  }

  /**
   * Sets newWords.
   *
   * @param int $newWords
   *   The new word count.
   *
   * @return $this
   */
  public function setNewWords($newWords) {
    $this->newWords = $newWords;
    return $this;
  }

  /**
   * Gets repeatedWords.
   *
   * @return int
   *   The repeated word count.
   */
  public function getRepeatedWords() {
    return $this->repeatedWords;
  }

  /**
   * Sets repeatedWords.
   *
   * @param int $repeatedWords
   *   The repeated word count.
   *
   * @return $this
   */
  public function setRepeatedWords($repeatedWords) {
    $this->repeatedWords = $repeatedWords;
    return $this;
  }

  /**
   * Gets tmLeverage.
   *
   * @return double
   *   The leverage.
   */
  public function getTmLeverage() {
    return $this->tmLeverage;
  }

  /**
   * Sets tmLeverage.
   *
   * @param double $tmLeverage
   *   The leverage.
   *
   * @return $this
   */
  public function setTmLeverage(double $tmLeverage) {
    $this->tmLeverage = $tmLeverage;
    return $this;
  }

  /**
   * Gets tmSavings.
   *
   * @return double
   *   The savings.
   */
  public function getTmSavings() {
    return $this->tmSavings;
  }

  /**
   * Sets tmSavings.
   *
   * @param double $tmSavings
   *   The savings.
   *
   * @return $this
   */
  public function setTmSavings(double $tmSavings) {
    $this->tmSavings = $tmSavings;
    return $this;
  }

  /**
   * Gets totalCost.
   *
   * @return double
   *   The total cost.
   */
  public function getTotalCost() {
    return $this->totalCost;
  }

  /**
   * Sets totalCost.
   *
   * @param double $totalCost
   *   The total cost.
   *
   * @return $this
   */
  public function setTotalCost(double $totalCost) {
    $this->totalCost = $totalCost;
    return $this;
  }

  /**
   * Gets percentComplete.
   *
   * @return int
   *   The completed percentage.
   */
  public function getPercentComplete() {
    return $this->percentComplete;
  }

  /**
   * Sets percentComplete.
   *
   * @param int $percentComplete
   *   The completed percentage.
   *
   * @return $this
   */
  public function setPercentComplete($percentComplete) {
    $this->percentComplete = $percentComplete;
    return $this;
  }

  /**
   * Gets totalWords.
   *
   * @return int
   *   The total word count.
   */
  public function getTotalWords() {
    return $this->totalWords;
  }

  /**
   * Sets totalWords.
   *
   * @param int $totalWords
   *   The total word count.
   *
   * @return $this
   */
  public function setTotalWords($totalWords) {
    $this->totalWords = $totalWords;
    return $this;
  }

}
