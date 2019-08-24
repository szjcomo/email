### Emailer类使用说明

- 该组件主要是简单使发送邮件更加简单便捷

-------------

#### 命名空间：` szjcomo\eamil\Emailer ` 
                    
> 实现了邮件发送

#### 方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| static  | send()  | 请查看参数说明  | 发送邮件  |

#### 参数说明：
- 函数原型send($address = null,$subject = '',$content = null,$options = [])

|   参数名称| 参数类型  | 是否必传  |  备注 |
| ------------ | ------------ | ------------ | ------------ |
|  $address | string/array  | 是  | 收件人地址，可以是字符串或数组 如果是字符串,用,号隔开  |
|  $subject | string  | 是  | 邮件标题  |
|  $content | string  | 是  | 邮件内容  |
|  $options | array  | 是/否  | 其它参数  |
|   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;user| string  | 是 | 发件人邮箱地址  |
|   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;password| string  | 是 | 发件人邮箱密码  |
|   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FromName| string  | 否 | 邮件显示主题  |
|   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;addAttachment| array  | 否 | 需要发送的附件(key=>value结果  key为附件名称 value为附件地址)  |


#### 使用示例：
######  一、普通邮件发送
```php
$options = ['user'=>'xxx@qq.com','password'=>'xxxx','FromName'=>'xxx信息科技有限公司发来的邮件'];
Emailer::send('xxx@qq.com,xxx@qq.com','这是一封测试邮件','这是一封测试邮件');
```
######  二、带附件的邮件发送
```php
$options = ['user'=>'xxx@qq.com','password'=>'xxxx','FromName'=>'xxx信息科技有限公司发来的邮件','addAttachment'=>['test.html'=>'./static/index.html']];
Emailer::send('xxx@qq.com,xxx@qq.com','这是一封测试邮件','这是一封测试邮件')
```
