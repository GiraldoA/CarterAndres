<!DOCTYPE HTML>
<?php
require_once("php/controller/create-db.php");
?>
<html>
    <head>
        <title>melonJS Template</title>
        <link rel="stylesheet" type="text/css" media="screen" href="index.css">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="apple-touch-icon" href="icons/touch-icon-iphone-60x60.png">
        <link rel="apple-touch-icon" sizes="76x76" href="icons/touch-icon-ipad-76x76.png">
        <link rel="apple-touch-icon" sizes="120x120" href="icons/touch-icon-iphone-retina-120x120.png">
        <link rel="apple-touch-icon" sizes="152x152" href="icons/touch-icon-ipad-retina-152x152.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    </head>
    <body>
        <!-- Canvas placeholder -->
        <div id="screen"></div>
        <form id="input" method="post">
            <!-- my username class and label-->
            <div class="field">
                <label for="username">Username</label>
                <input type='username' name='username' id='username' autocomplete='off'>
            </div>    
            <!--my password class and label-->
            <div class='password'>
                <label for="password">Password</label>
                <input type='password' name='password' id='password' autocomplete='off'>   
            </div>
            <!--my buttons-->
            <button type='button' id='register'>Register</button>
            <button type='button' id='load'>Load</button>
            <button type='button' id='mainmenu'>Back</button>
        </form>
        <!-- melonJS Library -->
        <!-- build:js js/app.min.js -->
        <script type="text/javascript" src="lib/melonJS-1.1.0-min.js"></script>

        <!-- Plugin(s) -->
        <script type="text/javascript" src="lib/plugins/debugPanel.js"></script>

        <!-- Game Scripts -->
        <script type="text/javascript" src="js/game.js"></script>
        <script type="text/javascript" src="js/resources.js"></script>

        <script type="text/javascript" src="js/entities/entities.js"></script>
        <script type="text/javascript" src="js/entities/HUD.js"></script>

        <script type="text/javascript" src="js/screens/title.js"></script>
        <script type="text/javascript" src="js/screens/play.js"></script>
        <script type="text/javascript" src="js/screens/NewUser.js"></script>
        <script type="text/javascript" src="js/screens/LoadUser.js"></script>
        <!-- /build -->
        <!-- Bootstrap & Mobile optimization tricks -->
        <script type="text/javascript">
            window.onReady(function onReady() {
                game.onload();

                // Mobile browser hacks
                if (me.device.isMobile && !navigator.isCocoonJS) {
                    // Prevent the webview from moving on a swipe
                    window.document.addEventListener("touchmove", function(e) {
                        e.preventDefault();
                        window.scroll(0, 0);
                        return false;
                    }, false);

                    // Scroll away mobile GUI
                    (function() {
                        window.scrollTo(0, 1);
                        me.video.onresize(null);
                    }).defer();

                    me.event.subscribe(me.event.WINDOW_ONRESIZE, function(e) {
                        window.scrollTo(0, 1);
                    });
                }
            });
        </script>
        <script>
            //checks if click on main menu button
            $("#mainmenu").bind("click", function() {
                me.state.change(me.state.MENU);
            });
            //checks if click on register button
            $("#register").bind("click", function() {
                $.ajax({
                    type: "POST",
                    url: "php/controller/create-user.php",
                    data: {
                        //data for username and password
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    dataType: "text"
                })
                        //for success 
                        .success(function(response) {
                            if (response === "true") {
                                //changes state to play
                                me.state.change(me.state.PLAY);
                            } else {
                                //alert if success
                                alert(response);
                            }
                        })
                        //my fail function
                        .fail(function(response) {
                            //alert for fail
                            alert("fail");
                        });
            });
            //checks if you click load button
            $("#load").bind("click", function() {
                //some ajax code 
                $.ajax({
                    type: "POST",
                    url: "php/controller/login-user.php",
                    data: {
                        //username and password data
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    dataType: "text"
                })
                        //my success function
                        .success(function(response) {
                            if (response === "invalid username and password") {
                                //alert if success
                                alert(response);
                            } else {
                                //jquery.parseJSON data
                                var data = jQuery.parseJSON(response);
                                
                                me.state.change(me.state.PLAY);
                            }
                        })
                        //my fail function
                        .fail(function(response) {
                            //alerts if fail
                            alert("fail");
                        });
            });
        </script>
    </body>
</html>
