<?php
namespace Common\Model;
use Think\Model;
//use Think\Page;

/**
 * 广告列表模型
 */

class BannerListModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        array('id', 'require', 'id不能为空','0','','2' ),
        array('id', 'number', 'id必须为数字','0','','2' ),
        array('type', 'require', 'type不能为空' ),
        array('type', 'number', 'type必须为数字' ),
        array('group', 'require', 'group不能为空' ),
        array('group', 'number', 'group必须为数字' ),
        array('title', 'require', '标题不能为空'),
        array('img', 'require', '图片链接不能为空'),
        array('url', 'require', '链接不能为空'),
        array('status', array(-1,0,1), '状态值必须为数字', 2, 'in' ),
        array('sort', 'number', '排序值必须为数字'),
        );

    /* 自动完成规则 */
    protected $_auto = array(
        array('create_time',NOW_TIME,1) ,
        array('update_time',NOW_TIME,3) ,
    );

    //public $page = '';

    /**
     * [getBannerValue 获得广告值]
     * @param  integer $id     [广告id]
     * @param  array   $data   [查询参数]
     * @param  integer $status [状态]
     * @param  boolean $field  [查询值]
     * @return [type]          [返回结果]
     */
    public function getBannerValue($id = -1, $data = array(), $status = 1, $field = true){
        $data["status"] = $status;
        if($id == -1 || $data == null){
            return null;
        }
        else if($id != -1){
            $data["id"] = $id;
        }
        /*
        if(!$field){
            $field = array('type','name', 'company','synopsis','portrait',);
        }
        */
        $returnData = $this->where($data)->field($field)->find();
        return $returnData;
        

    }
    /**
     * 获取广告列表
     * @param  integer  $category 分类ID  0表示 全部查询
     * @param  string   $group    分组字符串
     * @param  string   $order    排序规则
     * @param  integer  $status   状态
     * @param  string   $field    字段 true-所有字段
     * @return array              文档列表
     */
    public function lists($category, $group = null , $order = '`id` DESC', $status = 1, $field = true){
        $map = $this->listMap($category, $status, $group);
       
        return $this->field($field)->where($map)->order($order)->select();
    }

    /**
     * 计算列表总数
     * @param  number  $category 分类ID
     * @param  integer $status   状态
     * @return integer           总数
     */
    public function listCount($category, $status = 1){
        $map = $this->listMap($category, $status);
        return $this->where($map)->count('id');
    }

    /**
     * 更新数据       
     * @param  number  $id       ID 
     * @param  array $data       数据集
     * @return integer           影响条数 
     */
    public function updates($id, $data){
        if($id){
            $data['id'] = $id;
        }
        
        $data['update_time'] = NOW_TIME;

        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else
           $returnData = $this->save($data);// 根据条件更新记录 ，并返回影响条数
        return $returnData;

    }

     /**
     * 添加数据       
     * @param  number  $type     页面类型
     * @param  string  $group    位置分组
     * @param  string  $title    标题
     * @param  string  $url      链接地址
     * @param  string  $img      图片地址 
     * @return integer           添加成功后的id 
     */
    public function addData($type,$group,$title,$url,$img){
        $data['type'] = $type;
        $data['title'] = $title;
        $data['url'] = $url;
        $data['img'] = $img;
        $data['group'] = $group;
        $data['create_time'] = NOW_TIME;
        $data['update_time'] = NOW_TIME;

        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else
           $returnData = $this->add($data);

        return $returnData;
    }

    /**
     * 删除数据
     * @param  number  $id     数据id
     * @return [type] [description]
     */
    public function deleteDate($id){
        $data['id'] = $id;
        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else
           $returnData = $this->where($data)->delete();

        return $returnData;
    }

    /**
     * 设置where查询条件
     * @param  number  $category 分类ID
     * @param  integer $status   状态
     * @param  string  $group    分组
     * @return array             查询条件
     */
    private function listMap($category, $status = 1, $group = null){
        /* 设置状态 */
        $map = array('status' => $status);

        /* 设置分类 */
        if(!is_null($category)){
            if(is_numeric($category)){
                if($category != 0)
                    $map['type'] = $category;
            } 
        }

        /* 设置分组 */
        if(!is_null($group)){
            if(!is_numeric($group)){
                $map['group'] = $group;
            }
        }
        //var_dump($map);
        return $map;
    }

}
