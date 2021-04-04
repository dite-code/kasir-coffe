<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Laporan_html
 *
 * @author yusda08
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'controllers/Temp.php');
require_once(APPPATH . 'libraries/vendor/autoload.php');


class Laporan extends Temp {
	public function index() {
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [100, 150],
			'orientation' => 'P'
		]);
		$mpdf->WriteHTML('<h1>Hello world!</h1>');
		$mpdf->Bookmark('Start of the document');
		$mpdf->WriteHTML('<div>Section 1 text</div>');
		
		// Buffer the following html with PHP so we can store it to a variable later
		ob_start();

		// This is where your script would normally output the HTML using echo or print
		echo '<div>Generate your content</div>';

		// Now collect the output buffer into a variable
		$html = ob_get_contents();
		ob_end_clean();

		// send the captured HTML from the output buffer to the mPDF class for processing
		$mpdf->WriteHTML($html);


		$mpdf->Output();
	}
}
