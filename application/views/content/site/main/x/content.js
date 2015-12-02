/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('.theta-viewer').each (function () {
    var that = $(this).get (0);
    that.viewer = new ThetaViewer (that, function (position) {
console.error (position);

    }, {x: -169.83280551862157, y: 324.91120752739204, z: 128.6111321289731}, $(this).data ('color'));
    that.viewer.images = [$(this).data ('url')];
    that.viewer.load ();
  });
});