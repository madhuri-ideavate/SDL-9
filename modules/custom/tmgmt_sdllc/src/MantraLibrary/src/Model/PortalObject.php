<?php

namespace MantraLibrary\Model;

/**
 * PortalObject class.
 *
 * This is the based class for all Mantra objects to be used for serialization.
 *
 * @category class
 * @package MantraLibrary\Model
 */
abstract class PortalObject {

  /**
   * Returns an array of ProperTypes.
   *
   * Map from class property name to data type.
   */
  abstract protected function getPropertyTypes();

  /**
   * Returns an array of AttributeMaps.
   *
   * Map from class property name to JSON seralized property name.
   */
  abstract protected function getPropertyMaps();

  /**
   * Check if a property is an array type.
   */
  protected function isArrayType($property) {
    if (preg_match('/\[\]$/', $this->getPropertyTypes()[$property])) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Return the data type of the class property.
   */
  protected function getPropertyType($property) {
    if ($property && array_key_exists($property, $this->getPropertyTypes())) {
      return rtrim($this->getPropertyTypes()[$property], '[]');
    }

    return $property;
  }

  /**
   * Return the class property name from the JSON property.
   */
  protected function getProperty($property_map) {
    $property = array_search($property_map, $this->getPropertyMaps());

    if ($property) {
      return $property;
    }

    return $property_map;
  }

  /**
   * Return the JSON property from the class property name.
   */
  protected function getPropertyMap($property) {
    return $this->getPropertyMaps()[$property];
  }

  /**
   * Switches the array keys from class property name to JSON property name.
   */
  private function updateKeyMap($array) {
    $arrayNew = [];

    foreach ($array as $key => $value) {
      $serializerKey = $this->getPropertyMap($key);

      $arrayNew[$serializerKey] = $value;
    }

    unset($array);

    return $arrayNew;
  }

  /**
   * Returns this object as an associated array.
   */
  public function toArray() {
    return $this->processArray($this->updateKeyMap(get_object_vars($this)));
  }

  /**
   * Converts class properties into an array.
   */
  private function processArray($array) {
    foreach ($array as $key => $value) {
      if (is_object($value)) {
        if (get_class($value) == 'DateTime' || get_class($value) == 'Drupal\Core\Datetime\DrupalDateTime') {
          $array[$key] = $value->format('Y-m-d\TH:i:s.u\Z');
        }
        else {
          $array[$key] = $value->toArray();
        }

      }
      if (is_array($value)) {
        $array[$key] = $this->processArray($value);
      }
    }
    // If the property isn't an object or array, leave it untouched.
    return $array;
  }

  /**
   * Write the object to JSON.
   */
  public function __toString() {
    $array = $this->toArray();
    return json_encode($array);
  }

}
