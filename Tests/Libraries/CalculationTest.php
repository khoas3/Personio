<?php
/**
 * Created by PhpStorm.
 * User: Khoa
 * Date: 11/29/2015
 * Time: 2:52 PM
 */

namespace Personio\Tests\Libraries;

use Personio\Libraries\Vacation;

class CalculationTest extends \PHPUnit_Framework_TestCase {
    public function testVacationEqualsOrGreater6Months()
    {
        $vacation = new Vacation('2015-03-01', '2015-09-01');
        $result = $vacation->calculate();
        $this->assertEquals(24, $result);
    }

    public function testVacationEqualsOrGreater6MonthsInFormerAndLatterYear()
    {
        $vacation = new Vacation('2015-10-18', '2016-04-18');
        $result = $vacation->calculate();
        $this->assertEquals(24, $result);
    }

    public function testVacationLessThan6Months()
    {
        $vacation = new Vacation('2015-10-18', '2016-01-18');
        $result = $vacation->calculate();
        $this->assertEquals(8, $result);
    }

    public function testVacationLessThan6MonthsAndOverPeriodOfFirstApril()
    {
        $vacation = new Vacation('2015-12-18', '2016-04-18');
        $result = $vacation->calculate();
        $this->assertEquals(8, $result);
    }
}