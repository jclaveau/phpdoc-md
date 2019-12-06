<?php
namespace PHPDocMD;

class MyClass extends MyParentClass implements MyInterface
{
    protected $protectedProperty = 'protected';
    private   $privateProperty   = 'private';
    public    $publicProperty    = 'public';
    
    public function __construct()
    {
        
    }
    
    public function getter()
    {
        return $this->protectedProperty;
    }
    
    public function setter($value)
    {
        $this->protectedProperty = $value;
    }
    
    protected function protectedMethod()
    {
        return $this->protectedProperty;
    }
    
    protected function protectedMethod()
    {
        return $this->protectedProperty;
    }
} 
