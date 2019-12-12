<?php
namespace PHPDocMD\PHP;

class Property extends AttributeDefinition
{
    protected $types = ['mixed'];
    protected $defaultValue;

    public function setTypes($types)
    {
        if (is_string($types)) {
            $types = [$types];
        }
        
        if (empty($types)) {
            $this->types = ['mixed'];
        }
        
        $this->types = $types;
        return $this;
    }
    
    public function getTypes()
    {
        return $this->types;
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
        
        $signature = $this->visibility.' '
                   . implode('|', $this->types).' '
                   . $definer
                   . ($this->isStatic() ? '::$' : '->')
                   . ltrim($this->name, '$')
                   . ($this->defaultValue !== null ? ' = '.var_export($this->defaultValue, true) : '')
                   ;
        
        return $signature;
    }

    /**/
} 
