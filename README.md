Query Grid
----------
Framework Agnostic DataGrid / Query Builder implementation.

_Everybody loves badges, check ours out:_

[![Build Status](https://img.shields.io/travis/willishq/query-grid/master.svg?style=flat-square)](https://travis-ci.org/willishq/query-grid)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/willishq/query-grid/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/willishq/query-grid/?branch=master) 
[![Code Coverage](https://scrutinizer-ci.com/g/willishq/query-grid/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/willishq/query-grid/?branch=master)
[![StyleCI](https://styleci.io/repos/151885472/shield)](https://styleci.io/repos/151885472)

## Installation

`composer require willishq/query-grid`

## Usage

_You'll need to create an implementation of the `Willishq\QueryGrid\Contracts\DataProvider` interface in order to query the data._

```php
$grid = new \Willishq\QueryGrid\Grid($dataProvider);

$grid->setResource('users'); // The resource sent to the data provider for the query.

$grid->addColumn('id', '#');
$grid->addColumn('name', 'Name');
$grid->addColumn('started', 'Start Date');

$result = $grid->getResult();
```

if you want to do more stuff to columns, the `addColumn` method returns an instance of the column, so you can set the
field mapping, add filters, formatting, mark as sortable or queryable:

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

## Coming soon / Todo
- Better documentation
- `GridResult` documentation
- Filter Options 
  - dropdown options
- Better error handling
- Code of Conduct
- Laravel data provider package
