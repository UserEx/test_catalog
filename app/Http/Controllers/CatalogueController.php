<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Doctrine\ORM\EntityManager;
use App\Entity\CatalogueNode;
use Doctrine\ORM\Query;
use App\Entity\CatalogueSlug;
use Illuminate\Http\Response;
use Doctrine\ORM\Query\Expr\Join;

class CatalogueController extends Controller
{
    protected $em = null;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function index()
    {
        $nodes = $this->em
            ->getRepository(CatalogueNode::class)
            ->createQueryBuilder('cn1')
            ->addSelect('cn2')
            ->addSelect('cn3')
            ->where('cn1.id LIKE \'D%\'')
            ->leftJoin('cn1.children', 'cn2', Join::WITH, 'cn2.id LIKE \'C%\'')
            ->leftJoin('cn2.children', 'cn3', Join::WITH, 'cn3.id LIKE \'S%\'')
            ->getQuery()
            ->getResult(/* Query::HYDRATE_ARRAY */);
        
        $nodesArray = array();
        
        /* @var $node CatalogueNode */
        foreach ($nodes as $node) {
            $nodesArray[] = $this->convertNodeToArray($node);
        }
        
        return view('catalogue.index', array('json_nodes' => json_encode($nodesArray)));
    }
    
    protected function convertNodeToArray(CatalogueNode $node)
    {
        $nodeArray = array(
            'text' => $node->getTitle(),
            'nodes' => array(),
            'href' => route('showCategoryBySlug', array('slug' => $node->getSlug()->getSlug()), false)
        );
        
        foreach ($node->getChildren() as $child) {
            $nodeArray['nodes'][] = $this->convertNodeToArray($child);
        }
        
        return $nodeArray;
    }
    
    public function showCategoryBySlug(Request $request, $slug)
    {
        $slug = $slug;
        /* @var $categorySlug CatalogueSlug */
        $categorySlug = $this->em->getRepository(CatalogueSlug::class)
            ->findOneBy(array('slug' => $slug));
        
        if (!$categorySlug) {
            abort(404, 'Не нашли такого слизняка');
        }
        
        $node = $categorySlug->getCatalogueNode();
        
        if ($node->getSlug()->getId() != $categorySlug->getId()) {
            
            return redirect()->route('showCategoryBySlug', array(
                'slug' => (string) $node->getSlug()
            ))->setStatusCode(301);
        }
        
        return view('catalogue.show', array('category' => $node));
    }
}
