<?php
require_once 'ResumeBuilder.php';
require_once 'Utils.php';
require_once 'SimpleImage.php';
require_once 'vendor/tecnickcom/tcpdf/tcpdf_import.php';
require_once 'models/User.php';

$user = getUserModel();
ResumeBuilder::build($user);

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

function getUserModel() :User {
    $imagePath = is_uploaded_file($_FILES['photo']['tmp_name']) ? processPhoto() : 'resources' . DIRECTORY_SEPARATOR . 'profile.jpg';

    $educationInfos = [];
    for ($i = 0; $i < $_POST["educationGroupsNum"]; $i++) {
        $edu = new UserEducationInfo(
            $_POST["eg-". $i . "-institute"],
            $_POST["eg-". $i . "-faculty"],
            $_POST["eg-". $i . "-speciality"],
            $_POST["eg-". $i . "-dateFrom"],
            $_POST["eg-". $i . "-dateTo"]
        );
        array_push($educationInfos, $edu);
    }

    $experienceInfos = [];
    for ($i = 0; $i < $_POST["experienceGroupNum"]; $i++) {
        $exp = new UserExperienceInfo(
            $_POST["xg-". $i . "-dateFrom"],
            $_POST["xg-". $i . "-dateTo"],
            $_POST["xg-". $i . "-position"],
            $_POST["xg-". $i . "-organization"],
            $_POST["xg-". $i . "-duties"]
        );
        array_push($experienceInfos, $exp);
    }

    return new User(
        new UserMainInfo(
            $_POST["firstname"],
            $_POST["lastname"],
            $_POST["patronymic"],
            $imagePath,
            $_POST["salary"],
            $_POST["email"]
        ),
        new UserPersonalInfo(
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
            $_POST["maritalStatus"]),
        $educationInfos,
        $experienceInfos,
    );
}

// TODO: Do logging to database