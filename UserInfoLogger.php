<?php

class UserInfoLogger
{
    public function Log($user)
    {
        $config = parse_ini_file('config.ini');
        $db = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
        if (!$db) {
            throw new Exception('Ошибка соединения: ' . mysqli_connect_error());
        }


        $db->begin_transaction();
        try {
            // $mainInfoId и $personalInfoId будут всегда одинаковые, эти значения идентифицируют конкретного пользователя
            $mainInfoId = $this->InsertMainInfo($db, $user->mainInfo);
            $personalInfoId = $this->InsertPersonalInfo($db, $user->personalInfo);
            $educationInfoIds = $this->InsertEducationInfos($db, $user->educationInfo);
            $experienceInfoIds = $this->InsertExperienceInfos($db, $user->experienceInfo);

            $this->InsertUserInfo($db, $mainInfoId, $personalInfoId, $educationInfoIds, $experienceInfoIds);

            $db->commit();
        } catch (mysqli_sql_exception $exception) {
            $db->rollback();
            $db->close();
            throw $exception;
        }

        $db->close();
    }

    function InsertMainInfo($db, $mainInfo) : int {
        $db->query(<<<EOF
insert into main_info (
    firstname,
    lastname,
    patronymic,
    imagePath,
    salary,
    email) 
values (
    '{$mainInfo->firstname}',
    '{$mainInfo->lastname}',
    '{$mainInfo->patronymic}',
    '{$mainInfo->imagePath}',
     {$mainInfo->salary},
    '{$mainInfo->email}'
);
EOF);
        $id = $db->insert_id;
        if ($id == 0) {
            throw new Exception($db->error);
        }

        return $id;
    }

    function InsertPersonalInfo($db, $personalInfo) : int {
        $db->query(<<<EOF
insert into personal_info (
    employment,
    schedule,
    position,
    assignment,
    phone,
    city,
    crossing,
    citizenship,
    gender,
    birthdate,
    maritalStatus)
values (
    '{$personalInfo->employment}',
    '{$personalInfo->schedule}',
    '{$personalInfo->position}',
    '{$personalInfo->assignment}',
    {$personalInfo->phone},
    '{$personalInfo->city}',
    '{$personalInfo->crossing}',
    '{$personalInfo->citizenship}',
    '{$personalInfo->gender}',
    '{$personalInfo->birthdate}',
    '{$personalInfo->maritalStatus}'
);
EOF);
        $id = $db->insert_id;
        if ($id == 0) {
            throw new Exception($db->error);
        }

        return $id;
    }

    function InsertEducationInfos($db, $educationInfos): array {
        $educationInfoIds = [];
        for ($i = 0; $i < count($educationInfos); $i++) {
            $edu = $educationInfos[$i];
            $db->query(<<<EOF
insert into education_info (
    institute,
    faculty,
    speciality,
    dateFrom,
    dateTo)
values (
    '{$edu->institute}',
    '{$edu->faculty}',
    '{$edu->speciality}',
    {$edu->dateFrom},
    {$edu->dateTo}
);
EOF);
            $id = $db->insert_id;
            if ($id == 0) {
                throw new Exception($db->error);
            }

            $educationInfoIds[$i] = $id;
        }

        // TODO check 0
        return $educationInfoIds;
    }

    function InsertExperienceInfos($db, $experienceInfos): array {
        $experienceInfoIds = [];
        for ($i = 0; $i < count($experienceInfos); $i++) {
            $exp = $experienceInfos[$i];
            $position = mysqli_escape_string($db, $exp->position);
            $organization = mysqli_escape_string($db, $exp->organization);
            $duties = mysqli_escape_string($db, $exp->duties);
            $db->query(<<<EOF
insert into experience_info (
    dateFrom,
    dateTo,
    position,
    organization,
    duties)
values (
    '{$exp->dateFrom}',
    '{$exp->dateTo}',
    '{$position}',
    '{$organization}',
    '{$duties}'
);
EOF);
            $id = $db->insert_id;
            if ($id == 0) {
                throw new Exception($db->error);
            }

            $experienceInfoIds[$i] = $id;
        }

        // TODO check 0
        return $experienceInfoIds;
    }

    function InsertUserInfo($db, $mainInfoId, $personalInfoId, $educationInfoIds, $experienceInfoIds) {
        if (count($educationInfoIds) == 0) {
            $educationInfoIds[0] = null;
        }
        if (count($experienceInfoIds) == 0) {
            $experienceInfoIds[0] = null;
        }

        for ($i = 0; $i < count($educationInfoIds); $i++) {
            for ($j = 0; $j < count($experienceInfoIds); $j++) {
                $edu = is_null($educationInfoIds[$i]) ? 'null' : $educationInfoIds[$i];
                $exp = is_null($experienceInfoIds[$j]) ? 'null' : $experienceInfoIds[$j];
                $db->query(<<<EOF
insert into user_info (
    main_info_id,
    personal_info_id,
    education_info_id,
    experience_info_id,
    generate_date)
values (
    {$mainInfoId},
    {$personalInfoId},
    {$edu},
    {$exp},
    NOW()
);
EOF);
                $id = $db->insert_id;
                if ($id == 0) {
                    throw new Exception($db->error);
                }
            }
        }
    }
}