<?php
namespace   PHPDocMD;
use         PHPDocMD\HTMLHelpers as HTML;

class MarkdownHelpers
{
    static function anchorId($title)
    {
        $title = strtolower($title);
        $titleParts = preg_split('/\s+/', $title);
        foreach ($titleParts as &$part) {
            $part = preg_replace('/[[:punct:]]/', '', $part);
        }
        
        return implode('-', $titleParts);
    }
    
    static function anchor($title, $link=null)
    {
        if ($link === null) {
            $link = static::anchorId($title);
        }
        
        return "[$title](#$link)";
    }

    /**
     * Creates an index of classes and namespaces.
     *
     * @return string
     */
    public static function createIndex($definitions)
    {
        $tree = [];

        foreach ($definitions as $definerName => $info) {
            $current = & $tree;

            foreach (array_filter(explode('\\', $definerName)) as $part) {
                if (!isset($current[$part])) {
                    $current[$part] = [];
                }

                $current = & $current[$part];
            }
            
            
            $current = [];
            
            $current['Constants'] = [];
            $current['Properties'] = [];
            
            foreach ($info['methods'] as $method) {
                if ($definerName == $method->isDefinedBy()) {
                    $current[ $method->getName().'()' ] = [];
                }
            }
        }
        
        /**
         * This will be a reference to the $treeOutput closure, so that it can be invoked
         * recursively. A string is used to trick static analysers into thinking this might be
         * callable.
         */
        $treeOutput = '';

        $treeOutput = function($item, $fullString = '', $depth = 0) use (&$treeOutput) {
            $output = '';

            foreach ($item as $name => $subItems) {
                $fullName = $name;

                if ($fullString) {
                    $fullName = $fullString . '\\' . $name;
                }

                $output .= str_repeat(' ', $depth * 4) . '* ' . HTML::classDocLink('\\'.$fullName, $name) . "\n";
                $output .= $treeOutput($subItems, $fullName, $depth + 1);
            }

            return $output;
        };
        
        return $treeOutput($tree);
    }

    /**/
}
