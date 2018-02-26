<?php

namespace app\common\model;

use think\Model;

class Cate extends Model
{
    protected $table = 'shop_cates';
    protected $pk = 'cid';

    // 服装
    // 	男装
    // 	  男上衣
    // 	  男下衣
    // 	    男裤
    // 	    男内裤
    // 	女装
    // 	童装
    // 图书
    // 食品
    static public function getOrderCates()
    {
    	$cates = self::select(); 
    	$arr_cates = [];
    	self::orderCates($cates, $arr_cates);
    	return $arr_cates;
    }

    static private function orderCates($cates, &$arr, $pid = 0, $level = 0)
    {
            foreach($cates as $k=>$v){
                if ($v->pid == $pid) {
                	$v->level = $level;
                    $arr[$v->cid] = $v;
                    self::orderCates($cates, $arr, $v->cid, $level+1);
                }

            }
    }

}
