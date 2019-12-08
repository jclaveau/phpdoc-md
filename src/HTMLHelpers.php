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
}
