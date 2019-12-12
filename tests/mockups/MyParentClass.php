<?php
namespace PHPDocMD;

class MyParentClass extends MyGrandParentClass
{
    final public static function setStaticProperty($value)
    {
        return self::$myStaticProperty = $value;
    }
}
