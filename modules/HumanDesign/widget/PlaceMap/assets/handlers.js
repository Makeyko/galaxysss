/**
 * Виджет PlaceMap
 *
 * @type {{init: Function}}
 */

var PlaceMapHumanDesign = {

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
        PlaceMapHumanDesign.fieldId = fieldId;

        if (typeof defaultPoint == 'undefined') {
            PlaceMapHumanDesign.geoLocation(function (position) {
                PlaceMapHumanDesign.setMapToPosition(position);
                PlaceMapHumanDesign.init2();
            }, function () {
                PlaceMapHumanDesign.setMapToDefault();
                PlaceMapHumanDesign.init2();
            });
        } else {
            PlaceMapHumanDesign.setMapToPosition(new google.maps.LatLng(defaultPoint.lat, defaultPoint.lng));
            PlaceMapHumanDesign.init2();
        }
    },

    init2: function () {
        var input = /** @type {HTMLInputElement} */(
            document.getElementById(PlaceMapHumanDesign.fieldId));

        var autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['(cities)']
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                PlaceMapHumanDesign.map.fitBounds(place.geometry.viewport);
            } else {
                PlaceMapHumanDesign.map.setCenter(place.geometry.location);
                PlaceMapHumanDesign.map.setZoom(17);
            }

            PlaceMapHumanDesign.addMarker(place.geometry.location);
        });
    },

    /**
     * Стирает старый маркер.
     * Устанавливает маркер на карту.
     * Устанавливает значения скрытых полей.
     * Устанавливает новый маркер в переменную PlaceMapHumanDesign.marker
     *
     * @param location точка в которую нужно установить маркер
     */
    addMarker: function (location) {
        PlaceMapHumanDesign.marker.setMap(null);

        var marker = new google.maps.Marker({
            position: location,
            map: PlaceMapHumanDesign.map
        });

        $('#' + PlaceMapHumanDesign.fieldId + '-lng').val(location.lng());
        $('#' + PlaceMapHumanDesign.fieldId + '-lat').val(location.lat());

        PlaceMapHumanDesign.marker = marker;

        PlaceMapHumanDesign.setPointOnMap(location);
    },


    /**
     * Устанавливает адрес в $('#' + PlaceMapHumanDesign.fieldId).val() по указанной точке
     *
     * @param location
     */
    setPointOnMap: function (location)
    {
        var latlng = new google.maps.LatLng(location.lat(), location.lng());
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var name = PlaceMapHumanDesign.findTownInResult(results);
                $('#' + PlaceMapHumanDesign.fieldId).val( name );
            } else {
                alert("Geocoder failed due to: " + status);
            }
        });
    },

    /**
     * Возвращает название города
     *
     * @param result array
     *
     * @return string
     */
    findTownInResult: function (result) {
        for(var i = 0; i < result.length; i++) {
            v = result[i];
            if (($.inArray('political', v.types) >= 0) && ($.inArray('locality', v.types) >= 0)) {
                return v.formatted_address;
            }
        }

        return result[0].formatted_address;
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
        PlaceMapHumanDesign.setMapToPosition(new google.maps.LatLng(37.7699298, -122.4469157));
        PlaceMapHumanDesign.marker.setVisible(false);
    },

    setMapToPosition: function (position) {
        var pos = position;
        PlaceMapHumanDesign.map = new google.maps.Map(document.getElementById(PlaceMapHumanDesign.fieldId + '-map'), {
            center: pos,
            zoom: 13
        });
        PlaceMapHumanDesign.marker = new google.maps.Marker({
            position: pos,
            map: PlaceMapHumanDesign.map
        });
        $('#' + PlaceMapHumanDesign.fieldId + '-lng').val(position.lng());
        $('#' + PlaceMapHumanDesign.fieldId + '-lat').val(position.lat());
    }
};