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
namespace szjcomo\email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * 邮件发送事例
 * 一、普通邮件发送
 *  	$options = ['user'=>'xxx@qq.com','password'=>'xxxx','FromName'=>'xxx信息科技有限公司发来的邮件'];
 * 	 	Emailer::send('814655481@qq.com,124012877@qq.com','这是一封测试邮件','这是一封测试邮件');
 * 二、带附件的邮件发送
 * 		$options = ['user'=>'xxx@qq.com','password'=>'xxxx','FromName'=>'xxx信息科技有限公司发来的邮件','addAttachment'=>['test.html'=>'./static/index.html']];
 * 		Emailer::send('814655481@qq.com,124012877@qq.com','这是一封测试邮件','这是一封测试邮件');
 */

/**
 * 电子邮件发送类
 */
Class Emailer {
	/**
	 * [send 对外提供发送电子邮件]
	 * @Author    como
	 * @DateTime  2019-08-16
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     [type]     $address [发送地址，多个请以,号隔开]
	 * @param     string     $subject [邮件标题]
	 * @param     [type]     $content [邮件内容]
	 * @param     array      $options [其它参数 如账号 密码等 具体请看示例]
	 * @return    [type]              [description]
	 */
	Public static function send($address = null,$subject = '',$content = null,$options = []){
		$defaultOpt = [
			'SMTPDebug'=>0,
			'Host'=>'smtp.qq.com',
			'SMTPSecure'=>'ssl',
			'Port'=>465,
			'CharSet'=>'UTF-8',
			'FromName'=>'思智捷信息科技有限公司',
			'Username'=>'',
			'Password'=>'',
			'From'=>'',
			'addAddress'=>'',
			'addAttachment'=>'',
			'Subject'=>'',
			'Body'=>''
		];
		$map = self::ParamsMerge($defaultOpt,$options);
		if(empty($map['Subject'])) $map['Subject'] = $subject;
		if(empty($map['Body'])) $map['Body'] = $content;
		if(empty($map['Username'])) $map['Username'] 	= (isset($options['user'])?$options['user']:'');
		if(empty($map['Password'])) $map['Password'] 	= (isset($options['password'])?$options['password']:'');
		if(empty($map['From'])) $map['From'] 		 	= $map['Username'];
		if(empty($map['addAddress'])) $map['addAddress']= self::ParasAddress($address);
		return self::sendEMail($map);
	}
	/**
	 * [ParasAddress 分析发送地址]
	 * @Author    como
	 * @DateTime  2019-08-16
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     string     $address [description]
	 */
	Protected static function ParasAddress($address = ''){
		$arr = [];
		if(!empty($address)){
			if(is_string($address)){
				$arr = explode(',',$address);
			} elseif(is_array($address)){
				$arr = $address;
			}
		}
		return $arr;
	}
	/**
	 * [ParamsMerge 参数合并]
	 * @Author    como
	 * @DateTime  2019-08-16
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     array      $orgParams [description]
	 * @param     array      $options   [description]
	 */
	Protected static function ParamsMerge($orgParams = [],$options = []){
		$result = [];
		foreach($orgParams as $key=>$val){
			if(!empty($options[$key])) 
				$result[$key] = $options[$key];
			else 
				$result[$key] = $val;
		}
		return $result;
	}
	/**
	 * [sendEMail 实现真正意义上的发送电子邮件]
	 * @Author    como
	 * @DateTime  2019-08-16
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     array      $data [description]
	 * @return    [type]           [description]
	 */
	Protected static function sendEMail($data = []){
		try{
			$checkRes = self::checkParams($data);
			if($checkRes['err'] !== false) return $checkRes;
			return self::sendEMailHandler($data);
		} catch(\Exception $err){
			return self::appResult($err->getMessage());
		}
	}
	/**
	 * [sendEMailHandler 发送邮件处理器]
	 * @Author    como
	 * @DateTime  2019-08-16
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     array      $data [description]
	 * @return    [type]           [description]
	 */
	Protected static function sendEMailHandler($data = []){
		$mailObj = new PHPMailer(true);
		$mailObj->isSMTP(); 					//使用smtp协议进行发送
		$mailObj->SMTPAuth 	= true;				//授权模式
		$mailObj->isHTML(true);					//html格式发送
		foreach($data as $key=>$val){
			if($key == 'addAddress'){
				if(is_array($val)){
					foreach($val as $k=>$v){
						$mailObj->addAddress($v);
					}
				}
			} else if($key == 'addAttachment' && !empty($data['addAttachment'])){
				$arr = [];
				if(is_string($data['addAttachment'])){
					$arr = explode(',',$data['addAttachment']);
				} elseif(is_array($data['addAttachment'])){
					$arr = $data['addAttachment'];
				}
				foreach($arr as $k=>$v){
					$mailObj->addAttachment($v,$k);
				}
			} else {
				$mailObj->$key = $val;
			}
		}
		try{
			$status = $mailObj->send();
			return empty($status)?self::appResult('邮件发送失败'):self::appResult('邮件发送成功',null,false);
		} catch(\Exception $err){
			return self::appResult($err->getMessage());
		}
	}
	/**
	 * [checkParams 进行各项参数检测]
	 * @Author    como
	 * @DateTime  2019-08-16
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     array      $data [description]
	 * @return    [type]           [description]
	 */
	Private static function checkParams($data = []){
		$mustarr = ['Username'=>'邮箱账号不能为空','Password'=>'邮箱密码不能为空','addAddress'=>'发送邮件到哪里去,请填写','Subject'=>'发送邮件的标题不能为空','Body'=>'发送邮件的内容不能为空'];
		$result = self::appResult('SUCCESS',null,false);
		foreach($mustarr as $key=>$val){
			if(!isset($data[$key]) || empty($data[$key])) {
				$result = self::appResult($val);
				break;
			}
		}
		return $result;
	}
	/**
	 * [appResult 统一返回值功能]
	 * @Author    como
	 * @DateTime  2019-08-16
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     string     $info [description]
	 * @param     array      $data [description]
	 * @param     boolean    $err  [description]
	 * @return    [type]           [description]
	 */
	Protected static function appResult($info = '',$data = null,$err = true){
		return ['info'=>$info,'data'=>$data,'err'=>$err];
	}
}