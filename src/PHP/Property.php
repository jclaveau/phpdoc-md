<?php
namespace PHPDocMD\PHP;

class Property extends AttributeDefinition
{
    protected $type = 'mixed';
    protected $defaultValue;

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }
    
    public function getDefaultValue()
    {
        return $this->defaultValue;
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
        
        $signature = $this->type.' '
                   . $this->visibility.' '
                   . $definer
                   . ($this->isStatic() ? '::$' : '->')
                   . $this->name
                   . ($this->defaultValue !== null ? ' = '.var_export($this->defaultValue, true) : '')
                   ;
        
        return $signature;
    }

    /**/
} 
