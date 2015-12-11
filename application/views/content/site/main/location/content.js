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
    var zoom = ($map.data ('lat') == -1) || ($map.data ('lng') == -1) ? 11 : 16;
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

    new google.maps.Marker ({
        map: _map,
        draggable: false,
        position: latLng,
      });
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});