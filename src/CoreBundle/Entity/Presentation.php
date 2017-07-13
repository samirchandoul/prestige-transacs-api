<?php


namespace CoreBundle\Entity;


use CoreBundle\Traits\TraceableAbstract;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Article
 *
 * @ORM\Table(name="presentation")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\PresentationRepository")
 * @UniqueEntity("code")
 * @UniqueEntity("rfid")
 *
 */
class Presentation extends TraceableAbstract
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Groups({"list", "detailsPresentation"})
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @JMS\Groups({"list", "detailsPresentation"})
     */
    private $description;

    /**
     * Presentation constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

}