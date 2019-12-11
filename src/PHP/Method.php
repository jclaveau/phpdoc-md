<?php
namespace PHPDocMD\PHP;

class Method
{
    protected $name;
    protected $definedBy;
    protected $description;
    protected $arguments;
    protected $visibility;
    protected $isAbstract;
    protected $isStatic;
    protected $isDeprecated;
    protected $isDefinedBy;
    protected $isDefinedAt;
    protected $returnType = 'mixed';
    protected $returnDescription;
    
    /**
     */
    public function setName($name)
    {
        $this->name = trim($name);
        return $this;
    }
    
    /**
     */
    public function setDescription($description)
    {
        $this->description = trim( (string) $description );
        return $this;
    }
    
    /**
     */
    public function getDescription()
    {
        return $this->description;
    }
    
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
    public function isDeprecated($value=null)
    {
        if ($value !== null) {
            $this->isDeprecated = (bool) $value;
            return $this;
        } else {
            return $this->isDeprecated;
        }
    }
    
    /**
     */
    public function isDefinedBy($value=null)
    {
        if ($value !== null) {
            $this->isDefinedBy = (string) $value;
            return $this;
        } else {
            return $this->isDefinedBy;
        }
    }
    
    /**
     */
    public function isDefinedAt(array $positions=null)
    {
        if ($value !== null) {
            $this->isDefinedAt = [
                'start' => reset($positions),
                'end'   => end($positions),
            ];
            return $this;
        } else {
            return $this->isDefinedAt;
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
    public function printSignature(array $options=null)
    {
        $name = ! empty($options['currentNamespace'])
            ? Helpers::getRelativeNamespace($this->name, $options['currentNamespace'])
            : $this->name;
        
        $signature = '';
        
        if ($this->returnType) {
            $signature .= $this->returnType.' ';
        }
        
        $signature .= $this->isDefinedBy().'::'.$this->name
            .'('.$this->printFunctionArguments().')';
        
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
