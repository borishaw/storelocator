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

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(43.7181557,-79.5181424),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var panelDiv = document.getElementById('panel');

    var dataFeed = new storeLocator.StaticDataFeed;
    
    dataFeed.setStores(stores);

    var view = new storeLocator.View(map, dataFeed, {
        geolocation: true
    });

    new storeLocator.Panel(panelDiv, {
        view: view
    });
});