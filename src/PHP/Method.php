<?php
namespace PHPDocMD\PHP;

class Method extends AttributeDefinition
{
    protected $arguments;
    protected $isAbstract;
    protected $isFinal;
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
    public function isFinal($value=null)
    {
        if ($value !== null) {
            $this->isFinal = (bool) $value;
            return $this;
        } else {
            return $this->isFinal;
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
        
        if ($this->isFinal()) {
            $signature .= 'final ';
        }
        
        $signature .= $this->visibility.' ';
        
        if ($this->isStatic()) {
            $signature .= 'static ';
        }
        
        $signature .= $definer.'::'.$this->getName()
            .'('
            .( ( ! is_array($options) || in_array('no_arguments', $options))
                ? ''
                : $this->printFunctionArguments() )
            .')'
            .($returnType != 'mixed' ? ' : '.$returnType : '')
            ;
        
        return $signature;
    }

    /**
     */
    public function getTypedName()
    {
        return $this->getName() . '()';
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
