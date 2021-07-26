<?php

namespace MantraLibrary\Model;

/**
 * PortalCreateProjectResponse class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalCreateProjectResponse extends PortalObject {

  /**
   * Array of property to type mappings. Used for (de)serialization.
   *
   * @var string[]
   */
  public static $propertyTypes = [
    'result' => 'int',
    'error' => 'string',
    'projectId' => 'string',
    'expectExtendedPreparationTime' => 'bool',
    'isUsersFirstProject' => 'bool',
  ];

  /**
   * Array of attributes. The key is the local, the value is the original name.
   *
   * @var string[]
   */
  public static $attributeMap = [
    'result' => 'Result',
    'error' => 'Error',
    'projectId' => 'ProjectId',
    'expectExtendedPreparationTime' => 'ExpectExtendedPreparationTime',
    'isUsersFirstProject' => 'IsUsersFirstProject',
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
   * Property $result.
   *
   * @var int
   */
  protected $result;

  /**
   * Property $error.
   *
   * @var string
   */
  protected $error;

  /**
   * Property $projectId.
   *
   * @var string
   */
  protected $projectId;

  /**
   * Property $expectExtendedPreparationTime.
   *
   * @var bool
   *    Indicating whether to expect extended preparation time.
   */
  protected $expectExtendedPreparationTime;

  /**
   * Property $isUsersFirstProject.
   *
   * @var bool
   */
  protected $isUsersFirstProject;

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
              'result',
              'expectExtendedPreparationTime',
              'isUsersFirstProject',
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
   * Gets result.
   *
   * @return int
   *   Result value.
   */
  public function getResult() {
    return $this->result;
  }

  /**
   * Sets result.
   *
   * @param int $result
   *   Result value.
   *
   * @return $this
   */
  public function setResult($result) {
    $allowed_values = [
      "0",
      "1",
      "2",
    ];
    if (!in_array($result, $allowed_values)) {
      throw new \InvalidArgumentException(
            "Invalid value for 'result', must be one of '0', '1', '2'");
    }
    $this->result = $result;
    return $this;
  }

  /**
   * Gets error.
   *
   * @return string
   *   Error string.
   */
  public function getError() {
    return $this->error;
  }

  /**
   * Sets error.
   *
   * @param string $error
   *   Error string.
   *
   * @return $this
   */
  public function setError($error) {
    $this->error = $error;
    return $this;
  }

  /**
   * Gets $projectId.
   *
   * @return string
   *   The project ID.
   */
  public function getProjectId() {
    return $this->projectId;
  }

  /**
   * Sets $projectId.
   *
   * @param string $projectId
   *   The project ID.
   *
   * @return $this
   */
  public function setProjectId($projectId) {
    $this->projectId = $projectId;
    return $this;
  }

  /**
   * Gets $expectExtendedPreparationTime.
   *
   * @return bool
   *   Indicating whether to expect extended preparation time.
   */
  public function getExpectExtendedPreparationTime() {
    return $this->expectExtendedPreparationTime;
  }

  /**
   * Sets $expectExtendedPreparationTime.
   *
   * @param bool $expectExtendedPreparationTime
   *   Indicating whether to expect extended preparation time.
   *
   * @return $this
   */
  public function setExpectExtendedPreparationTime(
    $expectExtendedPreparationTime) {
    $this->expectExtendedPreparationTime = $expectExtendedPreparationTime;
    return $this;
  }

  /**
   * Gets is_users_first_project.
   *
   * @return bool
   *   True if first project, false otherwise.
   */
  public function getIsUsersFirstProject() {
    return $this->is_users_first_project;
  }

  /**
   * Sets is_users_first_project.
   *
   * @param bool $isUsersFirstProject
   *   True if first project, false otherwise.
   *
   * @return $this
   */
  public function setIsUsersFirstProject($isUsersFirstProject) {
    $this->isUsersFirstProject = $isUsersFirstProject;
    return $this;
  }

}
