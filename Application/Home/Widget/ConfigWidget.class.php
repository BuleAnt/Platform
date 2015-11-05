<?php
namespace Home\Widget;
use Think\Controller;

/**
 * 分类widget
 * 用于动态调用分类信息
 */

class ConfigWidget extends Controller{
	
	/* 显示指定分类的同级分类或子分类列表 */
	/*
	public function lists($cate, $child = false){
		$field = 'id,name,pid,title,link_id';
		if($child){
			$category = D('Category')->getTree($cate, $field);
			$category = $category['_'];
		} else {
			$category = D('Category')->getSameLevel($cate, $field);
		}
		$this->assign('category', $category);
		$this->assign('current', $cate);
		$this->display('Category/lists');
	}
	*/
	/**
	 * [friendlink 友情链接]
	 * @return [type] [description]
	 */
	public function friendlink(){ 
		
		$Friendlink = D('Friendlink');
	    $friendlink = $Friendlink->friendlinkLists();
	    
	    $this->assign('friendlink', $friendlink);
		$this->display('Public/friendlink');  
	}

	/**
	 * [copyright 底部的配置链接]
	 * @return [type] [description]
	 */
	public function copyright(){ 
		$Config = D('Config');
	    $copyright = $Config->copyright();
	    //var_dump($copyright);
	    $this->assign('copyright', $copyright);
		$this->display('Public/copyright');
	}
	
	public function showdate($date){
		var_dump( $date);
	}
}
