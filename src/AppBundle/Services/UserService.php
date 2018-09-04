<?php namespace AppBundle\Services;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{

    public function userObjectReducer(UserInterface $user)
    {
        return [
            'id'  =>  $user->getId(),
            'username'  =>  $user->getUsername(),
            'email'  =>  $user->getEmail(),
            'firstName'  =>  $user->getFirstName(),
            'lastName'  =>  $user->getLastName(),
            'birthDate'  =>  $user->getBirthDateAsTimestamp(),
            'gender'  =>  $user->getGender(),
            'country'  =>  $user->getCountry(),
            'bodyWeight'  =>  $user->getBodyWeight(),
            'club'  =>  $user->getClub(),
            'artOfPaddling'  =>  $user->getArtOfPaddling(),
            'unitWeight' => $user->getUnitWeight(),
            'unitDistance' => $user->getUnitDistance(),
            'unitPace' => $user->getUnitPace()
        ];
    }

}
