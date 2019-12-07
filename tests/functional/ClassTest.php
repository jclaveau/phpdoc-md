<?php
namespace PHPDocMD;

/**
 */
class ClassTest extends \AbstractTest
{
    /**
     */
    public function test_new_()
    {
        // Run PHPdoc-MD
        $root = __DIR__ . '/../..';
        $config = [
          'input'        => "$root/tests/generated_docs/structure.xml",
          'output_dir'   => "$root/tests/generated_docs/result",
          'template_dir' => "$root/templates",
          'lt'           => '%c.md',
          'index'        => 'ApiIndex.md',
        ];
        
        if ( ! file_exists($config['output_dir']) ) {
            mkdir($config['output_dir'], 0777, true);
        }

        $generator = new \PHPDocMD\Generator(
            (new \PHPDocMD\Parser($config['input']))->run(),
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
