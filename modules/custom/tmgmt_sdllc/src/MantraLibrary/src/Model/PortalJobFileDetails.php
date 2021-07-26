<?php

namespace MantraLibrary\Model;

/**
 * PortalJobFileDetails class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalJobFileDetails extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'id' => 'string',
    'sourceId' => 'string',
    'language' => 'string',
    'name' => 'string',
    'perfectMatchWords' => 'int',
    'hundredWords' => 'int',
    'fuzzyWords' => 'int',
    'newWords' => 'int',
    'repeatedWords' => 'int',
    'tmLeverage' => 'double',
    'tmSavings' => 'double',
    'cost' => 'double',
    'totalWords' => 'int',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'id' => 'Id',
    'sourceId' => 'SourceId',
    'language' => 'Language',
    'name' => 'Name',
    'perfectMatchWords' => 'PerfectMatchWords',
    'hundredWords' => 'HundredWords',
    'fuzzyWords' => 'FuzzyWords',
    'newWords' => 'NewWords',
    'repeatedWords' => 'RepeatedWords',
    'tmLeverage' => 'TMLeverage',
    'tmSavings' => 'TMSavings',
    'cost' => 'Cost',
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
   * Property $id.
   *
   * @var string
   */
  protected $id;

  /**
   * Property $sourceId.
   *
   * @var string
   */
  protected $sourceId;

  /**
   * Property $language.
   *
   * @var string
   */
  protected $language;

  /**
   * Property $name.
   *
   * @var string
   */
  protected $name;

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
   * Property $cost.
   *
   * @var double
   */
  protected $cost;

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

      if (in_array($object_property,
            [
              'perfectMatchWords',
              'hundredWords',
              'fuzzyWords',
              'newWords',
              'repeatedWords',
              'tmLeverage',
              'tmSavings',
              'cost',
              'totalWords',
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
   * Gets sourceId.
   *
   * @return string
   *   The source id.
   */
  public function getSourceId() {
    return $this->sourceId;
  }

  /**
   * Sets sourceId.
   *
   * @param string $sourceId
   *   The source id.
   *
   * @return $this
   */
  public function setSourceId($sourceId) {
    $this->sourceId = $sourceId;
    return $this;
  }

  /**
   * Gets language.
   *
   * @return string
   *   The language.
   */
  public function getLanguage() {
    return $this->language;
  }

  /**
   * Sets language.
   *
   * @param string $language
   *   The language.
   *
   * @return $this
   */
  public function setLanguage($language) {
    $this->language = $language;
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
   *   The number of hundred words.
   */
  public function getHundredWords() {
    return $this->hundredWords;
  }

  /**
   * Sets hundredWords.
   *
   * @param int $hundredWords
   *   The number of hundred words.
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
   *   The number of fuzzy words.
   */
  public function getFuzzyWords() {
    return $this->fuzzyWords;
  }

  /**
   * Sets fuzzyWords.
   *
   * @param int $fuzzyWords
   *   The number of fuzzy words.
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
   *   The number of new words.
   */
  public function getNewWords() {
    return $this->newWords;
  }

  /**
   * Sets newWords.
   *
   * @param int $newWords
   *   The number of new words.
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
   *   The number of repeated words.
   */
  public function getRepeatedWords() {
    return $this->repeatedWords;
  }

  /**
   * Sets repeatedWords.
   *
   * @param int $repeatedWords
   *   The number of repeated words.
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
   * Gets totalWords.
   *
   * @return int
   *   The number of words.
   */
  public function getTotalWords() {
    return $this->totalWords;
  }

  /**
   * Sets totalWords.
   *
   * @param int $totalWords
   *   The number of words.
   *
   * @return $this
   */
  public function setTotalWords($totalWords) {
    $this->totalWords = $totalWords;
    return $this;
  }

}
