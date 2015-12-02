/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $(window).resize (function () {
    $('.p').each (function () {
      $(this).height ($(this).width ());
    });
  }).resize ();


  if ($('#content_url').val ().length) {
    $.fancybox ({
        href: $('#content_url').val () + '?t=' + new Date ().getTime (),
        type: 'iframe',
        padding: 0,
        margin: 30,
        width: '100%',
        maxWidth: '1200',
    });
  }

  $('.b').each (function () {
    var that = $(this).get (0);
    var position = $(this).data ('position');
    that.viewer = new ThetaViewer (that, null, $(this).data ('position'), $(this).data ('color'));
    that.viewer.setEnable (false);
    that.viewer.images = [$(this).data ('url')];
    that.viewer.load ();
  });
});