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
        $relativeNamespace = preg_replace(
            $rgxp = "#^".preg_quote($referenceNamespace.'\\', '#')."#", 
            '',
            $namespace
        );
        
        // var_dump(get_defined_vars());
        // exit;
        
        return $relativeNamespace;
    }
    
    /**
     */
    static function definitionParts($definitionPath)
    {
        // $definitionPath = "PHPDocMD\MyParentClass::lalala(lolo)";
        preg_match('#^([^:]+\\\\)?([^:]+)(::([^\(]+))?#', $definitionPath, $matches);
        // var_dump($matches);
        return [
            'namespace' => rtrim($matches[1], '\\'),
            'definer'   => $matches[2],
            'name'      => isset($matches[4]) ? $matches[4] : '',
        ];
    }
    
    /**/
}
