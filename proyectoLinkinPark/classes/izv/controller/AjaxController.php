<?php
namespace izv\controller;

use izv\tools\Reader;
use izv\tools\Tools;
use izv\tools\Upload;

use izv\data\Category;
use izv\data\Project;

/**
 * El controlador
 * 
 */
class AjaxController extends Controller {
    
    private function checkLogin() {
        if(!$this->getSession()->isLogged()) {
            exit();
        }
    }
    
    function action($params) {
        $this->checkLogin();
        $user_id = $this->getSession()->getLogin()->getId();
        
        $page = Reader::read('page');
        if($page === null || !is_numeric($page)) {
            $page =1;
        }
        
        $order = Reader::read('order');
        $orderes = array( 'id'=>'', 'href'=>'', 'comment'=>'', 'category'=>'', 'visible'=>'' );
        if(!isset($orderes[$order])) {
            $order = 'id';
        }
        $filter = Reader::read('filter');
        
        if(isset($params['type'])) {
            $type = $params['type'];
            
            if(isset($params['type'])) {
                $type = $params['type'];
                $r = ['action' => false];
                if($type === 'category') {
                    $r = $this->getModel()->getCategories($user_id, $page, $order, $filter);
                    $tmp =$r['categories_list'];
                    unset($r['categories_list']);
                    $r['list'] = $tmp;
                } else if($type === 'link') {
                    $r = $this->getModel()->getLinks($user_id, $page, $order, $filter);
                    $tmp =$r['links_list'];
                    unset($r['links_list']);
                    $r['list'] = $tmp;    
                } else if ($type === 'project') {
                    $r = $this->getModel()->getProjects($user_id, $page, $order, $filter);
                    $tmp =$r['projects'];
                    unset($r['projects']);
                    $r['list'] = $tmp;
                }
                $this->getModel()->add($r);
            }
        }
        //echo Tools::view($this->getModel()->getViewData());
    }
    
    function insert($params) {
        $this->checkLogin();
        
        $user_id = $this->getSession()->getLogin()->getId(); 
        $r = false;
        
        if(isset($params['type'])) {
            $type = $params['type'];
            
            if($type === 'category') {
                if(isset($params['name'])) {
                    $category = new Category();
                    $category->setName($params['name']);
                    $category->setActive(true);
                    $r = $this->getModel()->addCategory($user_id, $category);
                }
            } else if($type === 'link') {
                $link = Reader::readObject('izv\data\Link');
                if($link !== null) {
                    $r = $this->getModel()->addLink($user_id, $link);
                }
            } else if($type === 'project') {
                $project = Reader::readObject('izv\data\Project');
                if ($project !== null) {
                    if(isset($_FILES['fichero']) && $_FILES['fichero']['error'] === 0) {
                        $archivo = file_get_contents($_FILES['fichero']['tmp_name']);
                        $encode = base64_encode($archivo);
                        $project->setImage($encode);
                    }
                    $project->setDate(new \DateTime($project->getDate()));
                    
                    $r =  $this->getModel()->addProject($project);    
                }
            }
        }
        
        $this->getModel()->set('action', $r);
    }
    
    function dodelete($params) {
        $this->checkLogin();
        $r = 0;
        
        if(isset($params['type'])) {
            $type = $params['type'];
            
            $types = array(
                'category' => 'izv\data\Category',
                'link' => 'izv\data\Link',
                'project' => 'izv\data\Project',
            );
            
            if(isset($types[$type])) {
                $class = $types[$type];
                
                $id = Reader::read('id');
                $ids = Reader::readArray('ids');
                if(isset($id)) {
                    $r = $this->getModel()->delete($id, $class);
                } else if($ids !== null) {
                    $r = $this->getModel()->deleteMultiple($ids, $class);
                }    
            }
        }
        $this->getModel()->set('action', $r);
    }
    
    function doupdate($params) {
        $this->checkLogin();
        $r = false;
        $id = Reader::read('id');
        
        if(isset($params['type']) && $id !== null ) {
            $type = $params['type'];
            
            if($type === 'category') {
                $category = Reader::readObject('izv\data\Category');
                if ($category !== null) {
                    $r = $this->getModel()->edit($id, 'izv\data\Category', $category->get());
                }
            } else if($type === 'link') {
                $link = Reader::readObject('izv\data\Link');
                if ($link !== null) {
                    $r = $this->getModel()->edit($id, 'izv\data\Link', $link->get());
                }
            } else if($type === 'project') {
                $project = Reader::readObject('izv\data\Project');
                if(isset($id) && isset($project)) {
                    $array = array();
                    foreach ($project->get() as $i=>$val) {
                        if(isset($val) && Reader::read($i) !== null) 
                            $array[$i] = $val;
                    }
                    
                    if(isset($_FILES['fichero']) && $_FILES['fichero']['error'] === 0) {
                        $archivo = file_get_contents($_FILES['fichero']['tmp_name']);
                        $encode = base64_encode($archivo);
                        $array['image'] = $encode;
                    }
                    
                    if(isset($array['date'])) {
                        $array['date'] = new \DateTime($array['date']);
                    }
                    
                    $r = $this->getModel()->updateProject($id, $array);
                }
            }
        }
        $this->getModel()->set('action', $r);
    }
    
}