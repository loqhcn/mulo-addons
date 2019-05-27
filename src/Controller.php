<?php
namespace mulo\addons;

use think\facade\Request;
use think\App;
use think\facade\Validate;
use think\Container;

class Controller extends \think\Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $request = $this->app['request'];

        // $request->controller('index');
        // $request->action('index');

        //插件视图目录
        $addons =  Container::get('mulo\addons\Addons');
        $this->view->config('view_path', $addons->getAddonsPath() . 'view' . DIRECTORY_SEPARATOR);
    }

    /*普通消息返回*/
    function jsonResult($status, $message = 'success', $data = array())
    {
        $re = array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
        return json_encode($re, JSON_UNESCAPED_UNICODE);
    }

      /**
     * 组建输入数据
     * 
     * default
     * 
     */
    function buildInput($data,$regs,$messages=[])
    { 
        $regsDo = [];
        $dataRes = [];
        foreach($regs as $key=>$li){
            //普通值输入
            if(!is_array($li)){
                $dataRes[$li] = isset($data[$li])?$data[$li]:'';
                continue;
            }
            $name = isset($li['name'])?$li['name']:$key;
            //验证规则
            if(isset($li['reg']) ){
                $regsDo[$name] = $li['reg'];
            }
            //默认数据赋值
            $dataRes[$name] = ( !isset($data[$name])  || empty($data[$name]) )? ( isset($li['default'])?$li['default']:'' ):$data[$name];
        }
        //验证
        $validate = Validate::make($regsDo)->message($messages);
        $result = $validate->check($data);
        if(!$result){
           return ['error'=>1,'message'=>$validate->getError(),'data'=>null];
        }
        return ['error'=>0,'message'=>'success','data'=>$dataRes];
    }

    /**
     * 获取分页 
     * 
     * @example list($page,$psize)=$this->page(false);
     * 
     */
    function page($returnKey=true){
        $page = max( input('page/d',1),1 );
        $psize = input('psize/d',20);
        if($returnKey){
            return ['page'=>$page,'psize'=>$psize]; 
        } 
        return   [$page,$psize];
            
    }
}
