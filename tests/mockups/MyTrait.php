<?php
namespace PHPDocMD;

trait MyTrait
{
    protected $protectedPropertyOfMyTrait = 'protected';
    
    public function getterOfMyTrait()
    {
        return $this->protectedProperty;
    }
    
    public function setterOfMyTrait(array $value)
    {
        $this->protectedProperty = $value;
    }
} 
