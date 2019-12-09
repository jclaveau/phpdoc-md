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
    
    public static function classLink($className)
    {
        // https://www.php.net/manual/en/language.types.php
        $target = null;
        if (in_array($className, ['string', 'array', 'float', 'integer', 'boolean', 'iterable', 'object', 'resource', 'null', 'callable'])) {
            $link = "https://www.php.net/manual/en/language.types.$className.php";
            $target = "_blank";
        } elseif (! $link = Generator::classUrl($className)) {
            return $className;
        }

        return "<a href='$link' ".($target ? "target='".$target."'" : '').">$className</a>";
    }
}
