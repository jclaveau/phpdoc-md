<?php
namespace PHPDocMD;

trait MyTrait
{
    /**
     * @var string|null $protectedPropertyOfMyTrait  A protected property of MyTrait
     * @var string|null $protectedPropertyOfMyTrait2 Second protected property of MyTrait
     */
    protected $protectedPropertyOfMyTrait, $protectedPropertyOfMyTrait2;
    
    public function getterOfMyTrait()
    {
        return $this->protectedProperty;
    }
    
    public function setterOfMyTrait(array $value)
    {
        $this->protectedProperty = $value;
    }
} 
