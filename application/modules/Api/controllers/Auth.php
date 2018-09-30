<?php
#配置
class AuthController extends ApiController
{

    function init()
    {
        parent::init();
    }

    function configAction(){
        $data = array(
            'category' => [
                '0' => '精选',
                '1' => '女装',
                '2' => '男装',
                '3' => '内衣',
                '4' => '美妆',
                '5' => '配饰',
                '6' => '鞋品',
                '7' => '箱包',
                '8' => '儿童',
                '9' => '母婴',
                '10' => '居家',
                '11' => '美食',
                '12' => '数码',
                '13' => '家电',
                '15' => '车品',
                '16' => '文体',
                '14' => '其他',
            ],
            'tab' => [
                '首页',
                '分类',
                '我的'
            ],
        );

        $this->responseJson(self::SUCCESS_CODE, self::SUCCESS_MSG, $data);
    }


    #banner 广告位
    function bannerAction(){

    }

}