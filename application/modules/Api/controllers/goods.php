<?php
#商品
class GoodsController extends ApiController
{

    function init()
    {
        parent::init();
    }

    #列表
    function listAction()
    {
        $url = "http://v2.api.haodanku.com/itemlist/apikey/allfree/nav/3/cid/0/back/10/min_id/1";
        $json = file_get_contents($url);
        //var_dump($json);die;
        $ret_data = json_decode($json,true)['data'];
        $data = array();
        foreach($ret_data as $val){
            $data[] = array(
                'itemid' => $val['itemid'],
                'itemshorttitle' => $val['itemshorttitle'],
                'itemdesc' => $val['itemdesc'],
                'itemprice' => $val['itemprice'],
                'itemsale' => $val['itemsale'],
                'itempic' => $val['itempic'],
                'itemendprice' => $val['itemendprice'],
                'url' => 'http://uland.taobao.com/coupon/edetail?activityId='.$val['activityid'].'&itemId='.$val['itemid'].'&src=qmmf_sqrb&mt=1&pid=mm_116356778_18618211_65740777',
                'couponmoney' => $val['couponmoney'],
                'couponexplain' => $val['couponexplain'],
                'couponstarttime' => $val['couponstarttime'],
                'couponendtime' => $val['couponendtime'],
//                'taobao_image' => explode(',' ,$val['taobao_image']),
            );
        }
        $this->responseJson(self::SUCCESS_CODE, self::SUCCESS_MSG, $data);
    }

    #详情
    function detailAction()
    {
        $itemid = intval($_REQUEST['itemid']);
        $url = "http://v2.api.haodanku.com/item_detail/apikey/allfree/itemid/".$itemid;
        $json = file_get_contents($url);
        $ret_data = json_decode($json,true)['data'];
        $ret_data['taobao_image'] = explode(',' ,$ret_data['taobao_image']);

        $this->responseJson(self::SUCCESS_CODE, self::SUCCESS_MSG, $ret_data);
    }

    #分类
    function categoryAction(){
        $url = "http://v2.api.haodanku.com/super_classify/apikey/allfree";
        $json = file_get_contents($url);
        //print_r($json);die;
        $ret_data = json_decode($json,true)['general_classify'];
        $this->responseJson(self::SUCCESS_CODE, self::SUCCESS_MSG, $ret_data);
    }

    #热搜词
    function keywordAction(){
        $url = "http://v2.api.haodanku.com/hot_key/apikey/allfree";
        $json = file_get_contents($url);
        //print_r($json);die;
        $ret_data = json_decode($json,true)['data'];
        $this->responseJson(self::SUCCESS_CODE, self::SUCCESS_MSG, $ret_data);
    }



}