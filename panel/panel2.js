google.maps.event.addDomListener(window, 'load', function () {
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(37, -95),
        zoom: 4,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var panelDiv = document.getElementById('panel');

    var dataFeed = new storeLocator.StaticDataFeed;

    var latLng1 = new google.maps.LatLng(40.7585, -73.9861);
    var store1 = new storeLocator.Store('times_square', latLng1, null, {
        title: 'Times Square',
        address: '1 Times Square<br>Manhattan, NY 10036'
    });

    dataFeed.setStores([store1]);

    var view = new storeLocator.View(map, dataFeed, {
        geolocation: false
    });

    new storeLocator.Panel(panelDiv, {
        view: view
    });
});