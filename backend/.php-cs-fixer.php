<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude(['vendor', 'storage', 'bootstrap/cache'])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PHP83Migration' => true,
        '@PHPUnit100Migration:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
        'blank_line_before_statement' => [
            'statements' => ['return', 'if', 'for', 'foreach', 'while', 'do', 'switch', 'try'],
        ],
        'cast_spaces' => ['space' => 'none'],
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'concat_space' => ['spacing' => 'one'],
        'fully_qualified_strict_types' => true,
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_summary' => false,
        'phpdoc_trim' => true,
        'phpdoc_var_annotation_correct_order' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'single_quote' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'parameters']],
        'unary_operator_spaces' => true,
    ])
    ->setFinder($finder);
