<?php 

//namespace Personio\Libraries;

class Vacation {
	const WORKDAYS_PER_WEEK = 5;
	const VOCATION_FULL_YEAR = 24;
	const VOCATION_PER_MONTH = 2;
	const PROBATION_MONTH_PERIOD = 6;		
	
	private $start_date;
	private $calc_date;
	private $remaining_vocation_days = 0;
    private $vacation = [];
	
	public function __construct(\DateTime $start_date, \DateTime $calc_date)
	{
		if ($start_date > $calc_date) {
			throw new \InvalidArgumentException('Start date cannot be greater than calculation date.');
		}
		$this->start_date = $start_date;
		$this->calc_date = $calc_date;
	}

    public function init()
    {
        return $this->vacation = [
            'vacation' => [],
            'vacation_taken' => []
        ];
    }
	
	/**
     * Void main
     */
    public function calculate()
    {
        return $this->accumulatedVacation($this->start_date, $this->calc_date);
    }

    /**
     * @param DateTime $start_date
     * @param DateTime $calc_date
     * @return int
     */
    private function accumulatedVacation(\DateTime $start_date, \DateTime $calc_date)
    {
        $start_year = intval($start_date->format('Y'));
        $calc_year = intval($calc_date->format('Y'));
        // Last day in last year.
        $last_year = $calc_year - $start_year > 0 ? ($calc_year - 1).'-12-31' : 0;
        $number_of_m = $this->workedMonth($start_date, $calc_date);
        if($number_of_m >= self::PROBATION_MONTH_PERIOD){
            $vacation_months = self::VOCATION_FULL_YEAR;
        } else {
            $vacation_months = $number_of_m * self::VOCATION_PER_MONTH;
        }

        if($number_of_m < 12 || $last_year == 0){
            return $vacation_months;
        }

        $last_year_dt = new \DateTime($last_year);
        return $vacation_months + $this->accumulatedVacation($start_date, $last_year_dt);
    }

    /**
     * @param \DateTime $start_date
     * @param \DateTime $calc_date
     * @return int
     */
    private function workedMonth(\DateTime $start_date, \DateTime $calc_date)
    {
        $interval = $start_date->diff($calc_date);
        $m = intval($interval->format('%m'));
        $y = intval($interval->format('%y'));
        if($y > 0){
            $m += $y*12;
        }
        return $m;
    }

    /**
     * @param \DateTime $start_date
     * @param \DateTime $calc_date
     * @return float|mixed
     */
    private function weekdays(\DateTime $start_date, \DateTime $calc_date)
    {
        $start_timestamp = $start_date->getTimestamp();
        $calc_timestamp = $calc_date->getTimestamp();
        // Find day of week for 2 dates
        $start_d = date('N', $start_timestamp);
        $calc_d = date('N', $calc_timestamp);
        // Calculate the number of time span in terms of weeks.
        $w = floor(($calc_timestamp - $start_timestamp)/(86400*7));
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
        return $wd;
    }
}