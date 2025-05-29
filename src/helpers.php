<?php

if (!function_exists('e')) {
    /**
     * Helper function to escape HTML output
     * 
     * @param string $string The string to escape
     * @return string The escaped string
     */
    function e(string $string): string
    {
        return htmlspecialchars($string);
    }
}

/**
 * Helper function to get the excerpt of a text
 * 
 * @param string $content The content to excerpt
 * @param int $limit The character limit
 * @return string The excerpt
 */
function excerpt(string $content, int $limit = 160): string
{
    return \App\Helpers\Text::excerpt($content, $limit);
}

// Note: dd() function is already provided by symfony/var-dumper
