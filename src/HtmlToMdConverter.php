<?php

namespace Dikki\Markdown;

use League\HTMLToMarkdown\HtmlConverter;

/**
 * HtmlToMdConverter class
 *
 * This class converts HTML to Markdown
 * @package Dikki\Markdown
 **/
class HtmlToMdConverter
{

    /**
     * @param $html
     * @return string
     */
    public function convert($html): string
    {
        $converter = new HtmlConverter(array('header_style' => 'atx'));
        return $converter->convert($html);
    }
}