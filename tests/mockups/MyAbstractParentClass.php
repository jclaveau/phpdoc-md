<?php
namespace PHPDocMD;

abstract class MyParentClass
{
    protected static $myStaticProperty;
    
    public static function getter()
    {
        return self::$myStaticProperty;
    }
    
    public static function setter($value)
    {
        return self::$myStaticProperty = $value;
    }
}
