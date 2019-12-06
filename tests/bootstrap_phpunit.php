<?php
// use phpDocumentor\Kernel;
// use Symfony\Component\Debug\Debug;
// use phpDocumentor\Console\Application;
// use phpDocumentor\AutoloaderLocator;

/**
 * This file is executed before every run of the tests
 */

// Avoid ellipsis of xdebug dumps
ini_set('xdebug.max_nesting_level', 10000);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

if (class_exists('\PHPUnit_Framework_TestCase') ) {
    require_once __DIR__ . '/AbstractTest_5.6.php';
}
else {
    require_once __DIR__ . '/AbstractTest.php';
}

// Run PHPDoc
$root = __DIR__ . '/..';
$command = "$root/bin/phpdoc -v -d $root/tests/mockups -t $root/tests/generated_docs --template=xml --ansi";
// echo $command;
system($command);


require_once "$root/vendor/autoload.php";
