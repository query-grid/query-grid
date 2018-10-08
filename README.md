Query Grid
------------
Framework Agnostic DataGrid / Query Builder implementation.

 _Everybody loves badges, check ours out:_

[![Build Status](https://img.shields.io/travis/willishq/query-grid/master.svg?style=flat-square)](https://travis-ci.org/willishq/query-grid)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/willishq/query-grid/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/willishq/query-grid/?branch=master) 
[![Code Coverage](https://scrutinizer-ci.com/g/willishq/query-grid/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/willishq/query-grid/?branch=master)
[![StyleCI](https://styleci.io/repos/151885472/shield)](https://styleci.io/repos/151885472)

## Disclaimer
This package's `master` branch is currently in "proof of concept" state, it works "as is" but things
can and will change. There are a lot of things which will be done differently in the finished package! Use at your own risk!

Development is currently on the `develop` branch which is a whole new project taking what was learnt building the proof of concept
and creating the project again from start to finish.

## Installation

`composer require willishq/query-grid`

## Usage

_You'll need to create an implementation of the `Willishq\QueryGrid\Contracts\DataProvider` interface in order to query the data._

```php
$grid = new \Willishq\QueryGrid\Grid($dataProvider, $queryParams);

$grid->setResource('users'); // The resource sent to the data provider for the query.

$grid->addColumn('id', '#');
$grid->addColumn('name', 'Name');
$grid->addColumn('created_at', 'Start Date');

$result = $grid->getResults();
```

if you want to do more stuff to columns, you can pass a closure as the third parameter to the `addColumn` method:

```php
$grid->addColumn('name', 'Name', function (Column $column) {
    $column->filterable();
    $column->sortable();
    $column->queryable();
    $column->formatter(function ($value) {
        return $value . '!';
    });
});
```

These options make the columns filterable, sortable or queryable. The formatter method takes the row value and formats it.

If you're parsing date values this can be useful to display the date in a user friendly way, or if you use a binary UUID
then you can convert it to a string here.

## Queries / Filters / Sorting

passing the query parameters to the grid enable you to filter, sort or query the data.

`?filter[name]=and|*&query=*|rew&sort=-created_at,name`

this query string would be converted to the following array:

```php
$queryParams = [
    'filter' => [
        'name' => 'and|*',
    ],
    'query' => '*|rew',
    'sort' => '-created_at,name',
];

```

The syntax for querying/filtering uses pipes to separate operators from the query string.

- `*` is a wildcard, so `*|rew` matches `drew`, `andrew`, `asdfiuwnveyvberew` but not `reww`
- `>|` is greater than
- `<|` is less than
- `>:|` is greater than or equal to
- `<:|` is less than or equal to

The colon being used for equality is not ideal, but we can not use the `=`. I'm open to suggestions about this if anybody
has any ideas.

Sorting is more simple. if you're sorting in ascending order, just provide the field name. Descending order: prefix the field
name with a `-`. You can provide multiple sorts separated by a comma, so `-created_at,name` will order by `created_at` descending
and then name in ascending order when the `created_at` value are identical.

## Coming soon / Todo
- `GridResult` documentation
- Filter Options 
  - filter type (date / string / dropdown / boolean)
  - dropdown options
- Query String filters revamp (maybe alias fields as filter fields)
- Better error handling
- Code of Conduct
- Laravel data provider package
