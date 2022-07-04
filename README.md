# google-search
Scrap google search result.

## Features

 * Fetch search request from google.ae or google.com

 ## Requirements

 * PHP version 7.1 or higher

 ## Easy Installation

### Install with composer

To install with [Composer](https://getcomposer.org/), simply require the
latest version of this package.

```bash
composer require developer53/google-search
```

Make sure that the autoload file from Composer is loaded.

```php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

```

## Quick Start

Just set search engine and pass query string as an array

```php
// instantiate and use the SearchEngine class
$client = new \SearchEngine\SearchEngine();

// set enginge name google.ae or google.com
$client->setEngine('google.ae');

// pass query string as an array
$results = $client->search(['shed stores dubai']);

// Output Results
echo '<pre>';
print_r($results);
echo '</pre>';
