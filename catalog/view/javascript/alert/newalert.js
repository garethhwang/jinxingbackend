/**
 * Created by zhengzhichao on 2017/1/13.
 */
$(function(){

    $('#demo1').on('click', function(){
        webToast("恭喜您，修改成功恭喜您，修改成功恭喜您修改成功恭喜您","middle",3000);
    });

    $('#demo2').on('click', function(){
        popTipShow.alert('弹窗标题','自定义弹窗内容，居左对齐显示，告知需要确认的信息等', ['知道了'],
            function(e){
                //callback 处理按钮事件
                var button = $(e.target).attr('class');
                if(button == 'ok'){
                    //按下确定按钮执行的操作
                    //todo ....
                    this.hide();
                }
            }
        );
    });

    $('#demo3').on('click', function(){
        popTipShow.confirm('弹窗标题','自定义弹窗内容，居左对齐显示，告知需要确认的信息等',['确 定','取 消'],
            function(e){
                //callback 处理按钮事件
                var button = $(e.target).attr('class');
                if(button == 'ok'){
                    //按下确定按钮执行的操作
                    //todo ....
                    this.hide();
                    setTimeout(function() {
                        webToast("操作成功","top", 2000);
                    }, 300);
                }

                if(button == 'cancel') {
                    //按下取消按钮执行的操作
                    //todo ....
                    this.hide();
                    setTimeout(function() {
                        webToast("您选择“取消”了","bottom", 2000);
                    }, 300);
                }
            }
        );
    });

    $('#demo4').on('click', function(){
        var html = "<label>姓名：<input class='confirm_input' placeholder='请输入'></label>";
        popTipShow.confirm('弹窗标题',html,['确 定','取 消'],
            function(e){
                //callback 处理按钮事件
                var button = $(e.target).attr('class');
                if(button == 'ok'){
                    if(null==$(".confirm_input").val() || ""==$(".confirm_input").val()){
                        webToast("姓名不能为空！","bottom", 3000);
                        return;
                    }

                    this.hide();
                    setTimeout(function() {
                        webToast($(".confirm_input").val(),"bottom", 3000);
                    }, 300);

                    //按下确定按钮执行的操作
                    //todo ....
                }

                if(button == 'cancel') {
                    //按下取消按钮执行的操作
                    //todo ....
                    this.hide();
                    setTimeout(function() {
                        webToast("您选择“取消”了","top", 2000);
                    }, 300);
                }
            }
        );
    });

});