<?php

namespace Guide\CountrysBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="Guide\CountrysBundle\Repository\CountryRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Country
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
     * @Assert\NotBlank(message="title is required.")
     * @ORM\Column(name="title", type="string", length=255)
     * @JMS\Expose
     */
    private $title;

    /**
     * @ORM\Column(name="text", type="text", nullable=true)
     * @JMS\Expose
     */
    private $text;    

    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="country")
     * @JMS\Expose
     */
    private $citys;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->citys = new ArrayCollection();
    }

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
     * @return Country
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
     * Add citys
     *
     * @param \Guide\CountrysBundle\Entity\City $citys
     * @return Country
     */
    public function addCity(\Guide\CountrysBundle\Entity\City $citys)
    {
        $this->citys[] = $citys;

        return $this;
    }

    /**
     * Remove citys
     *
     * @param \Guide\CountrysBundle\Entity\City $citys
     */
    public function removeCity(\Guide\CountrysBundle\Entity\City $citys)
    {
        $this->citys->removeElement($citys);
    }

    /**
     * Get citys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCitys()
    {
        return $this->citys;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Country
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
}
