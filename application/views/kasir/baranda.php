<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$a = $this->session->userdata('is_login');
$msg = $this->session->flashdata('msg');
$tipe = $this->session->flashdata('tipe');
$lambang = 'fa-check';
$notify = 'Sukses!';
echo $javasc;

?>

        <div class="box">
        <div class="box-body">
			
			<div class="row">
                <div class="col-md-12">
					<form method="get">
					<table  width="100%" border="0" align="center"  >
						<tr>
							<td style="padding-bottom:5px;">Transksi Tanggal : <?= Tgl_indo::indo($caritanggal); ?></td>
							<td style="padding-bottom:5px;text-align:right">Cari Tanggal : </td>
							<td width="5%" style="padding-bottom:5px;text-align:right">
								<input class="form-control tanggal"	type="date" name="caritanggal" value="<?= $caritanggal; ?>">
							</td>
							<td width="5%" style="padding-bottom:5px;text-align:right"><button class="btn btn-flat btn-success"><i class="fa fa-search"></i></button></td>
						</tr>
					</table>
					</form>
				</div>
			</div>
            
			<div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="tabel_3 table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center"  width="3%">No</th>
                                    <th class="text-center"  width="12%">Kode Order</th>
                                    <th class="text-center"  >No Meja</th>
                                    <th class="text-center"  >Nama Kasir</th>
                                    <th class="text-center"  >Tanggal dan Jam</th>
                                    <th class="text-center"  >Sub Total</th>
                                    <th class="text-center"  width="5%">Diskon</th>
                                    <th class="text-center"  >Total </th>
                                    <th class="text-center"  width="10%"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $ttl_pemb_sub = 0;
                                $ttl_pemb_all = 0;
                                foreach ($get_transOrderJoinUser as $row) {
                                    if($row->id_user == $a['id']){
                                    $ttl_pemb = @($row->ttl_pembayaran - ($row->ttl_pembayaran * $row->diskon / 100));
									$ppn = $row_pro->ppn;
									$ttl_ppn = @($ttl_pemb * $ppn / 100);
									$ttl_ppn_pem = $ttl_pemb + $ttl_ppn;
                                    
                                    $ttl_pemb_sub += $row->ttl_pembayaran;
                                    $ttl_pemb_all += $ttl_ppn_pem;
									?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row->kode_order; ?></td>
                                        <td class="text-center"><?= $row->no_meja; ?></td>
                                        <td class=""><?= $row->nama_admin; ?></td>
                                        <td class="text-center"><?= Tgl_indo::indo($row->tanggal) . "<br>" . $row->jam; ?></td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?= number_format($row->ttl_pembayaran, 2, ',', '.'); ?></td>
                                        <td class="text-center"><?= $row->diskon; ?> %</td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?= number_format($ttl_ppn_pem, 2, ',', '.'); ?></td>
                                        <td class="text-center">
										<?php 
											if($row->status==""){ ?>
												<a href="<?= base_url(); ?>index.php/transaksi/Trans_order/edit_transaksi.html?kode_order=<?= $row->kode_order; ?>" 
                                                   class="btn btn-flat btn-xs btn-warning"><i class="fa fa-pencil"></i></a> &nbsp;
										<?php
											}
										?>
                                                <!--                                            <button class="btn btn-flat btn-sm btn-danger" data-toggle="modal" 
                                                                                                        data-target="#deleteOrder" 
                                                                                                        data-kode_order = "<?= $row->kode_order; ?>"
                                                                                                        data-ket="hapus"><i class="fa fa-trash"></i></button>-->
												<a target="_blank" href="<?= base_url(); ?>index.php/admin/laporan/laporan_html/cetak_strukOrder.html?kode_order=<?= $row->kode_order; ?>" class="btn btn-success btn-xs btn-flat"><i class="fa fa-print"></i> Print</a>
                                        </td>
                                    </tr>
                                    <?php
                                } }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center"  colspan="5">T o t a l</th>
                                    <th class="text-right"  ><span class="pull-left">Rp. </span><?= number_format($ttl_pemb_sub, 2, ',', '.'); ?></th>
                                    <th class="text-center"  width="5%"></th>
                                    <th class="text-right"  ><span class="pull-left">Rp. </span><?= number_format($ttl_pemb_all, 2, ',', '.'); ?></th>
                                    <th class="text-center" ></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
