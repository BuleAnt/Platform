<?php
namespace Admin\Controller;

 /**
     * 多媒体管理
     * @author 蜉尘 <cheng1483@163.com>
     */
class MediaController extends AdminController {

   
    public function index($p='1',$tab='-1'){
       
    /* 查询条件初始化 */
        $map = array();
        $map  = array('status' => 1);
        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }
        if(isset($_GET['type'])){
            $map['type']   =   I('type',0);
        }
        if(isset($_GET['title'])){
            $map['title']    =   array('like', '%'.(string)I('name').'%');
        }

        $list = $this->lists('PersonnelData', $map,'id');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

       // $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);

        $this->assign('group',  $map['group']);
        $this->meta_title = '配置管理';
        $this->display();
    }


    /**
     * 新增配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add($type=1){
        $DataModel = D('MediaData');
        $ArticleModel = D('MediaArticle');

        if(IS_POST){
            $data = $DataModel->create();
            //$data['type'] = $type;
            if($data){
                $key = $DataModel->add();
                $media['content'] = I('article',' ');
                $media['media_id'] = $key;
                if($key && $type==3 || $key && $type!=3 && $ArticleModel->add($media)){
                    S('DB_CONFIG_DATA',null);
                    $this->success('新增成功', Cookie('__forward__'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($DataModel->getError());
            }
        } else {
            $this->meta_title = '新增配置';
            $this->assign('info',null);

            switch ($type) {
                case 1:
                   $this->display('newsedit');
                    break;
                 case 2:
                   $this->display('teachingedit');
                    break;
                 case 3:
                   $this->display('richedit');
                    break;
            }
        }
    }

    /**
     * 编辑配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        $DataModel = D('MediaData');
        
        if(IS_POST){

            $data = $DataModel->create();

            if($data){
                if($DataModel->save($data)){

                    S('DB_CONFIG_DATA',null);//设置缓存
                    //记录行为
                    action_log('update_config','media_data',$data['id'],UID);
                    $this->success('更新成功', Cookie('__forward__'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($DataModel->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = $DataModel->field(true)->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑配置';
            //var_dump($info);
            /*
            //获得所有教师
            $taach = D('PersonnelData')->getPersonnels(1);
            $this -> assign('taach', $taach);
            */
            //$this->display();
        }
    }

    /**
     * 删除配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del($type=1){

        $DataModel = D('MediaData');
        $ArticleModel = D('MediaArticle');

        $id = array_unique((array)I('id',0));
        if (empty($id)) {
            $this->error('无操作的数据!');
        }

        if($type!=3){
            $ArticleModel->where(array('media_id' => array('in', $id)) )->delete();
            /*
            foreach($id as $key => $value) {
               $map = array('id' => array('in', $id) );
               $DataModel->where(array('id' => array('in', $id) ))->delete()
            }
            */
        }
        
        $map = array('id' => array('in', $id) );
        if($DataModel->where($map)->delete()){
            S('DB_TAB_DATA',null);
            //记录行为
            action_log('update_config','PersonnelData',$id,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！！');
        }
    }

    /**
     * [getResource 获得资源]
     * @param  [type] $tab  [description]
     * @param  [type] $page [description]
     * @return [type]       [description]
     */
    protected function getResource($tab,$page){

        $Resource = D('Resource');
        $banner = $Resource->getResourcesList($tab,$page);
        
        return $banner; 
    }

    protected function getPageValue($tab,$page){

        $Resource = D('Resource');
        $banner = $Resource->getPageValue($tab);

        $banner = ($banner%$page)?$banner++:$banner;
        return $banner; 
    }

    /**
     * [news 新闻]
     * @return [type] [description]
     */
    public function news(){
        $map = array();
        $map['status']  = 1;
        $map['type']  = 1;  //新闻
        
        if(isset($_GET['title'])){
            $map['title']    =   array('like', '%'.(string)I('name').'%');
        }

        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }

        $list = $this->lists('MediaData', $map,'id');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

       // $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);

        $this->assign('group',  $map['group']);
        $this->meta_title = '配置管理';
        $this->display();
    }

    public function newsedit($id = 0){
        //$this->edit($id);
        $DataModel = D('MediaData');
            
        if(IS_POST){
            //$media['media_id'] = I('id',0);
            $media['content'] = I('article',0);
            $data = $DataModel->create();
            if($data){
                if($DataModel->save($data) || D('MediaArticle')->where(array('media_id' =>$id ))->save($media)){
                    
                    S('DB_CONFIG_DATA',null);//设置缓存
                    action_log('update_config','MediaData',$data['id'],UID);
                    action_log('update_config','MediaArticle',$id,UID);
                    $this->success('更新成功', Cookie('__forward__'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($DataModel->getError());
            }


        } else {
            $info = array();
            /* 获取数据 */
            $info = $DataModel->field(true)->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑配置';

            //var_dump($info);
            //获得文档内容
            
            $article = D('MediaArticle')->where(array('media_id' => $id))->find();

            $this -> assign('article', $article);
            
            //$this->display();
            }
        $this->display();
    }
    

    /**
     * [news 教师]
     * @return [type] [description]
     */
    public function teaching(){

        $map = array();
        $map['status']  = 1;
        $map['type']  = 2;  //教学
        
        if(isset($_GET['title'])){
            $map['title']    =   array('like', '%'.(string)I('name').'%');
        }

        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }

        $list = $this->lists('MediaData', $map,'id');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

       // $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);

        $this->assign('group',  $map['group']);
        $this->meta_title = '配置管理';
        $this->display();
    }
    /**
     * [teachingedit 教学内容编辑]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function teachingedit($id = 0){
        //$this->edit($id);
        $DataModel = D('MediaData');
            
        if(IS_POST){
            //$media['media_id'] = I('id',0);
            $media['content'] = I('article',0);
            $data = $DataModel->create();
            if($data){
                if($DataModel->save($data) || D('MediaArticle')->where(array('media_id' =>$id ))->save($media)){
                    
                    S('DB_CONFIG_DATA',null);//设置缓存
                    action_log('update_config','MediaData',$data['id'],UID);
                    action_log('update_config','MediaArticle',$id,UID);
                    $this->success('更新成功', Cookie('__forward__'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($DataModel->getError());
            }


        } else {
            $info = array();
            /* 获取数据 */
            $info = $DataModel->field(true)->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑配置';

            //var_dump($info);
            //获得文档内容
            
            $article = D('MediaArticle')->where(array('media_id' => $id))->find();

            $this -> assign('article', $article);
            
            //$this->display();
            }
        $this->display();
    }

    /**
     * [news 富文本]
     * @return [type] [description]
     */
    public function rich(){
        $map = array();
        $map['status']  = 1;
        $map['type']  = 3;  //图文
        
        if(isset($_GET['title'])){
            $map['title']    =   array('like', '%'.(string)I('name').'%');
        }

        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }

        $list = $this->lists('MediaData', $map,'id');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

       // $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);

        $this->assign('group',  $map['group']);
        $this->meta_title = '配置管理';
        $this->display();
    }

    /**
     * [richedit 富文本编辑]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function richedit($id = 0){
        //$this->edit($id);
        $DataModel = D('MediaData');
            
        if(IS_POST){
            //$media['media_id'] = I('id',0);
            $media['content'] = I('article',0);
            $data = $DataModel->create();
            if($data){
                if($DataModel->save($data)){
                    
                    S('DB_CONFIG_DATA',null);//设置缓存
                    action_log('update_config','MediaData',$data['id'],UID);
                    action_log('update_config','MediaArticle',$id,UID);
                    $this->success('更新成功', Cookie('__forward__'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($DataModel->getError());
            }

        } else {
            $info = array();
            /* 获取数据 */
            $info = $DataModel->field(true)->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑配置';
            }
        $this->display();
    }

}