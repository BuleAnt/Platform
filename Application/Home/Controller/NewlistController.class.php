<?php
namespace Home\Controller;
use OT\DataDictionary;

/**
 * 新闻资讯控制器
 * 主要获取新闻资讯数据
 */

class NewlistController extends HomeController {
	//设置页面特征：标题，控制器名称，
	public $PageFeature = array('ControllerName' =>'News/index', 'Title' =>'新闻列表');
    //public $MediaData = D('MediaData');
	 //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
		$this->assign('PageFeature',$this->PageFeature);
    }
	//系统首页
    public function index($type='1',$group='-1'){

        switch ($type) {
            case '1':
                $listHost[] = array('key'=>'-1','value' =>"资讯快报");
                $listHost[] = array('key'=>'1' ,'value'=>"热门资讯" );
                $listHost[] = array('key'=>'2' ,'value'=>"学院新闻" );
                $listHost[] = array('key'=>'3' ,'value'=>"通知");

                $listData = $this->getNewsList($group,$page='1,10');
                $pageValue = $this->getPageValue($type,$group,$page='10');

                $this->assign('listHost',$listHost);
                $this->assign('listData',$listData);
                $this->assign('pageValue',$pageValue);
                $this->assign('group',$group);
                break;
            
            default:
                # code...
                break;
        }
        
        $this->display();
          
    }

    /**
     * [getNews 获得最新新闻列表]
     * @return [array] [返回查询列表]
     */
    public function getNews(){
        $MediaData = D('MediaData');
        $returnData = $MediaData->getNewsPage();
        return $returnData;
    }

    /**
     * [getHotTopics 获得热门资讯]
     * @return [type] [description]
     */
    public function getHotTopics(){
      
        $MediaData = D('MediaData');
        $hotTopics = $MediaData -> getNewsPage(1); //group 为1 时 表示 热门资讯
        return $hotTopics;
    }   

    /**
     * [getCollegeNews 获得学院新闻]
     * @return [type] [description]
     */
    public function getCollegeNews(){
        $MediaData = D('MediaData');
        $collegeNews = $MediaData -> getNewsPage(2,'1,4'); //group 为2 时 表示 学院新闻 
        return $collegeNews;
    }

    /**
     * [getNotice 获得通知]
     * @return [type] [description]
     */
    public function getNotice(){
        $MediaData = D('MediaData');
        $notice = $MediaData -> getNewsPage(3,'1,4'); //group 为3 时 表示 通知 
        return $notice;
    }

    /**
     * [getNewsList 获得新闻列表]
     * @param  [type] $group [description]
     * @param  string $page  [description]
     * @return [type]        [description]
     */
    public function getNewsList($group,$page='1,4'){
        $MediaData = D('MediaData');
        $notice = $MediaData -> getNewsPage($group,$page); 
        return $notice;
    }

    /**
     * [getNewsPage 获得新闻页数]
     * @return [type] [description]
     */
    public function getPageValue($type,$group,$page='10'){
        $MediaData = D('MediaData');
        $value = $MediaData -> getPageValue($type,$group); 
        $pageValue = $value /(int)$page;
        $value %(int)$page?++$pageValue : $pageValue;
        return $pageValue;
    }

    public function getContery(){
        
    }
}
