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

class ResourceTabModel extends Model {

    protected $_validate = array(
        array('id', 'require', 'id不能为空','0','','2' ),
        array('id', 'number', 'id必须为数字','0','','2' ),
        array('type', 'require', 'type不能为空' ),
        array('type', 'number', 'type必须为数字' ),
        array('features', 'require', 'group不能为空' ),
        array('features', 'number', 'group必须为数字' ),
        array('name', 'require', '标签名不能为空'),
        array('status', array(-1,0,1), '状态值必须为数字', 2, 'in' ),
        array('sort', 'number', '排序值必须为数字'),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('create_time',NOW_TIME,1) ,
        array('update_time',NOW_TIME,3) ,
    );
   
    /**
     * 获取配置列表
     * @return array 配置数组
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    /*
    public function lists(){
        $map    = array('status' => 1);
        $data   = $this->where($map)->field('type,name,value')->select();
        
        $config = array();
        if($data && is_array($data)){
            foreach ($data as $value) {
                $config[$value['name']] = $this->parse($value['type'], $value['value']);
            }
        }
        return $config;
    }
    */
    /**
     * [selectLists 查询配置值列表]
     * @param  [array] $configName [配置名字]
     * @param  [array] $returnName [返回值名字]
     * @return [array]             [返回数组]
     */
    /*
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
    */
    public function getValue($id){
        $field = array('id' ,'type','name' ,'features','update_time');
        $data['id'] = $id;
        
        $returnData = $this->where($data)->field($field)->find();
        return $returnData;
    }

    /**
     * [getTablists 获得标签列表]
     * @param  integer $features [标注]
     * @param  integer $status   [状态]
     * @param  array   $order    [排序]
     * @return [type]            [返回结果]
     */
    public function getTablists($features = -1,$status = 1,$order = array('id'=>'asc')){
        $data['status'] = $status;

        if($features != -1){
             $data['features'] = $features;
        }
        
        $returnData = $this->selectData($data,$order,array('id','type','name','features','update_time'));
        return $returnData;
        
    }

    /**
     * [addTab 添加标签]
     * @param [type]  $name     [标签名]
     * @param [type]  $type     [description]
     * @param integer $features [description]
     */
    public function addTab($name,$type,$features = 0) {
        
        $data['name'] = $name;
        $data['type'] = $type;
        $data['features'] = $features;
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

    pubLic function updateData($id, $data){
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

}
