/**
 * Created by sally on 2017/1/22.
 */
KindEditor.ready(function (K) {
    //\"press_description[<?php echo $language['language_id']; ?>][description]\"
    var editor1 = K.create("textarea[data-id='kindeditor']", {
        cssPath: 'view/javascript/kindeditor/plugins/code/prettify.css',
        uploadJson: 'index.php?route=common/filemanager/uploadeditor&token='+getUrlParam("token"),
        allowFileManager: true,
        afterUpload: function (data) {
        }
    });
});
