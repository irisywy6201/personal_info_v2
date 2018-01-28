# SearchEngine

SearchEngine is a tool for searching matched data from database by a given keyword.

## Dependencies

* php5
* composer 1.0.*
* Laravel 4.2
* MySQL 5.6

## Installation

1. Go to `servicedesk/svcdsk/workbench/john/search-engine`.
2. `$ composer install`.
3. Go to `servicedesk/svcdsk`.
4. `$ php artisan dump-autoload`.
5. Done!!

## APIs

```laravel
SearchEngine::search(string $keyword, string $table, array | string $columns)
```
Search the database by a given keyword.

Parameters:

* $keyword: The keyword to be matched.
* $table: The table to be searched.
* $columns: The columns to be searched.

Returns:

Returns the matched results which contain the given keyword as a Builder.