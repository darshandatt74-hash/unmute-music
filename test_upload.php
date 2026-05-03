<?php
echo "PHP VERSION: ".phpversion()."<br><br>";

if(isset($_POST['go'])){

    var_dump($_FILES);

    if(move_uploaded_file($_FILES['file']['tmp_name'], "assets/music/ok.mp3")){
        echo "<h2>UPLOAD SUCCESS</h2>";
    }else{
        echo "<h2>UPLOAD FAILED</h2>";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <button name="go">UPLOAD</button>
</form>
