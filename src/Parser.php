<?php

namespace PHPDocMD;

use SimpleXMLElement;

/**
 * This class parses structure.xml and generates the api documentation.
 *
 * @copyright Copyright (C) Evert Pot. All rights reserved.
 * @author    Evert Pot (https://evertpot.coom/)
 * @license   MIT
 */
class Parser
{
    /**
     * The directory on which PHPDoc has been run
     *
     * @var string
     */
    protected $sourceDir;

    /**
     * Path to the structure.xml file.
     *
     * @var string
     */
    protected $structureXmlFile;

    /**
     * The list of classes and interfaces.
     *
     * @var array
     */
    protected $classDefinitions;

    /**
     * @param string $structureXmlFile
     * @param string $sourceDir
     */
    function __construct($structureXmlFile, $sourceDir)
    {
        $this->structureXmlFile = $structureXmlFile;
        $this->sourceDir = $sourceDir;
    }

    /**
     * Starts the process.
     */
    function run()
    {
        $xml = simplexml_load_file($this->structureXmlFile);

        $this->getClassDefinitions($xml);

        foreach ($this->classDefinitions as $className => $classInfo) {
            $this->expandMethods($className);
            $this->expandProperties($className);
        }

        return $this->classDefinitions;
    }

    /**
     * Gets all classes and interfaces from the file and puts them in an easy to use array.
     *
     * @param SimpleXmlElement $xml
     */
    protected function getClassDefinitions(SimpleXmlElement $xml)
    {
        $classNames = [];

        foreach ($xml->xpath('file') as $file) {
            $path = (string) $file['path'];
            $package = (string) $file['package'];
            $errors = $file->parse_markers;
            
            foreach ($file->xpath('class|interface|trait') as $xmlClass) {
                $className = (string) $xmlClass->full_name;

                $implements = [];
                if (isset($xmlClass->implements)) {
                    foreach ($xmlClass->implements as $interface) {
                        $implements[] = (string) $interface;
                    }
                }

                $extends = [];
                if (isset($xmlClass->extends)) {
                    foreach ($xmlClass->extends as $parent) {
                        $extends[] = (string) $parent;
                    }
                }

                $class = [
                    'path'            => $this->sourceDir.'/'.$path,
                    'package'         => $package,
                    'docFile'         => str_replace('\\', '-', ltrim($className, '\\')) . '.md',
                    'className'       => $className,
                    'shortClass'      => (string)$xmlClass->name,
                    'namespace'       => '\\'.$xmlClass['namespace'],
                    'description'     => (string)$xmlClass->docblock->description,
                    'longDescription' => (string)$xmlClass->docblock->{'long-description'},
                    'implements'      => $implements,
                    'extends'         => $extends,
                    'isClass'         => $xmlClass->getName() === 'class',
                    'isInterface'     => $xmlClass->getName() === 'interface',
                    'isTrait'         => $xmlClass->getName() === 'trait',
                    'abstract'        => (string)$xmlClass['abstract'] == 'true',
                    'deprecated'      => count($xmlClass->xpath('docblock/tag[@name="deprecated"]')) > 0,
                ];
                
                $class['methods']    = $this->parseMethods($xmlClass, $class);
                $class['properties'] = $this->parseProperties($xmlClass, $class);
                $class['constants']  = $this->parseConstants($xmlClass, $class);
                
                $classNames[$className] = $class;
            }
        }

        $this->classDefinitions = $classNames;
    }

    /**
     * Parses all the method information for a single class or interface.
     *
     * You must pass an xml element that refers to either the class or interface element from
     * structure.xml.
     *
     * @param SimpleXMLElement $class
     *
     * @return array
     */
    protected function parseMethods(SimpleXMLElement $xmlClass, array $class)
    {
        $className = (string)$xmlClass->full_name;
        
        $methods = [];
        foreach ($xmlClass->method as $method) {
            $methodName = (string)$method->name;

            $return = $method->xpath('docblock/tag[@name="return"]');
            

            if (count($return)) {
                $returnType = (string)$return[0]->type;
                $returnDescription = (string)$return[0]['description'];
            } else {
                $returnType = 'mixed';
                $returnDescription = '';
            }

            $arguments = [];

            foreach ($method->argument as $argument) {
                $nArgument = [
                    'type' => (string)$argument->type,
                    'name' => (string)$argument->name
                ];

                $tags = $method->xpath(
                    sprintf('docblock/tag[@name="param" and @variable="%s"]', $nArgument['name'])
                );

                if (count($tags)) {
                    $tag = $tags[0];

                    if ((string)$tag['type']) {
                        $nArgument['type'] = (string)$tag['type'];
                    }

                    if ((string)$tag['description']) {
                        $nArgument['description'] = preg_replace(
                            '#(^'.preg_quote('<p>').')|('.preg_quote('</p>').'$)#', 
                            '',
                            (string)$tag['description']
                        );
                        
                        $nArgument['description'] = trim($nArgument['description']);
                    }

                    if ((string)$tag['variable']) {
                        $nArgument['name'] = (string)$tag['variable'];
                    }
                }

                $arguments[] = $nArgument;
            }
            
            $methods[$methodName] = (new PHP\Method)
                ->setName($methodName)
                ->setArguments($arguments)
                ->setDescription($method->docblock->description . $method->docblock->{'long-description'})
                ->setVisibility((string) $method['visibility'])
                ->isAbstract( ((string)$method['abstract']) == "true")
                ->isStatic( ((string)$method['static']) == "true")
                ->isFinal( ((string)$method['final']) == "true")
                ->isDeprecated( count($xmlClass->xpath('docblock/tag[@name="deprecated"]')) > 0)
                ->isDefinedBy($className)
                ->setReturnType($returnType)
                ->setReturnDescription($returnDescription)
                ->setFile($class['path'])
                ->setLine((string)$method['line'])
                ;
                
        }

        return $methods;
    }

