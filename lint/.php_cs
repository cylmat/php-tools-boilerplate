<?php

$ROOT = __DIR__ . '/../';

/**
 * https://github.com/FriendsOfPHP/PHP-CS-Fixer
 */
return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setCacheFile($ROOT . '.php_cs.cache')
    ->setUsingCache(false)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                $ROOT . '/src',
                $ROOT . '/tests'
            ])
            ->notPath('/^app\/sample.php/')
            ->exclude([
                'vendor'
            ])
    );
                                             