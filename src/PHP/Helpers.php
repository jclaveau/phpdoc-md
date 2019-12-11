<?php

namespace PHPDocMD\PHP;

class Helpers
{
    static function indexByDefiner(array $entries)
    {
        $entriesByDefiner = [];
        foreach ($entries as $entry) {
            
            $definer = is_object($entry)
                ? $entry->isDefinedBy()
                : $entry['definedBy'];
            
            
            if ( ! isset($entriesByDefiner[ $definer ])) {
                $entriesByDefiner[ $definer ] = [];
            }
            
            $entriesByDefiner[ $definer ][] = $entry;
        }
        
        return $entriesByDefiner;
    }
    
    /**
     * This function allows us to easily link classes to their existing pages.
     *
     * @param string $className
     *
     * @return string The relative URL
     */
    static function classUrl($className)
    {
        $classDefinitions = $GLOBALS['PHPDocMD_classDefinitions'];
        $linkTemplate = $GLOBALS['PHPDocMD_linkTemplate'];
        
        $returnedClasses = [];

        $className = trim($className, '\\ ');

        if ( ! isset($classDefinitions[$className])) {
            return null;
        } else {
            return $classDefinitions[$className]['fileName'];
        }
    }
    
    static function getRelativeNamespace(array $namespace, $referenceNamespace)
    {
        if (strpos($namespace, 0, 1) == '\\') {
            return $namespace; // already relative
        }
        
        return preg_replace("#^".preg_quote($referenceNamespace, '#')."\#", $namespace, '');
    }
}
