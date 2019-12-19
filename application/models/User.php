<?php

#用户表
class UserModel extends PdoModel
{
    protected $_name = 'user';

    function __construct()
    {
        parent::__construct();
    }

    #添加
    function addData($data)
    {
        if (empty($data)) {
            return false;
        }
        $data['created_at'] = time();
        $data['updated_at'] = time();
        return $this->insert($data);
    }

    #更新
    function updateData($data, $uid)
    {
        if (empty($data) || empty($uid)) {
            return false;
        }
        $data['updated_at'] = time();
        return $this->update($data, "uid = {$uid}");
    }

    #查找单条信息
    function getDataByUid($uid = 0)
    {
        if (empty($uid)) {
            return false;
        }
        $data = $this->find('uid = ' . $uid);
        if (!empty($data)) {
            return $data;
        }

        return [];
    }

    #查找单条信息
    function getDataByMobile($mobile = 0)
    {
        if (empty($mobile)) {
            return false;
        }
        $data = $this->find('mobile = ' . $mobile);
        if (!empty($data)) {
            return $data;
        }

        return [];
    }

    function getListData($page = 1, $page_size = 20, $condition = array())
    {
        $sql = " select * from {$this->_name} where 1 ";
        if (!empty($condition['uid'])) {
            $sql .= " and uid={$condition['uid']} ";
        }

        if (!empty($condition['mobile'])) {
            $sql .= " and mobile={$condition['mobile']} ";
        }

        $sql .= " order by uid desc ";

        $start = ($page - 1) * $page_size;
        $sql .= " limit {$start}, {$page_size}";
        try {
            $data = $this->fetchAll($sql);
        } catch (Exception $ex) {
            $data = [];
        }
        return $data;
    }

    function getListCount($condition = array())
    {
        $sql = " select count(*) as num from {$this->_name} where 1 ";
        if (!empty($condition['uid'])) {
            $sql .= " and uid={$condition['uid']} ";
        }

        if (!empty($condition['mobile'])) {
            $sql .= " and mobile={$condition['mobile']} ";
        }

        $result = $this->fetchRow($sql);
        $num = 0;
        if (!empty($result['num'])) {
            $num = $result['num'];
        }
        return $num;
    }
}