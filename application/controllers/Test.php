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
            $plan_start = $_REQUEST['start_plan'];
            $plan_end = $_REQUEST['end_plan'];

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
            1 => '周',
            2 => '二周',
            3 => '三周',
            5 => '月',
            6 => '天',
        ];
        $hope = [
            1=>[
                '1'=>'周一',
                '2'=>'周二',
                '3'=>'周三',
                '4'=>'周四',
                '5'=>'周五',
                '6'=>'周六',
                '7'=>'周日',
            ],
            2=>[
                '1'=>'第一周周一',
                '2'=>'第一周周二',
                '3'=>'第一周周三',
                '4'=>'第一周周四',
                '5'=>'第一周周五',
                '6'=>'第一周周六',
                '7'=>'第一周周日',
                '8'=>'第二周周一',
                '9'=>'第二周周二',
                '10'=>'第二周周三',
                '11'=>'第二周周四',
                '12'=>'第二周周五',
                '13'=>'第二周周六',
                '14'=>'第二周周日',
            ],
            3=>[
                '1'=>'第一周周一',
                '2'=>'第一周周二',
                '3'=>'第一周周三',
                '4'=>'第一周周四',
                '5'=>'第一周周五',
                '6'=>'第一周周六',
                '7'=>'第一周周日',
                '8'=>'第二周周一',
                '9'=>'第二周周二',
                '10'=>'第二周周三',
                '11'=>'第二周周四',
                '12'=>'第二周周五',
                '13'=>'第二周周六',
                '14'=>'第二周周日',
                '15'=>'第三周周一',
                '16'=>'第三周周二',
                '17'=>'第三周周三',
                '18'=>'第三周周四',
                '19'=>'第三周周五',
                '20'=>'第三周周六',
                '21'=>'第三周周日',
            ],
            5=>[
                '1'=>'1号',
                '2'=>'2号',
                '3'=>'3号',
                '4'=>'4号',
                '5'=>'5号',
                '6'=>'6号',
                '7'=>'7号',
                '8'=>'8号',
                '9'=>'9号',
                '10'=>'10号',
                '11'=>'11号',
                '12'=>'12号',
                '13'=>'13号',
                '14'=>'14号',
                '15'=>'15号',
                '16'=>'16号',
                '17'=>'17号',
                '18'=>'18号',
                '19'=>'19号',
                '20'=>'20号',
                '21'=>'21号',
                '22'=>'22号',
                '23'=>'23号',
                '24'=>'24号',
                '25'=>'25号',
                '26'=>'26号',
                '27'=>'27号',
                '28'=>'28号',
                '29'=>'29号',
                '30'=>'30号',
                '31'=>'31号',
            ]
        ];

        $once = [
            '0.5'=>'0.5',
            '0.75'=>'0.75',
            '1'=>'1',
            '1.5'=>'1.5',
            '2'=>'2',
            '3'=>'3',

        ];
        $this->_view->hope = $hope;
        $this->_view->level = $level;
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
