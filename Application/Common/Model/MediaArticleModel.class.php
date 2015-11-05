<?php
// +----------------------------------------------------------------------
// | Author: 蜉尘 <cheng1483@163.com>
// +----------------------------------------------------------------------

namespace Common\Model;
use Think\Model;
/**
 * 多媒体文章页模型
 * @author 蜉尘 <cheng1483@163.com>
 */

class MediaArticleModel extends Model {

    protected $_validate = array(
        array('id', 'require', 'id不能为空','0','','2' ),
        array('id', 'number', 'id必须为数字','0','','2' ),
        array('id','','id已经存在！请检测id是否合法',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('media_id', 'require', 'media_id不能为空' ,'0','','2'),
        array('media_id', 'number', 'media_id必须为数字' ,'0','','2'),
        array('media_id','','media_id已经存在！请检测media_id是否合法',2,'unique',1), // 在新增的时候验证name字段是否唯一
        
        array('parse', 'require', 'parse不能为空' ),
        array('parse', array(0,1,2), 'parse超出范围', 2, 'in'),
        array('status', array(-1,0,1), '状态值必须为数字', 2, 'in' ),
        array('sort', 'number', '排序值必须为数字'),

        array('content', 'require', '内容不能为空' ),
    );

    protected $_auto = array(
    );
    
    /**
     * [addReturn 添加资源]
     * @param [type] $media_id       [资源_id]
     * @param [type] $content  [内容]
     * @param string $parse    [资源类型]
     * @param string $template [详情页显示模板]
     * @return [array] [创建成功后的记录id]
     */
    public function addReturn($media_id, $content, $parse='0', $template = null) {
        
        $data['media_id'] = $media_id;
        $data['content'] = $content;
        $data['parse'] = $parse;
        $data['template'] = $template;
        
        $data['create_time'] = NOW_TIME;

        $returnData =  $this->CreateData($data);
        return $returnData; 
    }

    /**
     * 查询资源
     */
    public function getArtics($media_id='-1',$id='-1',$status = 1,$order = array('create_time'=>'desc')){

        $data['status'] = $status; 
        $field = array('id' ,'parse','content' ,'template','bookmark','create_time');


        if($id != -1){
            $data['id'] = $id;
        }

        if($media_id != -1){
            $data['media_id'] = $media_id;
        }

        $returnData = $this->selectData($data,$order, $field);
      
        return $returnData;
    }

    public function getArtic($media_id='-1',$id='-1',$status = 1){

        $data['status'] = $status; 
        $field = array('id' ,'parse','content' ,'template','bookmark','create_time');

        if($id != -1){
            $data['id'] = $id;
        }

        if($media_id != -1){
            $data['media_id'] = $media_id;
        }

        $returnData = $this->where($data)->field($field)->find();
        //var_dump($this->_sql());
        
        return $returnData;
    }

    public function addBookmark($id='-1',$status = 1){
        $data['status'] = $status; 
        if($id == -1){
            return null;
        }
        $data['id'] = $id;
        $returnData = $this->getArtic(-1,$id);
        $save['bookmark'] = $returnData['bookmark']+1;
        $returnData = $this->where($data)->save($save); // 根据条件更新记录
        //var_dump($returnData);
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
        $returnData = $this->create($data,2);  //暂时使用 自动验证
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
}
