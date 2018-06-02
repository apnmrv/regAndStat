<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 31/05/2018
 * Time: 18:37
 */

namespace App\Service;

use App\Entity\User;
use App\Entity\Country;
use App\Entity\RegistrationEvent;
use App\Entity\LoginEvent;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;

class UserStatisticsHandler
{
    private $entityManager;
    private $userRepo;
    private $countryRepo;
    private $regRepo;
    private $logRepo;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepo = $entityManager->getRepository(User::class);
        $this->countryRepo = $entityManager->getRepository(Country::class);
        $this->regRepo = $entityManager->getRepository(RegistrationEvent::class);
        $this->logRepo = $entityManager->getRepository(LoginEvent::class);
    }

    /**
     * @param DateTime $fromDate
     * @param DateTime $tillDate
     * @return array
     */
    public function getBirthdays(string $fromDate,
                                 string $tillDate) : array
    {
        return $this->userRepo->findAllByBirthday($fromDate, $tillDate);
    }

    /**
     * @param string $fromDate
     * @param string $tillDate
     * @param DateTimeHandler $dateHandler
     * @return array
     * @throws \Exception
     */
    public function getVisitors(string $fromDate,
                                string $tillDate,
                                DateTimeHandler $dateHandler) : array
    {

        $rawData = $this->logRepo->findVisitorsForAPeriod($fromDate, $tillDate);

        $fineVisitors = [];
        foreach ($rawData as $el) {
            $has_data = false;
            $key = $el['username'];
            $subKey0 = 'name';
            $name = $el['firstName'] . ' ' . $el['lastName'];
            $fineVisitors[$key][$subKey0] = $name;
            $subKey1 = 'visits';
            $date = $fromDate;
            do {
                    $visits = 0;
                    if ($date == $el['date']->format('Y-m-d')) {
                        $visits += $el['times'];
                        $has_data = true;
                    }
                    $fineVisitors[$key][$subKey1][$date] = $visits;

                    $date = $dateHandler->getDateSomeDaysFromGivenDate($date, 1);

                } while ($date < $tillDate);
            if( ! $has_data ) array_pop($fineVisitors);
        }

        return $fineVisitors;
    }

    /**
     * @param string $fromDate
     * @param string $tillDate
     * @return array
     */
    public function getRegistrations(string $fromDate, string $tillDate) : array
    {
        return $this->userRepo->findAllByRegistrationDatesGroupByCity($fromDate, $tillDate);
    }

    /**
     * @param string $fromDate
     * @param string $tillDate
     * @param DateTimeHandler $dateHandler
     * @return array
     * @throws \Exception
     */
    public function getVisits(string $fromDate,
                              string $tillDate,
                              DateTimeHandler $dateHandler) : array
    {
        $date = $fromDate;
        $result = [];
        do {
            $visits = 'no visits';
            $handlerReply = $this->logRepo->findUniqueForADay($date);
            if (isset($handlerReply[0][1])) {
                $visits = $handlerReply[0][2];
            }

            $result [$date] = $visits;

            $date = $dateHandler->getDateSomeDaysFromGivenDate($date, 1);

        } while (
            ($dateHandler->getDateObjectFromString($date))
                ->getTimestamp() <
            ($dateHandler->getDateObjectFromString($tillDate))
                ->getTimestamp());

        return $result;
    }
}