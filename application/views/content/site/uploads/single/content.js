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
  var $img = $('#img');

  var $picture = $('#picture').change (function () {
    $(this).parent ().attr ('data-path', $(this).val ().split (/(\\|\/)/g).pop ());
    readURL ($picture.get (0), $img);
  });

  $('button[type="submit"]').click (function () {
    $(this).prop ('disabled', true).text ('上傳中..');
    $('#form').submit ();
  });
  $('button[type="reset"]').click (function () {
    $picture.val ('').change ();
  });

  var $drop = $('#drop');
  var ooleft = $picture.parent ().offset().left;
  var ooright = $picture.parent ().outerWidth() + ooleft;
  var ootop = $picture.parent ().offset().top;
  var oobottom = $picture.parent ().outerHeight() + ootop;

  function stopEvent (e) { e.stopPropagation (); e.preventDefault (); }
  $drop.bind ('dragover', function (e) {
    stopEvent (e); $(this).addClass ('h');

    var x = e.originalEvent.pageX;
    var y = e.originalEvent.pageY;

    $picture.offset (!((x < ooleft) || (x > ooright) || (y < ootop) || (y > oobottom)) ? { top: y - 15, left: x - 100 } : { top: -400, left: -400 });
  })
  .bind ('dragleave', function (e) { stopEvent (e); $(this).removeClass ('h'); })
  .bind ('drop', function (e) { $(this).removeClass ('h'); });

});