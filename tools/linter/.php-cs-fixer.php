<?php

/**
 * Code
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer
 * 
 * Doc
 * @see https://cs.symfony.com/doc/ruleSets
 * 
 * Oliva (v3.11) edition
 */

$rules = [
    '@PSR12' => true,         # https://cs.symfony.com/doc/ruleSets/PSR12.html
    //'@PhpCsFixer' => true,  # https://cs.symfony.com/doc/ruleSets/PhpCsFixer.html
    //'@Symfony' => true,     # https://cs.symfony.com/doc/ruleSets/Symfony.html

    'array_syntax' => ['syntax' => 'short'],
    'full_opening_tag' => true,
    'echo_tag_syntax' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'php_unit_internal_class' => false,
];

$root = __DIR__.'/../../';
return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setCacheFile($root.'var/php-cs-fixer.cache')
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([$root.'src'])
            ->exclude([$root.'vendor'])
    )
;
