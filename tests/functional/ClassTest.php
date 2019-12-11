<?php
namespace PHPDocMD;

/**
 */
class ClassTest extends \AbstractTest
{
    /**
     */
    public function test_render()
    {
        // Run PHPdoc-MD
        $root = __DIR__ . '/../..';
        $config = [
          'source_dir'   => "../../mockups",
          'input'        => "$root/tests/generated_docs/structure.xml",
          'output_dir'   => "$root/tests/generated_docs/result",
          'template_dir' => "$root/templates/compact_php",
          'lt'           => '%c.md',
          'index'        => 'ApiIndex.md',
        ];
        
        if ( ! file_exists($config['output_dir']) ) {
            mkdir($config['output_dir'], 0777, true);
        }

        $generator = new \PHPDocMD\Generator(
            (new \PHPDocMD\Parser($config['input'], $config['source_dir']))->run(),
            $config['output_dir'],
            $config['template_dir'],
            $config['lt'],
            $config['index']
        );
        $generator->run();
        
        $this->assertFileExists($config['output_dir'].'/ApiIndex.md');
        $this->assertFileExists($config['output_dir'].'/PHPDocMD-MyClass.md');
        $this->assertFileExists($config['output_dir'].'/PHPDocMD-MyParentClass.md');
        $this->assertFileExists($config['output_dir'].'/PHPDocMD-MyInterface.md');
    }

    /**/
}
