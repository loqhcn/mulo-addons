<?php

namespace mulo\addons;

use  think\facade\Request;

use think\facade\Route;
use think\exception\HttpException;
use think\facade\Env;
use function think\__require_file;

class Addons
{

    protected $app;
    protected $addonsName;
    protected $addonsPath;

    function __construct()
    { 
        
    }

    /**
     * 加载插件
     */
    function initAddons($addonsName)
    {
        $this->addonsName = $addonsName;
        $this->addonsPath = ADDONS_PATH . $this->addonsName . DIRECTORY_SEPARATOR;
        //插件目录定义


        $route = app('mulo\addons\AddonsRoute');
        $app = $route->getApp();
        $routeFiles = $this->routeFiles();
        //加载插件路由
        Route::group("addons/{$addonsName}", function () use ($routeFiles) {

            foreach($routeFiles as $routeFile){
                __require_file($routeFile);
            }
        });

    }
    function getAddonsPath(){
        return $this->addonsPath;
    }

    /**
     * 读取路由文件
     * 
     */
    protected function routeFiles($routeFilder = 'route')
    {
        $path = $this->addonsPath . $routeFilder . DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            @mkdir($path, 0755, true);
        }
        $results = scandir($path);
        $list = [];
        foreach ($results as $file) {
            if ($file === '.' or $file === '..')
                continue;
            //查找php文件
            if (is_file($path . $file) &&  strlen($file) > 4 && (substr($file, (strlen($file) - 4), 4))) {
                array_push($list,($path . $file));
            }
        }
        return $list;
        // var_dump($results);
    }
}
