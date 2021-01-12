<?php
require_once 'ResumeBuilder.php';
require_once 'Utils.php';
require_once 'SimpleImage.php';
require_once 'vendor/tecnickcom/tcpdf/tcpdf_import.php';

$imagePath = is_uploaded_file($_FILES['photo']['tmp_name']) ? processPhoto() : 'resources' . DIRECTORY_SEPARATOR . 'profile.jpg';
// Build document in PDF output
ResumeBuilder::build(
    $_POST["firstname"],
    $_POST["lastname"],
    $_POST["patronymic"],
    $imagePath,
    $_POST["salary"],
    $_POST["email"],
    $_POST["employment"],
    $_POST["schedule"],
    $_POST["position"],
    $_POST["assignment"],
    $_POST["phone"],

    $_POST["city"],
    $_POST["crossing"],
    $_POST["citizenship"],
    $_POST["gender"],
    $_POST["birthdate"],
    $_POST["maritalStatus"]
);

// Load user photo to disk
// TODO: Allow PNG, WEBM
// ---------------------
// Solution from: https://stackoverflow.com/a/29362735/6887107
function processPhoto(): string
{
    $upload_dir = 'uploads' . DIRECTORY_SEPARATOR;
    $fileGuid = Utils::GUIDv4();
    $imagePath = $upload_dir . $fileGuid . '.jpg';
    $image = new SimpleImage();
    $image->load($_FILES['photo']['tmp_name']);
    $image->resizeToWidth(220);
    $image->save($imagePath);
    return $imagePath;
}

// TODO: Do logging to database
?>