<?= "<?php" ?>

namespace App\Models;

class <?= ucfirst($tableName) . PHP_EOL ?>
{
<?php
    $indent = '    ';
    $atributes = [];
    $methods = [];
    $params = [];
    $declarations = [];

    foreach ($columns as $column) {
        $params[] = "{$column['type']} \${$column['name']}";
        $declarations[] = $indent . $indent . "\$this->{$column['name']} = \${$column['name']};";

        // atributo
        $atributes[] = $indent . "private {$column['type']} \${$column['name']};";

        // Getter
        $methods[] =
            $indent . "public function get" . ucfirst($column['name']) . "(): " . $column['type'] . PHP_EOL .
            $indent . "{" . PHP_EOL .
            $indent . $indent . "return \$this->{$column['name']};" . PHP_EOL .
            $indent . "}";

        // Setter
        $methods[] =
            $indent . "public function set" . ucfirst($column['name']) . "(" . $column['type'] . " \${$column['name']}): void" . PHP_EOL .
            $indent . "{" . PHP_EOL .
            $indent . $indent . "\$this->{$column['name']} = \${$column['name']};" . PHP_EOL .
            $indent . "}";
    }

    $construct = $indent . "public function __construct (" . implode(', ',  $params) . ")" . PHP_EOL . $indent . "{" . PHP_EOL .
        implode(PHP_EOL, $declarations) . PHP_EOL .
        $indent . "}" . PHP_EOL;

    echo implode(PHP_EOL, $atributes) . PHP_EOL . PHP_EOL;
    echo $construct;
    echo implode(PHP_EOL . PHP_EOL, $methods);
?><?= PHP_EOL ?>
}