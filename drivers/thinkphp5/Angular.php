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

class Angular {

    private $template = null;
    private $config   = [];
    private $storage  = null;

    public function __construct($config = []) {
        $this->config   = [
            'tpl_path'         => App::$modulePath . 'view' . DS,
            'tpl_suffix'       => Config::get('view.engine_config.suffix') ? : '.html',
            'tpl_cache_path'   => CACHE_PATH,
            'tpl_cache_suffix' => Config::get('view.engine_config.cache') ? : '.php',
            'attr'             => 'php-',
        ];
        $this->template = new \Angular($this->config);
        // 初始化模板编译存储器
        $storage       = Config::get('compile_type') ? : '\\think\\template\\driver\\File';
        $this->storage = new $storage();
    }

    public function fetch($template, $data = [], $cache = []) {
        if (!$template) {
            $request    = Request::instance();
            $controller = $request->controller();
            $action = $request->action();
            $template       = $controller. DS . $action;
        }
        // 根据模版文件名定位缓存文件
        $tpl_cache_file = CACHE_PATH . 'angular_' . md5($template) . '.php';
        if (App::$debug || !is_file($tpl_cache_file) || !$this->storage->check($tpl_cache_file, 0)) {
            // 编译模板内容
            $content = $this->template->compiler($template, $data);
            $this->storage->write($tpl_cache_file, $content);
        }
        $this->storage->read($tpl_cache_file, $data);
    }

}
