<?php

class TestController extends Yaf_Controller_Abstract
{
    function init()
    {
        header('content-type:text/html;charset=utf-8');
    }

    function testAction()
    {
        echo 'test';
        die;
    }


    private function log($content = '')
    {
        $fp = fopen('/tmp/test_book.log', 'a');
        if (!$fp) {
            return;
        }
        fwrite($fp, $content);
        fclose($fp);
    }
}
