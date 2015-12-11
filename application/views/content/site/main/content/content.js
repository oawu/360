/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $ball = $('#ball');
  var $move = $('#move');
  if (!$ball.length) return;
  var ball = $ball.get (0);

  ball.viewer = new ThetaViewer (ball, null, $ball.data ('position'), $ball.data ('color'), 1, {
      max: 500,
      min: 100
    });
  ball.viewer.images = [$ball.data ('url')];
  ball.viewer.load ();
  
  $move.bind ('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function () { $(this).remove (); });
  setTimeout (function () { $move.remove (); }, 3500);
});