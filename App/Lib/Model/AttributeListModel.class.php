<?php

/**
 * AttributeListModel.class.php
 * 商品属性信息表模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-09-02 09:24
 * @package  Controller
 * @todo 字段验证
 */
class AttributeListModel extends Model {

    protected $tableName = 'attribute_list';
    //_pk 表示主键字段名称 _autoinc 表示主键是否自动增长类型
    protected $fields = array(
        'id', 'sort_id', 'attr_name','attr_input_type','attr_type','attr_values','attr_index','myorder','is_linked','attr_group','_pk' => 'id', '_autoinc' => true
    );

}

?>