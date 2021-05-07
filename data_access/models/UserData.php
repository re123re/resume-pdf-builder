<?php

/**
 * Данные, заполненные пользователем в форме резюме
 */
class UserData {
    public $mainInfo;
    public $personalInfo;
    // array
    public $educationInfo;
    // array
    public $experienceInfo;
    public $coursesInfo;
    public $addonInfo;
    public $generateDate;

    function __construct($main, $personal, $edu, $exp, $cou, $addon) {
        $this->mainInfo = $main;
        $this->personalInfo = $personal;
        $this->educationInfo = $edu;
        $this->experienceInfo = $exp;
        $this->coursesInfo = $cou;
        $this->addonInfo = $addon;
    }
}

class UserMainInfo {
    public $firstname;
    public $lastname;
    public $patronymic;
    public $imagePath;
    public $currency;
    public $salary;
    public $email;

    function __construct($firstname, $lastname, $patronymic, $imagePath, $currency, $salary, $email) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->patronymic = $patronymic;
        $this->imagePath = $imagePath;
        $this->currency = $currency;
        $this->salary = $salary;
        $this->email = $email;
    }
}

class UserPersonalInfo {
    public $employment;
    public $schedule;
    public $position;
    public $assignment;
    public $phonecode;
    public $phone;
    public $city;
    public $crossing;
    public $citizenship;
    public $gender;
    public $birthdate;
    public $maritalStatus;

    function __construct($employment, $schedule, $position, $assignment, $phonecode, $phone, $city, $crossing, $citizenship, $gender, $birthdate, $maritalStatus) {
        $this->employment = $employment;
        $this->schedule = $schedule;
        $this->position = $position;
        $this->assignment = $assignment;
        $this->phonecode = $phonecode;
        $this->phone = $phone;
        $this->city = $city;
        $this->crossing = $crossing;
        $this->citizenship = $citizenship;
        $this->gender = $gender;
        $this->birthdate = $birthdate;
        $this->maritalStatus = $maritalStatus;
    }
}

class UserEducationInfo {
    public $institute;
    public $faculty;
    public $speciality;
    public $dateFrom;
    public $dateTo;

    function __construct($institute, $faculty, $speciality, $dateFrom, $dateTo) {
        $this->institute = $institute;
        $this->faculty = $faculty;
        $this->speciality = $speciality;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
}

class UserExperienceInfo {
    public $dateFrom;
    public $dateTo;
    public $currentTime;
    public $position;
    public $organization;
    public $duties;

    function __construct($dateFrom, $dateTo, $currentTime, $position, $organization, $duties) {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->currentTime = $currentTime;
        $this->position = $position;
        $this->organization = $organization;
        $this->duties = $duties;
    }
}

class UserCoursesInfo {
    public $training;
    public $organizationCoach;
    public $completion;
    public $duration;

    function __construct($training, $organizationCoach, $completion, $duration) {
        $this->training = $training;
        $this->organizationCoach = $organizationCoach;
        $this->completion = $completion;
        $this->duration = $duration;
    }
}

class UserAddonInfo {
    public $languages;
    public $drive;
    public $skills;
    public $personalQualities;

    function __construct($languages, $drive, $skills, $personalQualities) {
        $this->languages = $languages;
        $this->drive = $drive;
        $this->skills = $skills;
        $this->personalQualities = $personalQualities;
    }
}

?>