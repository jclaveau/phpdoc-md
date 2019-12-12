<?php
namespace PHPDocMD;

abstract class MyGrandParentClass
{
    protected static $myStaticProperty;
    
    public static function getStaticProperty()
    {
        return self::$myStaticProperty;
    }
}
