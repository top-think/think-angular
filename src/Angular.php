<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 翟帅干 <zhaishuaigan@qq.com> <http://zhaishuaigan.cn>
// +----------------------------------------------------------------------

namespace think\view\driver;

use think\App;
use PHPAngular\Angular;
use think\template\exception\TemplateNotFoundException;
class Angular
{

    // 模板引擎实例
    private $template;
    private $app;

    // 模板引擎参数
    protected $config = [
        'debug'            => true, // 是否开启调试模式
        'tpl_path'         => '', // 模板目录
        'tpl_suffix'       => '.html', // 模板后缀
        'tpl_cache_path'   => '', // 模板缓存目录
        'tpl_cache_suffix' => '.php', // 模板缓存文件后缀
        'directive_prefix' => 'php-', // 指令前缀
        'directive_max'    => 10000, // 指令的最大解析次数
    ];

    public function __construct(App $app, array $config = [])
    {

        $this->app = $app;
        $this->config = array_merge($this->config, (array) $config);

        $this->config['tpl_path']
        $this->config['tpl_cache_path']

        if (empty($this->config['tpl_path'])) {
            $this->config['tpl_path'] = $app->getAppPath() . 'view' . DIRECTORY_SEPARATOR;
        }

        if (empty($this->config['tpl_cache_path'])) {
            $this->config['tpl_cache_path'] = $app->getRuntimePath() . 'temp' . DIRECTORY_SEPARATOR;
        }

        $this->template = new Angular($this->config);
    }

    /**
     * 检测是否存在模板文件
     * @access public
     * @param  string $template 模板文件或者模板规则
     * @return bool
     */
    public function exists(string $template): bool
    {
        if ('' == pathinfo($template, PATHINFO_EXTENSION)) {
            // 获取模板文件名
            $template = $this->parseTemplate($template);
        }

        return is_file($template);
    }

    /**
     * 渲染模板文件
     * @access public
     * @param  string    $template 模板文件
     * @param  array     $data 模板变量
     * @return void
     */
    public function fetch(string $template, array $data = []): void
    {
        // 记录视图信息
        $this->app['log']
            ->record('[ VIEW ] ' . $template . ' [ ' . var_export(array_keys($data), true) . ' ]');

        $this->template->fetch($template, $data);
    }

    /**
     * 渲染模板内容
     * @access public
     * @param  string    $template 模板内容
     * @param  array     $data 模板变量
     * @return void
     */
    public function display(string $template, array $data = []): void
    {
        $this->template->display($template, $data);
    }


    /**
     * 配置模板引擎
     * @access private
     * @param  array  $config 参数
     * @return void
     */
    public function config(array $config): void
    {
        $this->config = array_merge($this->config, $config);
        $this->template->config = $this->config;
    }

    /**
     * 获取模板引擎配置
     * @access public
     * @param  string  $name 参数名
     * @return void
     */
    public function getConfig(string $name)
    {
        return $this->template->config;
    }

    public function __call($method, $params)
    {
        return call_user_func_array([$this->template, $method], $params);
    }
}
