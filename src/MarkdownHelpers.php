<?php

namespace PHPDocMD;

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
}
