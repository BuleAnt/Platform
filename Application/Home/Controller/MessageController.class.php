<?php
namespace Home\Controller;
use OT\DataDictionary;

class MessageController extends HomeController {
	
	//设置页面特征：标题，控制器名称，
    public $PageFeature = array('ControllerName' =>'Resources/index', 'Title' =>'教学资源');
    //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
        $this->assign('PageFeature',$this->PageFeature);
    }
    
    public function index($p='1'){

        $banner = $this->getBanner($this->PageFeature['ControllerName']);
        $this->assign('banner',$banner);

    	
         /* 查询条件初始化 */
        $map = array();
        $map  = array('status' => 1);
        $list = $this->lists('Message', $map,'create_time desc');
        $this->assign('list',$list);

    	$this->display();
    }

    	
}