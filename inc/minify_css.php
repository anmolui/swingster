<?php
function minify_css($input) {
    if (empty($input)) return $input; // Return if no input

    // Remove comments
    $input = preg_replace('!/\*.*?\*/!s', '', $input);

    // Remove spaces after colons
    $input = str_replace(': ', ':', $input);

    // Remove spaces, tabs, newlines, etc.
    $input = preg_replace('/\s+/', ' ', $input);
    $input = preg_replace('/\s?([{}|:;,])\s?/', '$1', $input);

    // Shorten hex colors
    $input = preg_replace('/#([a-fA-F0-9])\\1([a-fA-F0-9])\\2([a-fA-F0-9])\\3\\b/', '#$1$2$3', $input);

    // Remove units for zero values
    $input = preg_replace('/(?<!\d)0(px|em|rem|pt|%|fr|vh|vw|vmin|vmax|ex|ch)/', '0', $input);

    // Remove trailing semicolon from declarations
    $input = preg_replace('/;\s*(})/', '$1', $input);

    // Experimental

    // Consolidate repeated CSS selectors
    preg_match_all('/(?ims)([^\{\}]+)\{([^\{\}]+)\}([^\}\{]*)\{\1\{([^\}]*)\}\}/', $input, $matches, PREG_OFFSET_CAPTURE);

    // Loop through matches and consolidate selectors
    if (!empty($matches[0])) {
        $matchesCount = count($matches[0]);
        for ($i = $matchesCount - 1; $i >= 0; $i--) {
            // Combine declarations of repeated selectors
            $combined = $matches[2][$i][0] . $matches[4][$i][0];

            // Calculate the start and end positions of the matched block
            $startPos = $matches[0][$i][1];
            $endPos = $startPos + strlen($matches[0][$i][0]);

            // Replace the repeated selectors with the combined declarations
            $input = substr_replace($input, $matches[1][$i][0] . '{' . $combined . '}' . $matches[3][$i][0], $startPos, $endPos - $startPos);
        }
    }

    return $input;
}
?>