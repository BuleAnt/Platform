<?php
// +----------------------------------------------------------------------
// | Author: 蜉尘 <cheng1483@163.com>
// +----------------------------------------------------------------------

namespace Common\Model;
use Think\Model;
/**
 * 多媒体数据模型
 * @author 蜉尘 <cheng1483@163.com>
 */

class MediaDataModel extends Model {

    protected $_validate = array(
        array('id', 'require', 'id不能为空','0','','2' ),
        array('id', 'number', 'id必须为数字','0','','2' ),
        array('type', 'require', 'type不能为空' ),
        array('type', 'number', 'type必须为数字' ),
        array('status', array(-1,0,1), '状态值必须为数字', 2, 'in' ),
        array('sort', 'number', '排序值必须为数字'),

        array('group', 'require', '分组不能为空'),
        array('group', 'number', '分组不能为空'),
        array('title', 'require', '标题不能为空' ),
        array('synopsis', 'require', '简介不能为空' ),
    );

    protected $_auto = array(
    );

    /**
     * [getPageValue 获得分页总数]
     * @param  integer $group [description]
     * @param  [type]  $page  [description]
     * @return [type]         [description]
     */
    public function getPageValue($type=1, $group=-1, $status = 1){
        $data['status'] = $status;
        $data['type'] = $type;

        if($group != -1){
             $data['group'] = $group;
        }

        $returnData = $this->where($data)->count();     // 查询满足要求的总记录数
        return $returnData;
    }

    /**
     * [getNewsList 获得新闻列表]
     * @param  integer $group  [分组]
     * @param  integer $status [状态]
     * @param  array   $order  [排序]
     * @return [array]          [返回查询结果]
     */
    public function getNewsList($group=-1, $status = 1,$order = array('create_time'=>'desc')){
        $data['status'] = $status;
        $data['type'] = 1;
        $field = array('id' ,'title','synopsis' ,'img','create_time');


        if($group != -1){
             $data['group'] = $group;
        }

        $returnData = $this->selectData($data,$order, $field);
        return $returnData;
    }

    public function getNewValue($id,$status = 1){
        $data['status'] = $status;
        $data['id'] = $id;
        $returnData = $this->create($data,2);
        $field = array('id' ,'title','synopsis' ,'img','create_time');

        if(!$returnData)
           exit($this->getError());
        else {
           $returnData = $this->where($data)->field($field)->find();
           //echo $this->_sql();
        }
        return $returnData;
    }

    /**
     * [getNewsPage 获得新闻分页]
     * @param  integer $group  [分组]
     * @param  string  $page   [分页]
     * @param  integer $status [状态]
     * @param  array   $order  [排序]
     * @return [type]          [返回查询结果]
     */
    public function getNewsPage($group=-1, $page = '1,6', $status = 1,$order = array('create_time'=>'desc')){
        $data['status'] = $status;
        $data['type'] = 1;
        $field = array('id' ,'title','synopsis' ,'img','create_time');

        if($group != -1){
             $data['group'] = $group;
        }

        //selectDataCustom($data, $order , $page, $field = true)
        $returnData = $this->selectDataCustom($data, $order , $page, $field);
        return $returnData;
    }
    
    /**
     * [getEducationList 获得教学列表]
     * @param  integer $group  [分组]
     * @param  integer $status [状态]
     * @param  array   $order  [排序]
     * @return [type]          [返回查询结果]
     */
    public function getEducationList( $group=-1, $status = 1, $order = array('id'=>'asc')){
        $data['status'] = $status;
        $data['type'] = 2;
        $field = array('id' ,'title','create_time');

        if($group != -1){
             $data['group'] = $group;
        }
        //$returnData = $this->selectDataCustom($data, $order , $page, $field);
        $returnData = $this->selectData($data,$order, $field);
        return $returnData;
    }


    /**
     * [getPicturesShow 获得图文显示]
     * @param  integer $group  [description]
     * @param  integer $status [description]
     * @param  array   $order  [description]
     * @return [type]          [description]
     */
    public function getPicturesShow($group=-1, $page = '1,10', $status = 1,$order = array('id'=>'asc')){
        $data['status'] = $status;
        $data['type'] = 3;
        $field = array('id' ,'title','synopsis' ,'img');

        if($group != -1){
             $data['group'] = $group;
        }
        
        $returnData = $this->selectDataCustom($data, $order, $page, $field);
        return $returnData;
    }
        /**
     * [getPicturesShows 获得图文显示]
     * @param  integer $group  [description]
     * @param  integer $status [description]
     * @param  array   $order  [description]
     * @return [type]          [description]
     */
    public function getPicturesShows($group=-1, $status = 1,$order = array('id'=>'asc')){
        $data['status'] = $status;
        $data['type'] = 3;
        $field = array('id' ,'title','synopsis' ,'img');

        if($group != -1){
             $data['group'] = $group;
        }

        $returnData = $this->selectData($data,$order, $field);
        return $returnData;
    }
    

    /**
     * [addReturn 添加资源]
     * @param [type] $type     [资源类型]
     * @param [type] $group    [分组]
     * @param [type] $title    [标题]
     * @param [type] $synopsis [简介]
     * @param [type] $img      [图片]
     * @return [array] [创建成功后的记录id]
     */
    public function addReturn($type, $group, $title, $synopsis, $img) {
        
        
        $data['type'] = $type;
        $data['group'] = $group;
        $data['title'] = $title;
        //$data['tab'] = $tab;
        $data['synopsis'] = $synopsis;
        $data['img'] = $img;
        
        $data['create_time'] = NOW_TIME;
        $data['update_time'] = NOW_TIME;

        $returnData =  $this->CreateData($data);
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
    public function selectDataCustom($data, $order, $page, $field = true){
        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else {
           $returnData = $this->where($data)->order($order)->field($field)->page($page)->select();
        }
        return $returnData;
    }
}
