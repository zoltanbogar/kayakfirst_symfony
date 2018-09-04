<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Version
 *
 * @ORM\Table(name="version")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VersionRepository")
 */
class Version
{

    /**
     * @var integer
     *
     * @ORM\Column(name="android", type="integer")
     * @ORM\Id
     */
    private $android;

    /**
     * @var integer
     *
     * @ORM\Column(name="ios", type="integer")
     */
    private $ios;

    /**
     * Get android
     *
     * @return integer
     */
    public function getAndroid()
    {
        return $this->android;
    }

    /**
     * Get ios
     *
     * @return integer
     */
    public function getIos()
    {
        return $this->ios;
    }

}
