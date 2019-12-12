<?php

namespace   PHPDocMD\PHP;
use         PHPDocMD\MarkdownHelpers as MD;

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
    static function definitionPathParts($definitionPath)
    {
        // $definitionPath = "PHPDocMD\MyParentClass::lalala()";
        preg_match('#^([^:]*\\\\)?([^:\\\\]+)(::(\$?([^\(]+)\(\)))?$#', $definitionPath, $matches);
        // var_dump($matches);
        // exit;
        
        $out = [
            'namespace' => $matches[1] != '\\' ? rtrim($matches[1], '\\') : $matches[1],
            'definer'   => $matches[2],
            'typedName' => isset($matches[4]) ? $matches[4] : '',
            'name'      => isset($matches[5]) ? $matches[5] : '',
            'type'      => null,
        ];
        
        if (preg_match("/\(\)$/", $out['typedName'])) {
            $out['type'] = 'method';
        }
        elseif (preg_match("/^\$/", $out['typedName'])) {
            $out['type'] = 'property';
        }
        elseif ($out['typedName']) {
            $out['type'] = 'constant';
        }
        
        return $out;
    }
    
    /**
     * This function allows us to easily link classes to their existing 
     * documentation pages.
     *
     * @param string $className
     *
     * @return string The relative URL
     */
    static function docUrl($definitionName)
    {
        $parts = self::definitionPathParts($definitionName);
        extract($parts);
        
        $definitions = $GLOBALS['PHPDocMD_classDefinitions'];
        $out = null;
        if (isset($definitions[ $namespace.'\\'.$definer ])) {
            $out = $definitions[ $namespace.'\\'.$definer ]['docFile'];
            
            if ( ! empty($name)) {
                $type = $type == 'property' ? 'properties' : $type.'s';
                
                if (isset($definitions[ $namespace.'\\'.$definer ][ $type ][ $name ])) {
                    $out .= '#'.MD::anchorId($definitions[ $namespace.'\\'.$definer ][ $type ][ $name ]->getPath());
                }
            }
            
        }
        
        return $out;
    }
    
    /**/
}
