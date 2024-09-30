<?php

namespace Dikki\Markdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class CommonMark
{
    private MarkdownConverter $converter;

    public function __construct(array $config = [])
    {
        $environment = $this->createEnvironment($config);
        $this->converter = new MarkdownConverter($environment);
    }

    public function convertToHtml($markdown): array
    {
        $result = $this->converter->convert($markdown);
        return [
            'content' => $result->getContent(),
            ...$result->getFrontMatter(),
        ];
    }

    private function createEnvironment(array $config): Environment
    {
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new FrontMatterExtension());
        return $environment;
    }
}