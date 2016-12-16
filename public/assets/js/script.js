/**
     * Created by Etudiant on 14/12/2016.
     */
$(function() {
    initialize();
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
            zoom: 8,
            center: latlng
        };
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
    }


    $('#geo').on('change', function () {


        function codeAddress() {
            var address = document.getElementById('geo').value;
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }

        codeAddress();
    });


    var url = $('#path').val();
    var array;
    $.ajax({
        url : url,
        method: 'POST',
        dataType: "json"


    }).
    done(function(response){
        console.log('reussite');
        console.log(response);
        $("#geo").autocomplete({
            source:response
        });

    });







});

