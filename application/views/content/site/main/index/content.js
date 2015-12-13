/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $linkPanel = $('#link_panel');
  var $url = $linkPanel.find ('.url').click (function () { $(this).select (); });
  var $copyMsg = $linkPanel.find ('.m').removeClass ('s');

  $('.obj').each (function () {
    var $this = $(this);
    var that = $this.get (0);
    var position = $(this).data ('position');
    that.viewer = new ThetaViewer (that, null, $(this).data ('position'), $(this).data ('color'), false, {
      max: 100,
      min: 388
    });
    that.viewer.setEnable (false);
    that.viewer.images = [$(this).data ('url')];
    that.viewer.load (function () {
      if (!($this.data ('cover') && $this.data ('cover').length))
        uploadCover ($this.data ('token'), $this.find ('canvas').get (0).toDataURL ());
    });
  });

  $('.icon-location').click (function () {
    if (!$(this).attr ('disabled'))
      $.fancybox ({
          href: $(this).data ('url'),
          type: 'iframe',
          padding: 0,
          margin: 30,
          width: '100%',
          maxWidth: '1200',
      });
  });

  $('.icon-mail-forward').click (function () {
    window.open ('https://www.facebook.com/sharer/sharer.php?u=' + $(this).data ('url'), '分享', 'scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left=' + (window.screen ? Math.round(screen.width / 2 - 275) : 100));
  });
  $('.icon-link').click (function () {
    $linkPanel.addClass ('s');
    $url.val ($(this).data ('url'));
    $copyMsg.text ('已經複製囉！').removeClass ('s');
  });
  $linkPanel.on ('click', '.d, .c', function () {
    $linkPanel.removeClass ('s');
    $url.val ('');
    $copyMsg.text ('已經複製囉！').removeClass ('s');
  });

  $linkPanel.on ('click', '.copy', function () {
    window.getSelection ().removeAllRanges ();
    var range = document.createRange ();
    range.selectNode ($url.get (0));
    window.getSelection ().addRange (range);

    try {
      if (document.execCommand ('copy'))
        $copyMsg.text ('已經複製囉！').addClass ('s');
      else throw 'GG.. 複製失敗..';
    } catch (err) {
      $copyMsg.text (err).addClass ('s');
    }
    window.getSelection ().removeAllRanges ();
  });






  
  // $(window).resize (function () {
  //   $('.p').height ($.makeArray ($('.p').map (function () {
  //     return $(this).width ();
  //   })).max ());
  // }).resize ();



  // $('.edit').click (function () {
  //   $.fancybox ({
  //       href: $(this).data ('url'),
  //       type: 'iframe',
  //       padding: 0,
  //       margin: 30,
  //       width: '100%',
  //       maxWidth: '1200',
  //       afterClose: function () {
  //         location.reload ();
  //       }
  //   });
  // });

  // $('.share').click (function () {
  //   window.open ('https://www.facebook.com/sharer/sharer.php?u=' + $(this).data ('url'), '分享', 'scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left=' + (window.screen ? Math.round(screen.width / 2 - 275) : 100));
  // });

  // $('.delete').click (function () {
  //   if (confirm ('確定刪除？'))
  //     $.ajax ({
  //       url: $(this).data ('url'),
  //       data: { },
  //       async: true, cache: false, dataType: 'json', type: 'delete',
  //     })
  //     .done (function (result) {
  //       if (result.status)
  //         location.reload ();
  //       else
  //         alert (result.message);
  //     })
  //     .fail (function (result) { ajaxError (result); })
  //     .complete (function (result) { });
  // });


  // $('.b').each (function () {
  //   var $this = $(this);
  //   var that = $this.get (0);
  //   var position = $(this).data ('position');
  //   that.viewer = new ThetaViewer (that, null, $(this).data ('position'), $(this).data ('color'), false, {
  //     max: 100,
  //     min: 388
  //   });
  //   that.viewer.setEnable (false);
  //   that.viewer.images = [$(this).data ('url')];
  //   that.viewer.load (function () {
  //     if (!($this.data ('cover') && $this.data ('cover').length))
  //       uploadCover ($this.data ('cover_url'), $this.find ('canvas').get (0).toDataURL ());
  //   });
  // });

});