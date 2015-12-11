/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $ball = $('#ball');
  var $move = $('#move');
  if (!$ball.length) return;
  var ball = $ball.get (0);

  ball.viewer = new ThetaViewer (ball, function (position) {
    ball.viewer.position = {
      x: position.x,
      y: position.y,
      z: position.z,
    };
  }, $ball.data ('position'), $ball.data ('color'), 1, {
      max: 388,
    });
  // ball.viewer.autoRotate = true;
  ball.viewer.images = [$ball.data ('url')];
  ball.viewer.load (function () {
    if (!($ball.data ('cover') && $ball.data ('cover').length))
      uploadCover ($ball.data ('cover_url'), $ball.find ('canvas').get (0).toDataURL ());
  });
  ball.viewer.position = $ball.data ('position');
  
  $move.bind ('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function () { $(this).hide (); });
  setTimeout (function () { $move.hide (); }, 3500);

  $('#cover').click (function () {
    $(this).prop ('disabled', true).text ('設定中..');
    uploadCoverPosition (
      $ball.data ('cover_position_url'),
      $ball.find ('canvas').get (0).toDataURL (),
      ball.viewer.position,
      function (result) {
        $(this).text ($(this).attr ('title')).prop ('disabled', false);
        $move.text (result.message).attr ('class', result.status ? 'icon-info-outline' : 'icon-warning').show ();
      }.bind ($(this)));
  });
});