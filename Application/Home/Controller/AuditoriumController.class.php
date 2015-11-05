<?php
namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 
 */
class AuditoriumController extends HomeController {
	
	//设置页面特征：标题，控制器名称，
	public $PageFeature = array('ControllerName' =>'Auditorium/index', 'Title' =>'名师讲堂');
	 //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
		$this->assign('PageFeature',$this->PageFeature);
    }

    public function index(){

    	$banner = $this->getBanner($this->PageFeature['ControllerName']);
		$this->assign('banner',$banner);
		
		$tab = $this->getTab();
		$this->assign('tabs',$tab);
		$tabVideo = NULL;
		//获得tabVideo
		foreach ($tab as $key => $value) {
			$tabVideo[$key] = $this->getTabVideo($value['id']);
			//转换数据
			foreach ($tabVideo[$key] as $key1 => $value1) {
                $tabVideo[$key][$key1]['create_time']=date('Y-m-d',$value1['create_time']);
                $tabVideo[$key][$key1]['update_time']=date('Y-m-d',$value1['update_time']);
                
                //获得教师信息
                $teach = $this->getInfo($value1['authority']);
                $tabVideo[$key][$key1]['name'] = $teach[0]['name'];
                $tabVideo[$key][$key1]['company'] = $teach[0]['company'];
                //var_dump( $value1);
			}
		}
		
		$this->assign('tabVideo',$tabVideo);
     	$this->display();
    }

    //获得tab标签
    public function getTab(){
    	$tab = D('ResourceTab');
    	
    	$returnData = $tab->getTablists(1);
    	//var_dump($returnData);
    	return $returnData;
    }
    //获得tab资源
    public function getTabVideo($tab){
    	$Resource = D('Resource');
    	$tabVideo = $Resource->getAuditoriumList($tab);
    	return $tabVideo;
    }

	private function setBanners(){
    	
	   	$data[] = array ("img"=>"/carousel/slider1.jpg","title"=>"图片1","url"=>"http://baidu.com" );

	   	$this->setBanner($this->PageFeature['ControllerName'], $data);
    }

    private function getInfo($id){
        $PersonnelData = D('PersonnelData');
    	$Personnel = $PersonnelData->selectTeachData($id);
        return $Personnel;
    }	
}