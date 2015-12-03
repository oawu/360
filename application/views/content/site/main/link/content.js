/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('.url').click (function () {
    $(this).select ();
  });

  document.querySelector ('.copy').addEventListener ('click', function (e) {
    
    var emailLink = document.querySelector ('.url');
    var range = document.createRange ();
    range.selectNode (emailLink);
    window.getSelection ().addRange (range);

    try {
      var successful = document.execCommand ('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      $('.link .m').text ('已經複製囉！').addClass ('s');
    } catch (err) {
      $('.link .m').text ('GG.. 複製失敗..').addClass ('s');
    }

    window.getSelection ().removeAllRanges ();
  });
});