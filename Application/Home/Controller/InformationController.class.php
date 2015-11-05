<?php
namespace Home\Controller;
use OT\DataDictionary;

class InformationController extends HomeController {
	
	//设置页面特征：标题，控制器名称，
    public $PageFeature = array('ControllerName' =>'Information/index', 'Title' =>'前沿专题');
    //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
        $this->assign('PageFeature',$this->PageFeature);
    }

    public function index(){

   		$banner = $this->getBanner($this->PageFeature['ControllerName']);
  		$this->assign('banner',$banner);

  		$note = $this->getNote();
  		$this->assign('note',$note);

  		$classicalVideo = $this->getClassicalVideo();
  		$this->assign('classicalVideo',$classicalVideo);

  		$successPeople = $this->getSuccessPeople();
  		$this->assign('successPeople',$successPeople);

  		$fieldExpert = $this->getFieldExpert();
  		$this->assign('fieldExpert',$fieldExpert);

  		$hotTopics = $this->getHotTopics();
  		$this->assign('hotTopics',$hotTopics);
			
    	$this->display();
    }

  

    public function getNote(){
    	$note = array ("img"=>"/page/information/keyword.jpg","title"=>"图片1");
    	
	   return $note;
    }

    public function getClassicalVideo(){
    	 
       $Resource = D('Resource');
       $classicalVideo = $Resource->getInformation();
       return $classicalVideo;
    }

    public function getSuccessPeople(){
    	
      $PersonnelData = D('PersonnelData');
      $successPeople = $PersonnelData->getSuccessPeople();
      //var_dump($successPeople);
      return $successPeople;
    }

   	public function getFieldExpert($start=1, $rows=4){
    	
      $PersonnelData = D('PersonnelData');
      $fieldExpert = $PersonnelData->getFieldExpert();
      return $fieldExpert;
    }

    public function getHotTopics(){
      
      $MediaData = D('MediaData');
      $hotTopics = $MediaData -> getNewsList(1); //group 为1 时 表示 热门资讯
      return $hotTopics;
    }   
}