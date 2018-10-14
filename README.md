Query Grid
----------
Framework Agnostic DataGrid / Query Builder implementation.

_Everybody loves badges, check ours out:_

[![Build Status](https://img.shields.io/travis/query-grid/query-grid/master.svg?style=flat-square)](https://travis-ci.org/query-grid/query-grid)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/query-grid/query-grid/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/query-grid/query-grid/?branch=master) 
[![Code Coverage](https://scrutinizer-ci.com/g/query-grid/query-grid/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/query-grid/query-grid/?branch=master)
[![StyleCI](https://styleci.io/repos/151885472/shield)](https://styleci.io/repos/151885472)

## Installation

`composer require query-grid/query-grid`

## Usage

_You'll need to create an implementation of the `QueryGrid\QueryGrid\Contracts\DataProvider` interface in order to query the data._

```php
$grid = new \QueryGrid\QueryGrid\Grid($dataProvider);

$grid->setResource('users'); // The resource sent to the data provider for the query.

$grid->addColumn('id', '#');
$grid->addColumn('name', 'Name');
$grid->addColumn('started', 'Start Date');

$result = $grid->getResult();
```

if you need to do more with columns, the `addColumn` method returns the column, so you can set the field mapping,
filters, formatting, mark as sortable or queryable:

```php
$column = $grid->addColumn('age', 'Age');
$column->fromField('dob');
$column->sortable();
$column->addFilter(Filter::LESS_THAN);
$column->formatter(new DateDiff('Y-m-d', '%y'));
```

## Filters and queries

What are filters and what are queries?

In this package, a filter is a field which, when set, it's value MUST match, so if you have 5 filters, and they've all
been provided, all 5 of the filters must match.

A query is one string which can match many fields, but only one of the fields need to match.

For example, if you have a user with 'hobbies' and 'work_history' fields, you could mark them both as queryable, then
provide a query string which will search both fields return the row if either field matches.

If the user also as `date_of_birth`, `role`, and `name` fields, and you apply filters to them, if the filter is provided,
it `MUST` match.

You can provide a query and filters in the same request too.

_Just because this is how I say that they should work in the package, unless you're using an officially supported 
 `DataProvider` then I can not guarantee this be the case, in fact, if you would rather it worked a different way,
I recommend creating your own data provider to treat filters, sorting and queries any way you want._

## Using queries, filters and sorting

when you call `$grid->getResult()` you can optionally pass through an array represending the 
query. The array can have four optional params:
 
 - filters
 - query
 - sort
 - page
 
Of these, page is related to pagination, telling the grid the current page for data.

### Filters
Filters are a `key:value` representation of a filter query.

The filter key is defined automatically when you add a filter to the grid column.

```php
$column = $grid->addColumn('name', 'Full Name');
$column->fromField('full_name');
$column->addFilter(Filter::CONTAINS);
$column->addFilter(Filter::STARTS_WITH);
$column->addFilter(Filter::ENDS_WITH);
```
This definition does three things: 
 - Defines a grid column with the key `name` and label `Full Name`
 - Defines a field `full_name` which we map the field from
 - adds a `CONTAINS` filter to the query.

when you call `$grid->getResult()`, if you pass the following array:

```php
$grid->getResult([
    'filters' => [
        'name.con' => 'dre',
    ],
]);
```

This will create a `Filter::CONTAINS` query on the `full_name` field with the value `dre`.

```php
$grid->getResult([
    'filters' => [
        'name.st' => 'and',
    ],
]);
```

Will create a `Filter::STARTS_WITH` query.

The dot syntax for keys, as you probably can tell, follows a `{key}.{filter}` syntax.

When converting the columns to arrays, it includes an array of filters on the fields:

```php
[
    [
        'key' => 'name',
        'label' => 'First Name',
        'sortable' => false,
        'queryable' => false,
        'filterable' => true,
        'filters' => [
            'name.con' => [
                'type' => 'con', // Filter::CONTAINS
                'name' => '',
            ],
            'name.st' => [
                'type' => 'st', // Filter::STARTS_WITH
                'name' => '',
            ],
           'name.enw' => [
                'type' => 'enw', // Filter::ENDS_WITH
                'name' => '',
            ],
        ],
    ],
];
```

if your filters have options, they will be present too:
```php
'name.enw' => [
    'type' => 'm1', // Filter::MATCH_ONE
    'name' => '',
    'options' => [
        [
            'value' => '',
            'label' => ''
        ],
        ...
    ],
],
```

This enables you to create the UI for the grid based on a filters type and options.

## Coming soon / Todo
- Better documentation
- Code of Conduct
- Laravel data provider package
