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

  $('.p').each (function () {
    var that = $(this).get (0);
    that.viewer = new ThetaViewer (that, null, null, $(this).data ('color'));

    // that.viewer.setEnable (false);
    that.viewer.images = [$(this).data ('url')];
    that.viewer.load ();
  });
});