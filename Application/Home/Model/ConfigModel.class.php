<?php
// +----------------------------------------------------------------------
// | Author: 蜉尘 <cheng1483@163.com>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;
/**
 * 配置模型
 * @author 蜉尘 <cheng1483@163.com>
 */

class ConfigModel extends Model {
    protected $_validate = array(
        array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        
    );

    /*
    protected $_auto = array(
        array('name', 'strtoupper', self::MODEL_BOTH, 'function'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_BOTH),
    );
    */
   
    /**
     * 获取配置列表
     * @return array 配置数组
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
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

    /**
     * 根据配置类型解析配置
     * @param  integer $type  配置类型
     * @param  string  $value 配置值
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    private function parse($type, $value){
        switch ($type) {
            case 3: //解析数组
                $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
                if(strpos($value,':')){
                    $value  = array();
                    foreach ($array as $val) {
                        list($k, $v) = explode(':', $val);
                        $value[$k]   = $v;
                    }
                }else{
                    $value =    $array;
                }
                break;
        }
        return $value;
    }

    /**
     * [getAboutUslists 获得关于我们的列表]
     * @return [type] [返回列表信息]
     */
    public function aboutUslists()
    {
        //配置名字,顺序为
        $configName = array('NETWORK_TEACHING_PLATFORM','CONTACT_EMAIL','CONTACT_WORD_PESS','CONTACT_ADDRESS' );
        $returnName = array('Platform', 'Email','WordPess','Address');
         $returnData = $this->selectLists($configName, $returnName);
        return $returnData;
    }

    public function copyright(){
        $configName = array('WEB_COPYRIGHT','CONTACT_ZIP_CODE', 'WEB_ADMINISTRATOR_EMAIL', 'CONTACT_PHONE', 'WEB_SITE_ICP' );
        $returnName = array('Copyright', 'ZipCode','AdminEmail','Phone','SiteIcp');
        
        $returnData = $this->selectLists($configName, $returnName);
        return $returnData;
    }

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

    public function selectData($data,$order = '`id` DESC'){
        $data['status'] = 1;

        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else
           $returnData = $this->where($data)->order($order)->select();

        return $returnData;
    }

}
