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

  addPv ('Picture', $ball.data ('token'));

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

  ball.viewer.autoRotate = $ball.data ('rotated');
  ball.viewer.images = [$ball.data ('url')];
  ball.viewer.load (function () {
    if (!($ball.data ('cover') && $ball.data ('cover').length))
      if ($ball.find ('canvas').get (0).width > window.canvasMaxWidth) {
          var canvas = document.createElement ('canvas');
          canvas.width = window.canvasMaxWidth;
          canvas.height = (window.canvasMaxWidth / $ball.find ('canvas').get (0).width) * $ball.find ('canvas').get (0).height;
          canvas.getContext ('2d').drawImage ($ball.find ('canvas').get (0), 0, 0, canvas.width, canvas.height);
          uploadCover ($ball.data ('token'), canvas.toDataURL ());
        } else {
          uploadCover ($ball.data ('token'), $ball.find ('canvas').get (0).toDataURL ());
        }
  });
  ball.viewer.position = $ball.data ('position');
  
  $move.bind ('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function () { $(this).remove (); });
  setTimeout (function () { $move.remove (); }, 3500);

  $('#share').click (function () {
    window.open ('https://www.facebook.com/sharer/sharer.php?u=' + $(this).data ('url'), '分享', 'scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left=' + (window.screen ? Math.round(screen.width / 2 - 275) : 100));
  });

  var resizeDataUriImage = function (url, width, height, callback) {
      var sourceImage = new Image();

      sourceImage.onload = function() {
          // Create a canvas with the desired dimensions
          var canvas = document.createElement('canvas');
          canvas.width = width;
          canvas.height = height;
          canvas.getContext('2d').drawImage(sourceImage, 0, 0, width, height);
          callback(canvas.toDataURL(), defe);
      };
      sourceImage.src = url;
      return defe;
  };
  $('#cover').click (function () {
    $(this).prop ('disabled', true).text ('設定中..');
    var url = $ball.find ('canvas').get (0).toDataURL ();

    if ($ball.find ('canvas').get (0).width > window.canvasMaxWidth) {
      var canvas = document.createElement ('canvas');
      canvas.width = window.canvasMaxWidth;
      canvas.height = (window.canvasMaxWidth / $ball.find ('canvas').get (0).width) * $ball.find ('canvas').get (0).height;
      canvas.getContext ('2d').drawImage ($ball.find ('canvas').get (0), 0, 0, canvas.width, canvas.height);
      url = canvas.toDataURL ();
    }

    uploadCoverPosition (
      $ball.data ('token'),
      url,
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