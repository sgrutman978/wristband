<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <body>
<script>

 function ChangeUrl(page, url) {
        if (typeof (history.pushState) != "undefined") {
            var obj = {Page: page, Url: url};
            history.pushState(obj, obj.Page, obj.Url);
        } else {
            window.location.href = "test.php";
            // alert("Browser does not support HTML5.");
        }
    }

  ChangeUrl('Page1', 'test.php');

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
 
if(<?php echo $_GET['amount'] ?> == -1 && <?php echo $_GET['id'] ?> == -1){
    var expiration_date = new Date();
expiration_date.setFullYear(expiration_date.getFullYear() + 1);
 document.cookie="barID=<?php echo $_GET['bar']; ?>; expires="+expiration_date.toGMTString();
     $('body').html("<div style='background-color:green;width:100%;height:100%;position:fixed;top:0px;left:0px;font-size:150px;text-align:center;padding-top:200px;color:white'><span style='color:yellow'>Bar ID Set</span></div>");
}else{
// if(getCookie("barID") != -1){
if(String(getCookie("barID")) == "<?php echo $_GET['bar']; ?>"){

 var ref = new Firebase("https://blistering-fire-195.firebaseio.com");
  ref.authWithPassword({
  email    : "<?php echo $_GET['email']; ?>",
  password : "<?php echo $_GET['password']; ?>"
}, function(error, authData) {
  if (error) {
   // alert("Login Failed!", error);
  } else {

 var scoresRef = new Firebase("https://blistering-fire-195.firebaseio.com/users/"+ authData.uid+"/payments/");
  // var counter = 0;
  // alert("fhns");
  scoresRef.orderByChild("id").startAt("<?php echo $_GET['id']; ?>").endAt("<?php echo $_GET['id']; ?>").once("value", function(snapshot) {
  	if(snapshot.val() == null){
$('body').html("<div style='background-color:red;width:100%;height:100%;position:fixed;top:0px;left:0px;font-size:150px;text-align:center;padding-top:200px;color:white'><span style='color:yellow'>Wristband</span></br>Denied</div>");
  	}
 //  document.getElementById("body1").innerHTML = " ";
  snapshot.forEach(function(data) {
    if(data.child("amount").val() == <?php echo $_GET['amount'] ?>){
 // counter++;
scoresRef.child(data.key()).remove();
 window.location.href = "http://stevengrutman.com/wristband/charge.php?mode=2&amount=<?php echo $_GET['amount']; ?>&id=<?php echo $_GET['id']; ?>&bar=<?php echo $_GET['bar']; ?>&email=<?php echo $_GET['email']; ?>";
    }
});
});

 }
});


}else{
	$('body').html("<div style='background-color:red;width:100%;height:100%;position:fixed;top:0px;left:0px;font-size:150px;text-align:center;padding-top:200px;color:white'><span style='color:yellow'>Wristband</span></br>Denied</span></div>");
}
  // }else{
  //   $('body').html("<div style='background-color:red;width:100%;height:100%;position:fixed;top:0px;left:0px;font-size:150px;text-align:center;padding-top:200px;color:white'><span style='color:yellow'>Set a Bar ID</span></div>");
  // }
}

</script>
</body>