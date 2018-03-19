<?php
	include('controllers/forgot_password_controller.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style-responsive.css">
    <link rel="stylesheet" href="assets/css/style1.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/set1.css">

    <!--Google Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <a href="<?php echo app_path ?>login.php">Login</a>
<form method ="POST">
    <div id="main-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 left-side">
                    <header>
                        <h2><img src="images/aurumlogo.png" heigh="180" width="180" ></h2>  
                    </header>
                </div>
                <div class="col-md-6 right-side">
                    <h2>Reyes Francisco Tecson Sabado<br>and Associates</h2>
                    <br><br><br>
                    <span class="input input--hoshi">
                        <input class="input__field input__field--hoshi" type="email" id="inpEmail" name="inpEmail" maxlength="100" />
                        <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="name">
                            <span class="input__label-content input__label-content--hoshi">Email</span>   
                        </label>
                    </span>
                    <span class="input input--hoshi">
                        <input class="input__field input__field--hoshi" type="email" id="inpCEmail" name="inpCEmail" maxlength="100" />
                        <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="email">
                            <span class="input__label-content input__label-content--hoshi">Re-enter email</span>
                        </label>
                    </span>
                    <?php echo $msgDisplay; ?>
                    <div class="cta">
                        <button class="btn btn-primary pull-left" type="submit" id="btnReset" name="btnReset">
                            Reset Password
                        </button>
                        <span><a href="login.php">Back</a></span>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/classie.js"></script>
<script>
  (function() {
    // Reference: 
    // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
    if (!String.prototype.trim) {
      (function() {
        // Make sure we trim BOM and NBSP
        var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
        String.prototype.trim = function() {
          return this.replace(rtrim, '');
        };
      })();
    }

    [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
      // in case the input is already filled..
      if( inputEl.value.trim() !== '' ) {
        classie.add( inputEl.parentNode, 'input--filled' );
      }

      // events:
      inputEl.addEventListener( 'focus', onInputFocus );
      inputEl.addEventListener( 'blur', onInputBlur );
    } );

    function onInputFocus( ev ) {
      classie.add( ev.target.parentNode, 'input--filled' );
    }

    function onInputBlur( ev ) {
      if( ev.target.value.trim() === '' ) {
        classie.remove( ev.target.parentNode, 'input--filled' );
      }
    }
  })();
</script>

</body>
</html>
