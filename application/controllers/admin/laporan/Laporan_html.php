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

class Laporan_html extends Temp {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_aksi');
        $this->load->model('Model_transaksi');
        $this->load->model('Model_setting');
        $this->load->model('Tgl_indo');
    }

    public function index() {
        if ($this->session->userdata('is_login')) {
            $a = $this->session->userdata('is_login');
            if ($a['level_user'] == 1) {
                $data = $this->layout_admin();
                $data['name_page'] = 'Laporan';
                $data['name_page_small'] = 'Admin';
                $record['javasc'] = $this->load->view('admin/js', NULL, TRUE);
                $record['get_setUser'] = $this->Model_setting->get_setUser();
                $record['get_transOrderJoinUser'] = $this->Model_transaksi->get_transOrderJoinUser();
                $data['content'] = $this->load->view('admin/laporan/laporan_index', $record, TRUE);
                $this->load->view('temp_admin/layout', $data);
            } else {
                redirect('login');
            }
        }
    }
    
    function cetak_bill() {
        $kode_order = $this->input->get('kode_order');
        $record['kode_order'] = $kode_order;
        //$record['get_transOrderJoinUser'] = $this->Model_transaksi->get_transOrderJoinUser();
        $record['get_transOrderDetail'] = $this->Model_transaksi->get_transOrderDetail($kode_order);
        $record['row_pro'] = $this->Model_setting->get_setProfil();
		$record['row_ord'] = $this->Model_transaksi->get_transOrder($kode_order);
        //var_dump($record);
		$this->load->view('admin/laporan/cetak_bill', $record);
//        $this->load->view('admin/laporan/paper', $data);
    }

    function cetak_strukOrder() {
        $kode_order = $this->input->get('kode_order');
        $record['kode_order'] = $kode_order;
        //$record['get_transOrderJoinUser'] = $this->Model_transaksi->get_transOrderJoinUser();
        $record['get_transOrderDetail'] = $this->Model_transaksi->get_transOrderDetail($kode_order);
        $record['row_pro'] = $this->Model_setting->get_setProfil();
		$record['row_ord'] = $this->Model_transaksi->get_transOrder($kode_order);
        //var_dump($record);
		$this->load->view('admin/laporan/cetak_struk', $record);
//        $this->load->view('admin/laporan/paper', $data);
    }

	function cetak_lapharian() {
        $tanggal = $this->input->get('tanggal');
        $record['tgl'] = $tanggal;
        //$record['get_transOrderJoinUser'] = $this->Model_transaksi->get_transOrderJoinUser();
        $record['laphar'] = $this->Model_transaksi->get_laphar($tanggal);
        $record['row_pro'] = $this->Model_setting->get_setProfil();
		$record['row_ord'] = $this->Model_transaksi->get_transOrder($kode_order);
        //var_dump($record);
		$this->load->view('admin/laporan/lap-harian', $record);
//        $this->load->view('admin/laporan/paper', $data);
    }
	function cetak_lapbulanan() {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $record['bln'] = $bulan;
        $record['thn'] = $tahun;
        //$record['get_transOrderJoinUser'] = $this->Model_transaksi->get_transOrderJoinUser();
        $record['laphar'] = $this->Model_transaksi->get_lapbulan($bulan, $tahun);
        $record['row_pro'] = $this->Model_setting->get_setProfil();
		$record['row_ord'] = $this->Model_transaksi->get_transOrder($kode_order);
        //var_dump($record);
		$this->load->view('admin/laporan/lap-bulanan', $record);
//        $this->load->view('admin/laporan/paper', $data);
    }
	
	function cetak_laptahunan() {
        $tahun = $this->input->get('tahun');
        $record['bln'] = $bulan;
        $record['thn'] = $tahun;
        //$record['get_transOrderJoinUser'] = $this->Model_transaksi->get_transOrderJoinUser();
        $record['laptahun'] = $this->Model_transaksi->get_laptahun($tahun);
        $record['row_pro'] = $this->Model_setting->get_setProfil();
		$record['row_ord'] = $this->Model_transaksi->get_transOrder($kode_order);
        //var_dump($record);
		$this->load->view('admin/laporan/lap-tahunan', $record);
//        $this->load->view('admin/laporan/paper', $data);
    }

}
