latlngs = [];

add_location = function(latitude, longitude, title) {
    latlngs.push(new google.maps.Marker({
        title: title,
        map: map,
        position: new google.maps.LatLng(latitude, longitude)
    }));
      
      /*
       Update the bounding box to make sure we're showing all of the markers
      */
      var latlngbounds = new google.maps.LatLngBounds();
      $.each(latlngs, function (i, marker) {
        latlngbounds.extend(marker.getPosition());
      });
      map.setCenter(latlngbounds.getCenter());
      map.fitBounds(latlngbounds);
    
};

var map;

initialize = function() {
  var mapOptions = {
    zoom: 1,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  
  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
  add_airbnb_markers();
  add_homeaway_markers();
}

google.maps.event.addDomListener(window, 'load', initialize);
