<?php
// +----------------------------------------------------------------------
// | Author: 蜉尘 <cheng1483@163.com>
// +----------------------------------------------------------------------

namespace Common\Model;
use Think\Model;
/**
 * 资源标签模型
 * @author 蜉尘 <cheng1483@163.com>
 */

class ResourceModel extends Model {

    protected $_validate = array(
        array('id', 'require', 'id不能为空','0','','2' ),
        array('id', 'number', 'id必须为数字','0','','2' ),
        array('type', 'require', 'type不能为空' ),
        array('type', array(0,1,2), 'type值不在范围内',2,'in' ),
        array('group', 'require', 'group不能为空' ),
        array('group', array(0,1,2), 'group值不在范围内',2,'in' ),
        array('tab', 'require', 'group不能为空' ),
        array('tab', 'number', 'tab值为数字'),
        array('img', 'require', 'img不能为空' ),
        array('video', 'require', 'video不能为空' ),
        array('authority', 'require', 'authority不能为空' ),
        array('set', 'require', 'set不能为空' ),
        array('title', 'require', 'title不能为空' ),
        array('features', 'number', 'group必须为数字' ),
        array('name', 'require', '标签名不能为空'),
        array('status', array(-1,0,1), '状态值必须为数字', 2, 'in' ),
        array('sort', 'number', '排序值必须为数字'),
    );

    protected $_auto = array(
        array('create_time',NOW_TIME,1) ,
        array('update_time',NOW_TIME,3) ,
    );
    
    /**
     * [addReturn 添加资源]
     * @param [type] $title     [标题]
     * @param [type] $type      [资源类型]
     * @param [type] $group     [分组]
     * @param [type] $tab       [标签]
     * @param [type] $img       [图片]
     * @param [type] $video     [视频]
     * @param [type] $authority [人员]
     * @param [type] $set       [分组]
     * @return [integer] [创建成功后的记录id]
     */
    public function addReturn($title, $type, $group, $tab, $img, $video, $authority, $set) {
        
        $data['title'] = $title;
        $data['type'] = $type;
        $data['group'] = $group;
        $data['tab'] = $tab;
        $data['img'] = $img;
        $data['video'] = $video;
        $data['authority'] = $authority;
        $data['set'] = $set;

        $data['create_time'] = NOW_TIME;
        $data['update_time'] = NOW_TIME;

        $returnData =  $this->CreateData($data);
        return $returnData; 
    }

    /**
     * [addBookmark 添加播放次数]
     * @param string  $id     [description]
     * @param integer $status [description]
     */
    public function addBookmark($id='-1',$status = 1){
        $data['status'] = $status; 
        if($id == -1){
            return null;
        }
        
        $data['id'] = $id;
        $returnData = $this->selectReturn($id);
        $save['player_number'] = $returnData[0]['player_number']+1;
        $returnData = $this->where($data)->save($save); // 根据条件更新记录
        //var_dump($returnData);
        return $returnData;
    }

    /**
     * [selectReturn 查询资源]
     * @param  string  $id     [ID]
     * @param  string  $set    [集合]
     * @param  integer $status [状态]
     * @param  array   $data   [数据]
     * @param  array   $order  [排序]
     * @return [type]          [description]
     */
    public function selectReturn($id = '-1',$set = '-1',$status = 1,$data = array(), $order = array('id'=>'asc')) {
        $data['status'] = $status;
        
        $field = array('type' ,'tab' ,'title','img' ,'authority' ,'player_number','video','create_time');
        $field = null;  
        if($id!=-1){
            $data['id'] = $id;
            $field = array('id','type' ,'tab' ,'title','img' ,'authority' ,'player_number','video','create_time','set');
        }
        if($set!=-1){
            $data['set'] = $set;
            $field = array('id','title','img' ,'player_number');
        }
        
        if($set==-1&&$id==-1){
            if(count($data) == 1){
                echo count($data);
                return null;
            }
        }
        
        $returnData = $this->selectData($data,$order,$field);
        return $returnData;
    }

