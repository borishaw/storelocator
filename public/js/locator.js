google.maps.event.addDomListener(window, 'load', function () {

    var stores = [];

    //Define features
    var year_round = new storeLocator.Feature('year_round', 'Year Round');
    var seasonal = new storeLocator.Feature('seasonal', 'Seasonal');
    var featureSet = new storeLocator.FeatureSet(year_round, seasonal);

    $.ajax({
        "url": "../php/getStores.php"
    }).done(function (data) {
        var resp = $.parseJSON(data);
        for (var i = 0; i < resp.length; i ++){
            var store = resp[i];
            var latLng = new google.maps.LatLng(store.x_coordinate, store.y_coordinate);
            var store_title;

            var features = new storeLocator.FeatureSet;
            if (store.year_round == 1){
                features.add(year_round);
            } else if (store.seasonal == 1){
                features.add(seasonal);
            }

            if (store.store_name){
                store_title = store.store_name;
            } else {
                store_title = store.banner;
            }

            var storeObj = new storeLocator.Store(store.store_id, latLng, features, {
                title: store_title,
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
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        maxZoom: 13
    });
	
		map.setOptions({styles: styles});
		
		//var mapMarker = new google.maps.Marker({
		//	position: latLng,
		//	map: map,
		//	icon: 'img/map-marker.png'
		// });
	 
    var panelDiv = document.getElementById('panel');

    var dataFeed = new storeLocator.StaticDataFeed;

    //Define features
    var year_round = new storeLocator.Feature('year_round', 'Year Round');
    var seasonal = new storeLocator.Feature('seasonal', 'Seasonal');

    dataFeed.setStores(stores);

    var view = new storeLocator.View(map, dataFeed, {
        markerIcon: "img/map-icon.png",
        geolocation: true,
        features: featureSet
    });

    new storeLocator.Panel(panelDiv, {
        view: view
    });
});