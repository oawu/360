/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $ball = $('#ball');
  var $loading = $('#loading');
  if (!$ball.length) return;

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

  ball.viewer = new ThetaViewer (ball, function (position) {
    $.ajax ({
      url: $('#update_url').val (),
      data: {
        position: {
          x: position.x,
          y: position.y,
          z: position.z
        }
      },
      async: true, cache: false, dataType: 'json', type: 'put',
      beforeSend: function () { $loading.addClass ('s'); }
    })
    .done (function (result) {
      $loading.removeClass ('s');
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
    
  }, $('#ball').data ('position'), $('#ball').data ('color'), true);
  ball.viewer.images = [$('#ball').data ('url')];
  ball.viewer.load ();

  $('body').css ({
    'background': '#' + $('#ball').data ('color')
  });
});