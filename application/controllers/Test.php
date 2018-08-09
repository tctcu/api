<?php
class TestController extends Yaf_Controller_Abstract
{
    function init(){
        header('content-type:text/html;charset=utf-8');
    }

    function addPicAction(){
        if($this->getRequest()->isPost()) {
            $model = new CommonModel();
            if (!empty($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
                $pic = $model->addPic($upload_file = 'upload_file');
                if (!empty($pic)) {
                   echo CommonModel::IMAGE_URL.$pic;
                } else {
                  echo '上传失败';die;
                }
            }
        }
    }


    function testAction(){
        echo file_get_contents("https://douban.uieee.com/v2/movie/in_theaters");die;

    }

    public function planAction(){
        $subjectId = 1;
        $courseName = '3';
        $courseVersion = '1';
        $level = '2';// 1-周 2-2周 3-3周  5-月 6-日
        $times = '2';//count($hope) 个数比对即可
        $once = '45';//0.5 0.75 1 1.5 2 ....
        $plan_start = '2018-08-08';
        $plan_end = '2018-10-08';

        $hope['1'] = [//第一周的周一
            'start'=>'18:00:00',
            'end'=>'20:00:00'
        ];

        $hope['11'] = [//第二周的周四
            'start'=>'19:00:00',
            'end'=>'21:00:00'
        ];

        $first_xq = date("w",strtotime($plan_start));//排课开始第一天是周几
        $first_week = 1; //以周几为周的第一天 1-周一 0-周日

        $flag = 1;//第几周
        if($first_xq==$first_week){
            $flag = 0;//第几周
        }
        $course_times = 0;//总排课几次
        for($i=strtotime($plan_start);$i<=strtotime($plan_end);$i+=86400){
            echo date("Ymd", $i) . '------' . $flag . '======';

            if($level==5){ //指定具体几号
                $day = intval(date("d", $i));
                if($hope[$day]){
                    echo date("Ymd", $i) . ' ' . $hope[$day]['start'] . '-' . date("Ymd", $i) . ' ' . $hope[$day]['end'];
                    $course_times++;
                }
            } elseif($level==6){ //指定具体日期
                foreach($hope as $key => $val){
                    if(date("Ymd", $i) == date("Ymd", strtotime($key))){
                        echo date("Ymd", $i) . ' ' .$val['start'] . '-' . date("Ymd", $i) . ' ' . $val['end'];
                        $course_times++;
                    }
                }

            } else {

                $xq = date("w", $i);

                if ($xq == $first_week) {
                    $flag++;
                }

                foreach ($hope as $key => $val) {
                    $this_xq = $key%7;//周几
                    $week = ceil($key/7);//第几周
                    if ($week == $level) {
                        $week = 0;
                    }
                    if (($flag % $level == $week) && $this_xq == $xq) {
                        echo date("Ymd", $i) . ' ' . $val['start'] . '-' . date("Ymd", $i) . ' ' . $val['end'];
                        $course_times++;
                    }
                }
            }
            echo "<hr>";
        }
        echo $course_times;
        die;
    }


    private function log($content='') {
        $fp = fopen('/tmp/test_book.log','a');
        if(!$fp){
            return ;
        }
        fwrite($fp, $content);
        fclose($fp);
    }


}
