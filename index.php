<?php



 


?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/hrts.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery-ui-1.9.1.custom.css" />
<style type="text/css">
    #dialogReset{
        display: none;
    }
</style> 

<title>HEITECH SERVICES (HRTS)</title>
<script type="text/javascript" src="http://docs.jquery.com/UI/Position"></script>
<script type="text/javascript" src="scripts/jquery-1.8.2.js"> </script>
<script type="text/javascript" src="../../ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="scripts/jquery-ui-1.9.1.custom.js"> </script>

<script type="text/javascript">

    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }


    $(document).ready(function () {
        $('.email').blur(function () {
            var sEmail = $('.email').val();
            if ($.trim(sEmail).length == 0) {
                $('#errorMessage').html('Please enter valid email address');
                $('.email').focus();
                e.preventDefault();
            }
            if (validateEmail(sEmail)) {
                //  alert('Email is valid');
            }
            else {
                $('#errorMessage').html('Invalid Email Address');
                $('.email').focus();
                // e.preventDefault();
            }
        });

    });


    $(document).ready(function () {
        $('.txtemail').blur(function () {
            var sxEmail = $('.txtemail').val();
            if ($.trim(sxEmail).length == 0) {
                $('.errorMessage').html('Please enter valid email address');
                $('.txtemail').focus();
                e.preventDefault();
            }
            if (validateEmail(sxEmail)) {
                //  alert('Email is valid');
            }
            else {
                $('.errorMessage').html('Invalid Email Address');
                $('.txtemail').focus();
                // e.preventDefault();
            }
        });

    });


    $(document).ready(function () {
        $('input').keyup(function (e) {

            // $('#errorMessage').html('');
            $('#errorMessage, .errorMessage').empty();
            // Enter pressed... do anything here...

        });
    });

    function check() {

        if ($(document.activeElement).attr("class") == "password") {
            alert('checkbox is fucused');
        }
    }


    /*  $(document).ready(function () {

    if ($('.password').is(':focus')) { $('#errorMessage').html(''); }
    }); */

    $(document).ready(function () {

        /*activate login dialog*/
        $("#dialogLogin").dialog({

            title: "Login",
            height: 300,
            width: 500,
            resizable: false,
            draggable: false,
            position: { my: "center", at: "center", of: window, within: "#mainDiv" },
            //position: [calculatedPosition,120],
            closeOnEscape: false,
            dialogClass: 'no-close changeBackground',
            buttons: [{ text: "Forgot Password", click: function () { /*$( this ).dialog( "close" );*/ /*alert('Under Construction!!!'); */
                frgtpswd_hrts();
            }
            },

                                  { text: "Login", click: function () { checkP(); }


                                  }]
        });


    });


    function checkP() {

        $(document).ready(function () {
            /*      $('.password').blur(function () { */
            var sPassword = $('.password').val();
            if ($.trim(sPassword).length == 0) {
                $('#errorMessage').html('Enter Password'); // alert('Enter Password');
                $('.password').focus();
                // e.preventDefault();
            } else { login_hrts(); }


        });
    }


    $('#dialogLogin').live('keyup', function (e) { if (e.keyCode == 13) { $(':button:contains("Login")').click(); } });

    function frgtpswd_hrts() {
        $(document).ready(function () {
            //   $('#dialogLogin').hide();
            $(".ui-dialog-content").dialog("destroy");
        });

        $(document).ready(function () {


            /*activate Reset dialog*/
            $("#dialogReset").dialog({

                title: "Reset",
                height: 250,
                width: 500,
                resizable: false,
                draggable: false,
                position: { my: "center", at: "center", of: window, within: "#mainDiv" },
                //position: [calculatedPosition,120],
                closeOnEscape: false,
                dialogClass: 'no-close changeBackground',
                buttons: [{ text: "Close", click: function () { window.close(); } },
                               { text: "Submit", click: function () { pswdExtract_hrts(); }
                               }]
            });

        });


    }

    function login_hrts() {

        //alert('It works');

        $.post('startSession.php',
                           { email: loginForm.email.value, password: loginForm.password.value }).done(function (data) {
                               if (data == 'Login Successful') { window.location = "main.php"; }
                               //else if(data == 'Enter Email Address'){$('#errorMessage').html(data).show();}
                               //else if(data == 'Incorrect Username and/or Password'){$('#errorMessage').html(data).show();}
                               //   else if (data == 'Enter Password') { $('#errorMessage').html('Enter Password'); }
                               else if (data == '') {
                                   $(document).ready(function () {
                                       $('#errorMessage').html('Empty');
                                   });
                               }

                               else if (data !== 'Login Successful') {
                                   $(document).ready(function () {
                                       $('#errorMessage').html('Incorrect Email Address and/or Password');
                                   });
                               }
                               else if (data == 'Enter Email Address') { $('#errorMessage').html(data); }

                               else if (data == 'Incorrect Email Address and/or Password') { $('#errorMessage').html(data); }
                               else if (data == 'Access Denied') {
                                   $('#errorMessage').html(data);
                                   /* else (alert("Incorrect Email Address and/or Password" ));*/
                               }
                               //else{ $('#errorMessage').html(data); }

                               $("form")[0].reset();

                           });

    }

    function pswdExtract_hrts() {

        $.post('newStartSession.php',
              { email: ResetForm.txtemail.value }).done(function (data) {
                  if (data == 'Login Successful') { window.location = "main.php"; }

                  else if (data !== 'Login Successful') {
                      $(document).ready(function () {
                          $('.errorMessage').html('Incorrect Email Address');
                      });
                  }

              });

        //  alert("Just Checking Up!!");
    }

    function clearForm() {

    }

    /*



    */ 

</script>

</head>

<body>

<div id="titleDiv">
    
    	<label id='title_text'> HeiQuality Automated Reporting and Tracking System </label>
    
    	<!--<img id="appTitle" src="images/hrts_title.png" />-->
        
        <!--<img id="heiTechLogo" src="images/HTS-logo3.png" height="80" />-->
    
    </div>
    
    
    <div id="mainDiv">
    
    	<div id="dialogLogin">
            
            <form id="loginForm" name="loginForm">
            
            	<div id="errorBox">
                
           <!-- 	<div id="errorMessage"> Incorrect Username and/or Password </div> -->
                
              <div id="errorMessage">  </div>
        		</div>
            
            	<table><tbody>
            		<tr><td> <label class="formTextFormat"> Email Address </label> </td><td> <input name="email" class="email" /> </td></tr>
                	<tr><td> <label class="formTextFormat"> Password </label> </td><td> <input name="password" class="password" type="password"/> </td></tr>
                </tbody></table>
            
            </form>
        
        </div>
        <div id="dialogReset">
            
            <form id="ResetForm" name="ResetForm">
            
            	<div class="errorBox">
            	<!--<div id="errorMessage"> Incorrect Username and/or Password </div>-->
              <div class="errorMessage">  </div>
        		</div>
            
            	<table><tbody>
            		<tr><td> <label class="formTextFormat"> Email Address </label> </td><td> <input name="txtemail" class="txtemail"/> </td></tr>
                	
                </tbody></table>
            
            </form>
        
        </div>
    
    </div>

</body>
</html>