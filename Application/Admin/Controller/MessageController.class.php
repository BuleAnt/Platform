<?php
namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author @author 蜉尘 <cheng1483@163.com>
 */
class MessageController extends AdminController {

    /**
     * 广告管理
     * @author 蜉尘 <cheng1483@163.com>
     */
    public function index($p='1'){
        /* 查询条件初始化 */

        $map = array();
        $map  = array('status' => 1);

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $list = $this->lists('Message', $map,'create_time desc');
        $this->assign('list',$list);

        $this->display();
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
        if(M('Message')->where($map)->delete()){
            S('DB_CONFIG_DATA',null);
            //记录行为
            action_log('update_config','BannerList',$id,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

}