/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $(window).resize (function () {
    $('.p').height ($.makeArray ($('.p').map (function () {
      return $(this).width ();
    })).max ());
  }).resize ();

  $('.location').click (function () {
    $.fancybox ({
        href: $(this).data ('url'),
        type: 'iframe',
        padding: 0,
        margin: 30,
        width: '100%',
        maxWidth: '1200',
    });
  });

  $('.edit').click (function () {
    $.fancybox ({
        href: $(this).data ('url'),
        type: 'iframe',
        padding: 0,
        margin: 30,
        width: '100%',
        maxWidth: '1200',
    });
  });

  $('.share').click (function () {
    window.open ('https://www.facebook.com/sharer/sharer.php?u=' + $(this).data ('url'), '分享', 'scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left=' + (window.screen ? Math.round(screen.width / 2 - 275) : 100));
  });

  $('.delete').click (function () {
    if (confirm ('確定刪除？'))
      $.ajax ({
        url: $(this).data ('url'),
        data: { },
        async: true, cache: false, dataType: 'json', type: 'delete',
      })
      .done (function (result) {
        if (result.status)
          location.reload ();
        else
          alert (result.message);
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
  });

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
    that.viewer = new ThetaViewer (that, null, $(this).data ('position'), $(this).data ('color'), false, {
      max: 100,
      min: 388
    });
    that.viewer.setEnable (false);
    that.viewer.images = [$(this).data ('url')];
    that.viewer.load ();
  });
});