<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table (name = "catalog")
 */
class CatalogueNode
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=9)
     * @ORM\CustomIdGenerator(class="\App\IdGenerator\IdGenerator")
     */
    protected $id;
    
    /**
     * 
     * @var string
     * 
     * @ORM\Column(name="title", type="string", length=256)
     */
    protected $title;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\CatalogueNode", mappedBy="parent")
     *
     */
    protected $children = null;
    
    /**
     * @var CatalogueNode
     * 
     * @ORM\ManyToOne(targetEntity="\App\Entity\CatalogueNode", inversedBy="children", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent = null;
    
    /**
     * @var CatalogueSlug
     * 
     * @ORM\OneToOne(targetEntity="\App\Entity\CatalogueSlug", fetch="EAGER")
     * @ORM\JoinColumn(name="slug_id", referencedColumnName="id")
     */
    protected $slug = null;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $id
     *
     * @return \App\Entity\CatalogueNode
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     * 
     * @return \App\Entity\CatalogueNode
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * @param ArrayCollection $children
     * 
     * @return \App\Entity\Catalogue
     */
    public function setChildren(ArrayCollection $children)
    {
        $this->children = $children;
        
        return $this;
    }
    
    /**
     * @param CatalogueNode $catalogue
     *
     * @return \App\Entity\CatalogueNode
     */
    public function addChild(CatalogueNode $catalogue)
    {
        $this->children->add($catalogue);
        
        return $this;
    }
    
    
    /**
     * @return \App\Entity\CatalogueNode
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * @param CatalogueNode $parent
     * 
     * @return \App\Entity\CatalogueNode
     */
    public function setParent(CatalogueNode $parent)
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    /**
     * @return \App\Entity\CatalogueSlug
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @param \App\Entity\CatalogueSlug $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}