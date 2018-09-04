<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppMessage
 *
 * @ORM\Table(name="app_message", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppMessageRepository")
 */
class AppMessage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="language_code", type="string", length=45, nullable=false)
     */
    private $languageCode;

    /**
     * @var string
     *
     * @ORM\Column(name="message_localized", type="text", length=16777215, nullable=true)
     */
    private $messageLocalized;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set languageCode
     *
     * @param string $languageCode
     *
     * @return AppMessage
     */
    public function setLanguageCode($languageCode)
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    /**
     * Get languageCode
     *
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * Set messageLocalized
     *
     * @param string $messageLocalized
     *
     * @return AppMessage
     */
    public function setMessageLocalized($messageLocalized)
    {
        $this->messageLocalized = $messageLocalized;

        return $this;
    }

    /**
     * Get messageLocalized
     *
     * @return string
     */
    public function getMessageLocalized()
    {
        return $this->messageLocalized;
    }
}
