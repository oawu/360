/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */
function readURL (input, $img) {
  $img.attr ('src', '').removeClass ('o');
  var $label = $img.parent ().attr ('data-loading', '圖片讀取中..').css ({
    'background-image': ''
  }).removeClass ('s');

  if (input.files && input.files[0]) {
    $label.addClass ('s');
    var reader = new FileReader ();

    reader.onload = function (e) {
      $img.attr ('src', e.target.result).load (function () {
        $img.addClass ('o');
        $label.imgLiquid ({verticalAlign: 'center'}).attr ('data-loading', '');
      });
    };

    reader.readAsDataURL (input.files[0]);
  }
}
$(function () {
  var $picture = $('#picture').change (function () {
    $(this).parent ().attr ('data-path', $(this).val ().split (/(\\|\/)/g).pop ());
    readURL (this, $('#img'));
  });
  $('button[type="reset"]').click (function () {
    $picture.val ('').change ();
  });
});