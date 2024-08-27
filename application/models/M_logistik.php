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
				'input_t'     	 => $this->input->post('plh_input'),
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

	function save_invoice()
	{
		$cek_inv        = $this->input->post('cek_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po');
		$pajak          = $this->input->post('pajak');

		($type=='roll')? $type_ok=$type : $type_ok='SHEET_BOX';
		
		($pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
		$c_no_inv_kd   = $this->input->post('no_inv_kd');

		if($cek_inv=='revisi')
		{
			$c_no_inv    = $this->input->post('no_inv');
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}else{
			$c_no_inv    = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok);
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $this->input->post('type_po'),
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			'status'             => 'Open',
		);
	
		$result_header = $this->db->insert('invoice_header', $data_header);

		$db2              = $this->load->database('database_simroll', TRUE);
		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		if ($type == 'roll')
		{
			$query = $db2->query("SELECT c.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight)-SUM(seset) AS weight,b.no_po,b.no_po_sj,b.no_surat
			FROM m_timbangan a 
			INNER JOIN pl b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			WHERE b.no_pl_inv = '0' AND b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
			GROUP BY b.no_po,a.nm_ker,a.g_label,a.width 
			ORDER BY a.g_label,b.no_surat,b.no_po,a.nm_ker DESC,a.g_label,a.width ")->result();

			$no = 1;
			foreach ( $query as $row ) 
			{

				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok   = $this->input->post('hrg['.$no.']');
					$hasil_ok   = $this->input->post('hasil['.$no.']');
					$id_pl_roll = $this->input->post('id_pl_roll['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => $this->input->post('seset['.$no.']'),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$update_no_pl   = $db2->query("UPDATE pl set no_pl_inv = 1 where id ='$id_pl_roll'");

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}else{
			if ($type == 'box')
			{				
				$where_po    = 'and d.po ="box"';
			}else{
				$where_po    = 'and d.po is null';
			}
			
			$query = $db2->query("SELECT b.id as id_pl, a.qty, a.qty_ket, b.tgl, b.id_perusahaan, c.nm_perusahaan, b.no_surat, b.no_po, b.no_kendaraan, d.item, d.kualitas, d.ukuran2,d.ukuran, 
			d.flute, d.po
			FROM m_box a 
			JOIN pl_box b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			JOIN po_box_master d ON b.no_po=d.no_po and a.ukuran=d.ukuran
			WHERE b.no_pl_inv = '0' AND b.tgl = '$tgl_sj' AND b.id_perusahaan='$id_perusahaan' $where_po
			ORDER BY b.tgl desc ")->result();
			
			$no = 1;
			foreach ( $query as $row ) 
			{			

				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok   = $this->input->post('hrg['.$no.']');
					$hasil_ok   = $this->input->post('hasil['.$no.']');
					$id_pl_roll = $this->input->post('id_pl_roll['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('item['.$no.']'),
						'g_label'      => $this->input->post('ukuran['.$no.']'),
						'kualitas'      => $this->input->post('kualitas['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$update_no_pl   = $db2->query("UPDATE pl_box set no_pl_inv = 1 where id ='$id_pl_roll'");

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
			
	}

	function simpanGudang()
	{
		$id_gudang = $_POST["id_gudang"];
		$good = $_POST["good"];
		$reject = $_POST["reject"];
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$no_po = $_POST["no_po"];
		$i = $_POST["i"];

		// UPDATE GUDANG
		if($good < 0 || $good == 0 || $good == ""){
			$data = false;
			$msg = "HASIL TIDAK BOLEH KOSONG!";
		}else if($reject < 0 || $reject == ""){
			$data = false;
			$msg = "REJECT HARUS DIISI!";
		}else{
			$this->db->set("gd_good_qty", $good);
			$this->db->set("gd_reject_qty", $reject);
			$this->db->set("gd_cek_spv", 'Close');
			$this->db->where("id_gudang", $id_gudang);
			$data = $this->db->update("m_gudang");
			$msg = "OK!";
		}

		if($opsi == 'cor'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'flexo'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'finishing'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing!='0'";
		}else{
			$where = "";
		}
		// UPDATE HEADER SPAN
		$h_span = $this->db->query("SELECT COUNT(g.id_gudang) AS h_jml FROM m_gudang g
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		WHERE g.gd_cek_spv='Open' AND g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' $where
		GROUP BY p.nm_pelanggan,g.gd_id_produk")->row();
		// UPDATE ISI SPAN
		$i_span = $this->db->query("SELECT COUNT(g.id_gudang) AS i_jml FROM m_gudang g
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		WHERE g.gd_cek_spv='Open' AND g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' $where
		GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po")->row();

		return [
			'data' => $data,
			'msg' => $msg,
			'h_span' => $h_span,
			'i_span' => $i_span,
			'i' => $i,
		];
	}

	function update_invoice()
	{
		$id_inv         = $this->input->post('id_inv');
		$cek_inv        = $this->input->post('cek_inv2');
		$c_no_inv_kd    = $this->input->post('no_inv_kd');
		$c_no_inv       = $this->input->post('no_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po2');
		$pajak          = $this->input->post('pajak2');
		$no_inv_old     = $this->input->post('no_inv_old');

		$m_no_inv       = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $type,
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak2'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			'status'             => 'Open',
		);

		$result_header = $this->db->update("invoice_header", $data_header,
			array(
				'id' => $id_inv
			)
		);

		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		$query = $this->db->query("SELECT *FROM invoice_detail where no_invoice='$no_inv_old' ")->result();

		if ($type == 'roll')
		{
			$no = 1;
			foreach ( $query as $row ) 
			{

					$harga_ok        = $this->input->post('hrg['.$no.']');
					$hasil_ok        = $this->input->post('hasil['.$no.']');
					$id_pl_roll      = $this->input->post('id_pl_roll['.$no.']');
					$id_inv_detail   = $this->input->post('id_inv_detail['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => $this->input->post('seset['.$no.']'),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$result_rinci = $this->db->update("invoice_detail", $data,
						array(
							'id' => $id_inv_detail
						)
					);

				$no++;
			}
		}else{
			
			$no = 1;
			foreach ( $query as $row ) 
			{			

					$harga_ok        = $this->input->post('hrg['.$no.']');
					$hasil_ok        = $this->input->post('hasil['.$no.']');
					$id_pl_roll      = $this->input->post('id_pl_roll['.$no.']');
					$id_inv_detail   = $this->input->post('id_inv_detail['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('item['.$no.']'),
						'g_label'      => $this->input->post('ukuran['.$no.']'),
						'kualitas'      => $this->input->post('kualitas['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$result_rinci = $this->db->update("invoice_detail", $data,
						array(
							'id' => $id_inv_detail
						)
					);

				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
	}

}
