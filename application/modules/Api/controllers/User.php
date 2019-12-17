<?php
class UserController extends ApiController
{

    function init()
    {
        parent::init();
    }

    function indexAction(){
        $data = [
            'test'
        ];
        $this->responseJson(self::SUCCESS_CODE, self::SUCCESS_MSG, $data);
    }

}