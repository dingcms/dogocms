<?php

/**
 * NavFootAction.class.php
 * 底部导航
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo 内容模型各项操作
 */
class NavFootAction extends BaseAction {

    /**
     * index
     * 底部导航列表页
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function index()
    {
        $this->display();
    }

    /**
     * add
     * 底部导航添加操作
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function add()
    {
        $radios = array(
            'y' => '启用',
            'n' => '禁用'
        );
        $this->assign('radios', $radios);
        $this->display();
    }

    /**
     * edit
     * 底部导航编辑操作
     * @access public
     * @return array
     * @version dogocms 1.0
     */
    public function edit()
    {
        $m = M('NavFoot');
        $id = $this->_get('id');
        $condition['id'] = array('eq',$id);
        $data = $m->where($condition)->find();
        
        $status = array(
            'y' => '启用',
            'n' => '禁用'
        );
        $this->assign('status', $status);
        $this->assign('v_status', $data['status']);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * insert
     * 底部导航add后插入数据库
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function insert()
    {
        //添加功能还需要验证数据不能为空的字段
        $m = M('NavFoot');
        $parent_id = $this->_post('parent_id');
        $text = $this->_post('text');
        if (empty($text)) {
            $this->dmsg('1', '分类名不能为空！', false, true);
        }
        if ($parent_id != 0) {
            $condition['id'] = array('eq',$parent_id);
            $data = $m->field('path')->where($condition)->find();
            $_POST['path'] = $data['path'] . $parent_id . ',';
        }
        $_POST['status'] = $_POST['status']['0'];
        if ($m->create($_POST)) {
            $rs = $m->add($_POST);
            if ($rs) {
                $this->dmsg('2', '操作成功！', true);
            } else {
                $this->dmsg('1', '分类添加失败！', false, true);
            }
        } else {
            $this->dmsg('1', '根据表单提交的POST数据创建数据对象失败！', false, true);
        }
    }

    /**
     * update
     * 底部导航编辑后更新
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function update()
    {
        $m = M('NavFoot');
        $d = D('NewsSort');
        $id = $this->_post('id');
        $parent_id = $this->_post('parent_id');
        $tbname = 'NavFoot';
        if ($parent_id != 0) {//不为0时判断是否为子分类
            $condition_sort['id'] = array('eq',$parent_id);
            $condition_sort['path'] = array('like','%,'.$id.',%');
            $cun = $m->field('id')->where($condition_sort)->find(); //判断id选择是否为其的子类
            if ($cun) {
                $this->dmsg('1', '不能选择当前分类的子类为父级分类！', false, true);
            }
            $condition_pid['id'] = array('eq',$parent_id);
            $data = $m->field('path')->where($condition_pid)->find();
            $sort_path = $data['path'] . $parent_id . ','; //取得不为0时的path
            $_POST['path'] = $data['path'] . $parent_id . ',';
            $d->updatePath($id, $sort_path, $tbname);
        } else {//为0，path为,
            $condition_id['id'] = array('eq',$id);
            $data = $m->field('parent_id')->where($condition_id)->find();
            if ($data['parent_id'] != $parent_id) {//相同不改变
                $sort_path = ','; //取得不为0时的path
                $d->updatePath($id, $sort_path, $tbname);
            }
            $_POST['path'] = ','; //应该是这个
        }
        $_POST['status'] = $_POST['status']['0'];
        $rs = $m->save($_POST);
        if ($rs == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '未有操作或操作失败！', false, true);
        }
    }

    /**
     * delete
     * 网站导航删除
     * @access public
     * @return boolean
     * @version dogocms 1.0
     */
    public function delete()
    {
        $m = M('NavFoot');
        $id = $this->_post('id');
        if (empty($id)) {
            $this->dmsg('1', '未有id值，操作失败！', false, true);
        }
        $condition_path['path'] = array('like','%,'.$id.',%');
        $data = $m->field('id')->where($condition_path)->select();
        if (is_array($data)) {
            $this->dmsg('1', '该分类下还有子级分类，操作失败！', false, true);
        }
        $condition_id['id'] = array('eq',$id);
        $del = $m->where($condition_id)->delete();
        if ($del == true) {
            $this->dmsg('2', '操作成功！', true);
        } else {
            $this->dmsg('1', '操作失败！', false, true);
        }//if
    }

    /**
     * json
     * 返回json数据
     * @access index
     * @return array
     * @version dogocms 1.0
     */
    public function json()
    {
        $m = M('NavFoot');
        $list = $m->field('id,parent_id,text')->select();
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
     * 底部导航返回树形json数据
     * @access add edit
     * @return array
     * @version dogocms 1.0
     */
    public function jsonTree()
    {
        Load('extend');
        $m = M('NavFoot');
        $tree = $m->field('id,parent_id,text')->select();
        $tree = list_to_tree($tree, 'id', 'parent_id', 'children');
        $tree = array_merge(array(array('id' => 0, 'text' => L('sort_root_name'))), $tree);
        echo json_encode($tree);
    }

}