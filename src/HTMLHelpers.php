<?php

namespace PHPDocMD;

class HTMLHelpers
{
    static function attributes($attributes)
    {
        if ( ! empty($attributes)) {
            $tmpAttributes = [];
            foreach ($attributes as $name => $value) {
                $tmpAttributes[] = "$name=\"$value\"";
            }
            return implode(' ', $tmpAttributes);
        }
        
        return '';
    }
    
    static function anchor($name, $link=null)
    {
        if ($link === null) {
            $link = MarkdownHelpers::anchorId($title);
        }
        
        return "<a href='#$link'>$name</a>";
    }
    
    static function link($link, $label=null, array $attributes=null)
    {
        if ( ! $label) {
            $label = $link;
        }
        
        $attributes = self::attributes($attributes);
        
        return "<a href='$link' $attributes>$label</a>";
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
    
    public static function docLink($className, $label=null)
    {
        if ( ! $label) {
            $label = $className;
        }
        
        // https://www.php.net/manual/en/language.types.php
        $target = null;
        if (in_array($className, ['string', 'array', 'float', 'integer', 'boolean', 'iterable', 'object', 'resource', 'null', 'callable'])) {
            $link = "https://www.php.net/manual/en/language.types.$className.php";
            $target = "_blank";
        } elseif (! $link = PHP\Helpers::docUrl($className)) {
            return $label;
        }

        return "<a href='$link' ".($target ? "target='".$target."'" : '').">$label</a>";
    }
    
    public static function heading($level, $label, $attributes=null)
    {
        if ($attributes !== null) {
            $attributes = self::attributes($attributes);
        }
        
        return "<h$level $attributes>$label</h$level>";
    }
}
