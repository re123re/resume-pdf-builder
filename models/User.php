<?php

class User {
    public $mainInfo;
    public $personalInfo;
    // array
    public $educationInfo;
    // array
    public $experienceInfo;

    function __construct($main, $personal, $edu) {
        $this->mainInfo = $main;
        $this->personalInfo = $personal;
        $this->educationInfo = $edu;
    }
}

class UserMainInfo {
    public $firstname;
    public $lastname;
    public $patronymic;
    public $imagePath;
    public $salary;
    public $email;

    function __construct($firstname, $lastname, $patronymic, $imagePath, $salary, $email) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->patronymic = $patronymic;
        $this->imagePath = $imagePath;
        $this->salary = $salary;
        $this->email = $email;
    }
}

class UserPersonalInfo {
    public $employment;
    public $schedule;
    public $position;
    public $assignment;
    public $phone;
    public $city;
    public $crossing;
    public $citizenship;
    public $gender;
    public $birthdate;
    public $maritalStatus;

    function __construct($employment, $schedule, $position, $assignment, $phone, $city, $crossing, $citizenship, $gender, $birthdate, $maritalStatus) {
        $this->employment = $employment;
        $this->schedule = $schedule;
        $this->position = $position;
        $this->assignment = $assignment;
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
    public $position;
    public $organization;
    public $duties;
}

?>