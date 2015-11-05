<?php
namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author @author 蜉尘 <cheng1483@163.com>
 */
class ResourceController extends AdminController {

    /**
     * 资源管理
     * @author 蜉尘 <cheng1483@163.com>
     */
    public function index($p='1',$tab='-1'){
       
   /* 查询条件初始化 */
        $map = array();
        $map  = array('status' => 1);
        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }
        if(isset($_GET['tab'])){
            $map['tab']   =   I('tab',0);
        }
        if(isset($_GET['title'])){
            $map['title']    =   array('like', '%'.(string)I('name').'%');
        }

        $list = $this->lists('Resource', $map,'id');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        // $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);
        $this->meta_title = '配置管理';

        //获得标签
        $tabs = D('ResourceTab')->getTablists();
        $this -> assign('tabs', $tabs);
        //获得标签
        $this -> assign('tab', $map['tab'] );
        //获得所有教师
        $taach = D('PersonnelData')->getPersonnels(1);
        $this -> assign('taach', $taach);

        $this->display();
    }


    /**
     * 新增配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        if(IS_POST){
            $BannerList = D('Resource');
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
            //获得标签
            $tabs = D('ResourceTab')->getTablists();
            $this -> assign('tabs', $tabs);
            //获得所有教师
            $taach = D('PersonnelData')->getPersonnels(1);
            $this -> assign('taach', $taach);
            
            $this->display('edit');
        }
    }

    /**
     * 编辑配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        $DataModel = D('Resource');
        
        if(IS_POST){

            $data = $DataModel->create();

            if($data){
                if($DataModel->save($data)){

                    S('DB_CONFIG_DATA',null);//设置缓存
                    //记录行为
                    action_log('update_config','Resource',$data['id'],UID);
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

            //获得标签
            $tabs = D('ResourceTab')->getTablists();
            $this -> assign('tabs', $tabs);
            //获得所有教师
            $taach = D('PersonnelData')->getPersonnels(1);
            $this -> assign('taach', $taach);
            
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
        if(M('Resource')->where($map)->delete()){
            S('DB_CONFIG_DATA',null);
            //记录行为
            action_log('update_config','Resource',$id,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
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


}