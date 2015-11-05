<?php
namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author @author 蜉尘 <cheng1483@163.com>
 */
class AdvertisementController extends AdminController {

    /**
     * 广告管理
     * @author 蜉尘 <cheng1483@163.com>
     */
    public function index(){
        /* 查询条件初始化 */

        /*
        $map = array();
        $map  = array('status' => 1);
        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }
        if(isset($_GET['name'])){
            $map['name']    =   array('like', '%'.(string)I('name').'%');
        }

        $list = $this->lists('Config', $map,'sort,id');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
            
        $this->assign('list', $list);
        $this->meta_title = '配置管理';
        $this->display();
        */
       //获得广告列表
        $list = $this->getBanner();
        $this -> assign('list', $list);
       //获得标识列表
        $mars = $this->getMarkList();
        $this -> assign('mars', $mars);
       // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        /*
        $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        */
        $this->display();

    }



    /**
     * 新增配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        if(IS_POST){
            $BannerList = D('BannerList');
            $data = $BannerList->create();
            if($data){
                if($BannerList->add()){
                    S('DB_CONFIG_DATA',null);
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($BannerList->getError());
            }
        } else {
            $this->meta_title = '新增配置';
            $this->assign('info',null);
            //获得标识列表
            $mars = $this->getMarkList();
            $this -> assign('mars', $mars);
            
            $this->display('edit');
        }
    }

    /**
     * 编辑配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        $BannerList = D('BannerList');

        if(IS_POST){
            //$Config = D('Config');
            $data = $BannerList->create();
            if($data){
                if($BannerList->updates(null,$data)){
                    S('DB_CONFIG_DATA',null);
                    //记录行为
                    action_log('update_config','config',$data['id'],UID);
                    $this->success('更新成功', Cookie('__forward__'));
                    //$this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($BannerList->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = D('BannerList') -> getBannerValue($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑配置';
             //获得标识列表
            $mars = $this->getMarkList();
            $this -> assign('mars', $mars);

            $this->display();
        }
    }

    /**
     * 批量保存配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function save($config){
        if($config && is_array($config)){
            $Config = M('Config');
            foreach ($config as $name => $value) {
                $map = array('name' => $name);
                $Config->where($map)->setField('value', $value);
            }
        }
        S('DB_CONFIG_DATA',null);
        $this->success('保存成功！');
    }

    /**
     * 删除配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id)) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('BannerList')->where($map)->delete()){
            S('DB_CONFIG_DATA',null);
            //记录行为
            action_log('update_config','BannerList',$id,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    // 获取某个标签的配置参数
    public function group() {
        $id     =   I('get.id',1);
        $type   =   C('CONFIG_GROUP_LIST');
        $list   =   M("Config")->where(array('status'=>1,'group'=>$id))->field('id,name,title,extra,value,remark,type')->order('sort')->select();
        if($list) {
            $this->assign('list',$list);
        }
        $this->assign('id',$id);
        $this->meta_title = $type[$id].'设置';
        $this->display();
    }

    /**
     * 配置排序
     * @author huajie <banhuajie@163.com>
     */
    public function sort(){
        if(IS_GET){
            $ids = I('get.ids');

            //获取排序的数据
            $map = array('status'=>array('gt',-1));
            if(!empty($ids)){
                $map['id'] = array('in',$ids);
            }elseif(I('group')){
                $map['group']	=	I('group');
            }
            $list = M('Config')->where($map)->field('id,title')->order('sort asc,id asc')->select();

            $this->assign('list', $list);
            $this->meta_title = '配置排序';
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = explode(',', $ids);
            foreach ($ids as $key=>$value){
                $res = M('Config')->where(array('id'=>$value))->setField('sort', $key+1);
            }
            if($res !== false){
                $this->success('排序成功！',Cookie('__forward__'));
            }else{
                $this->error('排序失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }

    /**
     * [getBanner 获得广告图片]
     * @return [type]   [广告列表]
     */
    protected function getBanner(){

        $Banner = D('BannerList');
        $banner = $Banner->lists(0);
        
        return $banner; 
    }

    protected function getMarkList(){

        $map  = array('status' => array('gt', -1));
        $field = array('id','title', 'url');
        $list = M('Channel')->where($map)->order('id asc')->field($field)->select();

        return $list ;
    }

}