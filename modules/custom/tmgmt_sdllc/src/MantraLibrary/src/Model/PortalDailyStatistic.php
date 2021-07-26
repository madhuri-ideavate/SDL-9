<?php

namespace MantraLibrary\Model;

use Drupal\Core\Datetime\Element\Datetime;

/**
 * PortalDailyStatistic class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalDailyStatistic extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'date' => '\DateTime',
    'totalJobs' => 'int',
    'totalWords' => 'int',
    'totalFiles' => 'int',
    'overallLeverage' => 'double',
    'costs' => '\MantraLibrary\Model\Cost[]',
    'savings' => '\MantraLibrary\Model\Cost[]',
    'languages' => '\MantraLibrary\Model\PortalLanguagePairWordCount[]',
    'leverage' => 'array[]',
  ];

  /**
   * Array of attributes where the key is the local, the value is original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'date' => 'Date',
    'totalJobs' => 'TotalJobs',
    'totalWords' => 'TotalWords',
    'totalFiles' => 'TotalFiles',
    'overallLeverage' => 'OverallLeverage',
    'costs' => 'Costs',
    'savings' => 'Savings',
    'languages' => 'Languages',
    'leverage' => 'Leverage',
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
   * Property $date.
   *
   * @var \DateTime
   */
  protected $date;

  /**
   * Property $totalJobs.
   *
   * @var int
   */
  protected $totalJobs;

  /**
   * Property $totalWords.
   *
   * @var int
   */
  protected $totalWords;

  /**
   * Property $totalFiles.
   *
   * @var int
   */
  protected $totalFiles;

  /**
   * Property overallLeverage.
   *
   * @var double
   */
  protected $overallLeverage;

  /**
   * Property $costs.
   *
   * @var \MantraLibrary\Model\Cost[]
   */
  protected $costs;

  /**
   * Property $savings.
   *
   * @var \MantraLibrary\Model\Cost[]
   */
  protected $savings;

  /**
   * Property $languages.
   *
   * @var \MantraLibrary\Model\PortalLanguagePairWordCount[]
   */
  protected $languages;

  /**
   * Property $leverage.
   *
   * @var array
   */
  protected $leverage;

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
        'costs',
        'savings',
      ])) {
        $object_array = [];

        foreach ($value as $k => $v) {
          $object_array[] = new Cost($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'languages') {
        $object_array = [];

        foreach ($value as $k => $v) {
          $object_array[] = new PortalLanguagePairWordCount($v);
        }

        $this->$object_property = $object_array;
      }
      elseif ($object_property == 'leverage') {
        $object_array = [];

        foreach ($value as $k => $v) {
          $object_array[$k] = $v;
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
   * Gets date.
   *
   * @return \DateTime
   *   The date.
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Sets date.
   *
   * @param DateTime $date
   *   The date.
   *
   * @return $this
   */
  public function setDate(DateTime $date) {
    $this->date = $date;
    return $this;
  }

  /**
   * Gets totalJobs.
   *
   * @return int
   *   Number of jobs.
   */
  public function getTotalJobs() {
    return $this->totalJobs;
  }

  /**
   * Sets totalJobs.
   *
   * @param int $totalJobs
   *   Number of jobs.
   *
   * @return $this
   */
  public function setTotalJobs($totalJobs) {
    $this->totalJobs = $totalJobs;
    return $this;
  }

  /**
   * Gets totalWords.
   *
   * @return int
   *   Number of words.
   */
  public function getTotalWords() {
    return $this->totalWords;
  }

  /**
   * Sets totalWords.
   *
   * @param int $totalWords
   *   Number of words.
   *
   * @return $this
   */
  public function setTotalWords($totalWords) {
    $this->totalWords = $totalWords;
    return $this;
  }

  /**
   * Gets totalFiles.
   *
   * @return int
   *   Number of files.
   */
  public function getTotalFiles() {
    return $this->totalFiles;
  }

  /**
   * Sets totalFiles.
   *
   * @param int $totalFiles
   *   Number of files.
   *
   * @return $this
   */
  public function setTotalFiles($totalFiles) {
    $this->totalFiles = $totalFiles;
    return $this;
  }

  /**
   * Gets overallLeverage.
   *
   * @return double
   *   The overall leverage.
   */
  public function getOverallLeverage() {
    return $this->overallLeverage;
  }

  /**
   * Sets overallLeverage.
   *
   * @param double $overallLeverage
   *   The overall leverage.
   *
   * @return $this
   */
  public function setOverallLeverage(double $overallLeverage) {
    $this->overallLeverage = $overallLeverage;
    return $this;
  }

  /**
   * Gets costs.
   *
   * @return \MantraLibrary\Model\Cost[]
   *   The Cost object.
   */
  public function getCosts() {
    return $this->costs;
  }

  /**
   * Sets costs.
   *
   * @param \MantraLibrary\Model\Cost[] $costs
   *   The Cost object.
   *
   * @return $this
   */
  public function setCosts(array $costs) {
    $this->costs = $costs;
    return $this;
  }

  /**
   * Gets savings.
   *
   * @return \MantraLibrary\Model\Cost[]
   *   Array of cost objects.
   */
  public function getSavings() {
    return $this->savings;
  }

  /**
   * Sets savings.
   *
   * @param \MantraLibrary\Model\Cost[] $savings
   *   Array of cost objects.
   *
   * @return $this
   */
  public function setSavings(array $savings) {
    $this->savings = $savings;
    return $this;
  }

  /**
   * Gets languages.
   *
   * @return \MantraLibrary\Model\PortalLanguagePairWordCount[]
   *   Array of PortalLanguagePairWordCount.
   */
  public function getLanguages() {
    return $this->languages;
  }

  /**
   * Sets languages.
   *
   * @param \MantraLibrary\Model\PortalLanguagePairWordCount[] $languages
   *   Array of PortalLanguagePairWordCount.
   *
   * @return $this
   */
  public function setLanguages(array $languages) {
    $this->languages = $languages;
    return $this;
  }

  /**
   * Gets leverage.
   *
   * @return array
   *   The leverage.
   */
  public function getLeverage() {
    return $this->leverage;
  }

  /**
   * Sets leverage.
   *
   * @param array $leverage
   *   The leverage.
   *
   * @return $this
   */
  public function setLeverage(array $leverage) {
    $this->leverage = $leverage;
    return $this;
  }

}
