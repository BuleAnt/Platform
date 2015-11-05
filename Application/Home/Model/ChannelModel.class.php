<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 * 分类模型
 */
class ChannelModel extends Model{

	 /* 自动验证规则 */
    protected $_validate = array(
        array('id', 'require', 'id不能为空' ),
        array('id', 'number', 'id必须为数字' ),
        array('title', 'require', '标题不能为空'),
        array('url', 'require', '链接不能为空'),
        array('status', array(-1,0,1), '状态值必须为数字', 2, 'in' ),
        array('sort', 'number', '排序值必须为数字'),
        array('target', array(0,1),'排序值必须为数字'),
        );

    /* 自动完成规则 */
    protected $_auto = array();
	/**
	 * 获取导航列表，支持多级导航
	 * @param  boolean $field 要列出的字段
	 * @return array          导航树
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function lists($field = true){
		$map = array('status' => 1);
		$list = $this->field($field)->where($map)->order('sort')->select();

		return list_to_tree($list, 'id', 'pid', '_');
	}

	/**
	 * 查询数据，支持多条件查询，默认排序为 按序号排序，下次再更改
	 * @param  [array] $data [要查询的条件]
	 * @return [array]       [返回结果]
	 */
	public function selectData($data){

		$returnData = $this->create($data);
        if(!$returnData)
           exit($this->getError());
        else
           $returnData = $this->where($data)->order('sort')->select($data);// 根据条件更新记录 ，并返回影响条数
        return $returnData;
	}
}
