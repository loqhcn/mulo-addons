<?php

namespace mulo\addons;
use think\Container;
use think\facade\Route;
/**
 * 插件路由加载
 */

class AddonsRoute extends Route{



    function getApp(){
        $app = self::app();
        return $app;
    }
    

}