    /**
     * [getAuditoriumList 获得名师讲堂资源列表]
     * @param  [type]  $tab    [description]
     * @param  integer $status [description]
     * @param  array   $data   [description]
     * @param  array   $order  [description]
     * @return [type]          [description]
     */
    public function getAuditoriumList($tab = null, $status = 1,$data = array(), $order = array('id'=>'asc')) {
        $data['status'] = $status;
        $data['group'] = 1;
        
        $field = array('id' ,'type' ,'title','img' ,'authority' ,'player_number','create_time');
        if($tab){
            $data['tab'] = $tab;
        }
        //var_dump($data);
        $returnData = $this->selectData($data,$order,$field);
        return $returnData;
    }

    /**
     * [getResourcesList 获得教学资源列表]
     * @param  [type]  $tab    [标签]
     * @param  string  $page   [分页]
     * @param  integer $status [状态]
     * @param  array   $data   [条件函数]
     * @param  array   $order  [排序]
     * @return [array]          [查询结果]
     */
    public function getResourcesList($tab = '-1', $page = '1,8', $status = 1, $data = array(), $order = array('id'=>'asc') ){
        $data['status'] = $status;
        //$field = array('id' ,'type' ,'tab' ,'title','img' ,'video' ,'authority' ,'set','player_number','create_time','update_time');
        $field = array('id' ,'type' ,'title','img' ,'video' ,'authority' ,'player_number','create_time');
         if($tab != -1){
            $data['tab'] = $tab;
        }
        //var_dump($data);
         $returnData = $this->selectDataCustom($data, $order, $page, $field);

        return $returnData;
    }
    /**
     * [getInformationList 获得经典视频列表 分页列表版]
     * @param  string  $page   [description]
     * @param  integer $status [description]
     * @param  array   $data   [description]
     * @param  array   $order  [description]
     * @return [type]          [description]
     */
    public function getInformationList($page = '1,8', $status = 1, $data = array(), $order = array('id'=>'asc') ){
        $data['status'] = $status;
        $data['group'] = 2;
        
        //$field = array('id' ,'type' ,'tab' ,'title','img' ,'video' ,'authority' ,'set','player_number','create_time','update_time');
        $field = array('id' ,'type' ,'title','img' ,'authority' ,'player_number','create_time');
        //var_dump($data);
        $returnData = $this->selectDataCustom($data, $order, $page, $field);
        return $returnData;
    }

    /**
     * [getInformationList 获得经典视频 全部]
     * @param  integer $status [description]
     * @param  array   $data   [description]
     * @param  array   $order  [description]
     * @return [type]          [description]
     */
    public function getInformation($status = 1, $data = array(), $order = array('id'=>'asc') ){
        $data['status'] = $status;
        $data['group'] = 2;
        
        //$field = array('id' ,'type' ,'tab' ,'title','img' ,'video' ,'authority' ,'set','player_number','create_time','update_time');
        $field = array('id' ,'type' ,'title','img' ,'authority' ,'player_number','create_time');
        //var_dump($data);
        $returnData = $this->selectData($data, $order, $field);
        return $returnData;
    }

    /**
     * [CreateData 创建数据]
     * @param [type] $data [数据组]
     * @return integer     [添加完成后的id]
     */
    public function CreateData($data){

        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else
           $returnData = $this->add($data);

        return $returnData;
    }

    /**
     * [selectData 查询数据]
     * @param  [type]  $data  [查询条件]
     * @param  string  $order [排序方式]
     * @param  boolean $field [要返回的字段]
     * @return [type]         [返回结果]
     */
    public function selectData($data, $order ,$field = true){
        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else {
           $returnData = $this->where($data)->order($order)->field($field)->select();
           //echo $this->_sql();
        }
        return $returnData;
    }

    /**
     * [selectDataCustom 自定义数据查询]
     * @param  [type]  $data  [查询数组]
     * @param  [type]  $order [排序]
     * @param  [type]  $page  [分页]
     * @param  boolean $field [要返回的字段]
     * @return [type]         [返回结果]
     */
    public function selectDataCustom($data, $order , $page, $field = true){
        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else {
           $returnData = $this->where($data)->order($order)->field($field)->page($page)->select();
        }
        return $returnData;
    }

    /**
     * [getPageValue 获得分页总数]
     * @param  integer $group [description]
     * @param  [type]  $page  [description]
     * @return [type]         [description]
     */
    public function getPageValue($tab = '-1', $status = 1){
        $data['status'] = $status;
        //$data['page'] = $page;

        if($tab != -1){
            $data['tab'] = $tab;
        }
        $returnData = $this->where($data)->count();     // 查询满足要求的总记录数
        return $returnData;
    }
}
