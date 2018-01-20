<?php
namespace App\Service;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\CatalogueNode;
use Doctrine\ORM\EntityManager;
use App\Entity\CatalogueSlug;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class CatalogueUpdateEventSubscriber implements EventSubscriber
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function prePersist(LifecycleEventArgs $event)
    {
        $node = $event->getObject();
        
        if ($node && ($node instanceof CatalogueNode)) {
            $this->addSlug($node, $event);
        }
    }
    
    
    public function postUpdate(LifecycleEventArgs $event)
    {
        $node = $event->getObject();
        
        if ($node && ($node instanceof CatalogueNode)) {
                $this->addSlugs($node);
                $event->getEntityManager()->flush();            
        }
        
    }
    
    protected function addSlug(CatalogueNode $node)
    {
        $slugStr = '';
        $baseNode = $node;

        while ($node) {
            $slugStr = '/'. str_slug($node->getTitle()) . $slugStr;
            $node = $node->getParent();
        }
        $slugStr = ltrim($slugStr, '/');        
        
        $slugs = $this->em->getRepository(CatalogueSlug::class)
            ->findBy(array('slug' => $slugStr));
        
        if (!count($slugs)) {
            $slug = new CatalogueSlug();
            $slug->setCatalogueNode($baseNode);
            $slug->setSlug($slugStr);
            
            $this->em->persist($slug);
            
            $baseNode->setSlug($slug);
        }
        
    }
    
    protected function addSlugs(CatalogueNode $node)
    {
        $this->addSlug($node);
        
        foreach ($node->getChildren() as $child) {
            $this->addSlugs($child);
        }
    }
    
    public function getSubscribedEvents()
    {
        return [Events::prePersist, Events::postUpdate];
    }
}