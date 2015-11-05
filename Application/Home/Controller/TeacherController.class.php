<?php
namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class TeacherController extends HomeController {
	//设置页面特征：标题，控制器名称，
	public $PageFeature = array('ControllerName' =>'Information/index', 'Title' =>'人物简介');

	 //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
		$this->assign('PageFeature',$this->PageFeature);
    }
	//系统首页
    public function index($id='-1'){

    	if($id=='-1'){
            $this->error('页面不存在','/Article/error',1);
        }
        
        //或得人员id 
		$Personnel = $this->selectPersonnel($id);
		if(!$Personnel){
			$this->error('页面不存在','/Article/error',1);
		}
		$this->assign('personnel',$Personnel);

		//获得资源列表
		$Resources = $this->getResources($id);
		$this->assign('resources',$Resources);

        $this->display();
    }

	/**
	 * [selectPersonnel 查询管理人员]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private function selectPersonnel($id){
		$PersonnelData = D('PersonnelData');
		$returnData = $PersonnelData->selectPersonnel($id);
		return $returnData;
	}

	//获得相关课程
	private function getResources($id){
		$Resource = D('Resource');
		$returnData = $Resource->selectReturn(-1, -1, 1, array('authority' =>$id ));
		return $returnData;
	}
	
}
