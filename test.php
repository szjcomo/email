<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷管理系统 1.5.0
 * @Author : como 
 * 版权申明：szjshop网上管理系统不是一个自由软件，是思智捷科技官方推出的商业源码，严禁在未经许可的情况下
 * 拷贝、复制、传播、使用szjshop网店管理系统的任意代码，如有违反，请立即删除，否则您将面临承担相应
 * 法律责任的风险。如果需要取得官方授权，请联系官方http://www.sizhijie.com
 * |-----------------------------------------------------------------------------------
 */
require './vendor/autoload.php';

use szjcomo\email\Emailer;
/**
 * 邮件发送事例
 * 	一、普通邮件发送
**/
$options = ['user'=>'xxx@qq.com','password'=>'xxxx','FromName'=>'xxx信息科技有限公司发来的邮件'];
Emailer::send('xxxx@qq.com','这是一封测试邮件','这是一封测试邮件');

/**
 * 邮件发送事例
 * 	二、带附件发送示例
**/
$options = ['user'=>'xxx@qq.com','password'=>'xxxx','FromName'=>'xxx信息科技有限公司发来的邮件','addAttachment'=>['test.html'=>'./static/index.html']];
Emailer::send('xxx@qq.com','这是一封测试邮件','这是一封测试邮件');