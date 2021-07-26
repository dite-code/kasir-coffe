<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$a = $this->session->userdata('is_login');
$msg = $this->session->flashdata('msg');
$tipe = $this->session->flashdata('tipe');
$lambang = 'fa-check';
$notify = 'Sukses!';
echo $javasc
?>   

<div class="box box-warning">
	<center><span id="load" style="display:none"><img src='<?= base_url(); ?>assets/img/ajax-loader.gif' ></span></center>
    <div class="box-body">
		<div class="table-responsive">
            <table class="tabel_3 table table-bordered table-hover" id="tabel_menu" width="100%">
                <thead>
                    <tr>
                        <th class="text-center"  width="20%">Kode Menu</th>
                        <th class="text-center"  width="40%">Jenis Menu</th>
                        <th class="text-center"  width="40%">Jenis Olahan</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($get_dataJenisMenu as $row) {
                        ?>
                        <tr>
                            <td class="text-center"><?= $row->id; ?></td>
                            <td class=""><?= $row->nama_jenis_menu; ?></td>
                            <td class="text-center">
								<select class="form-control select2" onchange="ganti_olahan(<?= $row->id; ?>, this.value)">
									<option <?php if($row->jenis_olahan==0){echo "selected";} ?> value="0" disabled>Pilih Jenis Olahan</option>
									<option <?php if($row->jenis_olahan==1){echo "selected";} ?> value="1">Olahan Dapur</option>
									<option <?php if($row->jenis_olahan==2){echo "selected";} ?> value="2">Olahan Bar</option>
								</select>
								
							</td>
                            
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
	
	
	
		

    </div>
    <div class="box-footer">
        <center><span id="load" style="display:none"><img src='<?= base_url(); ?>assets/img/ajax-loader.gif' ></span></center>
                <div id='lihatMenu'></div>
    </div>

</div><!-- /.box -->     
<div class="modal fade" id="aksi_jns_menu" role="dialog" aria-labelledby="editlabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" id="close-modal"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editlabel"></h4>
            </div>
            <form id="form_jenis_menu">
                <div class="modal-body">
                    <div class="hapusHidden">
                        <h4 class="alert bg-gray-active">Apakah Andayakin akan menghapus jenis menu ini . . ??</h4>
                    </div>

                    <div class="hapusHiddenGagal">
                        <h4 class="alert bg-gray">Anda Tidak bisa menghapus ini karena masih terkait dengan data menu!!<br></h4>
                        <note>*) Silahkan kosongkan terlebih dahulu menu pada jenis menu ini.</note>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Jenis Menu</label>
                                <input type='text' name='nama_jenis_menu' class="form-control nama_jenis_menu" id='nama_jenis_menu' autofocus="true" placeholder="Nama Pengguna">
                            </div>
                        </div>
                        <input type='hidden' name='id' class="form-control id" id='id' placeholder="id">
                        <input type='hidden' name='ket' class="form-control ket" id='ket' placeholder="ket">
                    </div>
                </div>
                <div class="modal-footer bg-gray-active">
                    <div class="submit"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    
	function ganti_olahan(id_jenis_menu, jenis_olahan) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>index.php/admin/Master/ganti_olahan',
            data: {
				id_jenis_menu: id_jenis_menu,
				jenis_olahan: jenis_olahan
			},
            beforeSend: function () {
                $('#load').show();
            },
            success: function (respont) {
                $('#load').hide();
				if (respont=='0'){alert('Gagal Mengubah!!!');}
                //$('#lihatMenu').html(respont);
            }
        });
    }

	
	$('#aksi_jns_menu').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ket = button.data('ket');
        var nama_jenis_menu = button.data('nama_jenis_menu');
        var id = button.data('id');
        var jml_menu = button.data('jml_menu');
        var modal = $(this);
        modal.find('.modal-body input.ket').val(ket);
        if (ket == 'tambah') {
            modal.find('#editlabel').html('<b>Form Tambah Jenis Menu</b>');
            modal.find('.modal-body input.nama_jenis_menu').val('').removeAttr('readonly', 'readonly');
            modal.find('.modal-body input.id').val('').removeAttr('readonly', 'readonly');
            modal.find('.hapusHidden').addClass('hidden');
            modal.find('.hapusHiddenGagal').addClass('hidden');
            modal.find('.submit').html('<button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>');
        } else if (ket == 'hapus') {
            if (jml_menu == 0) {
                modal.find('#editlabel').html('<b>Form Hapus Data User</b>');
                modal.find('.modal-body input.nama_jenis_menu').val(nama_jenis_menu).attr('readonly', 'readonly');
                modal.find('.modal-body input.id').val(id);
                modal.find('.hapusHiddenGagal').addClass('hidden');
                modal.find('.hapusHidden').removeClass('hidden');
                modal.find('.submit').html('<button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>');
            } else {
                modal.find('.hapusHiddenGagal').removeClass('hidden');
                modal.find('.hapusHidden').addClass('hidden');
                modal.find('.submit').html('<button type="submit" disabled class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>');
            }
        }
    });
    $('#form_jenis_menu').validate({
        rules: {
            nama_jenis_menu: {required: true}
        },
        submitHandler: function (form) {
            var ket = $('#ket').val();
            if (ket == 'tambah') {
                var url_form = '<?= base_url(); ?>index.php/admin/Master/insertJnsMenu';
            } else if (ket == 'hapus') {
                var url_form = '<?= base_url(); ?>index.php/admin/Master/deleteJnsMenu';
            }
            $.ajax({
                type: 'POST',
                url: url_form,
                data: $(form).serialize(),
                success: function (data) {
                    if (data == 'true') {
                        sukses(ket);
                    } else {
                        gagal(ket);
                    }
                }
            });
        }
    });

function lihat_menu(id_jenis_menu) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>index.php/admin/Master/lihat_menu',
            data: {id_jenis_menu: id_jenis_menu},
            beforeSend: function () {
                $('#load').show();
            },
            success: function (respont) {
                $('#load').hide();
                $('#lihatMenu').html(respont);
            }
        });
    }

    function sukses(ket) {
        $("#notivs").html('<div class="alert alert-success alert-dismissable animated fadeIn" id="notification"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> Sukses!</h4> Berhasil di ' + ket + '. </div>');
        $('#close-modal').trigger("click");
        setTimeout(function () {
            location.reload();
            $('#notification').fadeOut('slow');
        }, 2000);
    }
    function gagal(ket) {
        $("#notivs").html('<div class="alert alert-danger alert-dismissible" id="alert-notification"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Peringatan!</h4> Gagal Di Simpan. </div>');
        $('#close-modal').trigger("click");
        setTimeout(function () {
            $('#alert-notification').fadeOut('slow');
        }, 2000);
    }

    $(document).ready(function () {
        var heights = $(".max").map(function () {
            return $(this).height();
        }).get(),
                maxHeight = Math.max.apply(null, heights);
        $(".max").height(maxHeight);
    });
</script>