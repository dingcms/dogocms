<?php

/**
 * GoodsAttributeModel.class.php
 * 商品属性扩展信息表模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-09-08 21:33
 * @package  Controller
 * @todo 字段验证
 */
class GoodsAttributeModel extends Model {
    
    protected $tableName = 'goods_attribute';
    //_pk 表示主键字段名称 _autoinc 表示主键是否自动增长类型
    protected $fields = array(
        'id', 'attribute_id', 'values','price','goods_id','attr_sort_id', '_pk' => 'id', '_autoinc' => true
    );

}

?>