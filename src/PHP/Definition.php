<?php
namespace PHPDocMD\PHP;

abstract class Definition
{
    protected $name;
    protected $description;
    protected $isDeprecated;
    protected $file;
    protected $line;
    
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
    public function generateCodeUrl()
    {
        // /blob/master/src/DeferredCallChain.php#L9
        return $this->file.'#'.$this->line;
    }

    /**/
} 
