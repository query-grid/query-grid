<?php

namespace Tests\Grid;

use DateTime;
use Willishq\QueryGrid\GridResult;

class GridDataTest extends TestCase
{
    /** @test */
    public function itCanBeCreated()
    {
        $grid = $this->itHasAGridInstance();

        $this->assertSame($this->dataProvider, $grid->getDataProvider());
        $this->assertEmpty($grid->getQueryParams());
    }

    /** @test */
    public function itSetsTheResource()
    {
        $grid = $this->itHasAGridInstance();

        $grid->setResource('resource');

        $this->assertEquals('resource', $this->dataProvider->getResource());
    }

    /** @test */
    public function itReturnsTheGridResponse()
    {
        $grid = $this->itHasAGridInstance();

        $response = $grid->getResult();

        $this->assertInstanceOf(GridResult::class, $response);
    }

    /** @test */
    public function itFormatsData()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('email_address', 'Email Address')
            ->fromField('email');

        $grid->addColumn('dob', 'Birthday')
            ->fromField('birthday')
            ->withFormat(function ($value) {
                return DateTime::createFromFormat('Y-m-d', $value)
                    ->format('d/m/Y');
            });

        $grid->addColumn('age', 'Age')
            ->fromField('birthday')
            ->withFormat(function ($value) {
                return DateTime::createFromFormat('Y-m-d', $value)
                    ->diff(DateTime::createFromFormat('Y-m-d', '2018-01-01'))
                    ->format('%y');
            });

        $this->dataProvider->setValues([
            [
                'email' => 'andrew@example.com',
                'birthday' => '1963-04-21'
            ],
            [
                'email' => 'rachel@example.com',
                'birthday' => '1973-05-24'
            ],
            [
                'email' => 'bob@example.com',
                'birthday' => '1983-06-27'
            ],
        ]);

        $this->assertEquals([
            [
                'email_address' => 'andrew@example.com',
                'dob' => '21/04/1963',
                'age' => '54',
            ],
            [
                'email_address' => 'rachel@example.com',
                'dob' => '24/05/1973',
                'age' => '44',
            ],
            [
                'email_address' => 'bob@example.com',
                'dob' => '27/06/1983',
                'age' => '34',
            ]
        ], $grid->getResult()->getRows());
    }
}
