<?php

namespace Tests\Grid;

use DateTime;
use Willishq\QueryGrid\Columns\Formatters\Date;
use Willishq\QueryGrid\Columns\Formatters\DateDiff;
use Willishq\QueryGrid\GridResult;

class GridDataTest extends TestCase
{
    /** @test */
    public function itCanBeCreated()
    {
        $grid = $this->itHasAGridInstance();

        $this->assertSame($this->dataProvider, $grid->getDataProvider());
    }

    /** @test */
    public function itSetsTheResource()
    {
        $grid = $this->itHasAGridInstance();

        $grid->setResource('resource');

        $this->assertEquals('resource', $this->dataProvider->getResource());
    }

    /** @test */
    public function itReturnsTheGridResult()
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
            ->withFormat(new Date('Y-m-d', 'd/m/Y'));

        $grid->addColumn('age', 'Age')
            ->fromField('birthday')
            ->withFormat((new DateDiff('Y-m-d', '%y'))->withFromDate('2018-01-01'));

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
        ], $grid->getResult()->getRows()->all());
    }
}
