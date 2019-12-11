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
     * This function allows us to easily link classes to their existing 
     * documentation pages.
     *
     * @param string $className
     *
     * @return string The relative URL
     */
    static function classDocUrl($className)
    {
        $classDefinitions = $GLOBALS['PHPDocMD_classDefinitions'];
        $linkTemplate = $GLOBALS['PHPDocMD_linkTemplate'];
        
        $returnedClasses = [];

        $className = trim($className, '\\ ');

        if ( ! isset($classDefinitions[$className])) {
            return null;
        } else {
            return $classDefinitions[$className]['docFile'];
        }
    }
    
    /**
     * This function allows us to easily link classes/traits/interfaces
     * to their code.
     *
     * @param string $className
     *
     * @return string The relative URL
     */
    static function codeUrl($className)
    {
        $classDefinitions = $GLOBALS['PHPDocMD_classDefinitions'];
        $linkTemplate = $GLOBALS['PHPDocMD_linkTemplate'];
        
        $returnedClasses = [];

        $className = trim($className, '\\ ');

        if ( ! isset($classDefinitions[$className])) {
            return null;
        } else {
            return $classDefinitions[$className]['docFile'];
        }
    }
    
    static function getRelativeNamespace($namespace, $referenceNamespace)
    {
        if (strpos($namespace, 0, 1) == '\\') {
            return $namespace; // already relative
        }
        
        $relativeNamespace = preg_replace(
            $rgxp = "#^".preg_quote($referenceNamespace.'\\', '#')."#", 
            '',
            $namespace
        );
        
        return $relativeNamespace;
    }
    
    /**
     */
    static function definitionParts($definitionPath)
    {
        preg_match('#^([^:])?([^:\\])::([^\(]])#', $definitionPath, $matches);
        // var_dump($matches);
        var_dump($matches);
        exit;
    }
    
    
}
