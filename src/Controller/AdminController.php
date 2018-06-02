<?php

namespace App\Controller;

use App\Service\UserStatisticsHandler;
use DateTimeImmutable;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\DateTimeHandler;

class AdminController extends Controller
{
     /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {

        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/statistics/this-month-registrations", name="this-month-registrations")
     * @param UserStatisticsHandler $statHandler
     * @param DateTimeHandler $dateHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUsersRegisteredThisMonth(UserStatisticsHandler $statHandler,
                                                 DateTimeHandler $dateHandler)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $data = $statHandler->getRegistrations($dateHandler->getDateThisMonthBegan(),
            $dateHandler->getDateNow());

        return $this->render('admin/this-month-registrations.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/admin/statistics/last-days-visits", name="last-days-visits")
     * @param UserStatisticsHandler $statHandler
     * @param DateTimeHandler $dateHandler
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function showUniqueVisitsForTheLastSevenDays(UserStatisticsHandler $statHandler,
                                                DateTimeHandler $dateHandler)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $data = $statHandler->getVisits($dateHandler->getDateSomeDaysFromNow(-7),
            $dateHandler->getDateNow(), $dateHandler);


        return $this->render('admin/last-days-visits.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/admin/statistics/last-days-visitors", name="last-days-visitors")
     * @param UserStatisticsHandler $statHandler
     * @param DateTimeHandler $dateHandler
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function showLastSevenDaysVisitors(UserStatisticsHandler $statHandler,
                                            DateTimeHandler $dateHandler)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $data = $statHandler->getVisitors($dateHandler->getDateSomeDaysFromNow(-7),
            $dateHandler->getDateNow(), $dateHandler);


        return $this->render('admin/last-days-visitors.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/admin/birthday-reminder", name="birthday-reminder")
     * @param UserStatisticsHandler $statHandler
     * @param DateTimeHandler $dateHandler
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function showBirthDayReminder(UserStatisticsHandler $statHandler,
                                         DateTimeHandler $dateHandler)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $data = $statHandler->getBirthdays($dateHandler->getDateSomeDaysFromNow(-3),
            $dateHandler->getDateSomeDaysFromNow(7));

        return $this->render('admin/birthday-reminder.html.twig', ['data' => $data]);
    }

}
