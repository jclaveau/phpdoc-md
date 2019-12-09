<?php
namespace PHPDocMD;

class MyClass extends MyParentClass implements MyInterface
{
    use MyTrait;
    
    protected $protectedProperty = 'protected';
    private   $privateProperty   = 'private';
    public    $publicProperty    = 'public';
    
    public function __construct()
    {
        
    }
    
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
