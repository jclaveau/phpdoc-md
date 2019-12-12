<?php
namespace PHPDocMD\PHP;

class Constant extends AttributeDefinition
{
    protected $value;

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     */
    public function generateSignature(array $options=null)
    {
        if ( ! is_array($options) || ! in_array('absolute', $options)) {
            $definer = Helpers::getRelativeNamespace($this->isDefinedBy(), $this->getNamespace());
        } else {
            $definer = $this->isDefinedBy();
        }
        
        $signature = $this->visibility.' const '
                   . $definer
                   . '::'
                   . $this->getName().' = '
                   . $this->value
                   ;
        
        return $signature;
    }

    /**
     */
    public function getTypedName()
    {
        return $this->getName();
    }

    /**/
} 
