<?php

namespace think;

use think\Config;
use think\View;

/**
 * 插件基类
 * Class Addons
 * @author Byron Sampson <xiaobo.sun@qq.com>
 * @package think\addons
 */
abstract class Addons
{



    //必须实现安装
    abstract public function install();

    //必须卸载插件方法
    abstract public function uninstall();
}
