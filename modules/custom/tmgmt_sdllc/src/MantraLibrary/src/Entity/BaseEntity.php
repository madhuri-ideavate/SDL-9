<?php
namespace MantraLibrary\Entity;

/**
 *
 * Base class for the SDL Language Cloud Manage Transation
 * This class will be inherited by all entityes
 * For helpers methods, please use MantraLibrary\Helper
 *
 * @author iflorian
 * @category class
 * @package MantraLibrary
 *         
 */
class BaseEntity
{

    /**
     * Creates getters and setter dynamically
     * Documentation: http://php.net/manual/ro/language.oop5.magic.php
     *
     * @param string $name
     * @param array $args
     * @return string|boolean
     */
    public function __call($name, $args)
    {
        if (isset($this->$name)) {

            if (isset($args[0])) {
                return $this->$name = $args[0];
            }

            return $this->$name;
        }

        return false;
    }
}