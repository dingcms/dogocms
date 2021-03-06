<?php

/**
 * LinkPageAction.class.php
 * 联动模型
 * 核心文件，关联内容模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-2-11 20:09
 * @package  Controller
 * @todo 联动模型其他操作
 */
class PagesAction extends BaseAction {

    /**
     * index
     * 广告列表页
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function index() {
        $this->display();
    }

    /**
     * add
     * 添加信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function add() {
        $radios = array(
            'y' => '可用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->display();
    }

    /**
     * edit
     * 编辑信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function edit() {
        $m = new PagesModel();
        $id = $this->_get('id');
        $condition['id'] = array('eq', $id);
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
     * insert
     * 插入信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function insert() {
        $m = new PagesModel();
        $ename = $this->_post('ename');
        $sort_id = $this->_post('sort_id');
        if (empty($ename)) {
            $this->dmsg('1', '单页名不能为空！', false, true);
        }
        if ($sort_id == 0) {
            $this->dmsg('1', '请选择所属分类！', false, true);
        }
        $_POST['addtime'] = time();
        $_POST['updatetime'] = time();
        $_POST['status'] = $_POST['status']['0'];
        if ($m->create($_POST)) {
            $rs = $m->add();
            if ($rs == true) {
                $this->dmsg('2', ' 操作成功！', true);
            } else {
                $this->dmsg('1', '操作失败！', false, true);
            }
        } else {
            $this->dmsg('1', '根据表单提交的POST数据创建数据对象失败！', false, true);
        }
    }

    /**
     * update
     * 更新信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function update() {
        $m = new PagesModel();
        $ename = $this->_post('ename');
        $sort_id = $this->_post('sort_id');
        $id = $this->_post('id');
        $data['id'] = array('eq', $id);
        if (empty($ename)) {
            $this->dmsg('1', '单页名不能为空！', false, true);
        }
        if ($sort_id == 0) {
            $this->dmsg('1', '请选择所属分类！', false, true);
        }
        $_POST['updatetime'] = time();
        $_POST['status'] = $_POST['status']['0'];
        $rs = $m->where($data)->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', ' 操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }
    }

    /**
     * delete
     * 单页删除
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function delete() {
        $m = new PagesModel();
        $id = $this->_post('id');
        $condition_id['id'] = array('eq', $id);
        $del = $m->where($condition_id)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * sort
     * 联动分类信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sort() {
        $this->display();
    }

    /**
     * sortadd
     * 单页分类添加
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortadd() {
        $radios = array(
            'y' => '启用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->display();
    }

    /**
     * sortedit
     * 单页分类编辑
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortedit() {
        $m = new PagesSortModel();
        $id = $this->_get('id');
        $condition['id'] = array('eq', $id);
        $data = $m->where($condition)->find();
        $radios = array(
            'y' => '启用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->assign('v_status', $data['status']);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * sortinsert
     * 单页分类插入
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortinsert() {
        $m = new PagesSortModel();
        $parent_id = $this->_post('parent_id');
        $ename = $this->_post('ename');
        if (empty($ename)) {
            $this->dmsg('1', '分类名不能为空！', false, true);
        }
        $en_name = $this->_post('en_name');
        if (empty($en_name)) {
            import("ORG.Util.Pinyin");
            $pinyin = new Pinyin();
            $_POST['en_name'] = $pinyin->output($en_name);
        }
        if ($parent_id != 0) {
            $condition_pid['id'] = array('eq', $parent_id);
            $data = $m->where($condition_pid)->find();
            $_POST['path'] = $data['path'] . $parent_id . ',';
        }
        $_POST['status'] = $_POST['status']['0'];
        $_POST['updatetime'] = time();
        if ($m->create($_POST)) {
            $rs = $m->add($_POST);
            if ($rs) {
                $this->dmsg('2', '操作成功！', true);
            } else {
                $this->dmsg('1', '操作失败！', false, true);
            }
        }//if
    }

    /**
     * sortupdate
     * 单页分类更新
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function sortupdate() {
        $m = new PagesSortModel();
        $d = new CommonSortModel();
        $id = $this->_post('id');
        $parent_id = $this->_post('parent_id');
        $tbname = 'PagesSort';
        if ($parent_id != 0) {//不为0时判断是否为子分类
            if ($id == $parent_id) {
                $this->dmsg('1', '不能选择自身分类为父级分类！', false, true);
            }
            $condition_path['path'] = array('like', '%,' . $id . ',%');
            $condition_path['id'] = array('eq', $parent_id);
            $cun = $m->field('id')->where($condition_path)->find(); //判断id选择是否为其的子类
            if ($cun) {
                $this->dmsg('1', '不能选择当前分类的子类为父级分类！', false, true);
            }
            $condition_pid['id'] = array('eq', $parent_id);
            $data = $m->field('path')->where($condition_pid)->find();
            $sort_path = $data['path'] . $parent_id . ','; //取得不为0时的path
            $_POST['path'] = $data['path'] . $parent_id . ',';
            $d->updatePath($id, $sort_path, $tbname);
        } else {//为0，path为,
            $condition_id['id'] = array('eq', $id);
            $data = $m->field('parent_id')->where($condition_id)->find();
            if ($data['parent_id'] != $parent_id) {//相同不改变
                $sort_path = ','; //取得不为0时的path
                $d->updatePath($id, $sort_path, $tbname);
            }
            $_POST['path'] = ','; //应该是这个
        }
        $_POST['status'] = $_POST['status']['0'];
        $_POST['updatetime'] = time();
        $en_name = $this->_post('en_name');
        if (empty($en_name)) {
            import("ORG.Util.Pinyin");
            $pinyin = new Pinyin();
            $_POST['en_name'] = $pinyin->output($en_name);
        }
        $rs = $m->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '未有操作或操作失败！', false, true);
        }
    }

    /**
     * sortdelete
     * 单页分类删除
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function sortdelete() {
        $m = new PagesSortModel();
        $id = $this->_post('id');
        $condition_id['id'] = array('eq', $id);
        $del = $m->where($condition_id)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * jsonTree
     * 分类json树结构数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonSortList() {
        $m = new PagesSortModel();
        $list = $m->field(array('id', 'parent_id', 'ename' => 'text'))->select();
        $navcatCount = $m->count("id");
        $a = array();
        foreach ($list as $k => $v) {
            $a[$k] = $v;
            $a[$k]['_parentId'] = intval($v['parent_id']); //_parentId为easyui中标识父id
        }
        $array = array();
        $array['total'] = $navcatCount;
        $array['rows'] = $a;
        echo json_encode($array);
    }

    /**
     * jsonTree
     * 分类json树结构数据
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonTree() {
        Load('extend');
        $m = new PagesSortModel();
        $tree = $m->field(array('id', 'parent_id', 'ename' => 'text'))->select();
        $tree = list_to_tree($tree, 'id', 'parent_id', 'children');
        $tree = array_merge(array(array('id' => 0, 'text' => L('sort_root_name'))), $tree);
        echo json_encode($tree);
    }

    /**
     * jsonList
     * 取得列表信息
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function jsonList() {
        $m = new PagesModel();
        import('ORG.Util.Page'); // 导入分页类
        $pageNumber = intval($_REQUEST['page']);
        $pageRows = intval($_REQUEST['rows']);
        $pageNumber = (($pageNumber == null || $pageNumber == 0) ? 1 : $pageNumber);
        $pageRows = (($pageRows == FALSE) ? 10 : $pageRows);
        $count = $m->count();
        $page = new Page($count, $pageRows);
        $firstRow = ($pageNumber - 1) * $pageRows;
        $data = $m->limit($firstRow . ',' . $pageRows)->order('id desc')->select();
        foreach ($data as $k => $v) {
            $data[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
        }
        $array = array();
        $array['total'] = $count;
        $array['rows'] = $data;
        echo json_encode($array);
    }

}
?>

