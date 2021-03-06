<?php

/**
 * CommentAction.class.php
 * 评论信息
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo
 */
class CommentAction extends BaseAction {

    /**
     * index
     * 广告列表页
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function index()
    {
        $this->display();
    }

    /**
     * edit
     * 编辑信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function edit()
    {
        $m = new CommentModel();
        $id = $this->_get('id');
        $condition['id'] = array('eq',$id);
        $data = $m->where($condition)->find();
        $radios = array(
            'y' => '可用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->assign('data', $data);
        $this->assign('v_status', $data['status']);
        $this->display();
    }

    /**
     * update
     * 更新信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function update()
    {
        $m = new CommentModel();
        $id = $this->_post('id');
        $data['id'] = array('eq', $id);
        $_POST['replaytime'] = time();
        $_POST['status'] = $_POST['status']['0'];
        $_POST['updatetime'] = time();
        $rs = $m->where($data)->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', ' 操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }
    }

    /**
     * delete
     * 留言删除
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function delete()
    {
        $m = new CommentModel();
        $id = $this->_post('id');
        $condition['id'] = array('eq',$id);
        $del = $m->where($condition)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * jsonList
     * 取得列表信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonList()
    {
        $m = new CommentModel();
        import('ORG.Util.Page'); // 导入分页类
        $pageNumber = intval($_REQUEST['page']);
        $pageRows = intval($_REQUEST['rows']);
        $pageNumber = (($pageNumber == null || $pageNumber == 0) ? 1 : $pageNumber);
        $pageRows = (($pageRows == FALSE) ? 10 : $pageRows);
        $count = $m->count();
        $page = new Page($count, $pageRows);
        $firstRow = ($pageNumber - 1) * $pageRows;
        $data = $m->field(array('c.*','t.title'))->Table(C('DB_PREFIX') . 'comment c')
                        ->join(C('DB_PREFIX') . 'title t ON t.id=c.title_id')
                        ->limit($firstRow . ',' . $pageRows)->order('c.id desc')->select();
        foreach ($data as $k => $v) {
            $data[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            $data[$k]['replytime'] = date('Y-m-d H:i:s', $v['replytime']);
            if ($v['status'] = 'true') {
                $data[$k]['status'] = '可用';
            } else {
                $data[$k]['status'] = '禁用';
            }
        }
        $array = array();
        $array['total'] = $count;
        $array['rows'] = $data;
        echo json_encode($array);
    }

}

?>