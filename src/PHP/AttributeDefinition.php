<?php
namespace PHPDocMD\PHP;

/**
 * A property, a method or a class constant
 */
abstract class AttributeDefinition extends Definition
{
    protected $isDefinedBy;
    protected $visibility = 'public';
    protected $isStatic;
    
    /**
     */
    public function isDefinedBy($value=null)
    {
        if ($value !== null) {
            $this->namespace = Helpers::definitionParts($value)['namespace'];
            $this->isDefinedBy = $value; 
            return $this;
        } else {
            return $this->isDefinedBy;
        }
    }
    
    /**
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }
    
    /**
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
    
    /**
     */
    public function isStatic($value=null)
    {
        if ($value !== null) {
            $this->isStatic = (bool) $value;
            return $this;
        } else {
            return $this->isStatic;
        }
    }
    
    /**/
} 
