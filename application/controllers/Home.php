<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once(dirname(__FILE__) . "/Temp.php");
	
	class Home extends Temp {
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Model_aksi');
			$this->load->model('Model_transaksi');
			$this->load->model('Tgl_indo');
			$this->load->model('Model_master');
			$this->load->model('Model_setting');
		}
		
		public function admin() {
			if ($this->session->userdata('is_login')) {
				$a = $this->session->userdata('is_login');
				$caritanggal = $this->input->get('caritanggal');
				if ($caritanggal==null){
					//echo "tanggal kosong";
					$caritanggal = date('Y-m-d');
				}
				if ($a['level_user'] == 1) {
					$data = $this->layout_admin();
					$data['name_page'] = 'Dasboard';
					$data['name_page_small'] = 'Admin';
					$record['javasc'] = $this->load->view('admin/js', NULL, TRUE);
					$record['ttl_hr'] = $this->Model_transaksi->get_transOrderJoinDetailWhereTgl(date('Y-m-d'));
					$record['total'] = $this->Model_transaksi->get_transOrderJoinDetail();
					$record['ttl_pengeluaran_hr'] = $this->Model_transaksi->get_transPengeluaranWhereTgl(date('Y-m-d'));
					$record['ttl_pengeluaran'] = $this->Model_transaksi->get_transPengeluaran();
					$record['caritanggal'] = $caritanggal;
					$data['content'] = $this->load->view('admin/dasboard', $record, TRUE);
					$this->load->view('temp_admin/layout', $data);
					} else {
					redirect('login');
				}
			}
		}
		
		public function kasir() {
			if ($this->session->userdata('is_login')) {
				$a = $this->session->userdata('is_login');
				$caritanggal = $this->input->get('caritanggal');
				if ($caritanggal==null){
					//echo "tanggal kosong";
					$caritanggal = date('Y-m-d');
				}
				if ($a['level_user'] == 2) {
					$data = $this->layout_kasir();
					//                $data['name_page'] = 'ada';
					//                $data['name_page_small'] = 'Kasir';
					$record['javasc'] = $this->load->view('kasir/js', NULL, TRUE);
					$record['kode_order'] = "PBB-" . $this->Model_aksi->getGUID();
					$record['get_transOrderJoinUser'] = $this->Model_transaksi->get_transOrderJoinUsertgl($caritanggal,$caritanggal);
					$record['get_transPengeluaranJoinUser'] = $this->Model_transaksi->get_transPengeluaranJoinUsertgl($caritanggal,$caritanggal);
					$record['last_serah_terima'] = $this->Model_transaksi->last_serah_terima();
					//echo "tes";
					//print_r($a);
					//echo $record['last_serah_terima']->sisasaldo;
					$record['saldo']=$record['last_serah_terima']->sisasaldo;
					foreach ($record['get_transOrderJoinUser'] as $row) {
						if(($row->id_user == $a['id']) or ($row->id_user == 100)){
							$ttl_pemb = @($row->ttl_pembayaran - ($row->ttl_pembayaran * $row->diskon / 100));
							$ttl_ppn = @($ttl_pemb * $row_pro->ppn / 100);
							$record['saldo'] += $ttl_pemb + $ttl_ppn;
						}
					}
					foreach ($record['get_transPengeluaranJoinUser'] as $row) {
						if ($a['id'] == $row->id_user) {
							$record['saldo'] -= $row->harga;
						}
					}
					$record['caritanggal'] = $caritanggal;
					
					$data['content'] = $this->load->view('kasir/baranda', $record, TRUE);
					//var_dump($record);
					$this->load->view('temp_kasir/layout', $data);
				} 
			}
			else {
				redirect('login');
			}
			
		}
		
		public function rekap() {
			if ($this->session->userdata('is_login')) {
				$a = $this->session->userdata('is_login');
				$caritanggal = $this->input->get('caritanggal');
				if ($caritanggal==null){
					//echo "tanggal kosong";
					$caritanggal = date('Y-m-d');
				}
				if ($a['level_user'] == 2) {
					$data = $this->layout_kasir();
					//                $data['name_page'] = 'ada';
					//                $data['name_page_small'] = 'Kasir';
					$record['javasc'] = $this->load->view('kasir/js', NULL, TRUE);
					$record['kode_order'] = "PBB-" . $this->Model_aksi->getGUID();
					$record['get_rekap'] = $this->Model_transaksi->get_rekap(date('Y'),$a['id']);
					//print_r($record['get_serah_terima']);
					$record['caritanggal'] = $caritanggal;
					$data['content'] = $this->load->view('kasir/rekap', $record, TRUE);
					//var_dump($record);
					$this->load->view('temp_kasir/layout', $data);
				} 
			}
			else {
				redirect('login');
			}
			
		}
		
		public function histori() {
			if ($this->session->userdata('is_login')) {
				$a = $this->session->userdata('is_login');
				$caritanggal = $this->input->get('caritanggal');
				if ($caritanggal==null){
					//echo "tanggal kosong";
					$caritanggal = date('Y-m-d');
				}
				if ($a['level_user'] == 2) {
					$data = $this->layout_kasir();
					//                $data['name_page'] = 'ada';
					//                $data['name_page_small'] = 'Kasir';
					$record['javasc'] = $this->load->view('kasir/js', NULL, TRUE);
					$record['kode_order'] = "PBB-" . $this->Model_aksi->getGUID();
					$record['get_serah_terima'] = $this->Model_transaksi->get_serah_terima();
					//print_r($record['get_serah_terima']);
					$record['caritanggal'] = $caritanggal;
					$data['content'] = $this->load->view('kasir/histori', $record, TRUE);
					//var_dump($record);
					$this->load->view('temp_kasir/layout', $data);
				} 
			}
			else {
				redirect('login');
			}
			
		}
		
		public function pelayan() {
			$log = array(
			'id' => '100',
			'level_user' => '9',
			'nm_level' => 'pelayan'
			);
			$this->session->set_userdata('is_login', $log);
			$a = $this->session->userdata('is_login');
			$caritanggal = date('Y-m-d');
			$profil = $this->Model_setting->get_setProfil();
			$data['meja'] = $profil->jml_meja;
			$data['kode_order'] = "PBB-" . $this->Model_aksi->getGUID();
			$data['mejaAktif'] = $this->Model_transaksi->cek_meja_kosong($caritanggal,$caritanggal);
			$this->load->view('kasir/pelayan', $data);			
		}
		
		public function meja() {
			$no_meja = $this->input->get('no_meja');
			$a = $this->session->userdata('is_login');
			$caritanggal = date('Y-m-d');
			//$profil= $this->Model_setting->get_setProfil();
			//$data['meja'] = $profil['jml_meja'];
			$data['no_meja'] = $no_meja;
			$data['order_meja'] = $this->Model_transaksi->cek_meja($no_meja, $caritanggal);
			if($data['order_meja']->kode_order==null){$data['order_meja']->kode_order="PBB-" . $this->Model_aksi->getGUID($no_meja);;}
			$data['get_dataMenuJoinFoto'] = $this->Model_master->get_dataMenuJoinFoto();
            $data['get_dataJenisMenu'] = $this->Model_master->get_dataJenisMenu();
			$data['order'] = $this->Model_transaksi->get_transOrderDetail($data['order_meja']->kode_order);
			//$data['keranjang'] = $this->ajax_pelayan($data['order_meja']->kode_order, $data);
			//print_r($data['order']);
			$this->load->view('kasir/meja', $data);			
		}
		
		function ajax_pelayan($kode_order) {
			//echo $kode_order;
			$row_ord = $this->Model_transaksi->get_transOrder($kode_order);
			$record['tunai'] = $row_ord->tunai;
			$record['row_pro']= $this->Model_setting->get_setProfil();
			$record['order'] = $this->Model_transaksi->get_transOrderDetail($kode_order);
			$data = $this->load->view('transaksi/ajax/pelayan', $record);
		}
		
		function ajax_cek_order() {
			$caritanggal = date('Y-m-d');
			$time= $this->input->post('last');
			//echo $time;
			$new_order = $this->Model_transaksi->cek_transOrder($caritanggal, $time);
			if ($new_order->num_rows()>0){
				echo "1";
			}
		}
		
		function simpanserahterima() {
			$a = $this->session->userdata('is_login');
			$penarikan= $this->input->post('penarikan');
			$sisasaldo= $this->input->post('sisasaldo');
			//echo $penarikan;
			$data["id_user"] = $a['id'];
			$data["penarikan"] = $penarikan;
			$data["sisasaldo"] = $sisasaldo;
			$data["tanggal"] = date('Y-m-d');
			$data["jam"] = date('H:i:s');
			//print_r($data);
			$query = $this->Model_aksi->insert('serah_terima', $data);
			if ($query) {
				echo "1";
				//print_r($query);
				$profil['saldo']=$sisasaldo;
				$kurangisaldo = $this->Model_aksi->update('id', 1, 'profil', $profil);
			}
			
		}
		
	}
