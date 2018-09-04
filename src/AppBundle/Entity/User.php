<?php namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="`user`", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=60, nullable=true)
     * @Expose
     * @SerializedName("firstName")
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=60, nullable=true)
     * @Expose
     * @SerializedName("lastName")
     */
    protected $lastName;

    /**
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     * @Expose
     * @SerializedName("birthDate")
     * @Accessor(getter="getBirthDateAsTimestamp",setter="setBirthDate")
     */
    protected $birthDate;

    /**
     * @ORM\Column(name="body_weight", type="float")
     * @Expose
     * @SerializedName("bodyWeight")
     */
    protected $bodyWeight;

    /**
     * @ORM\Column(name="country", type="string")
     * @Expose
     */
    protected $country;

    /**
     * @ORM\Column(name="gender", type="string")
     * @Expose
     */
    protected $gender;

    /**
     * @ORM\Column(name="club", type="string", nullable=true)
     * @Expose
     */
    protected $club;

    /**
     * @ORM\Column(name="art_of_paddling", type="string")
     * @Expose
     */
    protected $artOfPaddling;

    /**
     * @var string
     * @ORM\Column(name="pw_reset_token", type="string", length=150, nullable=true)
     */
    protected $pwResetToken;

    /**
     * @ORM\OneToMany(targetEntity="Training", mappedBy="user")
     */
    protected $trainings;

    /**
     * @ORM\OneToMany(targetEntity="TrainingAvg", mappedBy="user")
     */
    protected $avgTrainings;

    /**
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    private $facebookId;

    /**
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    private $googleId;

    /**
     * @ORM\Column(name="unit_weight", type="string")
     * @Expose
     * @Assert\Choice(callback = "getUnitTypes")
     */
    protected $unitWeight = 'metric';

    /**
     * @ORM\Column(name="unit_distance", type="string")
     * @Expose
     * @Assert\Choice(callback = "getUnitTypes")
     */
    protected $unitDistance = 'metric';

    /**
     * @ORM\Column(name="unit_pace", type="string")
     * @Expose
     * @Assert\Choice(callback = "getUnitTypes")
     */
    protected $unitPace = 'metric';

    public static function getUnitTypes() {
        return [
            'metric',
            'imperial'
        ];
    }

    public function __construct() {
        parent::__construct();
        $this->trainings = new ArrayCollection();
        $this->avgTrainings = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getBodyWeight()
    {
        return $this->bodyWeight;
    }

    /**
     * @param mixed $bodyWeight
     */
    public function setBodyWeight($bodyWeight)
    {
        $this->bodyWeight = $bodyWeight;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }



    public static function getGenders()
    {
        return array('male', 'female');
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    /*public function getRoles()
    {
        //return ['ROLE_USER'];
        return $this->roles;
    }*/

    public function addTraining(Training $training)
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings->add($training);
            $training->setUser($this); // Fix this
        }
    }

    public function removeTraining($training)
    {
        $this->trainings->remove($training);
        $training->setUser(null);
    }

    public function getTrainings()
    {
        return $this->trainings;
    }

    public function clearTrainings()
    {
        return $this->trainings->clear();
    }

    /**
     * @return mixed
     */
    public function getPwResetToken()
    {
        return $this->pwResetToken;
    }

    /**
     * @param mixed $pwResetToken
     */
    public function setPwResetToken($pwResetToken)
    {
        $this->pwResetToken = $pwResetToken;
    }

    public function getBirthDateAsTimestamp(){
        if($this->birthDate){
            return $this->birthDate->getTimestamp()*1000;
        }
         return null;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param mixed $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    public function addAvgTraining(TrainingAvg $training)
    {
        if (!$this->avgTrainings->contains($training)) {
            $this->avgTrainings->add($training);
            $training->setUser($this); // Fix this
        }
    }

    public function removeAvgTraining($training)
    {
        $this->avgTrainings->remove($training);
        $training->setUser(null);
    }

    public function getAvgTrainings()
    {
        return $this->avgTrainings;
    }

    public function clearAvgTrainings()
    {
        return $this->avgTrainings->clear();
    }

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param mixed $googleId
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }

    /**
     * @return mixed
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club)
    {
        $this->club = $club;
    }

    /**
     * @return mixed
     */
    public function getArtOfPaddling()
    {
        return $this->artOfPaddling;
    }

    /**
     * @param mixed $artOfPaddling
     */
    public function setArtOfPaddling($artOfPaddling)
    {
        $this->artOfPaddling = $artOfPaddling;
    }

    /**
     * Set unitWeight
     *
     * @param string $unitWeight
     *
     * @return User
     */
    public function setUnitWeight($unitWeight)
    {
        $this->unitWeight = $unitWeight;

        return $this;
    }

    /**
     * Get unitWeight
     *
     * @return string
     */
    public function getUnitWeight()
    {
        return $this->unitWeight;
    }

    /**
     * Set unitDistance
     *
     * @param string $unitDistance
     *
     * @return User
     */
    public function setUnitDistance($unitDistance)
    {
        $this->unitDistance = $unitDistance;

        return $this;
    }

    /**
     * Get unitDistance
     *
     * @return string
     */
    public function getUnitDistance()
    {
        return $this->unitDistance;
    }

    /**
     * Set unitPlace
     *
     * @param string $unitPace
     *
     * @return User
     */
    public function setUnitPace($unitPace)
    {
        $this->unitPace = $unitPace;

        return $this;
    }

    /**
     * Get unitPace
     *
     * @return string
     */
    public function getUnitPace()
    {
        return $this->unitPace;
    }
}
