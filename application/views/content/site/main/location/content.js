/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $map = $('#map');
  if (!$map.length)
      return;
  var _map = null;

  function initialize () {
    var zoom = ($map.data ('lat') == -1) || ($map.data ('lng') == -1) ? 12 : 16;
    var latLng = ($map.data ('lat') == -1) || ($map.data ('lng') == -1) ? new google.maps.LatLng (25.04, 121.55) : new google.maps.LatLng ($map.data ('lat'), $map.data ('lng'));
    
    _map = new google.maps.Map ($map.get (0), {
        zoom: zoom,
        zoomControl: true,
        scrollwheel: true,
        scaleControl: true,
        mapTypeControl: false,
        navigationControl: true,
        streetViewControl: false,
        disableDoubleClickZoom: true,
        center: latLng,
      });

    var infoWindow = new InfoBubble ({
      margin: 0, padding: 0, arrowStyle: 0,
      borderWidth: 1, shadowStyle: 3, borderRadius: '110', minWidth: 'auto',
      maxWidth: 'auto', minHeight: 'auto', maxHeight: 'auto',
      borderColor: 'rgba(39, 40, 34, .7)', backgroundClassName: '',
      content: '<div class="info_bubble"><div class="img"><img src="' + $map.data ('cover') + '" /><div class="title"></div></div></div>'
    });
    infoWindow.open (_map, new google.maps.Marker ({
      map: _map,
      draggable: false,
      position: latLng,
      icon: '/resource/image/shadow.png'
    }));

  }

  google.maps.event.addDomListener (window, 'load', initialize);
});