<?php
$username = $_GET["username"];
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Take Photo</title>
        <style>
            #my_camera{
                width: 320px;
                height: 240px;
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <div id="my_camera"></div>
        <input type=button value="Take Snapshot" name="takeSnapshot" onClick="take_snapshot()">

        <?php
        if(isset($_POST["takeSnapshot"])){
            printf("<div id='results'>
                <input type='button' value='Submit' class='btn btn-secondary' onclick=\"location.href='editMemberProfile.php'\" />
                </div>
                     "); 
        }
        ?>
        <div id="results" ></div>
        

        <script type="text/javascript" src="webcam.min.js"></script>

        <script>
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
            
            var shut = new Audio();
            shut.autoplay=true;
            shut.src=navigator.userAgent.match(/IDE'S Default Browser/)? 'shuuter.ogg' : 'shutter.mp3';
            
            function take_snapshot(){
                shut.play();
                Webcam.snap(function(data_uri){
                    Webcam.upload(data_uri,'saveMemberImage.php',function(code,tetx,Name){
                        document.getElementById('results').innerHTML = '' + '<img src="'+data_uri+'"/>' + '<input type="button" value="Submit" class="btn btn-secondary" onclick="getUsername()" />';
                    });
                });
                
            }
            
            function getUsername(){
            var username = "<?php echo $username;?>";
            location.href='editMemberProfile.php?username=' + username;
            }
                    </script>

    </body>
</html>
