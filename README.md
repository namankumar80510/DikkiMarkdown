# Dikki Markdown

Dikki Markdown is a `league/commonmark` wrapper you can use to fetch contents, including the front matter, from markdown
files. Say you
write your blog posts in markdown. You can use this package to fetch the contents of the markdown file as html and the
rest of the front matter as arrays.

You can also convert html to markdown using this package.

**Basically, it is just a wrapper around [league/commonmark](https://commonmark.thephpleague.com)
and [league/html-to-markdown](https://github.com/thephpleague/html-to-markdown)**.

## Installation

```bash
composer require dikki/markdown
```

## Usage

The below examples will illustrate.

### **Example 1: getting the contents of a markdown post**:

_sample-post.md_:

```md
---
title: This is a sample title
description: This is a description
cover_image: /path/to/image.png
slug: sample-post
---

This is the body content of the blog post.

```

_using the parser in your app_:

```php
<?php

use Dikki\Markdown\MarkdownParser;

require_once '../vendor/autoload.php';

$parser = new MarkdownParser(
    __DIR__ . '/contents/'
);

$output = $parser->getFileContent("sample-post");

echo "<pre>";
print_r($output);
```

**Output**:

```html
Array
(
    [title] => This is a sample title
    [description] => This is a description
    [cover_image] => /path/to/image.png
    [slug] => sample-post
    [content] =>
    
    This is the body content of the blog post.

)

```

As you can see, you get an array of meta-data you passed as Yaml in the markdown file as well as the content you wrote.

## Converting Html to Markdown

Simply use the `HtmltoMdConverter()` class's `convert()` method:

```php

$string = "<h1>Heading 1 Here</h1>";

$md = (new \Dikki\Markdown\HtmlToMdConverter())->convert($string);

echo $md;

// OUTPUT:

# Heading 1 Here

```