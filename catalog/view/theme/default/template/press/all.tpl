<?php echo $header; ?>
<div class="bloglist">
    <?php foreach($presses as $press) { ?>
    <div class="blogItem">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 14.25rem;">
                    <img src="<?php echo $press['thumb']; ?>"/>
                </td>
                <td data-href="<?php echo $press['link']; ?>" name="blogtitle">
                    <?php echo $press['title']; ?>
                </td>
            </tr>
        </table>
    </div>
    <?php } ?>
</div>
<?php echo $footer; ?>
<script>
    var nextPage = <?php echo $nextPage; ?>;
    var limit=10;
    $(document).ready(function(){
        $("[name='blogtitle']").click(function () {
            var url = $(this).attr("data-href");
            location.href = url;
        });

        $(window).scroll(function () {
            var scrollTop = $(this).scrollTop();
            var scrollHeight = $(document).height();
            var windowHeight = $(this).height();
            if (scrollTop + windowHeight == scrollHeight && nextPage != -1) {
                getListMore();
            }
        });
    });

    function getListMore() {
        $.ajax({
            url: "/index.php?route=press/all&page="+nextPage+"&limit="+limit,
            dataType: 'json',
            success: function (data) {
                if (data.length < limit) {
                    nextPage = -1;
                }
                else {
                    nextPage++;
                }
                var totalHTML = "";
                console.log("getListMore blog"+data.length);
                for (var i = 0; i < data.length; i++) {
                    var blog = data[i];
                    totalHTML += listHTML("", blog.link, blog.title);
                }
                $(".bloglist").append(totalHTML);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function listHTML(imgsrc, link, title) {
        var html = '<div class="blogItem"><table cellpadding="0" cellspacing="0"><tr><td style="width: 14.25rem;"><img src="image/catalog/newstyle/bloglist1.png"/></td>'
                  +'<td data-href="'+link+'" name="blogtitle">'+title+'</td></tr></table></div>';
        return html;
    }
</script>
