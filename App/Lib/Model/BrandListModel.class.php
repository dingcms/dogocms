<?php

/**
 * BrandModel.class.php
 * 商家品牌列表信息表模型
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2013-09-04 14:40
 * @package  Controller
 * @todo 字段验证
 */
class BrandListModel extends Model {

    protected $tableName = 'brand_list';
    //_pk 表示主键字段名称 _autoinc 表示主键是否自动增长类型
    protected $fields = array(
        'id', 'name', 'status', 'brand_logo','myorder','addtime','url','description', 'updatetime','_pk' => 'id', '_autoinc' => true
    );

}

?>