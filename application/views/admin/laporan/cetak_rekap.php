<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$a = $this->session->userdata('is_login');
$msg = $this->session->flashdata('msg');
$tipe = $this->session->flashdata('tipe');
$lambang = 'fa-check';
$notify = 'Sukses!';
echo $javasc;
$nama_admin = $a['nama_admin'];
$ttl_pemb = 0;
foreach ($get_transOrderDetail as $row) {
    $sub_ttl = $row->harga_menu * $row->qty;
    $ttl_pemb += $sub_ttl;
}
$no_meja = $row_ord->no_meja;
$tanggal = $row_ord->tanggal;
$jam = $row_ord->jam;
$diskon = $row_ord->diskon;
$tunai = $row_ord->tunai;

$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [80, 80],
			'orientation' => 'P',
			'margin_top' => 5,
			'margin_bottom' => 5,
			'margin_left' => 5,
			'margin_right' => 5
		]);
		
		
		//$mpdf->WriteHTML('<h1>Hello world!</h1>');
		//$mpdf->Bookmark('Start of the document');
		//$mpdf->WriteHTML('<div>Section 1 text</div>');
		
		// Buffer the following html with PHP so we can store it to a variable later
		ob_start();

		// This is where your script would normally output the HTML using echo or print
		?>
		<table border="0" width="100%">
		<tr><td style="text-align:center" colspan="2"><?= $row_pro->nama; ?></td></tr>
		<tr><td style="text-align:center" colspan="2"><?= $row_pro->alamat; ?></td></tr>
		<tr><td style="text-align:center" colspan="2"><?= $tgl ?></td></tr>
		<tr>	
			<td>Nama Kasir</td>
			<td>: <?= $kasir; ?></td>
		</tr>
		<tr><td colspan="2">---------------------------------------------------------</td></tr>
		<tr>
			<td>Pendapatan</td>
			<td><span class="pull-left">: Rp. </span><?= number_format($pendapatan, 0, ',', '.'); ?></td>
		</tr>
		<tr>
			<td>Pengeluaran</td>
			<td><span class="pull-left">: Rp. </span><?= number_format($pengeluaran, 0, ',', '.'); ?></td>
		</tr>
		<tr><td colspan="2">---------------------------------------------------------</td></tr>
		<tr>
			<td>Total Bersih</td>
			<td><span class="pull-left">: Rp. </span><?= number_format($pendapatan-$pengeluaran, 0, ',', '.'); ?></td>
		</tr>
		
		</table>
		<?php
		// Now collect the output buffer into a variable
		$html = ob_get_contents();
		ob_end_clean();

		// send the captured HTML from the output buffer to the mPDF class for processing
		$mpdf->WriteHTML($html);


		$mpdf->Output();
?>
