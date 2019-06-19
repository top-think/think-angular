
#think-angular

> 仿angularjs的php模板引擎

## 使用说明

此模板引擎针对能够使用angularjs的php开发者编写, 主要特点是 不需要额外的标签定义, 全部使用属性定义, 写好模板文件在IDE中不会出现警告和错误, 格式化代码的时候很整洁, 因为套完的模板文件还是规范的html

注: 一个标签上可以使用多个模板指令, 指令有前后顺序要求, 所以要注意属性的顺序, 在单标签上使用模板属性时一定要使用<code>/></code>结束, 如 <code>&lt;input php-if="$is_download" type="button" value="下载" />, &lt;img php-if="$article['pic']" src="{&dollar;article.pic}" /></code> 等等, 具体可参考手册.  

## 安装方法

此分支针对ThinkPHP 6.0.x 版本  
使用composer安装模版引擎方法: <code>composer require topthink/think-angular:3.0.x</code>  

其他版本参考: https://www.kancloud.cn/shuai/php-angular/151359

### 模板配置

```
// config/template.php

// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

return [
    // 模板引擎类型 支持 php think Angular 支持扩展
    'type'             => 'Angular',
    'debug'            => true, // 是否开启调试模式
    'tpl_suffix'       => '.html', // 模板后缀
    'tpl_cache_suffix' => '.php', // 模板缓存文件后缀
    'directive_prefix' => 'php-', // 指令前缀
    'directive_max'    => 10000, // 指令的最大解析次数
];

```
### 模板输出和调用
```
// 模板变量赋值
View::assign('name','ThinkPHP');
View::assign('email','thinkphp@qq.com');
// 或者批量赋值
View::assign([
    'name'  => 'ThinkPHP',
    'email' => 'thinkphp@qq.com'
]);
// 模板输出, 模板路径不能为空, 必须写全路径
return View::fetch('index');
```


## 开发手册
看云文档托管平台: http://www.kancloud.cn/shuai/php-angular

## 示例代码
参考/test目录 