<?php

include_once 'associative-array.php';

$associativeArray = new AssociativeArray();
$associativeArray->setKeyValue('lol', 'lmao');

echo $associativeArray->getKeyValue('lol') . "\n";
if ($associativeArray->keyExists('lol2')) {
    echo $associativeArray->getKeyValue('lol2') . "\n";
}