<?php
namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {
	//设置页面特征：标题，控制器名称，
	public $PageFeature = array('ControllerName' =>'Index/index', 'Title' =>'主页');

	 //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
		$this->assign('PageFeature',$this->PageFeature);
    }
	//系统首页
    public function index(){

        $category = D('Category')->getTree();
        $this->assign('category',$category);//栏目

        $lists = D('Document')->lists(null);
        $this->assign('lists',$lists);//列表

        $this->assign('page',D('Document')->page);//分页
		
		$banner = $this->getBanner($this->PageFeature['ControllerName']);
		$this->assign('banner',$banner);//广告
		
		/*
		$news = $this->getNews();
		$this->assign('news',$news);//新闻
		*/
	
		$subjectActivity = $this->getSubjectActivity();
		$this->assign('subjectActivity',$subjectActivity);//获得主题活动
		
		$aboutUs = $this->getAboutUs();//获得关于我们
		$this->assign('AboutUs',$aboutUs);
                 
        $this->display();
    }

	//获得新闻资源
	private function getNews(){
	}
	
	//获得主题活动
	private function getSubjectActivity(){
	   //json 格式：[{"img":"","title":""}]
	   $data1 = array ("img"=>"/carousel/association.jpg","title"=>"特色社团","summary"=>C('COMMUNITY_COMMENTS'),"link"=>"#communityt");
	   $data2 = array ("img"=>"/carousel/ebook.jpg","title"=>"Ebook 读书节","summary"=>C('EBOOK_COMMENTS'),"link"=>"#ebook");
	   $data3 = array ("img"=>"/carousel/photography.jpg","title"=>"美丽校园摄影大赛","summary"=>C('PHOTOGRAPHY_COMMENTS'),"link"=>"#photography");
	   
	   $subjectActivity = array ($data1 ,$data2 ,$data3 );
	   return $subjectActivity;
	}
	
	//获得关于我们
	private function getAboutUs(){

	   	$Config = D('Config');
	   $aboutUs = $Config->aboutUslists();
	   return $aboutUs;
	}
}
