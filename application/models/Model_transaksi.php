<?php
	
	/*
		* To change this license header, choose License Headers in Project Properties.
		* To change this template file, choose Tools | Templates
		* and open the template in the editor.
	*/
	
	/**
		* Description of Model_transaksi
		*
		* @author yusda08
	*/
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Model_transaksi extends CI_Model {
		
		public function get_transOrderJoinUser() {
			$query = $this->db->query("select a.*, b.nama_admin, aa.ttl_pembayaran from trans_order a 
			join user b on a.id_user=b.id
			left join (select sum(harga_menu*qty) as ttl_pembayaran, kode_order  from trans_order_detail group by kode_order) 
			aa on aa.kode_order=a.kode_order order by a.tanggal desc, jam desc");
			if ($query) {
				return $query->result();
				} else {
				return false;
			}
		}
		
		public function get_transOrderJoinPelayanTgl($tgl_dari, $tgl_sampai) {
			$query = $this->db->query("select a.*, b.nama_admin, aa.ttl_pembayaran from trans_order a 
			join user b on a.id_user=b.id
			left join (select sum(harga_menu*qty) as ttl_pembayaran, kode_order  from trans_order_detail group by kode_order) 
			aa on aa.kode_order=a.kode_order where a.tanggal BETWEEN '$tgl_dari' and '$tgl_sampai' order by a.tanggal desc, jam desc");
			if ($query) {
				return $query->result();
				} else {
				return false;
			}
		}
		
		public function cek_meja_kosong($tgl_dari, $tgl_sampai) {
			$query = $this->db->query("select no_meja from trans_order where status='' and (tanggal BETWEEN '$tgl_dari' and '$tgl_sampai') order by no_meja");
			if ($query) {
				$i=0;
				$hasil=$query->result();
				foreach ($hasil as $row) {
					$data[$i]=$row->no_meja;
					$i++;
				}
				return $data;
				} else {
				return false;
			}
		}
		
		public function cek_meja($no_meja,$tanggal) {
			$query = $this->db->query("select * from trans_order a 
			where a.no_meja='$no_meja' and a.tanggal='$tanggal' and a.status=''");
			if ($query) {
				return $query->row();
				} else {
				return false;
			}
		}
		
		public function aktifkan_meja($no_meja,$kode_order) {
			$data['no_meja'] = $no_meja;
			$data['kode_order'] = $kode_order;
			$data['id_user'] = 100;
			$data['tanggal'] = date('Y-m-d');
			$data['jam'] = date('H:i:s');
			$data['tunai'] = 0;
			$this->db->insert('trans_order', $data);
			return $this->db->affected_rows();
		}
		
		
		public function get_transOrderJoinUserTgl($tgl_dari, $tgl_sampai) {
			$query = $this->db->query("select a.*, b.nama_admin, aa.ttl_pembayaran from trans_order a 
			join user b on a.id_user=b.id
			left join (select sum(harga_menu*qty) as ttl_pembayaran, kode_order  from trans_order_detail group by kode_order) 
			aa on aa.kode_order=a.kode_order where a.tanggal BETWEEN '$tgl_dari' and '$tgl_sampai' order by a.tanggal desc, jam desc");
			if ($query) {
				return $query->result();
				} else {
				return false;
			}
		}
		
		public function get_laphar($tgl) {
			$query = $this->db->query("select a.*, b.nama_admin, aa.ttl_pembayaran from trans_order a 
			join user b on a.id_user=b.id
			left join (select sum(harga_menu*qty) as ttl_pembayaran, kode_order  from trans_order_detail group by kode_order) 
			aa on aa.kode_order=a.kode_order where a.tanggal='$tgl' order by a.tanggal desc, jam asc");
			if ($query) {
				return $query->result();
				} else {
				return false;
			}
		}
		
		public function get_lapbulan($bulan, $tahun) {
			$query = $this->db->query("select a.*, b.nama_admin, sum(aa.ttl_pembayaran) as ttl_pembayaran, sum(bb.harga) as ttl_belanja from trans_order a 
			join user b on a.id_user=b.id
		left join trans_pengeluaran bb on bb.tanggal=a.tanggal
		left join (select sum(harga_menu*qty) as ttl_pembayaran, kode_order  from trans_order_detail group by kode_order) 
		aa on aa.kode_order=a.kode_order where YEAR(a.tanggal)='$tahun' and MONTH(a.tanggal)='$bulan' group by DAY(a.tanggal)");
		
        if ($query) {
		return $query->result();
        } else {
		return false;
        }
		}
		
		public function get_laptahun($tahun) {
        $query = $this->db->query("select a.*, b.nama_admin, sum(aa.ttl_pembayaran) as ttl_pembayaran from trans_order a 
		join user b on a.id_user=b.id
		left join (select sum(harga_menu*qty) as ttl_pembayaran, kode_order  from trans_order_detail group by kode_order) 
		aa on aa.kode_order=a.kode_order where YEAR(a.tanggal)='$tahun' group by MONTH(a.tanggal)");
		
        if ($query) {
		return $query->result();
        } else {
		return false;
        }
		}
		
		public function get_transOrderDetail($kode_order) {
        $query = $this->db->query("select * from trans_order_detail where kode_order='$kode_order'");
        if ($query) {
		return $query->result();
        } else {
		return false;
        }
		}
		
		public function get_transOrder($kode_order) {
        $query = $this->db->query("select * from trans_order where kode_order='$kode_order'");
        if ($query) {
		return $query->row();
        } else {
		return false;
        }
		}
		
		public function get_transOrderJoinDetailWhereTgl($date) {
        $query = $this->db->query("select sum(ceil(a.harga_menu*a.qty)) as total_hari from trans_order_detail a join trans_order b on a.kode_order=b.kode_order where b.tanggal='$date'");
        if ($query) {
		return $query->row()->total_hari;
        } else {
		return false;
        }
		}
		public function get_transPengeluaranWhereTgl($date) {
        $query = $this->db->query("select sum(a.harga) as ttl_pengeluaran_hr from trans_pengeluaran a where a.tanggal='$date'");
        if ($query) {
		return $query->row()->ttl_pengeluaran_hr;
        } else {
		return false;
        }
		}
		
		public function get_transOrderJoinDetail() {
        $query = $this->db->query("select sum(ceil(a.harga_menu*a.qty)) as total from trans_order_detail a join trans_order b on a.kode_order=b.kode_order");
        if ($query) {
		return $query->row()->total;
        } else {
		return false;
        }
		}
		public function get_transPengeluaran() {
        $query = $this->db->query("select sum(a.harga) as ttl_pengeluaran from trans_pengeluaran a");
        if ($query) {
		return $query->row()->ttl_pengeluaran;
        } else {
		return false;
        }
		}
		
		public function get_transTemporaryDetail($kode_order) {
        $query = $this->db->query("select * from temporary_order_detail where kode_order='$kode_order'");
        if ($query) {
		return $query->result();
        } else {
		return false;
        }
		}
		
		public function get_transTemporaryDetailWhereKd($kode_menu, $kode_order) {
        $query = $this->db->query("select * from temporary_order_detail where kode_menu='$kode_menu' and kode_order='$kode_order' ");
        if ($query) {
		return $query->row();
        } else {
		return false;
        }
		}
		
		public function get_transOrderDetailWhereKd($kode_menu, $kode_order) {
        $query = $this->db->query("select * from trans_order_detail where kode_menu='$kode_menu' and kode_order='$kode_order' ");
        if ($query) {
		return $query->row();
        } else {
		return false;
        }
		}
		
		public function get_transPengeluaranJoinUser() {
        $query = $this->db->query("select a.*, b.nama_admin from trans_pengeluaran a join user b on a.id_user=b.id order by tanggal desc");
        if ($query) {
		return $query->result();
        } else {
		return false;
        }
		}
		
		public function get_transPengeluaranJoinUserTgl($tgl_dari, $tgl_sampai) {
        $query = $this->db->query("select a.*, b.nama_admin from trans_pengeluaran a join user b on a.id_user=b.id where a.tanggal BETWEEN '$tgl_dari' and '$tgl_sampai' order by tanggal desc");
        if ($query) {
		return $query->result();
        } else {
		return false;
        }
		}
		}
				