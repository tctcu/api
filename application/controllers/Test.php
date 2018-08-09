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
        if($this->getRequest()->isPost()) {
            $subjectId = 1;
            $courseName = '3';
            $courseVersion = '1';
            $level = $_REQUEST['level'];// 1-周 2-2周 3-3周  5-月 6-日
            $times = $_REQUEST['times'];//count($hope) 个数比对即可
            $once = $_REQUEST['once'];//0.5 0.75 1 1.5 2 ....
            $plan_start = $_REQUEST['start_time'];
            $plan_end = $_REQUEST['end_time'];

            $hope['1'] = [//第一周的周一
                'start' => '18:00:00',
                'end' => '20:00:00'
            ];

            $hope['11'] = [//第二周的周四
                'start' => '19:00:00',
                'end' => '21:00:00'
            ];

            $first_xq = date("w", strtotime($plan_start));//排课开始第一天是周几
            $first_week = 1; //以周几为周的第一天 1-周一 0-周日

            $flag = 1;//第几周
            if ($first_xq == $first_week) {
                $flag = 0;//第几周
            }
            $course_times = 0;//总排课几次
            $show_list = [];
            for ($i = strtotime($plan_start); $i <= strtotime($plan_end); $i += 86400) {
                $plan_time = '';
                $xq = date("w", $i);
                if ($level == 5) { //指定具体几号
                    $day = intval(date("d", $i));
                    if ($hope[$day]) {
                        $plan_time = $hope[$day]['start'] . '-' . $hope[$day]['end'];
                        $course_times++;
                    }
                } elseif ($level == 6) { //指定具体日期
                    foreach ($hope as $key => $val) {
                        if (date("Ymd", $i) == date("Ymd", strtotime($key))) {
                            $plan_time =  $val['start'] . '-' . $val['end'];
                            $course_times++;
                        }
                    }

                } else {

                    if ($xq == $first_week) {
                        $flag++;
                    }

                    foreach ($hope as $key => $val) {
                        $this_xq = $key % 7;//周几
                        $week = ceil($key / 7);//第几周
                        if ($week == $level) {
                            $week = 0;
                        }
                        if (($flag % $level == $week) && $this_xq == $xq) {
                            $plan_time = $val['start'] . '-' . $val['end'];
                            $course_times++;
                        }
                    }
                }
                $show_list[]=[
                    'date'=>date("Y-m-d", $i),
                    'xq'=>$xq,
                    'week'=>$flag,
                    'plan_time'=>$plan_time,
                    'once'=>$once
                ];
            }
            $this->_view->show_list = $show_list;
            $this->_view->course_times = $course_times;
            $this->_view->course_hour = $once*$course_times;
        }
        $level = [
            1=>'周',
            2=>'2周',
            3=>'3周',
            5=>'月',
            6=>'日',
        ];
        $this->_view->level = $level;

        $once = [
            '0.5'=>'0.5',
            '0.75'=>'0.75',
            '1'=>'1',
            '1.5'=>'1.5',
            '2'=>'2',
            '3'=>'3',

        ];
        $this->_view->once = $once;


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
