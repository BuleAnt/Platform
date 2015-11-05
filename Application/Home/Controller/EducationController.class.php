<?php
namespace Home\Controller;
use OT\DataDictionary;

class EducationController extends HomeController {
	
    //设置页面特征：标题，控制器名称，
    public $PageFeature = array('ControllerName' =>'Education/index', 'Title' =>'教学资源');
    //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
        $this->assign('PageFeature',$this->PageFeature);
    }

    /**
     * page 的取值范围{1：教学内容列表，2：情景教学列表， 3：教学成果与评价列表}
     */
    public function index($page='1',$key='-1'){
        
        $banner = $this->getBanner($this->PageFeature['ControllerName']);
        $this->assign('banner',$banner);

    	$this->assign('page',$page);

        $list = $this->getList($page);
        $this->assign('list',$list);
        //var_dump($list);
        $key = ($key!='-1') ? $key : $list[0]['id']; 
        $this->assign('keys',$key);
     
        $content = $this->getContent($key);
        //对内容进行处理
        foreach ($list as $k => $value) {
            if($value['id'] == $key){
                $content['title'] = $value['title'];
                break; 
            }
        }

        $this->assign('content',$content);
        //var_dump($content);
        /*
        //教学内容列表
        $EduContent = $this->getEduContent();
        $this->assign('eduContent',$EduContent );
        var_dump($EduContent);

        //情景教学列表
        $EduScenario = $this->getEduScenario();
        $this->assign('eduScenario',$EduScenario );

        //
        $EduEvaluation = $this->getEduEvaluation();
        $this->assign('eduEvaluation',$EduEvaluation);
        */
    	$this->display();
    }

    /**
     * [getList 获得列表]
     * @return [type] [description]
     */
    public function getList($page){
        $MediaData = D('MediaData');
        $returnData = $MediaData -> getEducationList($page);
        return $returnData;
    }

    /**
     * [getContent 获得内容]
     * @param  [type] $key [内容id]
     * @return [type]      [description]
     */
    public function getContent($key){
        $MediaData = D('MediaArticle');
        $returnData = $MediaData -> getArtic($key);
        return $returnData;
    }
}