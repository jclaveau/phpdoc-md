<?php
namespace PHPDocMD;

abstract class MyParentClass
{
    protected static $myStaticProperty;
    
    public static function getStaticProperty()
    {
        return self::$myStaticProperty;
    }
    
    final public static function setStaticProperty($value)
    {
        return self::$myStaticProperty = $value;
    }
}
