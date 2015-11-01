<?php 

//namespace Personio\Libraries;

class Vacation {
	const WORKDAYS_PER_WEEK = 5;
	const VACATION_FULL_YEAR = 24;
	const VACATION_PER_MONTH = 2;
	const PROBATION_MONTH_PERIOD = 6;
    const DATE_TO_REMOVE = '04-01'; // m-d (Vacation will be lost from 1st of April 2016 forward.)

    /**
     * @var
     */
	private $start_date;
    /**
     * @var
     */
	private $calc_date;
    /**
     * @var array
     */
    private $vacation = [];

    /**
     * @var bool
     */
    private $qualified = false;

    /**
     * Constructor
     *
     * @param DateTime $start_date
     * @param DateTime $calc_date
     */
	public function __construct($start_date, $calc_date)
	{
        // If not numeric then convert texts to unix timestamps
        if (!is_int($start_date)) {
            $this->start_date = strtotime($start_date);
        }
        if (!is_int($calc_date)) {
            $this->calc_date = strtotime($calc_date);
        }

        $this->init();
        $this->isQualified($start_date, $calc_date);
	}

    /**
     * @return array
     */
    public function init()
    {
        $this->vacation = [
            'vacation' => [],
            'vacation_taken' => []
        ];
    }

    /**
     * @return array
     */
    public function getVacation()
    {
        return $this->vacation;
    }

    /**
     * @param $year
     * @param $num
     * @return $this
     */
    public function addVacation($year, $num )
    {
        $this->vacation['vacation'][$year] = $num;
        return $this;
    }

    /**
     * @param $year
     */
    public function removeVacation($year)
    {
        if(isset($this->vacation['vacation'][$year])){
            unset($this->vacation['vacation'][$year]);
        }
    }

    /**
     * @param $key
     * @param $val
     * @return $this
     */
    public function addMessage($msg)
    {
        $this->vacation['vacation_taken'][] = $msg;
        return $this;
    }

    /**
     * @param $start_date
     * @param $calc_date
     */
    private function clearVacation($start_date, $calc_date)
    {
        $start_year = date('Y', $start_date );
        $calc_year = date('Y', $calc_date );
        $range_of_year = $calc_year - $start_year;
        $endpoint = strtotime($calc_year.'-'.self::DATE_TO_REMOVE);
        if($range_of_year > 0){
            // Calc date greater than or equal endpoint.
            if($calc_date - $endpoint >= 0){
                for($i=$calc_year-1;$i>=$start_year; $i--){
                    $this->removeVacation($i);
                }
            }else{
                // year period greater than or equal 1
                $interval = $this->dateDiff($start_date, $calc_date);
                if($interval >= 1){
                    for($i=$calc_year-2; $i>=$start_year;$i--){
                        $this->removeVacation($i);
                    }
                }
            }
        }
    }

    /**
     * @param array $start_vacation
     * @param array $end_vacation
     */
    public function subtractVacation(array $start_vacation, array $end_vacation)
    {
        if(!empty($start_vacation) && !empty($end_vacation)){
            $days = 0;
            foreach($start_vacation as $k => $v){
                $days += $this->weekdays($start_vacation[$k], $end_vacation[$k]);
            }
            // Subtract prev year first if has.
            ksort($this->vacation['vacation']);
            foreach($this->vacation['vacation'] as $k => $v){
                $sub = $v - $days;
                // Day off less than or equal vacation.
                if($sub >= 0){
                    $this->vacation['vacation'][$k] = $sub;
                    break;
                }
                $days = $sub;
                unset($this->vacation['vacation'][$k]);
            }
        }
    }
	/**
     * Void main
     */
    public function calculate()
    {
        // Calculate num of vacation.
        $this->accumulatedVacation($this->start_date, $this->calc_date);
        // Vacation will be lost from 1st of April 2016 forward.
        $this->clearVacation($this->start_date, $this->calc_date);
    }

    /**
     * @param $start_date
     * @param $calc_date
     */
    private function isQualified($start_date, $calc_date)
    {
        $num_of_m = $this->workedMonth($start_date, $calc_date);
        $num_of_m += 1; // Granted vacation on the first working day.
        if($num_of_m > self::PROBATION_MONTH_PERIOD)
        {
            $this->qualified = true;
        }
    }

    /**
     * @param $start_date
     * @param $calc_date
     * @return int
     */
    private function accumulatedVacation($start_date, $calc_date)
    {
        $start_year = date('Y', $start_date);
        $start_day = date('d', $start_date);
        $calc_year = date('Y', $calc_date);
        $prev_year = $start_date;
        $year_before = false;
        // Last month in year.
        if($calc_year - $start_year > 0)
        {
            $year_before = true;
            $prev_year = strtotime(($calc_year - 1).'-12-'.$start_day);
        }

        $num_of_m = $this->workedMonth($prev_year, $calc_date);
        if(!$year_before){
            $num_of_m += 1; // Granted vacation on the first working day.
            $num_of_vacation = $num_of_m > self::PROBATION_MONTH_PERIOD ? self::VACATION_FULL_YEAR : $num_of_m * self::VACATION_PER_MONTH;
        }else{
            $num_of_vacation = $this->qualified === true ? self::VACATION_FULL_YEAR : $num_of_m * self::VACATION_PER_MONTH;
        }

        $this->addVacation($calc_year, $num_of_vacation);
        if(!$year_before){
            return $num_of_vacation;
        }

        return $num_of_vacation + $this->accumulatedVacation($start_date, $prev_year);
    }

    /**
     * @param $start_date
     * @param $calc_date
     * @return mixed
     */
    private function workedMonth($start_date, $calc_date)
    {
        $dateDiff = $this->dateDiff($start_date, $calc_date);
        $y = $dateDiff['year'];
        $m = $dateDiff['month'];
        if($y > 0){
            $m += $y*12;
        }
        return $m;
    }

    /**
     * @param $time1
     * @param $time2
     * @param int $precision
     * @return array
     */
    private function dateDiff($time1, $time2, $precision = 6) {

        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        // Set up intervals and diffs arrays
        $intervals = array('year','month','day','hour','minute','second');
        $diffs = array();

        // Loop through all intervals
        foreach ($intervals as $interval) {
            // Create temp time from time1 and interval
            $ttime = strtotime('+1 ' . $interval, $time1);
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
        // Loop through all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }

            // Add value and interval to times array
            $times[$interval] = $value;
            $count++;
        }

        // Return string with times
        return $times;
    }

    /**
     * @param $start_date
     * @param $calc_date
     * @return float|mixed
     */
    private function weekdays($start_date, $calc_date)
    {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($start_date)) {
            $start_date = strtotime($start_date);
        }
        if (!is_int($calc_date)) {
            $calc_date = strtotime($calc_date);
        }

        // Find day of week for 2 dates
        $start_d = date('N', $start_date);
        $calc_d = date('N', $calc_date);
        // Calculate the number of time span in terms of weeks.
        $w = floor(($calc_date - $start_date)/(86400*7));
        // Deduct the first week from the number of weeks.
        if($calc_d >=$start_d)
        {
            $w--;
        }
        // Calculate the days in the first week.
        $wd = max(6 - $start_d,0);
        // Calculate the days in the last week.
        $wd += min($calc_d, 5);
        $wd += $w*self::WORKDAYS_PER_WEEK;
        $this->addMessage(sprintf("From %s to %s you took %d leave", date('Y-m-d',$start_date), date('Y-m-d', $calc_date), $wd));
        return $wd;
    }
}