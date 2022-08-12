<?php

if (!function_exists('alert')) {

    // 경고메세지를 경고창으로
    function alert($msg = '', $url = '')
    {
        //if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

        echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
        echo "<script type='text/javascript'>";
        if ($msg) echo "alert('" . $msg . "');";
        if ($url) echo "location.replace('" . $url . "');";
        else echo "history.go(-1);";
        echo "</script>";
        exit;
    }

    // 경고메세지 출력후 창을 닫음
    function alert_close($msg = "")
    {
        //if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

        echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
        echo "<script type='text/javascript'>";
        if ($msg) echo "alert('" . $msg . "');";
        echo "top.window.close(); </script>";
        exit;
    }

    // 경고메세지 출력후 현재 페이지 새로고침
    function alert_reload($msg = "")
    {
        //if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

        echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
        echo "<script type='text/javascript'>";
        if ($msg) echo "alert('" . $msg . "');  ";
        echo "top.document.location.reload(); </script>";
        exit;
    }

    // 경고메세지 출력후 부모창 새로고침 후 창을 닫음
    function alert_reload_close($msg = "")
    {
        //if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

        echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
        echo "<script type='text/javascript'>";
        if ($msg) echo "alert('" . $msg . "');  ";
        echo "opener.location.reload();window.close(); ";
        echo "</script>";
        exit;
    }

    // 경고메세지만 출력
    function alert_only($msg)
    {
        if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

        echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
        echo "<script type='text/javascript'> alert('" . $msg . "'); </script>";
        exit;
    }

}

?>
