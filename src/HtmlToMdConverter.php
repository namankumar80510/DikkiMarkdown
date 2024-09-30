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
    private HtmlConverter $converter;

    public function __construct()
    {
        $this->converter = new HtmlConverter(['header_style' => 'atx']);
    }

    /**
     * @param $html
     * @return string
     */
    public function convert($html): string
    {
        return $this->converter->convert($html);
    }
}