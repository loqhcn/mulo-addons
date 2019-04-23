<?php
namespace mulo\addons;

use think\facade\Request;
use think\App;
use think\Container;

class Controller extends \think\Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $request = $this->app['request'];
        
        $request->controller('index');
        $request->action('index');

        //插件视图目录
        $addons =  Container::get('mulo\addons\Addons');
        $this->view->config('view_path', $addons->getAddonsPath() . 'view' . DIRECTORY_SEPARATOR);
    }
    
}
