<?php
// +----------------------------------------------------------------------
// | Author: 蜉尘 <cheng1483@163.com>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;
/**
 * 友情链接模型
 * @author 蜉尘 <cheng1483@163.com>
 */

class FriendlinkModel extends Model {
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
    public function friendlinkLists() {
        $returnData = $this->selectData(null);

        if(!$returnData)
           exit($this->getError());
       
        return $returnData;
    }


    public function selectData($data, $order = '`id` DESC'){
        $data['status'] = 1;
        $returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else
           $returnData = $this->where($data)->order($order)->select();

        return $returnData;
    }

}
