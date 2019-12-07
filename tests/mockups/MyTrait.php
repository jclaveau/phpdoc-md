<?php
namespace PHPDocMD;

trait MyTrait
{
    protected $protectedPropertyOfMyTrait = 'protected';
    
    public function getterOfMyTrait()
    {
        return $this->protectedProperty;
    }
    
    public function setterOfMyTrait($value)
    {
        $this->protectedProperty = $value;
    }
} 
