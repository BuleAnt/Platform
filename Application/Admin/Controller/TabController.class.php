<?php
namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author @author 蜉尘 <cheng1483@163.com>
 */
class TabController extends AdminController {


    //前置操作方法
    public function _before_index(){
        //在前置方法中 操作判断用户
        $this->assign('PageFeature','标签');
    }
    /**
     * 资源标签管理
     * @author 蜉尘 <cheng1483@163.com>
     */
    public function index(){
        /* 查询条件初始化 */
        $map = array();
        $map  = array('status' => 1);
        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }
        if(isset($_GET['name'])){
            $map['name']    =   array('like', '%'.(string)I('name').'%');
        }

        $list = $this->lists('ResourceTab', $map,'sort,id');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        //$this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);
        $this->meta_title = '配置管理';
        $this->display();
    }


    /**
     * 新增配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        $DataModel = D('ResourceTab');
        if(IS_POST){
            $data = $DataModel->create();
            if($data){
                if($DataModel->add()){
                    S('DB_TAB_DATA',null);
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($DataModel->getError());
            }
        } else {
            $this->meta_title = '新增配置';
            $this->assign('info',null);
            
            $this->display('edit');
        }
    }

    /**
     * 编辑配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        $DataModel = D('ResourceTab');

        if(IS_POST){
            //$Config = D('Config');
            $data = $DataModel->create();
            if($data){
                if($DataModel->updateData(null,$data)){
                    S('DB_TAB_DATA',null);
                    //记录行为
                    action_log('update_config','ResourceTab',$data['id'],UID);
                    $this->success('更新成功', Cookie('__forward__'));
                    //$this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($DataModel->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = $DataModel -> getValue($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑配置';
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
        S('DB_TAB_DATA',null);
        $this->success('保存成功！');
    }

    /**
     * 删除配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del(){
        $DataModel = D('ResourceTab');
        $id = array_unique((array)I('id',0));
        if (empty($id)) {
            $this->error('无操作的数据!');
        }

        foreach ($id as $key => $value) {
           if(D('Resource')->getResourcesList($value) ){
                $this->error('请保证没有资源引用 id: '.$value.'的标签');
                return null;
            }
        }
        $map = array('id' => array('in', $id) );
        if($DataModel->where($map)->delete()){
            S('DB_TAB_DATA',null);
            //记录行为
            action_log('update_config','ResourceTab',$id,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！！');
        }
    }
    
    /**
     * [getTabs 获得标签]
     * @return [type] [标签列表]
     */
    protected function getTabs(){

        $ResourceTab = D('ResourceTab');
        $tabs = $ResourceTab->getTablists();
        
        return $tabs; 
    }
}