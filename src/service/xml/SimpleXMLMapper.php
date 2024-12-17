<?php

namespace Capsphere\PhpCore\Service\Xml;

use SimpleXMLElement; 

class SimpleXMLMapper
{
    public static function mapToObject(SimpleXMLElement $xml, string $class)
    {
        $object = new $class();

        // Loop through each element in the XML and assign to the object's properties
        foreach ($xml as $key => $value) {
            $property = self::camelCase($key); // Convert XML element to camel case for property matching
            if (property_exists($object, $property)) {
                $object->$property = (string)$value;
            }
        }

        return $object;
    }

    // Function to handle conversion of snake_case (XML tags) to camelCase (PHP properties)
    private static function camelCase(string $string): string
    {
        $result = strtolower($string);
        preg_match_all('/_([a-z])/', $result, $matches);
        foreach ($matches[1] as $match) {
            $result = str_replace('_' . $match, strtoupper($match), $result);
        }
        return $result;
    }
}
