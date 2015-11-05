<?php
namespace Home\Controller;
use OT\DataDictionary;

class ResourcesController extends HomeController {
    
    //设置页面特征：标题，控制器名称，
    public $PageFeature = array('ControllerName' =>'Resources/index', 'Title' =>'教学资源');
    //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
        $this->assign('PageFeature',$this->PageFeature);
    }
    
    public function index(){

        $banner = $this->getBanner($this->PageFeature['ControllerName']);
        $this->assign('banner',$banner);

        $this->assign('page',$page);
    
        $tab = $this->getTab();
        $this->assign('tabs',$tab);

        $courseList = $this->getCourseList(-1);
        //转换数据
        $this->adjust($courseList);
        //var_dump($courseList);
        $this->assign('courseList',$courseList);

        $this->display();
    }

    //获得资源标签
    public function getTab(){
        $tab = D('ResourceTab');
        $returnData = $tab->getTablists();
        return $returnData;
    }

    //获得课程资源
    private function getCourseList($tab=-1, $start=1, $rows=6) {
       $Resource = D('Resource');
       $tabVideo = $Resource->getResourcesList($tab,$start.','.$rows);
       return $tabVideo;
    }

    //相应post请求
    public function getCourseListAjax(){
        //得到参数
        
        $tab = I('param.tab',0,'htmlspecialchars');  
        $start = I('param.start',1,'htmlspecialchars'); 
        $rows = I('param.rows',6,'htmlspecialchars');

        $data = $this->getCourseList($tab, $start, $rows);
        $this->adjust($data);
        $this->adjustExpand($data);
        
        //$this->ajaxReturn($data);
        //print_r($date);
        

        $this->ajaxReturn(json_encode($data));
    }

    private function getInfo($id){
        $PersonnelData = D('PersonnelData');
        $Personnel = $PersonnelData->selectTeachData($id);
        return $Personnel;
    }

    /**
     * [adjust格式化操作]
     * @param  [type] &$courseList [操作值]
     * @return [type]              [description]
     */
    private function adjust(&$courseList){
         foreach ($courseList as $key => $value) {
            $courseList[$key]['create_time']=date('Y-m-d',$value['create_time']);
            $courseList[$key]['update_time']=date('Y-m-d',$value['update_time']);
            //获得教师信息
            $teach = $this->getInfo($value['authority']);
            $courseList[$key]['name'] = $teach[0]['name'];
            $courseList[$key]['company'] = $teach[0]['company'];
        }
    }

    /**
     * [adjustExpand 格式化操作扩展]
     * @param  [type] &$courseList [操作值]
     * @return [type]              [description]
     */
    private function adjustExpand(&$courseList){
        foreach ($courseList as $key => $value) {
            
            //图片地址
            $courseList[$key]['img'] = get_cover($courseList[$key]['img'],'path');
            $courseList[$key]['id'] =  U('Video/index?id='.$courseList[$key]['id']);
            $courseList[$key]['authority'] =  U('Teacher/index?id='.$courseList[$key]['authority']);
        }
    }           
}