/**
 * Created by Jameshwart Villarmea Lopez on 4/7/2015.
 */

var x = document.getElementById("map_holder");
var map;
var infowindow;
var latlng;
var request;
var selected;
var sortyby = "PROMINENCE";
var place_details_sortbyprominence = [];
var place_details_sorbydistance = [];
var radius_val;

$(document).ready(function () {
    $(window).load(function(){
        if(localStorage.getItem("recent_choice") != null){
            $("#recent").html("");
            $("#recent").html(localStorage.getItem("recent_choice"));
        }
    });

    $("#selecta").select2({
        placeholder: "Select Places...",
        allowClear: true,
        maximumSelectionLength: 3
    });


    $('#my_slider').on('slide', function () {
        selected = $("#selecta").select2("val");
        radius_val = $('#my_slider').val();
        request = {
            location: latlng,
            radius: radius_val,
            rankBy: google.maps.places.RankBy.PROMINENCE,
            types: selected
        };
    });
    $('#my_slider').on('change', function () {
        selected = $("#selecta").select2("val");
        radius_val = $('#my_slider').val();
        request = {
            location: latlng,
            radius: radius_val,
            rankBy: google.maps.places.RankBy.PROMINENCE,
            types: selected
        };
    });

    $(document).on("change", "#selecta", function () {
        selected = $("#selecta").select2("val");
        radius_val = $('#my_slider').val();
        request = {
            location: latlng,
            radius: radius_val,
            rankBy: google.maps.places.RankBy.PROMINENCE,
            types: selected
        };
    });

    $('#cmdSubmit').click(function () {
        $("#mnu_1,#your").css("display", "block");
        place_details_sortbyprominence = [];
        place_details_sorbydistance = [];
        localStorage.removeItem("leloo_by_prominence");
        localStorage.removeItem("leloo_by_distance");
        if ($("#selecta").select2("val")) {
            $(this).hide();
            $("#noSubmit").show();
            radius_val = $('#my_slider').val();
            request.types = selected;
            request.radius = radius_val;
            request.rankBy = google.maps.places.RankBy.PROMINENCE;
            getLocation();
            $(".loading").show();
            setTimeout(function () {
                $("#noSubmit").hide();
                $("#cmdSubmit").fadeIn();
                display_sorted_results(localStorage.getItem("leloo_by_prominence"))
                $(".loading").fadeOut();
            }, 2000)
        } else {
            $('#alert-msg').html("<div class='alert alert-warning alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Ops!&nbsp;</strong>Please select place/s.</div>");
            var placelength = $("#placeres").html();
            if (placelength.length <= 0) {
                $("#mnu_1,#your").css("display", "none");
            } else if (placelength.length > 0) {
                $("#mnu_1,#your").css("display", "block");
            }
        }
        var recent_cat = [];

        selected_val    = $("#selecta").select2('data');
        recentitems     = $('#recent option').size();
        for(i = 0 ; i < selected_val.length;i++){
            $("#recent").append($("<option></option>").text(selected_val[i].text).val(selected_val[i].id));
        }
        var totalsize  = ($("#recent option").size()) - 3;
        if(recentitems>1){
            $("#recent option").slice(0,totalsize).remove();
        }
        $("#selecta").select2({
            placeholder: "Select Places...",
            allowClear: true,
            maximumSelectionLength: 3
        });

        localStorage.setItem("recent_choice",$("#recent").html());
    });

    $(".sortby").click(function () {
        $(".sortby").removeClass("active");
        $(this).addClass("active");


        if ($(this).text() === 'Distance') {

            if ("leloo_by_distance" in localStorage) {
                display_sorted_results(localStorage.getItem("leloo_by_distance"));
            } else {
                if ($("#selecta").select2("val")) {
                    request.types = selected;
                    request.radius = null;
                    request.rankBy = google.maps.places.RankBy.DISTANCE;
                    getLocation();
                    $(".loading").fadeIn();
                    setTimeout(function(){
                        display_sorted_results(localStorage.getItem("leloo_by_distance"));
                        $(".loading").fadeOut();
                    },2000);
                }

            }

        } else if ($(this).text() === 'Popularity') {

            if ("leloo_by_prominence" in localStorage) {

                display_sorted_results(localStorage.getItem("leloo_by_prominence"));
            } else {
                if ($("#selecta").select2("val")) {
                    radius_val = $('#my_slider').val();
                    request.types = selected;
                    request.radius = radius_val;
                    request.rankBy = google.maps.places.RankBy.PROMINENCE;
                    getLocation();
                    display_sorted_results(localStorage.getItem("leloo_by_prominence"));
                }

            }
        }


    });
});


