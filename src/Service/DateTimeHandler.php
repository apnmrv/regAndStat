<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 17:50
 */

namespace App\Service;


use DateInterval;
use DateTime;
use Exception;

/**
 * @property DateTime timeNow
 */
class DateTimeHandler
{
    private $dateTimeNowObject;
    private $dateNow;
    private $timeNow;
    private $dateThisMonthBegan;
    private $dateThisMonday;
    private $dateThisYearBegan;

    /**
     * DateTimeHandler constructor.
     *
     */
    public function __construct()
    {
        $this->dateTimeNowObject = new DateTime('now');

        $this->dateNow = ($this->dateTimeNowObject)->format('Y-m-d');
        $this->timeNow = ($this->dateTimeNowObject)->format('H:i:s');
        $this->dateThisMonday = (new DateTime('Last Monday'))->format('Y-m-d');
        $this->dateThisMonthBegan = ($this->dateTimeNowObject)->format('Y-m-01');
        $this->dateThisYearBegan = ($this->dateTimeNowObject)->format('Y-01-01');
    }

    /**
     * @return string
     */
    public function getDateNow() : string
    {
        return $this->dateNow;
    }

    /**
     * @return string
     */
    public function getTimeNow() : string
    {
        return $this->timeNow;
    }

    /**
     * @return string
     */
    public function getDateThisMonthBegan() : string
    {
        return $this->dateThisMonthBegan;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getThisMondayDate( ) : string
    {
        return $this->dateThisMonday;
    }

    /**
     * @param int $shift
     * @return string
     * @throws Exception
     */
    public function getDateSomeDaysFromNow( int $shift ) : string
    {
        $interval = new DateInterval('P' . abs( $shift ) . 'D');

        if ( $shift < 0 ) {
            return (new DateTime('now'))->sub ( $interval )->format('Y-m-d');
        }

        return (new DateTime('now'))->add ( $interval )->format('Y-m-d');
    }

    /**
     * @param DateTime $date
     * @param int $shift
     * @return string
     * @throws Exception
     */
    public function getDateSomeDaysFromGivenDate(string $date, int $shift) : string
    {
        $date = $this->getDateObjectFromString($date);

        $interval = new DateInterval('P' . abs($shift) . 'D');

        if ( $shift < 0 ) {
            return ($date->sub( $interval ))->format('Y-m-d');
        }

        return ($date->add( $interval ))->format('Y-m-d');
    }

    public function getDateObjectFromString(string $s) : DateTime
    {
        $date = new DateTime($s);
        return $date;
    }
}