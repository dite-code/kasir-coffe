<?php
//echo $javasc;
//echo "tes";
$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [80, 100],
			'orientation' => 'P',
			'margin_top' => 5,
			'margin_bottom' => 5,
			'margin_left' => 5,
			'margin_right' => 5
		]);
$mpdf->WriteHTML('Your Introduction');
$mpdf->AddPage('L'); 
$mpdf->WriteHTML('Your Book text');
$mpdf->Output();
?>