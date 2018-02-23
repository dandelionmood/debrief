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
