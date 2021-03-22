<?php

// launch Sample.php to run Codeception test
require __DIR__ . '/../src/Sample.php';
$sample = new \App\Sample();
echo $sample->sampleText('from server -' . $_SERVER['SERVER_SOFTWARE']) . "-\n";