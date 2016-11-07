<?php

namespace Guide\CountrysBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="Guide\CountrysBundle\Repository\CityRepository")
 * @JMS\ExclusionPolicy("all")
 */
class City
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Name is required.")
     * @ORM\Column(name="title", type="string", length=255)
     * @JMS\Expose
     */
    private $title;


    /**
     * @Assert\NotBlank(message="Country_id is required.")
     * @ORM\Column(name="country_id", type="integer")
     */
    private $country_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="citys")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    public function __toString()
    {
        return $this->getTitle();
    }

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
     * Set title
     *
     * @param string $title
     * @return City
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set country_id
     *
     * @param integer $countryId
     * @return City
     */
    public function setCountryId($countryId)
    {
        $this->country_id = $countryId;

        return $this;
    }

    /**
     * Get country_id
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Set country
     *
     * @param \Guide\CountrysBundle\Entity\Country $country
     * @return City
     */
    public function setCountry(\Guide\CountrysBundle\Entity\Country $country = null)
    {
        $this->country = $country;
        $this->setCountryId($country->getId());
        return $this;
    }

    /**
     * Get country
     *
     * @return \Guide\CountrysBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
