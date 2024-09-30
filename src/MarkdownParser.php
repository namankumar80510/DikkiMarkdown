<?php

namespace Dikki\Markdown;

use League\CommonMark\Exception\CommonMarkException;
use Nette\Utils\FileSystem;
use Nette\Utils\Finder;

/**
 * MarkdownParser
 *
 * You can provide the path to a markdown content file.
 * It will return the contents of the file as html and the front matter as an array.
 *
 * @package Dikki\Markdown
 */
class MarkdownParser
{

    private CommonMark $commonMark;

    /**
     * @param string $path
     */
    public function __construct(
        private string $path
    )
    {
        $this->path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->commonMark = new CommonMark();
    }

    /**
     * @param string $fileLocation
     * @param array $replaceArr
     * @return array|null
     * @throws CommonMarkException
     */
    public function getFileContent(string $fileLocation, array $replaceArr = []): ?array
    {
        $file = $this->findFile($fileLocation);
        if (!$file) {
            return null;
        }

        $content = $this->parseFile($file, $replaceArr);
        return $content['meta']['published'] ?? true ? $content : null;
    }

    /**
     * @param string $folderLocation
     * @return array|null
     * @throws CommonMarkException
     */
    public function getFolderFiles(string $folderLocation): ?array
    {
        $folder = $this->path . $folderLocation;
        if (!is_dir($folder)) {
            return null;
        }

        $files = Finder::findFiles('*.md')->in($folder);
        return array_map([$this, 'parseFile'], iterator_to_array($files));
    }

    private function findFile(string $fileLocation): ?string
    {
        $filePaths = [
            $this->path . $fileLocation . '.md',
            $this->path . $fileLocation . '/index.md',
        ];

        foreach ($filePaths as $filePath) {
            if (file_exists($filePath)) {
                return $filePath;
            }
        }

        return null;
    }

    private function parseFile(string $file, array $replaceArr = []): array
    {
        $content = FileSystem::read($file);
        $parsed = $this->commonMark->convertToHtml($content);

        if (!empty($replaceArr)) {
            $parsed['content'] = strtr($parsed['content'], $replaceArr);
        }

        return $parsed;
    }

}