<?php
namespace Home\Controller;
use OT\DataDictionary;

class DisplayController extends HomeController {
	
	//设置页面特征：标题，控制器名称，
	public $PageFeature = array('ControllerName' =>'Display/index', 'Title' =>'学生作品');
	 //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
		$this->assign('PageFeature',$this->PageFeature);
    }

    public function index(){

    	$banner = $this->getBanner($this->PageFeature['ControllerName']);
		$this->assign('banner',$banner);

		$introduction = $this->getIntroduction();
		$this->assign('introduction',$introduction);

		$displayWork = $this->getDisplayWork();
		$this->assign('displayWork',$displayWork);
    	$this->display();
    }

   	public function setBanners(){
    	
	   	$data[] = array ("img"=>"/carousel/slider1.jpg","title"=>"图片1","url"=>"http://baidu.com" );
	    $data[] = array ("img"=>"/carousel/slider2.jpg","title"=>"图片2","url"=>"http://baidu.com" );
	    $data[] = array ("img"=>"/carousel/slider3.jpg","title"=>"图片3","url"=>"http://baidu.com" );

	   	$this->setBanner($this->PageFeature['ControllerName'], $data);
    }	
	protected function getIntroduction(){
		$introduction = array("title"=>C('DISPLAY_TITLE') ,"titleSmall"=>C('DISPLAY_TITLE_SMALL'),"content"=>C('DISPLAY_CONTENT'),"link"=>C('DISPLAY_LINK') );
		return $introduction;
	}

	protected function getDisplayWork(){
		
		$MediaData = D('MediaData');
		$displayWork = $MediaData->getPicturesShow(4);
		return $displayWork;
	}


}