<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 翟帅干 <zhaishuaigan@qq.com> <http://zhaishuaigan.cn>
// +----------------------------------------------------------------------

namespace think\view\driver;

use think\Config;
use think\Request;
use think\App;
use think\angular\Angular as AngularTpl;
use think\template\driver\File as Storage;

class Angular
{

    private $template = null;
    private $config   = [];
    private $storage  = null;

    public function __construct($config = [])
    {
        $this->config   = [
            'tpl_path'         => App::$modulePath . 'view' . DS,
            'tpl_suffix'       => '.' . (Config::get('template.view_suffix') ? : 'html'),
            'tpl_cache_path'   => RUNTIME_PATH . 'temp' . DS,
            'tpl_cache_suffix' => Config::get('template.cache_view_suffix') ? : '.php',
            'attr'             => 'php-',
        ];
        $this->template = new AngularTpl($this->config);
        // 初始化模板编译存储器
        $this->storage  = new Storage();
    }

    /**
     * 获取模版运行结果
     * @param string $template 模版地址
     * @param array $data 模版数据
     * @param array $config 配置
     * @return string
     */
    public function fetch($template, $data = [], $config = [])
    {
        // 处理模版地址
        $template = $this->parseTemplatePath($template);

        // 根据模版文件名定位缓存文件
        $tpl_cache_file = $this->config['tpl_cache_path'] . 'angular_' . md5($template) . '.php';
        if (App::$debug || !is_file($tpl_cache_file) || !$this->storage->check($tpl_cache_file, 0)) {
            // 编译模板内容
            $content = $this->template->compiler($template, $data);
            $this->storage->write($tpl_cache_file, $content);
        }
        $this->storage->read($tpl_cache_file, $data);
    }

    /**
     * fetch的别名
     * @param string $template 模版地址
     * @param array $data 模版数据
     * @param array $config 配置
     * @return string
     */
    public function display($template, $data = [], $config = [])
    {
        return $this->fetch($template, $data, $config);
    }

    /**
     * 如果模版为空, 则通过URL参数获取模版地址
     * @param string $template 模版地址
     * @return string
     */
    public function parseTemplatePath($template)
    {
        if (!$template) {
            $request    = Request::instance();
            $controller = $request->controller();
            $action     = $request->action();
            $template   = $controller . DS . $action;
            $template   = str_replace('.', DS, $template);
        }
        return $template;
    }

}
