<?php
if (!isset($_POST['submit'])) {
    header("Location: form-test.php");
}
require_once "FileUploader.php";
$upload = new FileUploader();
$check = $upload->set_file($_FILES['file'])
    ->set_dir()
    ->allowed_ext('png/jpg')
    ->upload();

if ($check == true) {
    echo "success";
} else {
    echo "fail";
}
print("<br>");
echo $upload->get_errMsg()."<br>";
echo $upload->get_dir()."<br>";