/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $ball = $('#ball');
  var ball = $ball.get (0);

  $(window).resize (function () {
    if ($(window).height () < $(window).width ())
      $ball.css ({
        top: 0 - Math.abs (($(window).height () - $(window).width ()) / 2)
      });
    else
      $ball.css ({
        left: 0 - Math.abs (($(window).width () - $(window).height ()) / 2)
      });
  }).resize ();

  ball.viewer = new ThetaViewer (ball, null, $('#ball').data ('position'), $('#ball').data ('color'), true);
  ball.viewer.images = [$('#ball').data ('url')];
  ball.viewer.load ();

  $('body').css ({
    'background': '#' + $('#ball').data ('color')
  });
});