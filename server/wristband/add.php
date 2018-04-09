<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
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

  ChangeUrl('Page1', 'test.php"');

 var ref = new Firebase("https://blistering-fire-195.firebaseio.com");
  ref.authWithPassword({
  email    : "<?php echo $_GET['stripeEmail']; ?>",
  password : "<?php echo $_GET['stripePassword']; ?>"
}, function(error, authData) {
  if (error) {
   // alert("Login Failed!", error);
  } else {
 var scoresRef = new Firebase("https://blistering-fire-195.firebaseio.com/users/"+ authData.uid+"/payments/");
 var googleLink = "<?php echo 'https://chart.googleapis.com/chart?cht=qr&chs=180x180&chl='.urlencode('http://www.stevengrutman.com/wristband/check.php?mode=2&amount=' . $_GET['stripeAmount'] . '&id=' . $_GET['stripeCustomer'] . '&bar=' . $_GET['stripeBar'] . '&email=' . $_GET['stripeEmail'] . '&password=' . $_GET['stripePassword'] . ''); ?>";
 scoresRef.push({
    id: "<?php echo $_GET['stripeCustomer'] ?>",
     amount: <?php echo $_GET["stripeAmount"] ?>,
     bar: "<?php echo $_GET['stripeBar'] ?>",
     time: Date.now(),
     //var dateTimeString = moment(1439198499).format("DD-MM-YYYY HH:mm:ss");
     link: googleLink
}, function(){
	 window.location.href = googleLink;
});
}
});
 // var scoresRef2 = scoresRef.push();
    // scoresRef2.set({ 'id': <?php echo '"'.$_GET["stripeCustomer"] .'"' ?>, 'email': <?php echo '"'.$_GET["stripeEmail"] .'"' ?>, 'amount': <?php echo '"'.$_GET["stripeAmount"] .'"' ?> });
  </script>