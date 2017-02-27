<?php echo $header; ?>
<input type="button" value="test" id="test" />
<script type="text/javascript">
    $(document).ready(function () {
        $("#test").click(function(){
            $(".weui_mask_transparent").show();
            popTipShow.alert('弹窗标题', '自定义弹窗内容，居左对齐显示，告知需要确认的信息等', ['知道了'],
                    function (e) {
                        //callback 处理按钮事件
                        var button = $(e.target).attr('class');
                        if (button == 'ok') {
                            //按下确定按钮执行的操作
                            //todo ....
                            $(".weui_mask_transparent").hide();
                            this.hide();
                        }
                    }
            );
        })

        alert("test");

    });
</script>