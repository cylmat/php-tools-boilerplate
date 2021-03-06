<?php

/**
 * WEBSITE
 * https://cs.symfony.com/
 * 
 * CODE
 * https://github.com/FriendsOfPHP/PHP-CS-Fixer
 * 
 * CONFIG DOC
 * https://cs.symfony.com/doc/rules/index.html
 * https://cs.symfony.com/doc/ruleSets/index.html
 */

$rules = [
    '@PSR12' => true,       // https://cs.symfony.com/doc/ruleSets/PSR12.html
    //'@PhpCsFixer' => true,  // https://cs.symfony.com/doc/ruleSets/PhpCsFixer.html
    //'@Symfony' => true,     // https://cs.symfony.com/doc/ruleSets/Symfony.html

    // sample...
    'array_syntax' => ['syntax' => 'short'],
    'no_php4_constructor' => true,
    'no_short_echo_tag' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'php_unit_internal_class' => false,
];

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setCacheFile(__DIR__ . '/../var/.phpcs-cache')
    ->setUsingCache(false)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                __DIR__ . '/../src'
            ])
            ->notPath('/^app\/sample.php/')
            ->exclude([
                __DIR__ . '/../vendor'
            ])
    );
