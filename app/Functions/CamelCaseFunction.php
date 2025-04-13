<?php

namespace App\Functions;

class CamelCaseFunction
{
    public static function snakeToCamelCase($value)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $value))));
    }

    public static function convertKeysToCamelCase($data)
    {
        if (is_array($data)) {
            // If the array is sequential (list of objects or associative array with numeric indices)
            $camelCaseArray = [];
            foreach ($data as $key => $value) {
                // Check if this is an array or object
                $newKey = is_string($key) ? CamelCaseFunction::snakeToCamelCase($key) : $key;
                $camelCaseArray[$newKey] = is_array($value) || is_object($value)
                    ? CamelCaseFunction::convertKeysToCamelCase($value)
                    : $value;
            }
            return $camelCaseArray;
        } elseif (is_object($data)) {
            $camelCaseObject = new \stdClass();
            foreach (get_object_vars($data) as $key => $value) {
                $newKey = CamelCaseFunction::snakeToCamelCase($key);
                $camelCaseObject->$newKey = is_array($value) || is_object($value)
                    ? CamelCaseFunction::convertKeysToCamelCase($value)
                    : $value;
            }
            return $camelCaseObject;
        }
        // Return unchanged if not array or object
        return $data;
    }

}

