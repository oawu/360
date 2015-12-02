/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('.theta-viewer').each (function () {
    var that = $(this).get (0);
    that.viewer = new ThetaViewer (that, function (position) {
    console.error (position);

    }, {x: -146.9435942167161, y: 427.6915706949481, z: 151.731325322211}, $(this).data ('color'));
    that.viewer.images = [$(this).data ('url')];
    that.viewer.load ();
  });
});