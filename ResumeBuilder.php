<?php

class ResumeBuilder
{
    public static function build($user)
    {
        ob_start();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        $pdf->SetFont('dejavusans', '', 12, '', true);

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();

        // Render photo
        $pdf->setJPEGQuality(90);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //$pdf->Image($user->mainInfo->imagePath, 15, 15, '', '', 'JPG', '', '');
        // Render main info
        $educationInfoHtml = ResumeBuilder::buildEducationInfo($user->educationInfo);
        $experienceInfoHtml = ResumeBuilder::buildExperienceInfo($user->experienceInfo);
        $coursesInfoHtml = ResumeBuilder::buildCoursesInfo($user->coursesInfo);
        $html = <<<EOF
<style>
p { 
    font-size: 10pt; 
}

</style>
<table style="border: none;">
    <tr>
       <td style="width: 300px">
            <img src="{$user->mainInfo->imagePath}">
       </td>
       <td>
           <b>{$user->mainInfo->lastname} {$user->mainInfo->firstname} {$user->mainInfo->patronymic}</b>
            <p><i>{$user->personalInfo->position}</i></p>
            <p><span style="color: #757575;"><b>Занятость: </b></span>{$user->personalInfo->employment}</p>
            <p><span style="color: #757575;"><b>График работы: </b></span>{$user->personalInfo->schedule}</p>
            <p><span style="color: #757575;"><b>Готовность к командировкам: </b></span>{$user->personalInfo->assignment}</p>
            <p><span style="color: #757575;"><b>Желаемая зарплата: </b></span>{$user->mainInfo->salary} {$user->mainInfo->currency}</p>
            <p><span style="color: #757575;"><b>Телефон: </b></span>{$user->personalInfo->phonecode} {$user->personalInfo->phone}</p>
            <p><span style="color: #757575;"><b>Электронная почта: </b></span>{$user->mainInfo->email}</p>
       </td>
    </tr>
</table>
    <br>
    <h2>Личная информация</h2>
    <p><span style="color: #757575;"><b>Гражданство: </b></span>{$user->personalInfo->citizenship}</p>
    <p><span style="color: #757575;"><b>Город проживания: </b></span>{$user->personalInfo->city}</p>
    <p><span style="color: #757575;"><b>Переезд: </b></span>{$user->personalInfo->crossing}</p>
    <p><span style="color: #757575;"><b>Пол: </b></span>{$user->personalInfo->gender}</p>
    <p><span style="color: #757575;"><b>Дата рождения: </b></span>{$user->personalInfo->birthdate}</p>
    <p><span style="color: #757575;"><b>Семейное положение: </b></span>{$user->personalInfo->maritalStatus}</p>
    <br>
    <h2>Образование</h2>
    {$educationInfoHtml}
    <br>
    <h2>Опыт работы</h2>
    {$experienceInfoHtml}
    <br>  
    <h2>Курсы и тренинги</h2>
    {$coursesInfoHtml}
    <br>
    <h2>Дополнительная информация</h2>
    <p><span style="color: #757575;"><b>Знание иностранных языков: </b></span>{$user->addonInfo->languages}</p>
    <p><span style="color: #757575;"><b>Водительские права (категории): </b></span>{$user->addonInfo->drive}</p>
    <p><span style="color: #757575;"><b>Ключевые навыки: </b></span>{$user->addonInfo->skills}</p>
    <p><span style="color: #757575;"><b>Личные качества: </b></span>{$user->addonInfo->personalQualities}</p>
EOF;
        $regions = array(
            array(
                'page' => '',
                'xt' => 90,
                'yt' => 0,
                'xb' => 90,
                'yb' => 90,
                'side' => 'L')
        );
        //$pdf->setPageRegions($regions);
        $pdf->writeHTML($html, true, false, true, false, '');

        $fileName = Utils::Transliterate($user->mainInfo->lastname . ' ' . $user->mainInfo->firstname . ' ' . $user->mainInfo->patronymic . '.pdf');
        $pdf->Output($fileName, 'I');
        ob_end_flush();
    }

    static function buildEducationInfo($educationInfos) : string
    {
        $html = '';
        for ($i = 0; $i < count($educationInfos); $i++) {
            $html .= <<<EOF
    <p><span style="color: #757575;"><b>Учебное заведение: </b></span>{$educationInfos[$i]->institute}</p>
    <p><span style="color: #757575;"><b>Факультет: </b></span>{$educationInfos[$i]->faculty}</p>
    <p><span style="color: #757575;"><b>Специальность: </b></span>{$educationInfos[$i]->speciality}</p>
    <p><span style="color: #757575;"><b>Год начала: </b></span>{$educationInfos[$i]->dateFrom}</p>
    <p><span style="color: #757575;"><b>Год окончания: </b></span>{$educationInfos[$i]->dateTo}</p>
EOF;
            if ($i >= 0 && $i < count($educationInfos) - 1) {
                $html .= '<hr>';
            }
        }
        return $html;
    }

    static function buildExperienceInfo($experienceInfos) : string
    {
        //htmlspecialchars
        $html = '';
        for ($i = 0; $i < count($experienceInfos); $i++) {
            $duties = nl2br($experienceInfos[$i]->duties);
            $html .= <<<EOF
    <p><span style="color: #757575;"><b>Период: </b></span>с {$experienceInfos[$i]->dateFrom} по {$experienceInfos[$i]->dateTo}</p>
    <p><span style="color: #757575;"><b>Должность: </b></span>{$experienceInfos[$i]->position}</p>
    <p><span style="color: #757575;"><b>Организация: </b></span>{$experienceInfos[$i]->organization}</p>
    <p><span style="color: #757575;"><b>Должностные обязанности и достижения: </b></span><br />{$duties}</p>
EOF;

            if ($i >= 0 && $i < count($experienceInfos) - 1) {
                $html .= '<hr>';
            }
        }
        return $html;
    }

    static function buildCoursesInfo($coursesInfos) : string
    {
        $html = '';
        for ($i = 0; $i < count($coursesInfos); $i++) {
            $html .= <<<EOF
    <p><span style="color: #757575;"><b>Название курса: </b></span>{$coursesInfos[$i]->training}</p>
    <p><span style="color: #757575;"><b>Наименование организации: </b></span>{$coursesInfos[$i]->organizationCoach}</p>
    <p><span style="color: #757575;"><b>Год окончания: </b></span>{$coursesInfos[$i]->completion}</p>
    <p><span style="color: #757575;"><b>Продолжительность: </b></span>{$coursesInfos[$i]->duration}</p>
EOF;
            if ($i >= 0 && $i < count($coursesInfos) - 1) {
                $html .= '<hr>';
            }
        }
        return $html;
    }
}