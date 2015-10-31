<?php 

//namespace Personio\Libraries;

class Vacation {
	const WORKDAYS_PER_WEEK = 5;
	const VACATION_FULL_YEAR = 24;
	const VACATION_PER_MONTH = 2;
	const PROBATION_MONTH_PERIOD = 6;

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
	public function __construct(\DateTime $start_date, \DateTime $calc_date)
	{
		if ($start_date > $calc_date) {
			throw new \InvalidArgumentException('Start date cannot be greater than calculation date.');
		}
		$this->start_date = $start_date;
		$this->calc_date = $calc_date;
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
     * Void main
     */
    public function calculate()
    {
        return $this->accumulatedVacation($this->start_date, $this->calc_date);
    }

    /**
     * @param DateTime $start_date
     * @param DateTime $calc_date
     */
    private function isQualified(\DateTime $start_date, \DateTime $calc_date)
    {
        $number_of_m = $this->workedMonth($start_date, $calc_date);
        $number_of_m += 1; // Granted vacation on the first working day.
        if($number_of_m > self::PROBATION_MONTH_PERIOD)
        {
            $this->qualified = true;
        }
    }

    /**
     * @param DateTime $start_date
     * @param DateTime $calc_date
     * @return int
     */
    private function accumulatedVacation(\DateTime $start_date, \DateTime $calc_date)
    {
        $start_year = intval($start_date->format('Y'));
        $start_day = intval($start_date->format('d'));
        $calc_year = intval($calc_date->format('Y'));
        $prev_year = $start_date;
        $stopped = true;
        // Last day in last year.
        if($calc_year - $start_year > 0)
        {
            $stopped = false;
            $prev_year = new \DateTime(($calc_year - 1).'-12-'.$start_day);
        }

        $number_of_m = $this->workedMonth($prev_year, $calc_date);
        if($stopped){
            // Granted vacation on the first working day.
            $vacation_months = $this->qualified === true ? self::VACATION_FULL_YEAR : $number_of_m * self::VACATION_PER_MONTH + self::VACATION_PER_MONTH;
        }else{
            $vacation_months = $this->qualified === true ? self::VACATION_FULL_YEAR : $number_of_m * self::VACATION_PER_MONTH;
        }

        $this->vacation['vacation'][$calc_year] = $vacation_months;
        if($stopped){
            return $vacation_months;
        }

        return $vacation_months + $this->accumulatedVacation($start_date, $prev_year);
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