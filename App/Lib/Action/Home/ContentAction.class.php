<?php

/**
 * ContentAction.class.php
 * 前台首页
 * 前台内容页面文件
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:08
 * @package  Controller
 * @todo 过滤无用字段,筛选符合条件的信息（需要全站共同使用）
 */
class ContentAction extends BasehomeAction {

    public function index($id)
    {
        //接收到的是文档title id，通过该id查询取得相应的内容
        //先通过这个方法调出来，之后再考虑其他标签式
        //过滤无用字段
        //筛选符合条件的信息
        $id = intval($id);
        $t = new TitleModel();
        $condition['t.id'] = array('eq',$id);
        $condition['t.status'] = array('eq','y');
        $condition['t.is_recycle'] = array('eq','n');
        //取得模型标识
        $emark = $t->field('ms.emark')
                    ->Table(C('DB_PREFIX') . 'title t')
                    ->join(C('DB_PREFIX') . 'news_sort ns ON ns.id=t.sort_id')
                    ->join(C('DB_PREFIX') . 'model_sort ms ON ms.id=ns.model_id')
                    ->where($condition)->find();
        //取得内容
        if($emark){
             $data = $t->field(array('t.*','m.*','c.*'))
                    ->Table(C('DB_PREFIX') . 'title t')
                    ->join(C('DB_PREFIX') . C('DB_ADD_PREFIX') . $emark['emark'] . ' m ON m.title_id=t.id')
                    ->join(C('DB_PREFIX') . 'content c ON c.title_id = t.id ')
                    ->where($condition)
                    ->find();
            //浏览量赋值+1
            $t->where('id=' . $id)->setInc('views',1);
        }
        //评论信息计数
        $skin = $this->getSkin(); //获取前台主题皮肤名称
        $this->assign('dogocms', $data);
        $this->assign('title',$data['title']);
        $this->assign('keywords',$data['keywords']);
        $this->assign('description',$data['description']);
        $this->display($skin . ':content');
    }

}