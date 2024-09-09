<?php
class M_logistik extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	function simpanTimbangan()
	{
		$thn            = date('Y');
		$no_timbangan   = $this->m_fungsi->urut_transaksi('TIMBANGAN').'/TIMB'.'/'.$thn;
		$status_input   = $this->input->post('sts_input');

		if($status_input == 'add')
		{
			$data_header = array(
				'no_timbangan'   => $no_timbangan,
				'jns'     		 => $this->input->post('jns'),
				'id_hub_occ'     => $this->input->post('hub_occ'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
			);
		
			$result_header = $this->db->insert('m_jembatan_timbang', $data_header);	
				
		}else{

			$data_header = array(
				'no_timbangan'   => $this->input->post('no_timbangan'),
				'id_hub_occ'     => $this->input->post('hub_occ'),
				'jns'     		 => $this->input->post('jns'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
			);
		
			
			$this->db->where('id_timbangan', $this->input->post('id_timbangan'));
			$result_header = $this->db->update('m_jembatan_timbang', $data_header);		
			
		}
		return $result_header;
	}

	function deleteTimbangan()
	{
		$this->db->where('id_timbangan', $_POST["id_timbangan"]);
		$data = $this->db->delete('m_jembatan_timbang');
		return [
			'data' => $data,
		];
	}

	function save_inv_bhn()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$tgl_inv       = $this->input->post('tgl_inv');
			$tanggal       = explode('-',$tgl_inv);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			
			$aka         = $this->input->post('aka_hub_occ');
			$c_no_inv    = $this->m_fungsi->urut_transaksi('INV_BHN_'.$aka);
			$m_no_inv    = $c_no_inv.'/INV/BHN/'.$aka.'/'.$bulan.'/'.$tahun;

			$data_header = array(
				'no_inv_bhn'    => $m_no_inv,
				'no_timb'       => $this->input->post('no_timbangan'),
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
				
			);

			$result_header = $this->db->insert('invoice_bhn', $data_header);

			return $result_header;
			
		}else{
			
			$no_inv_bhn    = $this->input->post('no_inv_bhn');
			$data_header = array(
				'no_inv_bhn'    => $no_inv_bhn,
				'no_timb'       => $this->input->post('no_timbangan'),
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
			);

			$this->db->where('id_inv_bhn', $this->input->post('id_inv_bhn'));
			$result_header = $this->db->update('invoice_bhn', $data_header);
			return $result_header;
		}
		
	}

	function save_inv_beli_bhn()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$tgl_inv       = $this->input->post('tgl_inv');
			$tanggal       = explode('-',$tgl_inv);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			
			$c_no_inv    = $this->m_fungsi->urut_transaksi('INV_BHN');
			$m_no_inv    = $c_no_inv.'/INV/BHN/'.$bulan.'/'.$tahun;

			$data_header = array(
				'no_inv_bhn'    => $m_no_inv,
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'id_hub'        => $this->input->post('hub_bhn'), 
				'suplier'       => $this->input->post('supp'), 
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
				
			);

			$result_header = $this->db->insert('invoice_beli_bhn', $data_header);

			return $result_header;
			
		}else{
			
			$no_inv_bhn    = $this->input->post('no_inv_bhn');
			$data_header = array(
				'no_inv_bhn'    => $no_inv_bhn,
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'id_hub'        => $this->input->post('hub_bhn'), 
				'suplier'       => $this->input->post('supp'), 
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
			);

			$this->db->where('id_inv_bhn', $this->input->post('id_inv_bhn'));
			$result_header = $this->db->update('invoice_beli_bhn', $data_header);
			return $result_header;
		}
		
	}

	function verif_inv_bhn()
	{
		$no_inv       = $this->input->post('no_inv');
		$acc          = $this->input->post('acc');
		$app          = "";

		// KHUSUS ADMIN //
		if ( in_array($this->session->userdata('level'), ['Admin','Owner']) ) 
		{
			if($acc=='N')
			{
				$this->db->set("acc_owner", 'Y');
			}else{
				
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_inv_bhn",$no_inv);
			$valid = $this->db->update("invoice_bhn");

		} else {
			
			$valid = false;

		}

		return $valid;
	}
	

}