    /**
     * Parses all property information for a single class or interface.
     *
     * You must pass an xml element that refers to either the class or interface element from
     * structure.xml.
     *
     * @param SimpleXMLElement $xmlClass
     * @param array $class
     *
     * @return array
     */
    protected function parseProperties(SimpleXMLElement $xmlClass, array $class)
    {
        $properties = [];

        $className = (string) $xmlClass->full_name;

        foreach ($xmlClass->property as $xmlProperty) {
            $type = 'mixed';
            $propName = (string) $xmlProperty->name;
            $default = (string) $xmlProperty->default;

            $xmlVar = $xmlProperty->xpath('docblock/tag[@name="var"]');
            if (count($xmlVar)) {
                $type = $xmlVar[0]->type;
                var_dump($xmlVar);
                exit;
            }
            

            $property = (new PHP\Property)
                ->setName($propName)
                ->setType($type)
                // ->setDescription($xmlProperty->xpath('docblock/tag[@name="var"]'))
                ->setVisibility((string) $xmlProperty['visibility'])
                ->isStatic( ((string) $xmlProperty['static']) == "true")
                ->isDeprecated( count($xmlClass->xpath('docblock/tag[@name="deprecated"]')) > 0)
                ->isDefinedBy($className)
                ->setFile($class['path'])
                ->setLine((string) $xmlProperty['line'])
                ;
            
            $properties[$propName] = $property;
        }

        return $properties;
    }

    /**
     * Parses all constant information for a single class or interface.
     *
     * You must pass an xml element that refers to either the class or interface element from
     * structure.xml.
     *
     * @param SimpleXMLElement $class
     *
     * @return array
     */
    protected function parseConstants(SimpleXMLElement $class)
    {
        $constants = [];

        $className = (string)$class->full_name;
        $className = ltrim($className, '\\');

        foreach ($class->constant as $xConstant) {
            $name = (string)$xConstant->name;
            $value = (string)$xConstant->value;

            $signature = sprintf('const %s = %s', $name, $value);

            $constants[$name] = [
                'name'        => $name,
                'description' => (string)$xConstant->docblock->description . "\n\n" . (string)$xConstant->docblock->{'long-description'},
                'signature'   => $signature,
                'value'       => $value,
                'deprecated'  => count($class->xpath('docblock/tag[@name="deprecated"]')) > 0,
                'definedBy'   => $className,
            ];
        }

        return $constants;
    }

    /**
     * This method goes through all the class definitions, and adds non-overridden method
     * information from parent classes.
     *
     * @param string $className
     *
     * @return array
     */
    protected function expandMethods($className)
    {
        $class = $this->classDefinitions[$className];

        $newMethods = [];

        foreach (array_merge($class['extends'], $class['implements']) as $extends) {
            if (!isset($this->classDefinitions[$extends])) {
                continue;
            }

            foreach ($this->classDefinitions[$extends]['methods'] as $methodName => $methodInfo) {
                if (!isset($class[$methodName])) {
                    $newMethods[$methodName] = $methodInfo;
                }
            }

            $newMethods = array_merge($newMethods, $this->expandMethods($extends));
        }

        $this->classDefinitions[$className]['methods'] = array_merge(
            $this->classDefinitions[$className]['methods'],
            $newMethods
        );

        return $newMethods;
    }

    /**
     * This method goes through all the class definitions, and adds non-overridden property
     * information from parent classes.
     *
     * @param string $className
     *
     * @return array
     */
    protected function expandProperties($className)
    {
        $class = $this->classDefinitions[$className];

        $newProperties = [];

        foreach (array_merge($class['implements'], $class['extends']) as $extends) {
            if (!isset($this->classDefinitions[$extends])) {
                continue;
            }

            foreach ($this->classDefinitions[$extends]['properties'] as $propertyName => $propertyInfo) {
                if ($propertyInfo->getVisibility() === 'private') {
                    continue;
                }

                if (!isset($class[$propertyName])) {
                    $newProperties[$propertyName] = $propertyInfo;
                }
            }

            $newProperties = array_merge($newProperties, $this->expandProperties($extends));
        }

        $this->classDefinitions[$className]['properties'] += $newProperties;

        return $newProperties;
    }
}
