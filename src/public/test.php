<pre>
<?php
    print_r($_POST);
    print_r($_FILES);
?>
</pre>

<form action="/test.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" value="Upload">
</form>