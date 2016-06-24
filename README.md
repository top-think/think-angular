
#think-angular

> 仿angularjs的php模板引擎

## 目前实现了以下几种标签和用法
**标签**  
1. php-if  php-elseif  php-else  
2. php-for  
3. php-foreach  
4. php-repeat  
5. php-show  
6. php-hide  
7. php-include  
8. php-init  
9. php-exec  
10. php-after  
11. php-before  
12. php-function  
13. php-call  
14. php-switch  
15. php-case  
16. php-default  
17. php-extends  
18. php-block  

**变量输出**  
{$var}  
{$array.name}  
{$array['name']}  
{$var ? '' : ''}  

**函数调用**  
{:func()}  

## 使用说明

此模板引擎针对能够使用angularjs的php开发者编写, 主要特点是 不需要额外的标签定义, 全部使用属性定义, 写好模板文件在IDE中不会出现警告和错误, 格式化代码的时候很整洁, 因为套完的模板文件还是规范的html

注: 一个标签上可以使用多个模板属性, 属性有前后顺序要求, 所以要注意属性的顺序, 在单标签上使用模板属性时一定要使用<code>/></code>结束, 如 <code>&lt;input php-if="$is_download" type="button" value="下载" />, &lt;img php-if="$article['pic']" src="{&dollar;article.pic}" /></code> 等等, 具体可参考后面章节的解析结果  

## 文档
看云文档托管平台: http://www.kancloud.cn/shuai/php-angular

## 示例代码
参考/test目录 

## 直接使用方法 /test/index.php

~~~
<?php

// 配置
$config = [
    'debug'            => true, // 是否开启调试
    'tpl_path'         => './view/', // 模板根目录
    'tpl_suffix'       => '.html', // 模板后缀
    'tpl_cache_path'   => './cache/', // 模板缓存目录
    'tpl_cache_suffix' => '.php', // 模板后缀
    'attr'             => 'php-', // 标签前缀
    'max_tag'          => 10000, // 标签属性的最大解析次数
];

// 实例化
$view = new think\angular\Angular($config);

// 数据
$data = array(
    'title' => 'Hello PHP Angular',
    'list'  => array(
        array('name' => 'name_1', 'email' => 'email_1@qq.com'),
        array('name' => 'name_2', 'email' => 'email_2@qq.com'),
        array('name' => 'name_3', 'email' => 'email_3@qq.com'),
        array('name' => 'name_4', 'email' => 'email_4@qq.com'),
        array('name' => 'name_5', 'email' => 'email_5@qq.com'),
    ),
);

// 向模板引擎设置数据
$view->assign($data);

// 输出解析结果
$view->display('index');

// 获取输出结果
// $view->fetch('index');

~~~


## 模板实例 /test/view/index.html
~~~
<!DOCTYPE html>
<html>
    <head>
        <title>think-angular</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            .box {
                padding: 10px;
                font-size: 12px;
                margin: 10px 5px;
                background: #CCC;
            }
        </style>
    </head>
    <body>
        <div class="box" php-show="$title">{$title}</div>

        <div class="box" php-hide="$title">如果title的值为空, 则可以显示这条消息, 否则不显示</div>

        <div class="box">
            <span>foreach by [1,2,3,4,5]</span>
            <ul>
                <li php-foreach="[1,2,3,4,5] as $i">foreach {$i}</li>
            </ul>
        </div>
        
        <div class="box">
            <span>repeat by [1,2,3,4,5]</span>
            <ul>
                <li php-repeat="[1,2,3,4,5] as $i">foreach {$i}</li>
            </ul>
        </div>

        <div class="box" php-show="$list">
            <span>foreach by $list as $item</span>
            <ul>
                <li php-foreach="$list as $item">name:{$item.name} -- email: {$item.email}</li>
            </ul>
        </div>
        
        <div class="box" php-show="$list">
            <span>repeat by $list as $item</span>
            <ul>
                <li php-repeat="$list as $item">name:{$item.name} -- email: {$item.email}</li>
            </ul>
        </div>

        <div class="box" php-if="$list">
            <span>foreach by $list as $key => $item</span>
            <ul>
                <li php-foreach="$list as $key => $item">{$key} -- name:{$item.name} -- email: {$item.email}</li>
            </ul>
        </div>
        
        <div class="box">
            <span>for by ($i = 1; $i <= 10; $i++;)</span>
            <ul>
                <li php-for="$i = 1; $i <= 10; $i++">for {$i}</li>
            </ul>
        </div>
        
        <div class="box" php-if="$list">
            <span>$list 不为空</span>
        </div>
    </body>
</html>


~~~

## 解析结果

~~~
<!DOCTYPE html>
<html>
    <head>
        <title>think-angular</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            .box {
                padding: 10px;
                font-size: 12px;
                margin: 10px 5px;
                background: #CCC;
            }
        </style>
    </head>
    <body>
        <?php if ($title) { ?><div class="box" ><?php echo $title; ?></div><?php } ?>

        <?php if (!($title)) { ?><div class="box" >如果title的值为空, 则可以显示这条消息, 否则不显示</div><?php } ?>

        <div class="box">
            <span>foreach by [1,2,3,4,5]</span>
            <ul>
                <?php foreach ([1,2,3,4,5] as $i) { ?><li >foreach <?php echo $i; ?></li><?php } ?>
            </ul>
        </div>
        
        <div class="box">
            <span>repeat by [1,2,3,4,5]</span>
            <ul>
                <?php foreach ([1,2,3,4,5] as $i) { ?><li >foreach <?php echo $i; ?></li><?php } ?>
            </ul>
        </div>

        <?php if ($list) { ?><div class="box" >
            <span>foreach by $list as $item</span>
            <ul>
                <?php foreach ($list as $item) { ?><li >name:<?php echo $item["name"]; ?> -- email: <?php echo $item["email"]; ?></li><?php } ?>
            </ul>
        </div><?php } ?>
        
        <?php if ($list) { ?><div class="box" >
            <span>repeat by $list as $item</span>
            <ul>
                <?php foreach ($list as $item) { ?><li >name:<?php echo $item["name"]; ?> -- email: <?php echo $item["email"]; ?></li><?php } ?>
            </ul>
        </div><?php } ?>

        <?php if ($list) { ?><div class="box" >
            <span>foreach by $list as $key => $item</span>
            <ul>
                <?php foreach ($list as $key => $item) { ?><li ><?php echo $key; ?> -- name:<?php echo $item["name"]; ?> -- email: <?php echo $item["email"]; ?></li><?php } ?>
            </ul>
        </div><?php } ?>
        
        <div class="box">
            <span>for by ($i = 1; $i <= 10; $i++;)</span>
            <ul>
                <?php for ($i = 1; $i <= 10; $i++) { ?><li >for <?php echo $i; ?></li><?php } ?>
            </ul>
        </div>
        
        <?php if ($list) { ?><div class="box" >
            <span>$list 不为空</span>
        </div><?php } ?>
    </body>
</html>

~~~
