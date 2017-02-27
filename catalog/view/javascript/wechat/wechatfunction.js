/**
 * Created by sally on 2017/1/3.
 */
// $(document).ready(function () {
//     //InitPage();
//     $(window).resize(function () {
//         InitPage();
//     });
// });
//
// function InitPage() {
//     $("html").css("font-size", $(document).width() / 750 * 100 + "%");
// }

//url解析获取参数
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}

function alertConfirm(content,confirmhref){
    if(arguments.length==1){
        $(".weui_mask_transparent").show();
        popTipShow.alert('金杏健康',content, ['知道了'],
            function(e){
                //callback 处理按钮事件
                var button = $(e.target).attr('class');
                if(button == 'ok'){
                    //按下确定按钮执行的操作
                    //todo ....
                    this.hide();
                    $(".weui_mask_transparent").hide();
                }
            }
        );
    }
    else if (arguments.length==2){
        $(".weui_mask_transparent").show();
        popTipShow.alert('金杏健康',content, ['知道了'],
            function(e){
                //callback 处理按钮事件
                var button = $(e.target).attr('class');
                if(button == 'ok'){
                    //按下确定按钮执行的操作
                    //todo ....
                    location.href = confirmhref;
                    this.hide();
                    $(".weui_mask_transparent").hide();
                }
            }
        );
    }
}

function alertConfirm2(content,lefttitle,lefthref){
    $(".weui_mask_transparent").show();
    popTipShow.confirm('金杏健康',content,[lefttitle,"返回首页"],
        function(e){
            //callback 处理按钮事件
            var button = $(e.target).attr('class');
            if(button == 'ok'){
                //按下确定按钮执行的操作
                //todo ....
                location.href = lefthref;
                this.hide();
                setTimeout(function() {
                    webToast("操作成功","top", 2000);
                }, 300);
            }

            if(button == 'cancel') {
                //按下取消按钮执行的操作
                //todo ....
                pushHistory();
                this.hide();
                setTimeout(function() {
                    webToast("您选择“取消”了","bottom", 2000);
                }, 300);
            }
        }
    );
};

function alertConfirmBack(content){
    $(".weui_mask_transparent").show();
    popTipShow.alert('金杏健康',content, ['知道了'],
        function(e){
            //callback 处理按钮事件
            var button = $(e.target).attr('class');
            if(button == 'ok'){
                //按下确定按钮执行的操作
                //todo ....
                pushHistory();
                this.hide();
                $(".weui_mask_transparent").hide();
            }
        }
    );
}


function pushHistory() {
    wx.closeWindow();
}

