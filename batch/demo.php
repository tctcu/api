<?php
//脚本demo
include('Common_func.php');
$dbh = dsn();
$sql = "select uid from `user` where uid=1";
$resGetItemList = $dbh->prepare($sql);
$resGetItemList->execute();
while ($row = $resGetItemList->fetch(PDO::FETCH_ASSOC)) {
    #关闭自动提交
    $dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    try {
        $dbh->beginTransaction();//开启事务处理

        #插入返利发放记录
        $insert_sql = "insert into xxx(xxx,xxx,xxx) values(xxx,xxx,xxx)";
        $affected_rows = $dbh->exec($insert_sql);
        if (!$affected_rows) {
            throw new PDOException("插入失败");
        }
        #操作返利金账户
        $update_user = "update xxx set xxx=xxx where xxx=xxx";
        $affected_rows = $dbh->exec($update_user);
        if (!$affected_rows) {
            throw new PDOException("更新失败");
        }

        $dbh->commit();//提交

    } catch (PDOException $e) {
        $dbh->rollback();//回滚
    }
    #开启自动提交
    $dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
}
