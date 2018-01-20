<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity
 * @ORM\Table (name = "slug")
 */
class CatalogueSlug
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=256, unique=true)
     */
    protected $slug;
    
    
    /**
     * @var CatalogueNode
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\CatalogueNode", inversedBy="slug", fetch="EAGER")
     * @ORM\JoinColumn(name="catalogue_id", referencedColumnName="id")
     */
    protected $catalogueNode;
    
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @param string $slug
     *
     * @return \App\Entity\CatalogueSlug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        
        return $this;
    }
    
    /**
     * @return \App\Entity\CatalogueNode
     */
    public function getCatalogueNode()
    {
        return $this->catalogueNode;
    }
    
    /**
     * @param CatalogueNode $catalogueNode
     *
     * @return \App\Entity\CatalogueNode
     */
    public function setCatalogueNode(CatalogueNode $catalogueNode)
    {
        $this->catalogueNode = $catalogueNode;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->slug;
    }
}