<?php

/**
 * Base model class
 * @class Model
 */
abstract class Model
{
    /**
     * validation function
     */
    abstract function validate();

    /**
     * Set model property
     * @param $property
     * @param $value
     */
    public function set($property, $value = null)
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }
}