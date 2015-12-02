/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('#upload').uploadFile ({
    multiple: true,
    maxFileSize: 1024 * 1024 * 100, //KB
    autoSubmit: true,
    showDone: true,
    showCancel: true,
    showAbort: true,
    fileName: 'picture',
    maxFileCount: 2,
    method: 'post',
    formData: {
      t: new Date ().getTime ()
    },
    enctype: 'multipart/form-data',
    returnType: 'json',
    allowedTypes: 'jpg,png,gif',
    url: $('#upload_url').val (),
    dragDropStr: '<span><b>或將圖片拖甩至此</b></span>',
    multiDragErrorStr: '不允許上傳多張照片！',
    sizeErrorStr: '照片大小不符合！ 最大只能: ',
    abortStr: '退出',
    cancelStr: '取消',
    deletelStr: '刪除',
    doneStr: '完成',
    extErrorStr: '是不允許的！ 只允許: ',
    uploadErrorStr: '不允許上傳！',
    fileCounterStyle: '.',
    onSuccess: function (files, data, xhr, pd) {
      pd.statusbar.fadeOut (1500, function () { $(this).remove (); });
    },
    done: function(e,data) {
      console.info (data);
    }
  });
});