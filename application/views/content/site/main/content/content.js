/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $ball = $('#ball');
  var $move = $('#move');
  var $border = $('#border');
  if (!$ball.length) return;
  var ball = $ball.get (0);
  var $rotated = $('#rotated');

  ball.viewer = new ThetaViewer (ball, function (position) {
      ball.viewer.position = {
        x: position.x,
        y: position.y,
        z: position.z,
      };
    }, $ball.data ('position'), $ball.data ('color'), 1, {
      max: 500,
      min: 100
    });

  ball.viewer.autoRotate = $rotated.prop ('checked');
  ball.viewer.images = [$ball.data ('url')];
  ball.viewer.load (function () {
    if (!($ball.data ('cover') && $ball.data ('cover').length))
      uploadCover ($ball.data ('token'), $ball.find ('canvas').get (0).toDataURL ());
  });
  ball.viewer.position = $ball.data ('position');
  
  $move.bind ('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function () { $(this).remove (); });
  setTimeout (function () { $move.remove (); }, 3500);

  $('#cover').click (function () {
    $(this).prop ('disabled', true).text ('設定中..');
    uploadCoverPosition (
      $ball.data ('token'),
      $ball.find ('canvas').get (0).toDataURL (),
      ball.viewer.position,
      function (result) {
        $(this).text ($(this).attr ('title')).prop ('disabled', false);
        $move.text (result.message).attr ('class', result.status ? 'icon-info-outline' : 'icon-warning').show ();
      }.bind ($(this)));
  });
  $('#visibled').change (function () {
    $(this).prop ('disabled', true).nextAll ('div').text ('設定中..');

    uploadVisibled (
      $(this).data ('token'),
      $(this).prop ('checked') === true,
      function (result) {
        $(this).prop ('disabled', false);
        if (result.content)
          $(this).nextAll ('div').text (result.content);
    }.bind ($(this)));
  });
  $rotated.change (function () {
    $(this).prop ('disabled', true).nextAll ('div').text ('設定中..');

    uploadRotated (
      $(this).data ('token'),
      $(this).prop ('checked') === true,
      function (result) {
        $(this).prop ('disabled', false);
        if (result.content)
          $(this).nextAll ('div').text (result.content);
    }.bind ($(this)));
  });

  if ($border.length)
    $border.css ({
      top: ($(window).height () - Math.min ($(window).width (), $(window).height ())) / 2,
      left: ($(window).width () - Math.min ($(window).width (), $(window).height ())) / 2,
      width: Math.min ($(window).width (), $(window).height ()),
      height: Math.min ($(window).width (), $(window).height ())
    });
});