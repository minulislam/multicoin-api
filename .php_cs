<?php
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
$finder = PhpCsFixer\Finder::create()
    ->in([
       'src'
    ])
    ->name('*.php')
    ->notName('_ide_helper')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

/*
$finder = Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage/')
    ->notPath('database/')
    ->notPath('resources/')
    ->notPath('Nova/')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('_ide_helper')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

       'ordered_class_elements'                     => [
            'use_trait', 'constant_public', 'constant_protected', 'constant_private',
            'property_public', 'property_protected', 'property_private', 'construct',
            'destruct', 'magic', 'phpunit', 'method_public', 'method_protected',
            'method_private',
        ],

        */

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
       // '@PhpCsFixer'                                => true,
        '@PSR2'                                      => true,
        'array_indentation'                          => true,
        'array_syntax'                               => ['syntax' => 'short'],
        'blank_line_before_statement'                => [
            'statements' => [
                'return',
            ],
        ],
        'combine_consecutive_unsets'                 => true,
        'compact_nullable_typehint'                  => true,
      //  'concat_space'                               => ['spacing' => 'one'],
      //  'declare_equal_normalize'                    => ['space' => 'single'],
        'full_opening_tag'                           => true,
        'function_declaration'                       => true,
        'function_typehint_space'                    => true,
        'list_syntax'                                => ['syntax' => 'long'],
        'method_argument_space'                      => [
            'on_multiline'                     => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        'multiline_whitespace_before_semicolons'     => ['strategy' => 'no_multi_line'],
        'no_break_comment'                           => true,
        'no_extra_blank_lines'                       => [
            'tokens' => [
                'extra',
                'curly_brace_block',
                'parenthesis_brace_block',
                'square_brace_block',
            ],
        ],
        'no_empty_statement'                         => true,
        'no_leading_import_slash'                    => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_after_function_name'              => true,
        'no_trailing_comma_in_singleline_array'      => true,
        'no_unneeded_control_parentheses'            => true,
        'no_unneeded_curly_braces'                   => true,
        'no_unused_imports'                          => true,
        'no_useless_else'                            => true,
        'no_useless_return'                          => true,
        'normalize_index_brace'                      => true,
        'not_operator_with_successor_space'          => true,
        'object_operator_without_whitespace'         => true,
        'ordered_class_elements'                     => [
            'order'         => [
                'use_trait', 'constant_public', 'constant_protected', 'constant_private',
                'property_public', 'property_protected', 'property_private', 'construct',
                'destruct', 'magic', 'phpunit', 'method_public', 'method_protected',
                'method_private',
            ],
           // 'sortAlgorithm' => 'alpha',
        ],
        'ordered_imports'                            => ['sortAlgorithm' => 'alpha'],
        'align_multiline_comment'                    => [
            'comment_type' => 'all_multiline',
        ],
        'phpdoc_order'                               => true,
        'single_class_element_per_statement'         => true,
        'single_quote'                               => true,
        'standardize_not_equals'                     => true,
        'ternary_operator_spaces'                    => true,
        'ternary_to_null_coalescing'                 => true,
        'trailing_comma_in_multiline_array'          => true,

    ])
    ->setUsingCache(false)
    ->setFinder($finder);

return $config;
