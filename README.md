# Laravel package to manage meta and title tags

This package makes it easier to work with HTML meta and title tags in Laravel 5 and Laravel 6.

The package can be used in any controller with the facade or in any blade file with the facade or the blade directives.

The package supports most meta tags. It also supports the `<title>` tag and the `<link>` tag for canonical since they are commonly used.

## Installation

Begin by installing the package with Composer from your command line:

```
$ composer require kfoobar/laravel-meta
```

### Laravel 5.5 or later

If you use auto-discovery, you don't need to do anything more to enable the package.

### Laravel 5.4 or earlier

You need to register the service provider with your Laravel application in `config/app.php`:

```php
'providers' => [
    '...',
    KFoobar\LaravelMeta\MetaServiceProvider::class,
];
```

Also add the facade to the same config file:

```php
'aliases' => [
    '...',
    'Meta'    => KFoobar\LaravelMeta\Facades\Meta::class,
];
```

## How to use

### How to use the facade

If you want to set your tags in a controller, you'll need to add the namespace for the `Meta` facade.

```php
<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use KFoobar\LaravelMeta\Facades\Meta;

class PostController extends Controller
{
...
```

#### Set values

You can set the tag values in your controller with the `set` method.

```php
public function index()
{
    Meta::set('title', 'Your new page title');
    Meta::set('description', 'Your new meta description');
    // or...
    Meta::setTitle('Your new page title');
    Meta::setDescription('Your new meta description');    
}
```

#### Get values

And if you need to, you can also get the values with the `get` method.

```php
public function index()
{
    Meta::get('title', 'Default title if none is set');
    Meta::get('description', 'Default description if none is set');
    // or...
    Meta::getTitle('Default title if none is set');
    Meta::getDescription('Default description if none is set');
 }
```

#### Get the full html tag

I you want the full html tag as a string, use the `tag` method.

```php
$titleTag = Meta::tag('title');
$titleTag = Meta::tag('title', 'Default title if none is set');
```

#### Check if value is set

If you need the check if any value is set, use the `has` method.

```php
if (!Meta::has('title')) {
    Meta::set('title', 'This is a fallback title');
}
```

### How to use the blade directives

You can use the facade directly in you blade files, but there are a few blade directives that will make your blade files look a bit cleaner.

#### Set values

By using the `@setMeta` directive, you can set the values of your title and meta tags in any blade file.

```php
@setMeta('title', 'Your new page title');
@setMeta('description', 'Your new meta description');
```

#### Get values

Use the `@getMeta` directive when you want to get the value of your title and meta tags.

```php
@getMeta('title')
@getMeta('title', 'Default title if none is set')

<title>
    @getMeta('title', 'Default title if none is set')
</title>
```

#### Get the full html tag

You can use the `@getTag` directive when you want to print the full html tag.

```php
@getTag('title')
@getTag('title', 'Default title if none is set')

@getTag('description')
@getTag('description', 'Default description if none is set')
```

#### Check if value is set

When you need the check if any value is set, use the `@hasMeta` directive.

```php
@hasMeta('author')
   <meta name="author" content="@meta('author')">
@endhasMeta
```

You can also use `@endif` instead of `@endhasMeta` if you prefer.

## Example

This is our blade file:

```php
@getTag('description')
@getTag('keywords')
@getTag('robots', 'index, follow')
@getTag('csrf-token')

@getTag('title', 'Default title if none is set')

@hasMeta('canonical')
    @getTag('canonical')
@endhasMeta
```

This will be the output:

```php
<meta name="description" content="Lorem ipsum dolor...">
<meta name="keywords" content="lorem, ipsum, dolor">
<meta name="robots" content="index, follow">
<meta name="csrf-token" content="4ipX8A07Awf60ZUBPBfy...">

<title>Default title if none is set</title>

<link rel="canonical" href="https://example.com/this-is-a-slug">
```

## Contributing

Contributions are welcome!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