function getLocation() {
    //get current position
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {


    document.querySelector("#mapcanvas").style.height = '500px';
    latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    var myOptions = {
        zoom: 15,
        center: latlng,
        mapTypeControl: false,
        navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);

    var infowindowmain = new google.maps.InfoWindow({
        map: map,
        position: latlng,
        content: "You are here! (at least within a " + position.coords.accuracy + " meter radius)"
    });

    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: "You are here! (at least within a " + position.coords.accuracy + " meter radius)"
    });
    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent("You are here! (at least within a " + position.coords.accuracy + " meter radius)");
        infowindow.open(map, this);
    });

    request.location = latlng;

    selected = $("#selecta").select2("val");
    infowindow = new google.maps.InfoWindow();
    var service = new google.maps.places.PlacesService(map);
    service.nearbySearch(request, callback);

    findhim(latlng);

}

function findhim(point) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({latLng: point}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {

                var p_name = (results[0].name) ? "Place name: " + results[0].name + "<br/>" : '';
                var p_address = (results[0].formatted_address) ? "<p>" + results[0].formatted_address + "<p>" : '';

                document.getElementById("location_container").innerHTML = p_name + p_address;
            }
        }
    });


}

function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            if (checkRadiusDistance(results[i], latlng, radius_val)) {
                createMarker(results[i]);
            }

        }

        $('#alert-msg').html("<div class='alert alert-success alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Returned <strong>" + results.length + "</strong> results</div>");

        $("#mnu_2,#about,#h_place,#btn-group-places").css("display", "block");
        $("#btn-group-places").css("display", "inline-block");
    }
    else {
        $('#alert-msg').html("<div class='alert alert-danger alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Returned <strong>" + results.length + "</strong> results</div>");
        $("#mnu_2,#about,#h_place,#btn-group-places").css("display", "none");

    }
}

function checkRadiusDistance(place, latlng, radius) {
    return google.maps.geometry.spherical.computeDistanceBetween(place.geometry.location, latlng) <= radius;
}


function createMarker(place) {

    var placeLoc = place.geometry.location;

    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
    });

    var requestdata = {
        placeId: place.place_id
    };

    document.getElementById("placeres").innerHTML = "";
    var service = new google.maps.places.PlacesService(map);
    service.getDetails(requestdata, function (placedata, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {

            if (request.rankBy === google.maps.places.RankBy.PROMINENCE) {
                place_details_sortbyprominence.push((placedata));
                localStorage.setItem("leloo_by_prominence", JSON.stringify(place_details_sortbyprominence));
            } else if (request.rankBy === google.maps.places.RankBy.DISTANCE) {
                place_details_sorbydistance.push((placedata));
                localStorage.setItem("leloo_by_distance", JSON.stringify(place_details_sorbydistance));
            }
        }
    });

    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(getPlace_contenet(place));
        infowindow.open(map, this);
    });


}

