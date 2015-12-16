/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46121102-21', 'auto');
  ga('send', 'pageview');

window.canvasMaxWidth = 1280;

Array.prototype.column = function (k) {
  return this.map (function (t) { return k ? eval ("t." + k) : t; });
};
Array.prototype.diff = function (a, k) {
  return this.filter (function (i) { return a.column (k).indexOf (eval ("i." + k)) < 0; });
};
Array.prototype.max = function (k) {
  return Math.max.apply (null, this.column (k));
};
Array.prototype.min = function (k) {
  return Math.min.apply (null, this.column (k));
};

window.ajaxError = function (result) {
  console.error (result.responseText);
};

window.addPv = function (className, token) {
  $.ajax ({
      url: $('#ajax_pv_url').val (),
      data: {
        class: className,
        token: token
      },
      async: true, cache: false, dataType: 'json', type: 'POST',
  });
};
function uploadRotated (token, status, callback) {
  if ($('#rotated_url').val ())
    $.ajax ({
      url: $('#rotated_url').val () + '/' + token,
      data: {
        is_rotated: status ? 1 : 0,
      },
      async: true, cache: false, dataType: 'json', type: 'post',
      beforeSend: function () { }
    })
    .done (callback ? callback : function (result) { })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
}
function uploadVisibled (token, status, callback) {
  if ($('#visibled_url').val ())
    $.ajax ({
      url: $('#visibled_url').val () + '/' + token,
      data: {
        is_visibled: status ? 1 : 0,
      },
      async: true, cache: false, dataType: 'json', type: 'post',
      beforeSend: function () { }
    })
    .done (callback ? callback : function (result) { })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
}
function uploadCoverPosition (token, cover, position, callback) {
  if ($('#cover_position_url').val ())
    $.ajax ({
      url: $('#cover_position_url').val () + '/' + token,
      data: {
        cover: cover,
        position: position,
      },
      async: true, cache: false, dataType: 'json', type: 'post',
      beforeSend: function () { }
    })
    .done (callback ? callback : function (result) { })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
}
function uploadCover (token, cover, callback) {
  if ($('#cover_url').val ())
    $.ajax ({
      url: $('#cover_url').val () + '/' + token,
      data: {
        cover: cover
      },
      async: true, cache: false, dataType: 'json', type: 'post',
      beforeSend: function () { }
    })
    .done (callback ? callback : function (result) { })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
}

$(function () {
});