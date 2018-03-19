<?php
include('controllers/login_controller.php');
#include('controllers/forgot_password_controller.php');
echo 'document root echo: ' . $_SERVER['DOCUMENT_ROOT'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="css/set1.css">
    <link href="css/style1.css" rel="stylesheet">

    <!--Google Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="main-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 left-side">
                    <header>
                        <h2><img src="images/aurumlogo.png" heigh="180" width="180" ></h2>
                    </header>
                </div>
                <form method="POST">
                    <div class="col-md-6 right-side">
                        <h2>Reyes Francisco Tecson Sabado<br>and Associates</h2>
                        <br><br><br>
                        <span class="input input--hoshi">
                            <input class="input__field input__field--hoshi" type="text" id="inpUsername" name="inpUsername" maxlength="100" />
                            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="name">
                                <span class="input__label-content input__label-content--hoshi">Username</span>
                            </label>
                        </span>
                        <span class="input input--hoshi">
                            <input class="input__field input__field--hoshi" type="password" id="inpPassword" name="inpPassword" maxlength="100" />
                            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="email">
                                <span class="input__label-content input__label-content--hoshi">Password</span>
                            </label>
                        </span>
                        <?php
                        if(isset($_POST['btnLogin']))
                        {
                            if($login_row_count == 0)
                            {
                                #username/password combination is invalid
                                echo "
                                <div class='alert alert-danger alert-dismissable fade in'>
                                <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                Login failed. Incorrect username and/or password.
                                </div>
                                ";
                            }
                        }
                        ?>

                        <div class="cta">
                            <button class="btn btn-primary pull-left" type="submit" id="btnLogin" name="btnLogin">
                                Sign In
                            </button>
                            <span><a href="forgot_password.php">Forgot password</a></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/classie.js"></script>
    <script>
        (function() {
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
        });

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

