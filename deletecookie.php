<?php
date_default_timezone_set('PRC');
setcookie("currency", "www", time() - 10, "/", ".".$_SERVER['HTTP_HOST']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta charset="UTF-8">
    <title>删除cookie</title>
    <script>
        var cookieObj = {
            cookie: function (objName) {
                var cookieArray = document.cookie.split(";"); //得到分割的cookie名值对

                var cookie = new Object();

                for (var i = 0; i < cookieArray.length; i++) {

                    var arr = cookieArray[i].split("=");    //将名和值分开

                    if (arr[0] == objName)return unescape(arr[1]); //如果是指定的cookie，则返回它的值

                }
                return "";
            },
            addCookie: function (objName, objValue, objHours) {
                var str = objName + "=" + escape(objValue);

                var Hours = objHours || 7 * 24;     //如果没有设定cookie时间，默认为7天

                var date = new Date();

                var ms = Hours * 3600 * 1000;

                date.setTime(date.getTime() + ms);

                str += "; expires=" + date.toGMTString();

                document.cookie = str;
            },
            SetCookie: function (objName, objValue, objHours) {
                var Hours = objHours || 7 * 24;//如果没有设定cookie时间，默认为7天

                var exp = new Date();    //new Date("December 31, 9998");

                exp.setTime(exp.getTime() + Hours * 3600 * 1000);

                document.cookie = objName + "=" + escape(objValue) + ";expires=" + exp.toGMTString();
            },
            getCookie: function (objName) {
                var arr = document.cookie.match(new RegExp("(^| )" + objName + "=([^;]*)(;|$)"));

                if (arr != null) return unescape(arr[2]);
                return "";
            },
            delCookie: function (objName) {
                var exp = new Date();

                exp.setTime(exp.getTime() - 1);

                var cval = this.getCookie(objName);

                if (cval != null) document.cookie = objName + "=" + cval + ";expires=" + exp.toGMTString();

            }
        };

        function deleteTest() {
            cookieObj.delCookie("test");
        }
        cookieObj.SetCookie("test", "test");
        cookieObj.delCookie("currency");
    </script>
</head>
<body>
删除currency
</body>
</html>