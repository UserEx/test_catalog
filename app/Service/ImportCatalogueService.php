<?php
namespace App\Service;

use Doctrine\ORM\EntityManager;
use App\Entity\CatalogueNode;
use Doctrine\ORM\Query;

/**
 * @author user0xff
 *
 */
class ImportCatalogueService
{
    protected $em = null;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function importJson(string $json)
    {
        if (!$categories = json_decode($json)) {
            throw new \Exception('Can not import catalog: json incorrect');          
        }
        $result = $this->em->getRepository(CatalogueNode::class)
            ->createQueryBuilder('n')
            ->select('n.id')
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_SCALAR)
            ->getResult();
        
        $ids = array_column($result, 'id');
        
        foreach ($categories as $category) {
            $this->dfs($category, $ids);
        }
        $this->em->flush();
    }
    
    protected function dfs($node, &$existNodeIds, $parent = null) 
    {
        if (!$node->id || !$node->title) {
            throw new \Exception('Can not import catalog: json incorrect');
        }
        
        if (in_array($node->id, $existNodeIds)) {
            $catalogNode = $this->em->find(CatalogueNode::class, $node->id);
            $catalogNode->setTitle($node->title);
        } else {
            $catalogNode = new CatalogueNode();
        }
        
        $catalogNode->setTitle($node->title);
        
        if ($parent) {
            $catalogNode->setParent($parent);
        }
        
        if (!$catalogNode->getId()) {
            $catalogNode->setId($node->id);
            $this->em->persist($catalogNode);
        }
        
        if (isset($node->children)) {
            foreach ($node->children as $child) {
                $child = $this->dfs($child, $existNodeIds, $catalogNode);
                
                if ($catalogNode->getChildren() && !$catalogNode->getChildren()->contains($child)) {
                    $catalogNode->addChild($child);
                }
            }
        }
        
        return $catalogNode;
    }
}