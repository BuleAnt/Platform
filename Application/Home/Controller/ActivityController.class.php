<?php
namespace Home\Controller;
use OT\DataDictionary;


class ActivityController extends HomeController {
	
	//设置页面特征：标题，控制器名称，
	public $PageFeature = array('ControllerName' =>'Activity/index', 'Title' =>'主题活动');
	 //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
		$this->assign('PageFeature',$this->PageFeature);
    }
    public function index($page=1){
    	$banner = $this->getBanner($this->PageFeature['ControllerName']);
		$this->assign('banner',$banner);

		$community = $this->getCommunity();
		$this->assign('community',$community);
		
		$reading = $this->getReading();
		$this->assign('reading',$reading);
		
		$photographyImg = $this->getPhotographyImg($page);
		$this->assign('photographyImg',$photographyImg);
		
		$pageNumber = D('MediaData')->getPageValue(3,3);
		$pageNumber = intval( ($pageNumber%10 == 0)?$pageNumber/10 : ($pageNumber/10+1) );

		$this->assign('pageNumber',floor($pageNumber));

		//var_dump($pageNumber);
		$this->assign('page',$page);
		//var_dump($page);
	
    	$this->display();
    }

   	protected function getCommunity(){
	   		
		$MediaData = D('MediaData');
		$community = $MediaData->getPicturesShow(1);
	   	return $community;
    }

    protected function getReading(){
    	
	    $MediaData = D('MediaData');
		$reading = $MediaData->getPicturesShow(2);
	   	return $reading;
    }

    protected function getPhotographyImg($page){
	   	$MediaData = D('MediaData');
		$photographyImg = $MediaData->getPicturesShow(3,$page.',10');
	   	return $photographyImg;
    }

}