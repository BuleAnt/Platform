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

class PersonnelDataModel extends Model {

    protected $_validate = array(
        array('id', 'require', 'id不能为空','0','','2' ),
        array('id', 'number', 'id必须为数字','0','','2' ),
        array('type', 'require', 'type不能为空' ),
        array('type', 'number', 'type必须为数字' ),
        array('status', array(-1,0,1), '状态值必须为数字', 2, 'in' ),
        array('sort', 'number', '排序值必须为数字'),

        array('name', 'require', '名字不能为空'),
        array('company', 'require', '在职单位不能为空' ),
        array('synopsis', 'require', '简介不能为空' ),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('create_time',NOW_TIME,1) ,
        array('update_time',NOW_TIME,3) ,
    );
   
    /**
     * [selectLists 查询配置值列表]
     * @param  [array] $configName [配置名字]
     * @param  [array] $returnName [返回值名字]
     * @return [array]             [返回数组]
     */
    public function selectLists($configName, $returnName){
        if(count($configName) != count($returnName) ){
            echo "数据必须一致";
            return null;
        }

        $returnData = array();
        foreach ($configName as $key => $value){
            $data = $this->selectData(array('name' => $value));
            if($data){
                $returnData[ $returnName[$key] ] = array('title' => $data[0]['title'] ,'value' => $data[0]['value'] );  
            }
        }
        return $returnData;
    }

    /**
     * [selectTeachData 查询教师数据]
     * @param  [type] $id    [description]
     * @param  array  $order [description]
     * @return [type]        [description]
     */
    public function selectTeachData($id, $order = array('id'=>'asc')){
        $field = array('name', 'company','synopsis','portrait',);
        $returnData = $this->selectData(array('id' => $id),$order,$field);

        return $returnData;
    }

    public function getSuccessPeople( $order = array('id'=>'asc')){
        $field = array('id','name', 'company','synopsis','portrait',); 
        $data = array('type' => 2 );

        $returnData = $this->selectData($data, $order, $field);
        return $returnData;
    }

    public function getFieldExpert( $order = array('id'=>'asc')){
        $field = array('id','name', 'company','synopsis','portrait',); 
        $data = array('type' => 3 );

        $returnData = $this->selectData($data, $order, $field);
        return $returnData;
    }

    public function getPersonnels($type = 1, $order = array('id'=>'asc')){
        $field = array('id','name', 'company','synopsis','portrait',); 
        $data['type'] = $type;

        $returnData = $this->selectData($data, $order, $field);
        return $returnData;
    }

    /**
     * [selectPersonnel 查询教师数据]
     * @param  [type] $id [id 标识]
     * @return [type]     [description]
     */
    public function selectPersonnel($id){
        $data['id'] = $id;
        $field = array('type','name', 'company','synopsis','portrait',);
        //$returnData = $this->selectData(array('id' => $id),$order,$field);
        $returnData = $this->where($data)->field($field)->find();
        return $returnData;
    }

    /**
     * [addPersonnel 添加工作人员]
     * @param [type] $name       [名字]
     * @param [type] $type       [类型]
     * @param [type] $company    [单位]
     * @param [type] $profession [职业]
     * @param [type] $synopsis   [简介]
     */
    public function addPersonnel($name,$type,$company,$synopsis) {
        
        $data['name'] = $name;
        $data['type'] = $type;
        $data['company'] = $company;
        $data['synopsis'] = $synopsis;
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
     * @param  [type] $data  [查询条件]
     * @param  string $order [排序方式]
     * @return [type]        [返回结果]
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
