<?php
namespace PHPDocMD\PHP;

/**
 * A trait, a class or an interface.
 */
abstract class Definition
{
    protected $namespace;
    protected $name;
    protected $description;
    protected $isDeprecated;
    protected $file;
    protected $line;
    
    /**
     */
    public function setNamespace($namespace)
    {
        $this->namespace = trim($namespace);
        return $this;
    }
    
    /**
     */
    public function setName($name)
    {
        $this->name = trim($name);
        return $this;
    }
    
    /**
     */
    public function getName()
    {
        return $this->name;
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
        $parts = array_filter($parts);
        return '\\'.implode('\\', $parts);
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
    public function generateSignature(array $options=null)
    {
        $signature = $this->namespace.'\\'.$this->name;
        
        if (! is_array($options) || ! in_array('absolute', $options)) {
            $signature = Helpers::getRelativeNamespace(
                $signature, 
                $this->getNamespace()
            );
        }
        
        return $signature;
    }

    /**
     */
    public function generateCodeUrl()
    {
        // /blob/master/src/DeferredCallChain.php#L9
        return $this->file.'#L'.$this->line;
    }

    /**/
} 
