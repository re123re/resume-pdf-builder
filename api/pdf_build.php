<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/export/ResumeBuilder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/Utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/SimpleImage.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/tecnickcom/tcpdf/tcpdf_import.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/models/UserData.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/UserInfoLogger.php';

$user = createUserData();

$builder = new ResumeBuilder();
$isAuthorized = $_COOKIE["Authorized"] == "true";
$builder->build($user, !$isAuthorized);

$logger = new UserInfoLogger();
$logger->Log($user);

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );
    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode($data[1]));
    fwrite($ifp, base64_decode($data[1]));

    // clean up the file resource
    fclose( $ifp );
    return $output_file;
}

function createUserData() : UserData {
    $imagePath = "";
    if ($_POST["photo"] === '') {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/resources/profile.jpg';
    } else {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads' . DIRECTORY_SEPARATOR;
        $fileGuid = Utils::GUIDv4();
        $imagePath = $upload_dir . $fileGuid . '.jpg';
        base64_to_jpeg($_POST['photo'], $imagePath);
    }

    $educationInfos = [];
    for ($i = 0; $i < $_POST["educationGroupNum"]; $i++) {
        if (!isset($_POST["eg-". $i . "-institute"])) {
            continue;
        }
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
        if (!isset($_POST["xg-". $i . "-dateFrom"])) {
            continue;
        }
        $exp = new UserExperienceInfo(
            $_POST["xg-". $i . "-dateFrom"],
            $_POST["xg-". $i . "-dateTo"],
            $_POST["xg-". $i . "-currentTime"],
            $_POST["xg-". $i . "-position"],
            $_POST["xg-". $i . "-organization"],
            $_POST["xg-". $i . "-duties"]
        );
        array_push($experienceInfos, $exp);
    }

    $coursesInfos = [];
    for ($i = 0; $i < $_POST["coursesGroupNum"]; $i++) {
        if (!isset($_POST["cg-". $i . "-training"])) {
            continue;
        }
        $cou = new UserCoursesInfo(
            $_POST["cg-". $i . "-training"],
            $_POST["cg-". $i . "-organizationCoach"],
            $_POST["cg-". $i . "-completion"],
            $_POST["cg-". $i . "-duration"]
        );
        array_push($coursesInfos, $cou);
    }

    return new UserData(
        new UserMainInfo(
            $_POST["firstname"],
            $_POST["lastname"],
            $_POST["patronymic"],
            $imagePath,
            $_POST["currency"],
            $_POST["salary"],
            $_POST["email"]
        ),
        new UserPersonalInfo(
            $_POST["employment"],
            $_POST["schedule"],
            $_POST["position"],
            $_POST["assignment"],
            $_POST["phonecode"],
            $_POST["phone"],
            $_POST["city"],
            $_POST["crossing"],
            $_POST["citizenship"],
            $_POST["gender"],
            $_POST["birthdate"],
            $_POST["maritalStatus"]),
        $educationInfos,
        $experienceInfos,
        $coursesInfos,
        new UserAddonInfo(
            $_POST["languages"],
            $_POST["drive"],
            $_POST["skills"],
            $_POST["personalQualities"]),
    );
}