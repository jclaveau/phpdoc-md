<?php

namespace PHPDocMD;

class HTMLHelpers
{
    static function anchor($name, $link=null)
    {
        if ($link === null) {
            $link = MarkdownHelpers::anchorId($title);
        }
        
        return "<a href='#$link'>$name</a>";
    }
    
    static function link($link, $name=null)
    {
        if ( ! $name) {
            $name = $link;
        }
        return "<a href='$link'>$name</a>";
    }
    
    public static function classDocLink($className, $label=null)
    {
        if ( ! $label) {
            $label = $className;
        }
        
        // https://www.php.net/manual/en/language.types.php
        $target = null;
        if (in_array($className, ['string', 'array', 'float', 'integer', 'boolean', 'iterable', 'object', 'resource', 'null', 'callable'])) {
            $link = "https://www.php.net/manual/en/language.types.$className.php";
            $target = "_blank";
        } elseif (! $link = PHP\Helpers::classDocUrl($className)) {
            return $label;
        }

        return "<a href='$link' ".($target ? "target='".$target."'" : '').">$label</a>";
    }
}
