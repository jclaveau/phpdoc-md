<?php
namespace PHPDocMD\PHP;

class Method extends Definition
{
    protected $definedBy;
    protected $arguments;
    protected $visibility;
    protected $isAbstract;
    protected $isStatic;
    protected $isDefinedBy;
    protected $returnType = 'mixed';
    protected $returnDescription;
    
    /**
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }
    
    /**
     */
    public function getArguments()
    {
        return $this->arguments;
    }
    
    /**
     */
    public function setVisibility($visibility)
    {
        $this->visibility = (bool) $visibility;
        return $this;
    }
    
    /**
     */
    public function isAbstract($value=null)
    {
        if ($value !== null) {
            $this->isAbstract = (bool) $value;
            return $this;
        } else {
            return $this->isAbstract;
        }
    }
    
    /**
     */
    public function isStatic($value)
    {
        if ($value !== null) {
            $this->isStatic = (bool) $value;
            return $this;
        } else {
            return $this->isStatic;
        }
    }
    
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
    public function setReturnType($returnType)
    {
        $this->returnType = (string) $returnType;
        return $this;
    }
    
    /**
     */
    public function getReturnType()
    {
        return $this->returnType;
    }
    
    /**
     */
    public function setReturnDescription($returnDescription)
    {
        $this->returnDescription = trim($returnDescription);
        return $this;
    }
    
    /**
     */
    public function getReturnDescription()
    {
        return $this->returnDescription;
    }
    
    /**
     */
    public function generateSignature(array $options=null)
    {
        if ( ! is_array($options) || ! in_array('absolute', $options)) {
            $definer = Helpers::getRelativeNamespace($this->isDefinedBy(), $this->getNamespace());
            $returnType = Helpers::getRelativeNamespace($this->returnType, $this->getNamespace());
            
        } else {
            $definer = $this->isDefinedBy();
            $returnType = $this->returnType;
        }
        
        $signature = '';
        
        if ($returnType) {
            $signature .= $returnType.' ';
        }
        
        $signature .= $definer.'::'.$this->name
            .'('
            .( ( ! is_array($options) || in_array('no_arguments', $options))
                ? ''
                : $this->printFunctionArguments() )
            .')';
        
        return $signature;
    }

    /**
     */
    public function printFunctionArguments()
    {
        $argumentStr = implode(', ', array_map(function($argument) {
            $return = $argument['name'];

            if ($argument['type']) {
                $return = $argument['type'] . ' ' . $return;
            }

            return $return;
        }, $this->arguments));
        
        return $argumentStr;
    }

    /**/
} 
