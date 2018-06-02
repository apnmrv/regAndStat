<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 30/05/2018
 * Time: 17:52
 */

namespace App\Service;
use App\Entity\User;
use App\Entity\Country;
use App\Entity\City;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RequestDataHandler
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="6", max="25")
     * @var string
     */
    public $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="7", max="100")
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="6", max="25")
     * @var string
     */
    public $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="6", max="25")
     * @var string
     */
    public $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="6", max="25")
     * @var string
     */
    public $plainPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @var \DateTimeImmutable
     */
    public $dateOfBirth;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="6")
     * @var string
     */
    public $sex;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="254")
     * @var string
     */
    public $countryName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="254")
     * @var string
     */
    public $cityName;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|EntityRepository
     */
    private $userRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|EntityRepository
     */
    private $countryRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|EntityRepository
     */
    private $cityRepository;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var Country
     */
    private $country;

    /*
     * @var City
     */
    private $city;

    /**
     * @var User
     */
    private $user;

    /**
     * RequestDataHandler constructor.
     * @param EntityManager $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManager $em,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->manager = $em;
        $this->userRepository = $this->manager->getRepository(User::class);
        $this->countryRepository = $this->manager->getRepository(Country::class);
        $this->cityRepository = $this->manager->getRepository(City::class);
        $this->encoder = $passwordEncoder;
    }

    /**
     * Data Processor
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function processData() : void
    {

        $this->checkCreateCountry();
        $this->checkCreateCity();
        $this->checkCreateUser();
        (new RegEventHandler($this->user, $this->manager, new DateTimeHandler()))->handleEvent();

        return;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function checkCreateCountry() : void
    {
        $country = $this->countryRepository
            ->findOneByName($this->countryName);

        if(null === $country) {

            $country = new Country();
            $country->setName($this->countryName);

            $this->manager->persist($country);
            $this->manager->flush();
        }
        $this->country = $this->countryRepository
            ->findOneByName($this->countryName);

        return;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function checkCreateCity() : void
    {
        $city = $this->cityRepository
            ->findOneByCountryAndName($this->country, $this->cityName);

        if(null === $city) {

            $city = new City();

            $city->setName($this->cityName);
            $city->setCountry($this->country);

            $this->manager->persist($city);
            $this->manager->flush();
        }
        $this->city = $this->cityRepository
            ->findOneByCountryAndName($this->country, $this->cityName);

        return;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function checkCreateUser() : void
    {
        $user = $this->userRepository
            ->findOneByUsername($this->username);

        if(null === $user) {
            $user = new User();
            $user->setUserName($this->username);
            $user->setEmail($this->email);
            $password = $this->encoder->encodePassword($user, $this->plainPassword);
            $user->setPassword($password);
            $user->setFirstName($this->firstName);
            $user->setLastName($this->lastName);
            $user->setSex($this->sex);
            $user->setDateOfBirth($this->dateOfBirth);
            $user->setCountry($this->country);
            $user->setCity($this->city);
            $this->manager->persist($user);
            $this->manager->flush();
    }

    $this->user = $user;

        return;
    }
}