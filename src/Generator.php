<?php

namespace PHPDocMD;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;


use PHPDocMD\MarkdownHelpers as MD;

/**
 * This class takes the output from 'parser', and generate the markdown
 * templates.
 *
 * @copyright Copyright (C) Evert Pot. All rights reserved.
 * @author    Evert Pot (https://evertpot.coom/)
 * @license   MIT
 */
class Generator
{
    /**
     * Output directory.
     *
     * @var string
     */
    protected $outputDir;

    /**
     * The list of classes and interfaces.
     *
     * @var array
     */
    protected $classDefinitions;

    /**
     * Use Twig or native PHP
     *
     * @var string
     */
    protected $templateEngine;

    /**
     * Directory containing the twig templates.
     *
     * @var string
     */
    protected $templateDir;

    /**
     * A simple template for generating links.
     *
     * @var string
     */
    protected $linkTemplate;

    /**
     * Filename for API Index.
     *
     * @var string
     */
    protected $apiIndexFile;

    /**
     * @param array  $classDefinitions
     * @param string $outputDir
     * @param string $templateDir
     * @param string $linkTemplate
     * @param string $apiIndexFile
     */
    function __construct(array $classDefinitions, $outputDir, $templateDir, $linkTemplate = '%c.md', $apiIndexFile = 'ApiIndex.md', $templateEngine = 'php')
    {
        $this->classDefinitions = $classDefinitions;
        $this->outputDir = $outputDir;
        $this->templateDir = $templateDir;
        $this->linkTemplate = $linkTemplate;
        $this->apiIndexFile = $apiIndexFile;
        $this->templateEngine = $templateEngine;
    }

    /**
     * Starts the generator.
     */
    function run()
    {
        $GLOBALS['PHPDocMD_classDefinitions'] = $this->classDefinitions;
        $GLOBALS['PHPDocMD_linkTemplate'] = $this->linkTemplate;
        
        if ($this->templateEngine == 'twig') {
            $this->renderWithTwig();
        } elseif ($this->templateEngine == 'php') {
            $this->renderWithPhp();
        } else {
            throw new \Exception("Invalid template engine '{$this->templateEngine}' instead of 'php' or 'twig'");
        }
    }

    protected function renderWithTwig()
    {
        $loader = new Twig_Loader_Filesystem($this->templateDir);

        $twig = new Twig_Environment($loader);

        $filter = new Twig_SimpleFilter('classLink', ['PHPDocMd\\Generator', 'classLink']);
        $twig->addFilter($filter);

        foreach ($this->classDefinitions as $className => $data) {
            $output = $twig->render('class.twig', $data);

            file_put_contents($this->outputDir . '/' . $data['fileName'], $output);
        }

        $index = MD::createIndex($this->classDefinitions);

        $index = $twig->render('index.twig',
            [
                'index'            => $index,
                // 'classDefinitions' => $this->classDefinitions,
            ]
        );

        file_put_contents($this->outputDir . '/' . $this->apiIndexFile, $index);
    }

    protected static function renderFileInPhp($filepath, $data)
    {
        ob_start();
        extract($data);
        unset($data);
        require $filepath;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    protected function renderWithPhp()
    {
        foreach ($this->classDefinitions as $className => $data) {
            
            $output = static::renderFileInPhp(
                $this->templateDir.'/class.md.php',
                $data
            );
            
            file_put_contents($this->outputDir . '/' . $data['docFile'], $output);
        }
        
        $index = MD::createIndex($this->classDefinitions);
        $output = static::renderFileInPhp(
            $this->templateDir.'/index.md.php',
            [
                'index'       => $index,
                // 'definitions' => $this->classDefinitions,
            ]
        );

        file_put_contents($this->outputDir . '/' . $this->apiIndexFile, $index);
    }

    /**
     * This is a twig template function.
     *
     * This function allows us to easily link classes to their existing pages.
     *
     * Due to the unfortunate way twig works, this must be static, and we must use a global to
     * achieve our goal.
     *
     * @param string      $className
     * @param null|string $label
     *
     * @return string
     * @return deprecated
     */
    static function classLink($className, $label = null)
    {
        $classDefinitions = $GLOBALS['PHPDocMD_classDefinitions'];
        $linkTemplate = $GLOBALS['PHPDocMD_linkTemplate'];

        $returnedClasses = [];

        foreach (explode('|', $className) as $oneClass) {
            $oneClass = trim($oneClass, '\\ ');

            if (!$label) {
                $label = $oneClass;
            }

            if (!isset($classDefinitions[$oneClass])) {
                $returnedClasses[] = $oneClass;
            } else {
                $link = str_replace('\\', '-', $oneClass);
                $link = strtr($linkTemplate, ['%c' => $link]);

                $returnedClasses[] = sprintf("[%s](%s)", $label, $link);
            }
        }

        return implode('|', $returnedClasses);
    }
    
}