function getReview(pid){
    $.ajax({
        method: "POST",
        url: "public/userAction/getPlaceReview.php",
        data: "placeid=" + pid,
        success: function (data) {
            if (data) {
                var db_user_review = JSON.parse(data);
                for (i = 0; i < db_user_review.length; i++) {
                    // alert(db_user_review[i].id);
                    var db_author_review = "<h5>" + db_user_review[i].full_name + "</h5>";
                    var db_rating_review = "<p style='font-size: 15px;'>Rating:  <span class='star'>" + rating_display(db_user_review[i].rating) + "</p>";
                    var db_text_review = "<p style='font-size: 12px;'>" + db_user_review[i].reviewtext + "</p>";

                    u_review = "<li class='list-group-item' style='color: #333;'>" + db_author_review + db_rating_review + db_text_review + "</li>";
                    $("#"+db_user_review[i].placeid).append(u_review);
                }
            }
        }
    });
}
function display_sorted_results(localstorage_data) {
    if (localstorage_data != null) {
        var data = localstorage_data.replace(/"\\&quot;/g, "'").replace(/\\&quot;"/g, "'");

        data = JSON.parse(data);
        document.getElementById("places").innerHTML = '';
        var str_container = "";

        for (var i = 0; i < data.length; i++) {

            var placedata = data[i];

            var place_name = "<h1>" + placedata.name + "</h1>";
            var place_address = "<h6>" + placedata.formatted_address + "</h6>";
            var place_img_representation = "<img src='" + placedata.icon + "' />";
            var place_internationa_phonenuber = (typeof placedata.international_phone_number !== 'undefined') ? "<p>" + placedata.international_phone_number + "</p>" : "";


            var place_rating = (typeof placedata.rating !== 'undefined') ? "<p>Rating based on aggregated user reviews:<span class='star'>" + rating_display(placedata.rating) + "</span></p>" : "";
            var place_website = (typeof placedata.website !== 'undefined') ? "<br/><a target='_blank' style='color:#324c73;' href='" + placedata.website + "'>" + placedata.website + "</a>" : "";

            var user_reviews = "";
            if (typeof placedata.reviews !== 'undefined') {
                for (var j = 0; j < placedata.reviews.length; j++) {

                    var place_reviews = placedata.reviews[j];
                    var review_author = "<h5>" + place_reviews.author_name + "</h5>";
                    var review_authorlink = (typeof place_reviews.author_url !== 'undefined') ? "<a target='_blank' href='" + place_reviews.author_url + "'>" + review_author + "</a>" : "<a href='#'>" + review_author + "</a>";
                    var review_rating = "<p style='font-size: 15px;'>Rating: <span class='star'>" + rating_display(place_reviews.rating) + "</span> </p>";
                    var review_text = "<p style='font-size: 12px;'>" + place_reviews.text + "</p>";

                    user_reviews += "<li class='list-group-item' style='color: #333;'>" + review_authorlink + review_rating + review_text + "</li>";
                }
            }
            getReview(placedata.place_id);
            var final_users_review = "<ul class='list-group' id='"+placedata.place_id+"'>" + user_reviews + "</ul>";

            str_container += "<div class='col-lg-6 '>" + place_img_representation + place_name + place_address + place_internationa_phonenuber + place_rating + place_website + final_users_review + "<button class='btn btn-primary btn-sm add_review'  data-place_id= '" + placedata.place_id + "'> Write a review</button></div>";
        }

        document.getElementById("placeres").innerHTML = str_container;
    }

}

function getPlace_contenet(place) {
    var content = '';
    content += '<table>';
    content += '<tr class="iw_table_row">';
    content += '<td style="text-align: right"><img class="hotelIcon" src="' + place.icon + '"/></td>';
    var url = (typeof place.url !== 'undefined') ? place.url : '#';

    content += '<td><b><a href="' + url + '">' + place.name + '</a></b></td></tr>';
    content += '<tr class="iw_table_row"><td class="iw_attribute_name">Address:</td><td>' + place.vicinity + '</td></tr>';
    if (place.formatted_phone_number) {
        content += '<tr class="iw_table_row"><td class="iw_attribute_name">Telephone:</td><td>' + place.formatted_phone_number + '</td></tr>';
    }

    if (place.rating) {
        rating_display(place.rating);
        content += '<tr class="iw_table_row"><td class="iw_attribute_name">Rating:</td><td><span id="rating">' + rating_display(place.rating);
        +'</span></td></tr>';

    }
    if (place.website) {
        var fullUrl = place.website;
        var website = hostnameRegexp.exec(place.website);
        if (website == null) {
            website = 'http://' + place.website + '/';
            fullUrl = website;
        }
        content += '<tr class="iw_table_row"><td class="iw_attribute_name">Website:</td><td><a href="' + fullUrl + '">' + website + '</a></td></tr>';
    }
    content += '</table>';
    return content;
}


function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}

function ucfirst(str) {
    var firstLetter = str.substr(0, 1);
    return firstLetter.toUpperCase() + str.substr(1);
}

function rating_display(rating) {
    var html_rating = "";
    for (var i = 0; i < 5; i++) {
        if (rating < (i + 0.5)) {
            html_rating += '&#10025;';
        } else {
            html_rating += '&#10029;';
        }
    }

    return html_rating;
}