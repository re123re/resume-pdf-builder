<?php
class ResumeBuilder
{
    public static function build(
        $lastname,
        $firstname,
        $patronymic,
        $imagePath,
        $salary,
        $email,
        $employment,
        $schedule,
        $position,
        $assignment,
        $phone,

        $city,
        $crossing,
        $citizenship,
        $gender,
        $birthdate,
        $maritalStatus
    )
    {
        //ob_start();
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
        //$pdf->Image($imagePath, 15, 15, '', '', 'JPG', '', '', false, 150, '', false, false, 1, false, false, false);
        $pdf->Image($imagePath, 15, 15, '', '', 'JPG', '', '');
        // Render main info
        $html = '<style>p { font-size: 10pt; }</style>'
            . '<h2>' . $lastname . ' ' . $firstname . ' ' . $patronymic . '</h2>'
            . '<p><i>' . $position . '</i></p>'
            . '<p><b>Занятость: </b>' . $employment . '</p>'
            . '<p><b>График работы: </b>' . $schedule . '</p>'
            . '<p><b>Готовность к командировкам: </b>' . $assignment . '</p>'
            . '<p><b>Желаемая зарплата: </b>' . $salary . '</p>'
            . '<p><b>Телфон: </b>' . $phone . '</p>'
            . '<p><b>Электронная почта: </b>' . $email . '</p>'
            . '<p><b>Город проживания: </b>' . $city . '</p>';
/*echo $html;
return;*/
        $regions = array(
            array(
                'page' => '',
                'xt' =>  100,
                'yt' => 0,
                'xb' =>  100,
                'yb' => 80,
                'side' => 'L')
        );
        $pdf->setPageRegions($regions);
        $pdf->writeHTML($html, true, false, true, false, '');

        $fileName = Utils::Transliterate($lastname . '_' . $firstname . '_' . $patronymic . '.pdf');
        ob_end_clean();
        $pdf->Output($fileName, 'I');
    }
}