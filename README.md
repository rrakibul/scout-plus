<h2 align="center">Scout Plus</h2>

## Introduction

Scout Plus is a laravel package based on [Laravel Scout](https://github.com/laravel/scout) package. 

Laravel Scout currently provides limited supports to the popular search engines: [Algolia](https://www.algolia.com/) & [Meilisearch](https://github.com/meilisearch/meilisearch). 

The objective of this package is to extend the capabilities of Laravel Scout, enabling it to support all operations provided by the supported search engines.

Currenly Scout Plus provides extend support for Meilisearch only. 

## Installing

This package requires Laravel 9.0 or later running on PHP 8.0 or higher.

This package can be installed using composer:

````
composer require rrakibul/scout-plus
````

## Documentation

Documentation for Scout can be found on the [Laravel website](https://laravel.com/docs/master/scout).

## Usage

Please follow the Scout documentation for development instructions. 

Additional usages that not in scout documentation.

````
Document::search($q)
                ->whereBetween('updated_at_timestamp', [$from, $to])

````

Now `where` clause will accept three parameters: [field], [operator], [value]
Supported operators: ` = , !=, >, <, >=, <= `

````
Order::search($q)
                ->where('amount', '>' 100)
````

````
// In case you ommit the operator parameter, this package will assume the operator is `=`.   

Order::search($q)
                ->where('amount', 100)
````

Note: Currently, the above operations will work only for meilisearch driver.

## License

Scout Plus is open-sourced software licensed under the [MIT license](LICENSE.md).