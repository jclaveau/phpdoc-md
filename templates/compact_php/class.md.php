<?php
namespace PHPDocMD;

use PHPDocMD\MarkdownHelpers as MD;
use PHPDocMD\HTMLHelpers as HTML;
use PHPDocMD\PHP\Helpers as PHP;

/**
 * HTML elements allowed in github: https://github.com/jch/html-pipeline/blob/master/lib/html/pipeline/sanitization_filter.rb
 * h1 h2 h3 h4 h5 h6 h7 h8 br b i strong em a pre code img tt
 * div ins del sup sub p ol ul table thead tbody tfoot blockquote
 * dl dt dd kbd q samp var hr ruby rt rp li tr td th s strike summary
 * details caption figure figcaption
 * abbr bdo cite dfn mark small span time wbr
 */
?>

# <?= ($deprecated ? '/!\ Deprecated /!\ ': '') 
    . ($abstract ? 'asbtract ' : '') 
    . $namespace . ' \ ' . $shortClass 
?>

<?= $description ?>

<?= $longDescription ?>

<!-- Mardown tables do not handle tables without column names -->
<table>
    <tbody>
        <tr>
            <th>Namespace</th>
            <td><?= $namespace ?></td>
        </tr>
        <?php if ($extends) { ?>
            <?php 
            $definitions = $GLOBALS['PHPDocMD_classDefinitions'];
            $current_parent = $extends[0];
            while ($current_parent) {
                if ( ! empty($definitions[ $current_parent ]['extends'][0])) {
                    $current_parent = $definitions[ $current_parent ]['extends'][0];
                    $extends[] = $current_parent;
                } else {
                    $current_parent = null;
                }
            }
            ?>
            <tr>
                <th>Extends</th>
                <td><?= implode(',<br>', array_map(HTML::class.'::classDocLink', $extends)) ?></td>
            </tr>
        <?php } ?>
        <?php if ($implements) { ?>
            <tr>
                <th>Implements</th>
                <td><?= implode(',<br>', array_map(HTML::class.'::classDocLink', $implements)) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
if ($constants) {
    echo "## Constants\n";

    foreach (PHP::indexByDefiner($constants) as $definer => $constants) {
        echo $definer != $className ? "    Defined by: $definer\n\n" : '';
        
        foreach ($constants as $constant) {
            echo '    '.$constant['signature']."\n";
        }
    }
}
?>

<?php 
/**/
if ($properties) {
    echo "## Properties\n";

    foreach (PHP::indexByDefiner($properties) as $definer => $properties) {
        echo $definer != $className 
            ? "\n### Defined by: ".HTML::classDocLink($definer)."\n" 
            : '';
        
        foreach ($properties as $property) {
            echo '#### - '.HTML::link($property->generateCodeUrl(), $property->generateSignature())
                .($property->isDeprecated() ? ' /!\ Deprecated /!\ ' : '')
                ."\n";
                
            $fullDescription = [];
            if ($property->getDescription()) {
                $fullDescription[] = $property->getDescription();
            }
            
            if ($property->getDefaultValue()) {
                $fullDescription[] = 'Default value:<br>'
                    .$property->getDefaultValue();
            }
            
            if ($fullDescription) {
                echo "<blockquote><pre>".implode("<br><br>", $fullDescription)."</pre></blockquote>\n\n\n";
            }
        }
    }
}
/**/

?>

<?php 

if ($methods) {
    echo "## Methods\n";

    foreach (PHP::indexByDefiner($methods) as $definer => $methods) {
        echo $definer != $className 
            ? "\n### Defined by: ".HTML::classDocLink($definer)."\n" 
            : '';
        
        foreach ($methods as $method) {
            echo '#### - '.HTML::link($method->generateCodeUrl(), $method->generateSignature())
                .($method->isDeprecated() ? ' /!\ Deprecated /!\ ' : '')
                ."\n";
            
            $fullDescription = [];
            
            if ($method->getDescription()) {
                $fullDescription[] = $method->getDescription();
            }
                
            if ($method->getArguments()) {
                $argumentsDescription = ["Parameters:"];
                foreach ($method->getArguments() as $argument) {
                    // $argumentsDescription[] = ' &#43; '
                    $argumentsDescription[] = ' &#x25FE; '
                        .($argument['type'] ? HTML::classDocLink($argument['type']) : 'mixed')
                        .' '.$argument['name']
                        .( ! empty($argument['description']) ? ': '.$argument['description'] : '')
                        ;
                }
                $fullDescription[] = implode("<br>", $argumentsDescription);
            }
            
            # todo use statement
            if ($method->getReturnDescription()) {
                $fullDescription[] = "Returns a ".HTML::classDocLink($method->getReturnType())
                    .': '.$method->getReturnDescription()
                    ;
            }
            
            if ($fullDescription) {
                echo "<blockquote><pre>".implode("<br><br>", $fullDescription)."</pre></blockquote>\n\n\n";
            }
        }
    }
}
