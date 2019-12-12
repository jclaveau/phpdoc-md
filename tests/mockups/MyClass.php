<?php
namespace PHPDocMD;

class MyClass extends MyParentClass implements MyInterface, MySecondInterface
{
    use MyTrait;

    const constant_without_description = 'not descripted';
    
    /**
     * @var string The description of my constant
     */
    const constant_with_description = 'I MUST have a description';
    
    /**
     * @var string A protected property of MyClass
     */
    protected $protectedProperty = 'protected';
    private   $privateProperty   = 'private';
    public    $publicProperty    = 'public';
    
    /**
     * Getter of protectedProperty.
     * 
     * @return string The value of $this->protectedProperty
     */
    public function getProtectedProperty() : string
    {
        return $this->protectedProperty;
    }
    
    /**
     * Setter of protectedProperty.
     * 
     * @param string $value The value to assign to $this->protectedProperty
     * @return self The current instance of MyClass
     */
    public function setProtectedProperty($value, array $options=null)
    {
        $this->protectedProperty = $value;
        return $this;
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
