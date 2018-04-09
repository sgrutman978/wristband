<?php
require_once('stripe-php-3.9.1/init.php');
\Stripe\Stripe::setApiKey("sk_test_7KM9LLHBNo4cmL1IgSkqwHWW");
$barAcc = 0;
$mode = 0;
if($_GET['mode'] == 3){
$bar = \Stripe\Account::create(
  array(
    "country" => "US",
    "managed" => true
  )
);
$barAcc = $bar->id;
$mode = $_GET['mode'];
}
?>

<div id="loginCreateDiv">

	</br>Create Bar</br>
   <input type="text" placeholder="Bar Name" id="createBarName"></br>
    <input type="text" placeholder="Phone" id="createPhone"></br>pic needed</br>
  <input type="text" placeholder="E-mail" id="createEmail"></br>
   <input type="password" placeholder="Password" id="createPassword"></br>
   <input type="password" placeholder="Verify Password" id="createPassword2"></br>
    <input type="text" placeholder="Cover Price In Cents (ie. for $5 write 500)" id="createPrice"></br>
    <input type="text" id="my-address"></br>
        <button id="getCords" onClick="codeAddress();">Submit</button>

          </br>Bar Login</br>
            <input type="text" placeholder="E-mail" id="loginEmail"></br>
   <input type="password" placeholder="Password" id="loginPassword"></br>
   <button id="loginSubmit" onclick="login(2);">Login</button>

 </div>
 <div id="loggenIn">
</br>Edit Bar Info</br>
   <input type="text" placeholder="Bar Name" id="editBarName"></br>
    <input type="text" placeholder="Phone" id="editPhone"></br>pic needed</br>
  <input type="text" placeholder="E-mail" id="editEmail"></br>
   <input type="password" placeholder="Old Password" id="oldPassword"></br>
   <input type="password" placeholder="New Password" id="editPassword"></br>
   <input type="password" placeholder="Verify New Password" id="editPassword2"></br>
    <input type="text" placeholder="Cover Price In Cents (ie. for $5 write 500)" id="editPrice"></br>
    <input type="text" id="my-address"></br>
 </div>

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
       <script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>

   <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <script type="text/javascript">
        
        //additional commened out syntax at test1.php

var lat = -1000;
var longi = -1000;

 $(document).ready(function(){
    ChangeUrl('Page1', 'barPage.php');
     login(0);
 });

 function ChangeUrl(page, url) {
        if (typeof (history.pushState) != "undefined") {
            var obj = {Page: page, Url: url};
            history.pushState(obj, obj.Page, obj.Url);
        } else {
            window.location.href = "test.php";
            // alert("Browser does not support HTML5.");
        }
    }

        function initialize() {
        var address = (document.getElementById('my-address'));
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
        }
      });
}


function codeAddress() {
  // alert();
    geocoder = new google.maps.Geocoder();
    var address = document.getElementById("my-address").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {


// alert();

  if($("#createPassword").val() == $("#createPassword2").val()){
    // alert("l");
var ref = new Firebase("https://blistering-fire-195.firebaseio.com");
ref.createUser({
  email: $("#createEmail").val(),
  password: $("#createPassword").val()
}, function(error, userData) {
  if (error) {
    switch (error.code) {
      case "EMAIL_TAKEN":
        alert("The new user account cannot be created because the email is already in use.");
        break;
      case "INVALID_EMAIL":
        alert("The specified email is not a valid email.");
        break;
      default:
        alert("Error creating user.");
    }
  } else {
    // alert();
        var expiration_date = new Date();
expiration_date.setFullYear(expiration_date.getFullYear() + 1);
// alert("a");
 document.cookie="email="+$("#createEmail").val()+"; expires="+expiration_date.toGMTString();
 document.cookie="password="+$("#createPassword").val()+"; expires="+expiration_date.toGMTString();
// alert("d");
lat = results[0].geometry.location.lat();
longi = results[0].geometry.location.lng();

      login(1);
  }
});
}else{
  alert("Passwords do not match!");
}



      }else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }



  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}


function login(mode){
try {
  if(mode == 2){
     var keyemail = $("#loginEmail").val();
   var keypass = $("#loginPassword").val();
  }else{
    var keyemail = getCookie("email");
   var keypass = getCookie("password");
 }
   var ref = new Firebase("https://blistering-fire-195.firebaseio.com");
  ref.authWithPassword({
  email    : keyemail,
  password : keypass
}, function(error, authData) {
  if (error) {
if(mode == 2){
  alert("Wrong Username or Password");
}
  } else {
    if(mode == 1){
      //create bar
      //ajax call to create thing and leave payment into warning that stripe wont work without payment info
     var ref2 = new Firebase("https://blistering-fire-195.firebaseio.com/bars/"+authData.uid+"");
    ref2.update({
    email: keyemail,
    barName: $("#createBarName").val(),
    phone: $("#createPhone").val(),
    price: $("#createPrice").val(),
    address: $("#my-address").val(),
    lat: lat,
    longi: longi
});
    //OR have a password, make a php thing on this page to create and edit accounts, reload the page with get function 'mode', change visible url
    window.location.href = "http://www.stevengrutman.com/wristband/barPage.php?mode=3";
  }
  if(mode == 2){
     var expiration_date = new Date();
expiration_date.setFullYear(expiration_date.getFullYear() + 1);
 document.cookie="email="+$("#loginEmail").val()+"; expires="+expiration_date.toGMTString();
 document.cookie="password="+$("#loginPassword").val()+"; expires="+expiration_date.toGMTString();
  }
    if(<?php echo $mode; ?> == 3){
         var ref2 = new Firebase("https://blistering-fire-195.firebaseio.com/bars/"+authData.uid+"");
    ref2.update({
    id: '<?php echo $barAcc; ?>'
});
     window.location.href = "http://www.stevengrutman.com/wristband/barPage.php";
 }
    $("#loginCreateDiv").css("display", "none");
 alert("logged in");
  }
});
}
catch(err) {
    //no cookie set, show login screen
}

}


google.maps.event.addDomListener(window, 'load', initialize);

        </script>
