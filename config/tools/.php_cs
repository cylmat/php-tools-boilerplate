<?php

/**
 * Code
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer
 * 
 * Doc
 * @see https://cs.symfony.com/doc/ruleSets/index.html
 */

$rules = [
    '@PSR12' => true,         # https://cs.symfony.com/doc/ruleSets/PSR12.html
    //'@PhpCsFixer' => true,  # https://cs.symfony.com/doc/ruleSets/PhpCsFixer.html
    //'@Symfony' => true,     # https://cs.symfony.com/doc/ruleSets/Symfony.html

    'array_syntax' => ['syntax' => 'short'],
    'no_php4_constructor' => true,
    'no_short_echo_tag' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'php_unit_internal_class' => false,
];

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setCacheFile(__DIR__ . '/../var/.phpcs-cache')
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([__DIR__ . '/../src'])
            ->exclude([__DIR__ . '/../vendor'])
    )
;
