<?php

namespace le7\Controller\Web;

use le7\Controller\ControllerWebPhp;

class IndexController extends ControllerWebPhp {

    //#[Params(wlp:1)]
    public function indexAction() {
        
        $this->setScriptLib('le7/gridview.js',false);
        $this->setStyleLib('fontawesome6/css/all.css');
        $this->setStyleLib('bootstrap5/dist/css/bootstrap.css');
        $this->setScriptLib('bootstrap5/dist/js/bootstrap.js', false);

        $s = $this->dpFactory->getGroupFromBeanPaginated('products');

        $s->setPage($this->request->wg('page', 1));
        
        $s->setLimit($this->request->wg('per_page',$this->request->wg('per_page',10)));
        
        $conds = array();
        $sql = ' WHERE ';
        $name = $this->request->wg('name');
        if ($name) {
            $sql .= ' name LIKE ? AND';
            $conds[] = '%'.$name.'%';
        }
        
        $price = $this->request->wg('price');
        $priceCond = $this->request->wg('price_cond');
        if ($price && $priceCond) {
            if ($priceCond === 'equal') {
                $sql .= ' price = ? AND';
            }
            if ($priceCond === 'not_equal') {
                $sql .= ' price != ? AND';
            }
            if ($priceCond === 'greater_than') {
                $sql .= ' price > ? AND';
            }
            if ($priceCond === 'less_then') {
                $sql .= ' price < ? AND';
            }
            if ($priceCond === 'greater_or_equal') {
                $sql .= ' price >= ? AND';
            }
            if ($priceCond === 'less_or_equal') {
                $sql .= ' price <= ? AND';
            }
            $conds[] = $price;
        }
        
        $sqlQuery = rtrim($sql,'AND');
        
        if (trim($sqlQuery) === 'WHERE') {
            $sqlQuery = '';
        }
        
        $orderField = $this->request->wg('order_field');
        $orderDirection = $this->request->wg('order_direction');
        if ($orderField && $orderDirection) {
            $order = '';
            if ($orderDirection === 'asc') {
                $od = 'ASC';
            } elseif ($orderDirection === 'desc') {
                $od = 'DESC';
            }
            if ($orderField === 'price') {
                $order .= ' ORDER BY price '.$od;
            }
            if ($orderField === 'name') {
                $order .= ' ORDER BY name '.$od;
            }
            if ($orderField === 'id') {
                $order .= ' ORDER BY id '.$od;
            }
            if ($orderField === 'sku') {
                $order .= ' ORDER BY sku '.$od;
            }
            $sqlQuery .= $order;
        }
        
        $s->setAddSql($sqlQuery);
        $s->setBindings($conds);
        
        $e = $s->getEntity();

        //print_r($e);
        //exit;
        
        $widget = $this->widgets->getGridViewBootstrap($e, [], []);

        //$widget->setFormId('myform_');
        
        $widget->setTitle('My great table');

        $widget->setTableClasses('table-striped table-bordered table-sm');
        
        $widget->setPerPageOptions(true,[2,6,10]);
        //$widget->setPerPageOptions(false);

        $widget->setOrder($this->request->wg('order_field',''),$this->request->wg('order_direction',''),['id']);
        
        $widget->setBase('');

        $widget->setStatEnable(true);
        $widget->setPagerEnable(true);

        $widget->setSearchEnable(true);

        $widget->setActionLinkTop('Create', '/create');
        $widget->setActionLinkBody('id', 'Update', '/update?id={id}');
        $widget->setActionLinkBody('', 'Delete');

        $columns = array(
            'sku'=> null,
            'test' => array(
                'name' => _('myCOlumn'),
                'action' => function () {
                    return 'ddd';
                }
            ),
            'owner' => 'none',
                    'actions' => null,
            'name' => function($item){
                return '<a href="443">'.$item['name'].'</a>';
            },
            'price' => null
        );

        $widget->setSearchWord($this->request->wg('search',''));
        
        $widget->setCustomColumns($columns);

        //print_r($this->request->wg('name',''));
        //exit;
        
        $widget->setFilterFindByString('name', $this->request->wg('name',''), _('Contents'));

        $variants = array(
            'none'=>'none',
            '1' => 'One',
            '2' => 'two',
            '3' => 'three'
        );

        $widget->setFilterFindSelectId('owner', $variants, $this->request->wg('owner',''));

        $widget->setFilterFindByInteger('price', $this->request->wg('price',''), $this->request->wg('price_cond',''));

        $this->assign('table', $widget->render());

        $this->render('test.phtml');
    }


    public function tsAction() {
        echo 'test2';
        exit;
    }
    
}
