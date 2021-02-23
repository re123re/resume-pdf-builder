<?php
require_once 'ResumeBuilder.php';
require_once 'Utils.php';
require_once 'SimpleImage.php';
require_once 'vendor/tecnickcom/tcpdf/tcpdf_import.php';
require_once 'models/User.php';
require_once 'UserInfoLogger.php';

$user = createUserModel();
// TODO: try - catch - finally
ResumeBuilder::build($user);
$logger = new UserInfoLogger();
$logger->Log($user);

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

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp );

    return $output_file;
}

function createUserModel() :User {
    //$imagePath = is_uploaded_file($_FILES['photo']['tmp_name']) ? processPhoto() : 'resources' . DIRECTORY_SEPARATOR . 'profile.jpg';

    $upload_dir = 'uploads' . DIRECTORY_SEPARATOR;
    $fileGuid = Utils::GUIDv4();
    $imagePath = $upload_dir . $fileGuid . '.jpg';
    base64_to_jpeg($_POST['photo'], $imagePath);


    $educationInfos = [];
    for ($i = 0; $i < $_POST["educationGroupNum"]; $i++) {
        // TODO: Костыль
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
        // TODO: Костыль
        if (!isset($_POST["xg-". $i . "-dateFrom"])) {
            continue;
        }
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