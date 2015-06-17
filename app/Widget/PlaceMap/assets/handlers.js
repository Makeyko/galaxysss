/**
 * Виджет PlaceMap
 *
 * @type {{init: Function}}
 */

var PlaceMap = {

    map: null,
    marker: null,
    fieldId: null,

    /**
     * Функция инициализации виджета
     * @param fieldId - string
     * @param defaultPoint [optional] точка в которую будет установлена карта после инициализации с маркером
     * {
     *    lng: float,
     *    lat: float
     * }
     */
    init: function (fieldId, defaultPoint) {
        PlaceMap.fieldId = fieldId;

        if (typeof defaultPoint == 'undefined') {
            PlaceMap.geoLocation(function (position) {
                PlaceMap.setMapToPosition(position);
                PlaceMap.init2();
            }, function () {
                PlaceMap.setMapToDefault();
                PlaceMap.init2();
            });
        } else {
            PlaceMap.setMapToPosition(new google.maps.LatLng(defaultPoint.lat, defaultPoint.lng));
            PlaceMap.init2();
        }
    },

    init2: function () {
        var input = /** @type {HTMLInputElement} */(
            document.getElementById(PlaceMap.fieldId));

        // This event listener will call addMarker() when the map is clicked.
        google.maps.event.addListener(PlaceMap.map, 'click', function (event) {
            PlaceMap.addMarker(event.latLng);
        });

        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                PlaceMap.map.fitBounds(place.geometry.viewport);
            } else {
                PlaceMap.map.setCenter(place.geometry.location);
                PlaceMap.map.setZoom(17);
            }

            PlaceMap.addMarker(place.geometry.location);
        });
    },

    /**
     * Стирает старый маркер.
     * Устанавливает маркер на карту.
     * Устанавливает значения скрытых полей.
     * Устанавливает новый маркер в переменную PlaceMap.marker
     *
     * @param location точка в которую нужно установить маркер
     */
    addMarker: function (location) {
        PlaceMap.marker.setMap(null);

        var marker = new google.maps.Marker({
            position: location,
            map: PlaceMap.map
        });

        $('#' + PlaceMap.fieldId + '-lng').val(location.lng());
        $('#' + PlaceMap.fieldId + '-lat').val(location.lat());

        PlaceMap.marker = marker;

        PlaceMap.setPointOnMap(location);
    },


    /**
     * Устанавливает адрес в $('#' + PlaceMap.fieldId).val() по указанной точке
     *
     * @param location
     */
    setPointOnMap: function (location)
    {
        var latlng = new google.maps.LatLng(location.lat(), location.lng());
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $('#' + PlaceMap.fieldId).val(results[0].formatted_address);
            } else {
                alert("Geocoder failed due to: " + status);
            }
        });
    },
    /**
     * Устанавливает карту в место определенное по геолокации
     */
    geoLocation: function (callbackSuccess, callbackError) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                callbackSuccess(latlng);

            }, function () {
                callbackError();
            });
        } else {
            // Browser doesn't support Geolocation
            callbackError();
        }
    },

    /**
     * Срабатывает когда геолокации у пользователя нет
     *
     * @param errorFlag bool
     */
    handleNoGeolocation: function (errorFlag) {
        var content;
        if (errorFlag) {
            content = 'Error: The Geolocation service failed.';
        } else {
            content = 'Error: Your browser doesn\'t support geolocation.';
        }

        var options = {
            map: map,
            position: new google.maps.LatLng(60, 105),
            content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
    },

    setMapToDefault: function () {
        PlaceMap.setMapToPosition(new google.maps.LatLng(37.7699298, -122.4469157));
        PlaceMap.marker.setVisible(false);
    },

    setMapToPosition: function (position) {
        var pos = position;
        PlaceMap.map = new google.maps.Map(document.getElementById(PlaceMap.fieldId + '-map'), {
            center: pos,
            zoom: 13
        });
        PlaceMap.marker = new google.maps.Marker({
            position: pos,
            map: PlaceMap.map
        });
        $('#' + PlaceMap.fieldId + '-lng').val(position.lng());
        $('#' + PlaceMap.fieldId + '-lat').val(position.lat());
    }
};