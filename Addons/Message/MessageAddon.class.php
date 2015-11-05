<?php
/**
 *留言板插件(根据cepljxiongjun的1.0进行升级)
 *
 * @package default
 * @author  nzing@aweb.cc
 * @link http://aweb.cc
 */
namespace Addons\Message;
use Common\Controller\Addon;
use Think\Db;
/**
 * 留言板插件
 * @author cepljxiongjun
 */
class MessageAddon extends Addon {
    public $info = array(
        'name' => 'Message',
        'title' => '留言板',
        'description' => '留言板插件',
        'status' => 1,
        'author' => 'nzing',
        'version' => '0.1'
    );
    public $addon_path = './Addons/Message/';
    /**
     * 配置列表页面
     * @var unknown_type
     */
    public $admin_list = array(
        'listKey' => array(
            'title' => '留言名称',
            'summary' => '留言内容',
            'email' => 'email',
            'qq' => 'qq',
            'phone' => 'phone',
            'addr' => 'addr',
            'typetext' => '分组管理',
            'statustext' => '显示状态',
            'reply_info' => '回复信息',
            'sort' => '排序',
            'create_time' => '开始时间',
        ),
        'model' => 'Message',
        'order' => 'sort desc,id asc'
    );
    public $custom_adminlist = 'adminlist.html';
    /**
     * (non-PHPdoc)
     * 安装函数
     * @see \Common\Controller\Addons::install()
     */
    public function table_name() {
        $db_prefix = C('DB_PREFIX');
        $table_name = "{$db_prefix}Message";
        return $table_name;
    }

    public function install() {
        $model = D();
        $db_prefix = C('DB_PREFIX');
        $bools = $model -> execute("INSERT INTO `{$db_prefix}hooks`(`name`,`description`,`type`)VALUES('Message','在线留言提交钩子','1');");
        if ($bools < 1) {
            session('addons_install_error', '在线留言提交钩子添加失败');
            return false;
        }
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `{$this->table_name()}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '留言名称',
  `summary` varchar(255) NOT NULL DEFAULT '' COMMENT '留言内容',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `qq` varchar(100) NOT NULL DEFAULT '' COMMENT 'QQ',
  `phone` varchar(100) NOT NULL DEFAULT '' COMMENT '电话',
  `addr` varchar(100) NOT NULL DEFAULT '' COMMENT '地址',
  `sort` int(3) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  `type` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '类型分组 1:投诉、建议 2:问题咨询 3:其他',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态（0：禁用，1：正常）',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '添加时间',
  `reply_info` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='留言板表';
SQL;
        $model -> execute($sql);
        if (count($model -> query("SHOW TABLES LIKE '" . $this -> table_name() . "'")) != 1) {
            session('addons_install_error', ',Message表未创建成功，请手动检查插件中的sql，修复后重新安装' . $sql);
            return false;
        }
        return true;
    }

    /**
     * (non-PHPdoc)
     * 卸载函数
     * @see \Common\Controller\Addons::uninstall()
     */
    public function uninstall() {
        $db_prefix = C('DB_PREFIX');
        $model = D();
        $sql = "DROP TABLE IF EXISTS `" . $this -> table_name() . "`;";
        $model -> execute($sql);
        $sql = "DELETE FROM `{$db_prefix}hooks` WHERE `name` = 'Message'";
        $model -> execute($sql);
        return true;
    }

    //实现的pageFooter底部钩子
    public function Message($type) {
        $config = $this -> getConfig();
        $this -> assign('config', $config);
        $model = M('Message');
        $where = "status=1 AND reply_info!=''";
        $count = $model -> where($where) -> count();
        $Page = new \Think\Page($count, 5);
        $show = $Page -> show();
        $list = $model -> where($where) -> order('create_time') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
        $this -> assign('list', $list);
        $this -> assign('page', $show);
        $this -> display('widget');
    }

}
