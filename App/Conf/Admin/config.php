<?php

//由ThinkPHP工具箱生成的配置文件

defined('THINK_PATH') or exit();
$array = require_once('config.php');
$miniConfig = array(
    'DEBUG_MODE' => false,
    'DEFAULT_ACTION' => 'index',
    //'TAGLIB_PRE_LOAD'           =>  'html,dogocms',
    'DEFAULT_LANG' => 'zh-cn', //默认语言
    //权限部分
    'USER_AUTH_ON' => false, //是否开启权限true,false
    'USER_AUTH_TYPE' => 2, // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY' => 'authId', // 用户认证SESSION标记
    'ADMIN_AUTH_KEY' => 'administrator',
    'USER_AUTH_MODEL' => 'Operators', // 默认验证数据表模型
    //'AUTH_PWD_ENCODER'          =>  'md5',	// 用户认证密码加密方式（不是md5加密方式）
    'USER_AUTH_GATEWAY' => '/Login/index', // 默认认证网关
    'NOT_AUTH_MODULE' => 'Login,Node,Role', // 默认无需认证模块
    'REQUIRE_AUTH_MODULE' => '', // 默认需要认证模块
    'NOT_AUTH_ACTION' => '', // 默认无需认证操作字符串
    'REQUIRE_AUTH_ACTION' => '', // 默认需要认证操作
    'GUEST_AUTH_ON' => false, // 是否开启游客授权访问
    'GUEST_AUTH_ID' => 0, // 游客的用户ID
    //'DB_LIKE_FIELDS'            =>  'title|remark',
    'AUTH_CONFIG' => array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => $array['DB_PREFIX'] . 'auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => $array['DB_PREFIX'] . 'auth_group_access', //用户组明细表
        'AUTH_RULE' => $array['DB_PREFIX'] . 'auth_rule', //权限规则表
        'AUTH_USER' => $array['DB_PREFIX'] . 'operators'//用户信息表
    ),
        //'SHOW_PAGE_TRACE'           =>  1,//显示调试信息
        //'LANG_LIST'=>'zh-cn,zh-tw',
        /*
          APP_NAME=>array(
          "stringcount" => "150",
          "all" =>  "1",
          "pagenum" =>"10",
          "smiletype" =>"mini",
          "replay" => "1",
          "fileawaypage" =>  "5",
          "fileaway" =>  "1",
          "delete" =>"0",
          )
         */
);
$array = array_merge((array) $array, (array) $miniConfig);
return $array;
?>