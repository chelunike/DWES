<?php
namespace izv\model;

use izv\database\Database;
use izv\tools\Mail;
use izv\app\App;
use izv\tools\Tools;
use izv\tools\Pagination;
use izv\data\Project;
use izv\data\Link;
use izv\data\Category;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * El modelo siempre accede a la base de datos
 * Luego hay que automatizar esos accesos
 * 
 */
class DashModel extends UserModel {
    
    function pagination($class, $pagina=1, $orden = 'id', $filtro = '', $limit = 10, $wheres = [] ) {
        $gestor = $this->getDoctrine()->getEntityManager();
        
        $names = $gestor->getClassMetadata($class)->getColumnNames();
        $query = $gestor->createQueryBuilder();
        
        // Set select class & from
        $query->select('c');
        $query->from($class, 'c');
        
        // Add search 
        if(isset($filtro) && trim($filtro) !== '') {
            foreach($names as $n => $name) {
                if($n == 0 ) {
                    $query->where( 'c.' . $name.' LIKE :filtro');
                } else
                    $query->orWhere( 'c.' . $name .' LIKE :filtro');
            }
            $query->setParameter('filtro', '%' . trim($filtro) . '%');
        }
        
        // If you want 
        foreach($wheres as $name => $where) {
            $query->andWhere('c.' . $name . ' = '. $where);
        }
        
        // Add orders
        $query->orderBy('c.'.$orden, 'DESC');
        
        //-----------------------------------------------------------------
        /*
        $dql = 'select c ';
        $dql .= 'from ' . $class . ' c ';
        // Add search 
        if(isset($filtro) && trim($filtro) !== '') {
            foreach($names as $n => $name) {
                if($n == 0 ) {
                    $dql .= ' where ( c.' . $name.' LIKE :filtro';
                } else
                    $dql .= ' or c.' . $name .' LIKE :filtro';
            }
            $dql .= ' ) ';
        }
        
        // If you want 
        foreach($wheres as $name => $where) {
            $dql .= ' and c.' . $name . ' = '. $where;
        }
        
        $dql .= ' order by c.' . $orden;
        
        echo $dql;
        
        $query = $gestor->createQuery($dql);
        $query->setParameter('filtro', trim($filtro));
        */
        /* -- The proccess of creative --
        $dql = 'select p from izv\data\Project p where p.author_id = :user order by p.'. $orden .', p.date, p.title, p.content';
        ->from('Project\Entities\Item', 'i')
            ->select("i, e")
            ->join("i.entity", 'e')
            ->where("i.lang = :lang AND e.album = :album")
            ->setParameter('lang', $lang)
            ->setParameter('album', $album);
        
        $expr = $em->getExpressionBuilder();
        
        if(isset($filtro) && trim($filtro) !== '') {
            $dql = 'select p from izv\data\Project p 
                    where p.active = 1 and id like :filtro or u.title like :filtro or u.excerpt like '.$filtro.' or u.date like '.$filtro .'
                    order by p.'. $orden .', p.date, p.title, p.excerpt'; 
            $query = $gestor->createQuery($dql);
            $query->setParameter('filtro', $filtro);
        }
        //$exp =  $qb->expr()->in('r.winner', array('?1'))
        
        //$query->add('where', $exp);
        ->where('e.source_id = :id')
        ->andWhere('source_name=?', 'test')
        ->andWhere('source_val=?', '30')
       
        //$query->orderBy('column1 ASC, column2 DESC');

        //$query->addOrderBy('column1', 'ASC')
        //   ->addOrderBy('column2', 'DESC');
        */
        $total = count($query->getQuery()->getArrayResult());
        //$total = count($query->getResult());
        
        $paginator = new Paginator($query);
        $paginator->getQuery()
            ->setFirstResult($limit * ($pagina - 1))
            ->setMaxResults($limit);
        $paginacion = new Pagination($total, $pagina, $limit);
        
        return array(
            'paginator' => $paginator,
            'rango' => $paginacion->rango(),
            'pagination' => $paginacion->values(),
            'order' => $orden
        );
    }
    
    function getProjects($user_id, $pagina = 1, $orden = 'id', $filtro = '', $limit = 5) {
        $total = $this->getNumProjects($user_id);
        
        $r = $this->pagination('izv\data\Project', $pagina, $orden, $filtro, $limit);
        
        $paginator = $r['paginator'];
        $projects = array();
        foreach($paginator as $project) {
            if($project->getActive()) {
                $array = $project->get();
                $array['date'] = $project->getDate()->format('d-m-Y');
                $array['image'] = stream_get_contents($project->getImage());
                $projects[] = $array;
            }
        }
        
        unset($r['paginator']);
        $r['projects'] = $projects;
        
        return $r;
    }
    
    function getLinks($user_id, $pagina=1, $orden = 'id', $filtro = '', $limit = 5) {
        $total = $this->getNumLinks($user_id);
        
        $r = $this->pagination('izv\data\Link', $pagina, $orden, $filtro, $limit, [ 'author' => $user_id ]);
        
        // Sacamos los datos de forma que se vean
        $paginator = $r['paginator'];
        $links = array();
        foreach($paginator as $link) {
            $tmp = $link->get();
            $tmp['category'] = $link->getCategory()->get();
            $links[] = $tmp;
        }
        // Borramos anterior e insertamos el bueno
        unset($r['paginator']);
        $r['links_list'] = $links;
        
        return $r;
    }
    
    function getCategories($user_id, $pagina=1, $order='id', $filtro='',  $limit = 5) {
        $total = $this->getNumLinks($user_id);
        
        $r = $this->pagination('izv\data\Category', $pagina, $order, $filtro, $limit, [ 'author' => $user_id ]);
        
        // Sacamos los datos de forma que se vean
        $paginator = $r['paginator'];
        $cats = array();
        foreach($paginator as $cat) {
            $cats[] = $cat->get();
        }
        // Borramos anterior e insertamos el bueno
        unset($r['paginator']);
        $r['categories_list'] = $cats;
        
        return $r;
    }
    
    function getNumProjects($user_id) {
        $gestor = $this->getDoctrine()->getEntityManager();
        $user = $gestor->find('izv\data\User', $user_id);
        return count($user->getProjects());
    }
    
    function getNumLinks($user_id) {
        $gestor = $this->getDoctrine()->getEntityManager();
        $user = $gestor->find('izv\data\User', $user_id);
        return count($user->getLinks());
    }
    
    function getNumCategories($user_id) {
        $gestor = $this->getDoctrine()->getEntityManager();
        $user = $gestor->find('izv\data\User', $user_id);
        return count($user->getCategories());
    }
    
    function addCategory($user_id, $category) {
        $user = $this->getUser($user_id);
        if(isset($user)) {
            $category->setAuthor($user);
            return $this->insert($category);
        }
        return false;
    }
    
    function addLink($user_id, $link) {
        $user = $this->getUser($user_id);
        
        $cat = $link->getCategory();
        if ( is_integer($cat) || is_string($cat) ) {
            $cat = $this->getByID('izv\data\Category', $cat);
            $link->setCategory($cat);
        }
        
        if(isset($user)) {
            $link->setAuthor($user);
            return $this->insert($link);
        }
        return false;
    }
    
}