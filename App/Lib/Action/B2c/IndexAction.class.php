<?php

/**
 * IndexAction.class.php
 * 前台首页
 * 前台核心文件，其他页面需要继承本类方可有效
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo 完善更多方法
 */
class IndexAction extends Baseb2cAction {

    public function index()
    {
        $m = M('Setting');
        
        $title['sys_name'] = array('eq','cfg_title');
        $keywords['sys_name'] = array('eq','cfg_keywords');
        $description['sys_name'] = array('eq','cfg_description');
        $data_title = $m->where($title)->find();
        $data_keywords = $m->where($keywords)->find();
        $data_description = $m->where($description)->find();
        
        $Cache = Cache::getInstance(C('DATA_CACHE_TYPE'),array('expire'=>C('DATA_CACHE_TIME')));
        $title = $Cache->get('title');
        if(empty($title)){
            $title['sys_name'] = array('eq','cfg_title');
            $data_title = $m->where($title)->find();
            $Cache->set('title',$data_title['sys_value']);
            $title = $data_title['sys_value'];
        }
        $skin = $this->getSkin();//获取前台主题皮肤名称
        $this->assign('title',$title);
        $this->assign('keywords',$data_keywords['sys_value']);
        $this->assign('description',$data_description['sys_value']);
        $this->display($skin.':index');
    }

}