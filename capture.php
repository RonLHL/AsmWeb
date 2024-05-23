<?php
$username = $_GET["username"];
?>
<link rel="icon" type="image/x-icon" href="./img/logo.jpg">
<style>
    #my_camera{
        width: 320px;
        height: 240px;
        border: 1px solid black;
    }
</style>
<center>
    <div id="my_camera"></div>
    <input type=button value="Take Snapshot" name="takeSnapshot" onClick="take_snapshot()">

    <div id="results" ></div>
</center>

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
    shut.autoplay = true;
    shut.src = navigator.userAgent.match(/Firefox/)? 'shuuter.ogg' : 'shutter.mp3';
    function take_snapshot(){
    shut.play();
    Webcam.snap(function(data_uri){
        var username = "<?php echo $username; ?>";
    Webcam.upload(data_uri, 'saveMemberImage.php?username=' + username, function(code,Name){
    document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/> <input type="button" value="Submit" class="btn btn-secondary" onclick="getUsername(\'' + Name + '\')" />';
    });
    });
    }

    function getUsername(imageName){
    var username = "<?php echo $username; ?>";
    location.href = 'editMemberProfile.php?username=' + username;
    }
</script>
