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
    protected $file;
    protected $line;
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
    public function getNamespace()
    {
        $parts = explode('\\', $this->isDefinedBy);
        array_pop($parts);
        return implode('\\', $parts);
    }
    
    /**
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    
    /**
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     */
    public function setLine($line)
    {
        $this->line = $line;
        return $this;
    }
    
    /**
     */
    public function getLine()
    {
        return $this->line;
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
        $definer = ! is_array($options) || ! in_array('absolute', $options)
            ? Helpers::getRelativeNamespace($this->isDefinedBy(), $this->getNamespace())
            : $this->isDefinedBy();
        
        $signature = '';
        
        if ($this->returnType) {
            $signature .= $this->returnType.' ';
        }
        
        $signature .= $definer.'::'.$this->name
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

    /**
     */
    public function generateCodeUrl()
    {
        // /blob/master/src/DeferredCallChain.php#L9
        return $this->file.'#'.$this->line;
    }

    /**/
} 
