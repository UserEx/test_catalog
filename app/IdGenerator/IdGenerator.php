<?php
namespace App\IdGenerator;

use Doctrine\ORM\Id\AbstractIdGenerator;

class IdGenerator extends AbstractIdGenerator
{    
    public function generate(\Doctrine\ORM\EntityManager $em, $entity)
    {
        /* @var $entity \App\Entity\Catalogue */
 
        $depthPrefixes = array('D', 'C', 'S');
        $parent = $entity->getParent();
        
        $depth = $parent ? array_flip($depthPrefixes)[$parent->getId()[0]] + 1 : 0;
        
        $prefix = $depthPrefixes[$depth];
        
        
        $entityName = $em->getClassMetadata(get_class($entity))->getName();
        
        while (true)
        {
            $id = $prefix . mt_rand(10000000, 99999999);
            $item = $em->find($entityName, $id);
            
            if (!$item)
            {
                return $id;
            }
        }
        
        throw new \Exception('Could not generate unique ID');
    }
}