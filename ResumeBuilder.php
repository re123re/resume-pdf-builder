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
        $pdf->Image($user->mainInfo->imagePath, 15, 15, '', '', 'JPG', '', '');
        // Render main info
        $educationInfoHtml = ResumeBuilder::buildEducationInfo($user->educationInfo);
        $experienceInfoHtml = ResumeBuilder::buildExperienceInfo($user->experienceInfo);
        $html = <<<EOF
<style>
p { 
    font-size: 10pt; 
}
.space {
    padding-top: 5px;
}
</style>
<div class="mainInfo">
    <h2>{$user->mainInfo->lastname} {$user->mainInfo->firstname} {$user->mainInfo->patronymic}</h2>
    <p><i>{$user->personalInfo->position}</i></p>
    <p><b>Занятость: </b>{$user->personalInfo->employment}</p>
    <p><b>График работы: </b>{$user->personalInfo->schedule}</p>
    <p><b>Готовность к командировкам: </b>{$user->personalInfo->assignment}</p>
    <p><b>Желаемая зарплата: </b>{$user->mainInfo->salary}</p>
    <p><b>Телефон: </b>{$user->personalInfo->phone}</p>
    <p><b>Электронная почта: </b>{$user->mainInfo->email}</p>
</div>

<div class="personalInfo">
    <h2>Личная информация</h2>
    <p><b>Гражданство: </b>{$user->personalInfo->citizenship}</p>
    <p><b>Город проживания: </b>{$user->personalInfo->city}</p>
    <p><b>Переезд: </b>{$user->personalInfo->crossing}</p>
    <p><b>Пол: </b>{$user->personalInfo->gender}</p>
    <p><b>Дата рождения: </b>{$user->personalInfo->birthdate}</p>
    <p><b>Семейное положение: </b>{$user->personalInfo->maritalStatus}</p>
</div>

<div class="educationInfo">
    <h2>Образование</h2>
    {$educationInfoHtml}
</div>

<div class="experienceInfo">
    <h2>Опыт работы</h2>
    {$experienceInfoHtml}
</div>
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
        $pdf->setPageRegions($regions);
        $pdf->writeHTML($html, true, false, true, false, '');

        $fileName = Utils::Transliterate($user->mainInfo->lastname . ' ' . $user->mainInfo->firstname . ' ' . $user->mainInfo->patronymic . '.pdf');
        $pdf->Output($fileName, 'I');
        ob_end_flush();
    }

    static function buildEducationInfo($educationInfos)
    {
        $html = '';
        for ($i = 0; $i < count($educationInfos); $i++) {
            $html .= <<<EOF
    <p><b>Учебное заведение: </b>{$educationInfos[$i]->institute}</p>
    <p><b>Факультет: </b>{$educationInfos[$i]->faculty}</p>
    <p><b>Специальность: </b>{$educationInfos[$i]->speciality}</p>
    <p><b>Год начала: </b>{$educationInfos[$i]->dateFrom}</p>
    <p><b>Год окончания: </b>{$educationInfos[$i]->dateTo}</p>
EOF;
        }
        return $html;
    }

    static function buildExperienceInfo($experienceInfos)
    {
        $html = '';
        for ($i = 0; $i < count($experienceInfos); $i++) {
            $html .= <<<EOF
    <p><b>Период: </b>с {$experienceInfos[$i]->dateFrom} по {$experienceInfos[$i]->dateTo}</p>
    <p><b>Должность: </b>{$experienceInfos[$i]->position}</p>
    <p><b>Организация: </b>{$experienceInfos[$i]->organization}</p>
    <p><b>Должностные обязанности и достижения: </b>{$experienceInfos[$i]->duties}</p>
EOF;
        }
        return $html;
    }

    static function valueOrDefault($value, $default)
    {
        return (isset($value) && $value !== '') ? $value : $default;
    }
}