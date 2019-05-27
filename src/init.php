<?php

use think\facade\Route;
use think\facade\Env;
use think\Loader;
use think\Container;
use think\facade\Request;
use think\Exception;
use mulo\addons\Addons;


//tp5.1取消了的一些常量
// defined('DS') or define('DS', DIRECTORY_SEPARATOR);
define('ADDONS_PATH',Env::get('ROOT_PATH')  . 'addons' . DIRECTORY_SEPARATOR);

// 如果插件目录不存在则创建
if (!is_dir(ADDONS_PATH)) {
    @mkdir(ADDONS_PATH, 0755, true);
}
// 注册类的根命名空间
Loader::addNamespace('addons', ADDONS_PATH);

//检测路径中是否为插件路径 进行加载插件路由
$request = Request::instance();
$serverParam = $request->server();
$pathInfo  = $request->pathinfo();
preg_match('/^(addons)\/([\w]+)(.*)/',$pathInfo, $matches);



//加载addons 
if($matches && $matches[0]){
    $addonsName = $matches[2];
    if($addonsName){
        //通过容器获得统一的 addons类
        $addons =  Container::get('mulo\addons\Addons');


        $addons->initAddons($addonsName);

        

    }
}

