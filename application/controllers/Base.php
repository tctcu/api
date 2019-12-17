<?php
abstract class BaseController extends Yaf_Controller_Abstract{
    /* @var $_error_codes System_ApiError() */
    protected $_error_codes = null;

    public function init(){
        $this->_error_codes = new ErrorCodeModel();
    }


    /**
     * 返回json数据
     * @param int $code 错误码
     * @param array $data 数据
     * @param string $msg 错误信息
     * @param int $options
     * @return void
     */
    public function responseJson($code = 0, $msg = '', $data = array(), $options = 0){
        $err_arr['return_code'] = strval($code);
        $err_arr['return_msg'] = !empty($msg) ? $msg : $this->_error_codes->system_errors[$code];
        $err_arr['return_data'] = $data;
        if( empty($data) && $options !=1) $options = JSON_FORCE_OBJECT;
        echo json_encode($err_arr, $options);
        exit;
    }

}