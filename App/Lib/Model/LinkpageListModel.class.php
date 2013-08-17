<?php

/**
 * LinkpageListModel.class.php
 * 联动列表信息表模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-08-17 21:40
 * @package  Controller
 * @todo 字段验证
 */
class LinkpageListModel extends Model {

    protected $tableName = 'linkpage_list';
    //_pk 表示主键字段名称 _autoinc 表示主键是否自动增长类型
    protected $fields = array(
        'id', 'parent_id', 'sort_name', 'path', 'linkpage_id', 'myorder', '_pk' => 'id', '_autoinc' => true
    );

}

?>