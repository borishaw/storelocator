google.maps.event.addDomListener(window, 'load', function () {

    var stores = [];

    $.ajax({
        "url": "../php/getStores.php"
    }).done(function (data) {
        var resp = $.parseJSON(data);
        for (var i = 0; i < resp.length; i ++){
            var store = resp[i];
            var latLng = new google.maps.LatLng(store.x_coordinate, store.y_coordinate);
            var storeObj = new storeLocator.Store(store.store_id, latLng, null, {
                title: store.banner + " " + store.store_name,
                address: store.address + "<br>" + store.city + " " + store.province + " " + store.postal_code,
                phone: store.tel
            });
            stores.push(storeObj);
        }
    });

	 var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"geometry.fill","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#b4d4e1"},{"visibility":"on"}]}];
	 
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(43.7181557,-79.5181424),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	
		map.setOptions({styles: styles});
		
		//var mapMarker = new google.maps.Marker({
		//	position: latLng,
		//	map: map,
		//	icon: 'img/map-marker.png'
		// });
	 
    var panelDiv = document.getElementById('panel');

    var dataFeed = new storeLocator.StaticDataFeed;
    
    dataFeed.setStores(stores);

    var view = new storeLocator.View(map, dataFeed, {
        markerIcon: "img/map-icon.png",
        geolocation: true
    });

    new storeLocator.Panel(panelDiv, {
        view: view
    });
});