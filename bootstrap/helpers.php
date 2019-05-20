<?php
if( !function_exists('parsedown') ) {
    /**
     * @param string $text
     * @return string
     */
    function parsedown($text)
    {
        /**
         * @var App\Services\Parsedown $parser
         */
        $parser = app('parsedown');
        return $parser->text($text);
    }
}

if( !function_exists('parsedown_line') ) {
    /**
     * @param string $text
     * @return string
     */
    function parsedown_line($text)
    {
        /**
         * @var App\Services\Parsedown $parser
         */
        $parser = app('parsedown');
        return $parser->line($text);
    }
}

if( !function_exists('getContrastColor') ) {
    /**
     *  Compute a matching color (white or black) to go alongside any colour.
     *  
     *  @param  string $hexColor the colour to match
     *  @return string hex code for the colour
     *
     *  @see copy pasted from https://stackoverflow.com/a/42921358
     */
    function getContrastColor($hexColor) {
        // hexColor RGB
        $R1 = hexdec(substr($hexColor, 1, 2));
        $G1 = hexdec(substr($hexColor, 3, 2));
        $B1 = hexdec(substr($hexColor, 5, 2));

        // Black RGB
        $blackColor = "#000000";
        $R2BlackColor = hexdec(substr($blackColor, 1, 2));
        $G2BlackColor = hexdec(substr($blackColor, 3, 2));
        $B2BlackColor = hexdec(substr($blackColor, 5, 2));

         // Calc contrast ratio
         $L1 = 0.2126 * pow($R1 / 255, 2.2) +
               0.7152 * pow($G1 / 255, 2.2) +
               0.0722 * pow($B1 / 255, 2.2);

        $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
              0.7152 * pow($G2BlackColor / 255, 2.2) +
              0.0722 * pow($B2BlackColor / 255, 2.2);

        $contrastRatio = 0;
        if ($L1 > $L2) {
            $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
        } else {
            $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
        }

        // If contrast is more than 5, return black color
        if ($contrastRatio > 5) {
            return '#000000';
        } else { 
            // if not, return white color.
            return '#FFFFFF';
        }
    }
}