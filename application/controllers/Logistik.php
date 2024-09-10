<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logistik extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_fungsi');
		$this->load->model('m_master');
		$this->load->model('m_logistik');
	}

	public function Timbangan()
	{
		$data = array(
			'judul' => "Timbangan",
		);

		$this->load->view('header',$data);
		if($this->session->userdata('level'))
		{
			$this->load->view('Logistik/v_timbangan');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}

	

	public function Invoice()
	{
		$data = array(
			'judul' => "Invoice",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice');
		$this->load->view('footer');
	}
	
	public function Invoice_add()
	{
		$data = array(
			'judul' => "Invoice Baru",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice_add');
		$this->load->view('footer');
	}
	
	public function Invoice_edit()
	{
		$id       = $_GET['id'];
		$no_inv   = $_GET['no_inv'];

		$data = array(
			'judul' 	 => "Edit Invoice",
			'id'    	 => $id,
			'no_inv'     => $no_inv,
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice_edit');
		$this->load->view('footer');
	}
	
	public function Surat_Jalan()
	{
		$data = array(
			'judul' => "Surat Jalan",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_surat_jln');
		$this->load->view('footer');
	}
	
	public function Surat_Jalan_add()
	{
		$data = array(
			'judul' => "Surat Jalan Baru",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_surat_jln_add');
		$this->load->view('footer');
	}
	
	public function Surat_Jalan_edit()
	{
		$id       = $_GET['id'];
		$no_inv   = $_GET['no_inv'];

		$data = array(
			'judul' 	 => "Edit Surat Jalan",
			'id'    	 => $id,
			'no_inv'     => $no_inv,
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_surat_jln_edit');
		$this->load->view('footer');
	}

	function load_produk()
    {
        
		$pl = $this->input->post('idp');
		$kd = $this->input->post('kd');

        if($pl !='' && $kd ==''){
            $cek ="where no_customer = '$pl' ";
        }else if($pl =='' && $kd !=''){
            $cek ="where id_produk = '$kd' ";
        }else {
            $cek ="";
        }

        $query = $this->db->query("SELECT * FROM m_produk $cek order by id_produk ")->result();

            if (!$query) {
                $response = [
                    'message'	=> 'not found',
                    'data'		=> [],
                    'status'	=> false,
                ];
            }else{
                $response = [
                    'message'	=> 'Success',
                    'data'		=> $query,
                    'status'	=> true,
                ];
            }
            $json = json_encode($response);
            print_r($json);
    }

	function load_no_inv()
    {
        
		$type   = $this->input->post('type');
		$pajak  = $this->input->post('pajak');

		($type=='roll')? $type_ok=$type : $type_ok='SHEET_BOX';
		
		($pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
		
		$type   = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok);
        echo json_encode($type);
    }

	function load_data_1()
	{
		$id       = $this->input->post('id');
		$tbl      = $this->input->post('tbl');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		if($jenis=='timbangan')
		{
			$queryh   = "SELECT *,a.jns,a.alamat FROM $tbl a JOIN m_hub b ON a.id_hub_occ=b.id_hub WHERE $field = '$id' ";
			
			$queryd   = "SELECT*FROM $tbl where $field = '$id' ";
		}else if($jenis=='spill_timb')
		{ 
			$queryh   = "SELECT *,a.jns FROM m_jembatan_timbang a JOIN m_hub b ON a.id_hub_occ=b.id_hub  where $field = '$id' ORDER BY id_timbangan DESC";
			
			
			$queryd   = "SELECT *,a.jns FROM m_jembatan_timbang a JOIN m_hub b ON a.id_hub_occ=b.id_hub  where $field = '$id' ORDER BY id_timbangan DESC";

		}else if($jenis=='edit_inv_bhn')
		{ 
			$queryh   = "SELECT*,b.jns from invoice_bhn a
			join m_jembatan_timbang b on a.no_timb=b.no_timbangan
			join m_hub c on b.id_hub_occ=c.id_hub
			where $field = '$id'
			order by tgl_inv_bhn desc, id_inv_bhn";
			
			
			$queryd   = "SELECT*,b.jns from invoice_bhn a
			join m_jembatan_timbang b on a.no_timb=b.no_timbangan
			join m_hub c on b.id_hub_occ=c.id_hub
			where $field = '$id'
			order by tgl_inv_bhn desc, id_inv_bhn";

		}else if($jenis=='edit_inv_beli_bhn')
		{ 
			$queryh   = "SELECT* from invoice_beli_bhn a
			JOIN m_hub b on a.id_hub=b.id_hub
			where $field = '$id'
			order by tgl_inv_bhn desc, id_inv_bhn";
			
			$queryd   = "SELECT* from invoice_beli_bhn a
			JOIN m_hub b on a.id_hub=b.id_hub
			where $field = '$id'
			order by tgl_inv_bhn desc, id_inv_bhn";

		}else{
			$queryh   = "SELECT*FROM $tbl where no_invoice='$id'";
			$queryd   = "SELECT*FROM invoice_detail where no_invoice='$id' ";

		}

		

		$header   = $this->db->query($queryh)->row();
		$detail    = $this->db->query($queryd)->result();

		$data = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}

	function load_data()
	{
		// $db2 = $this->load->database('database_simroll', TRUE);
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "Invoice") {
			$query = $this->db->query("SELECT * FROM invoice_header ORDER BY tgl_invoice,no_invoice")->result();
			$i = 1;
			foreach ($query as $r) {
				$id = "'$r->id'";
				$no_inv = "'$r->no_invoice'";
				$print = base_url("laporan/print_invoice_v2?no_invoice=") . $r->no_invoice;

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind($r->tgl_invoice).'</div>';
				$row[] = $r->no_invoice;
				$row[] = $r->kepada;
				$row[] = $r->nm_perusahaan;
				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','Keuangan1']))
				{
					if ($r->status == "Open") {
						$aksi = '
							<a class="btn btn-sm btn-warning" href="' . base_url("Logistik/Invoice_edit?id=" .$r->id ."&no_inv=" .$r->no_invoice ."") . '" title="EDIT DATA" >
								<b><i class="fa fa-edit"></i> </b>
							</a> 

							<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_inv . ')" class="btn btn-danger btn-sm">
								<i class="fa fa-trash-alt"></i>
							</button> 

							<button title="VERIFIKASI DATA" type="button" onclick="tampil_edit(' . $id . ',' . $no_inv . ')" class="btn btn-info btn-sm">
								<i class="fa fa-check"></i>
							</button>

							<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
							
							';
					} else if ($r->status == "Verified") {
						$aksi = '
							<a type="button" href="' . $print . '" target="blank" class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Print Invoice">
								<i class="material-icons">print</i>
							</a>';
					}
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		}else if ($jenis == "Timbangan") {
			$query = $this->db->query("SELECT * FROM m_jembatan_timbang ORDER BY id_timbangan DESC")->result();
			$i = 1;
			foreach ($query as $r) {
				
				$id         = "'$r->id_timbangan'";
				$no_timb    = "'$r->no_timbangan'";
				
				$print      = base_url('Logistik/printTimbangan?id='.$r->id_timbangan.'&top=10');
				$printLampiran = base_url('Logistik/lampiranTimbangan?id='.$r->id_timbangan);
				$row        = array();
				$row[]      = '<div class="text-center">'.$i.'</div>';
				$row[]      = '<div class="text-center">'.$r->no_timbangan.'</div>';
				$row[]      = '<div class="text-center">'.$r->permintaan.'</div>';
				$row[]      = '<div class="text-center">'.substr($r->date_masuk,0,10).'</div>';
				$row[]      = $r->suplier;
				$row[]      = $r->nm_barang;
				$row[]      = $r->catatan;
				$row[]      = '<div class="text-right"><a>'.number_format($r->berat_bersih, 0, ",", ".").'</a></div>';
				// $row[] = '<div class="text-right"><a href="javascript:void(0)" onclick="editTimbangan('."'".$r->id_timbangan."'".','."'detail'".')">'.number_format($r->berat_bersih).'</a></div>';
				$aksi       = "";

				if (in_array($this->session->userdata('level'), ['Admin','User'])) 
				{
					$cek = $this->db->query("SELECT * FROM invoice_bhn where no_timb='$r->no_timbangan' ")->num_rows();

					if($cek>0)
					{
						$aksi = '
						<a class="btn btn-sm btn-primary" onclick=edit_data(' . $id . ',' . $no_timb . ',"look") title="PREVIEW DATA" >
							<b><i class="fa fa-eye"></i> </b>
						</a> 

						<a target="_blank" class="btn btn-sm btn-danger" href="'.$print.'" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
						';
					}else{

						$aksi = '
						<a class="btn btn-sm btn-warning" onclick=edit_data(' . $id . ',' . $no_timb . ',"editt") title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 


						<button type="button" title="DELETE" onclick="deleteTimbangan(' . $id . ',' . $no_timb . ')" class="btn btn-secondary btn-sm">
							<i class="fa fa-trash-alt"></i>

						</button> 
						<a target="_blank" class="btn btn-sm btn-danger" href="'.$print.'" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
						';
					}
					
				} else {
					$aksi = '<a target="_blank" class="btn btn-sm btn-danger" href="'.$print.'" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;
				$i++;
			}
		}else if ($jenis == "search_timbangan") {			
			$query = $this->db->query("SELECT * FROM m_jembatan_timbang 
			where no_timbangan not in (select no_timb from invoice_bhn) 
			ORDER BY id_timbangan")->result();

			$i = 1;
			foreach ($query as $r) {
				
				$id         = "'$r->id_timbangan'";
				$no_timb    = "'$r->no_timbangan'";
				
				$print      = base_url('Logistik/printTimbangan?id='.$r->id_timbangan.'&top=10');
				$printLampiran = base_url('Logistik/lampiranTimbangan?id='.$r->id_timbangan);
				$row        = array();
				$row[]      = '<div class="text-center">'.$i.'</div>';
				$row[]      = '<div class="text-center">'.$r->no_timbangan.'</div>';
				$row[]      = '<div class="text-center">'.substr($r->date_masuk,0,10).'</div>';
				$row[]      = '<div class="text-center">'.$r->no_polisi.'</div>';
				$row[]      = '<div class="text-center">'.$r->nm_sopir.'</div>';
				$row[]      = $r->suplier;
				$row[]      = $r->nm_barang;
				$row[]      = $r->catatan;
				$row[]      = '<div class="text-right"><b><a>'.number_format($r->berat_bersih, 0, ",", ".").' Kg</a></b></div>';
				$aksi       = "";

				$aksi = '
				<button type="button" title="PILIH"  onclick="spilldata(' . $id . ',' . $no_timb . ')" class="btn btn-success btn-sm">
					<i class="fas fa-check-circle"></i>
				</button> ';
				// }
				
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;
				$i++;
			}
		
		}else if ($jenis == "inv_bhn") {			
			$query = $this->db->query("SELECT*,b.jns from invoice_bhn a
			join m_jembatan_timbang b on a.no_timb=b.no_timbangan
			join m_hub c on b.id_hub_occ=c.id_hub
			order by tgl_inv_bhn desc, id_inv_bhn")->result();
 
			$i               = 1;
			foreach ($query as $r) {

				$id           = "'$r->id_inv_bhn'";
				$no_inv_bhn   = "'$r->no_inv_bhn'";

				if($r->acc_owner=='N')
                {
                    $btn2   = 'btn-warning';
                    $i2     = '<i class="fas fa-lock"></i>';
                } else {
                    $btn2   = 'btn-success';
                    $i2     = '<i class="fas fa-check-circle"></i>';
                }
				
				if (in_array($this->session->userdata('username'), ['owner','developer']))
				{
					$urll2 = "onclick=open_modal('$r->id_inv_bhn','$r->no_inv_bhn')";
				} else {
					$urll2 = '';
				}
					
				$row    = array();
				$row[]  = '<div class="text-center">'.$i.'</div>';
				$row[]  = '<div class="text-center">'.$r->no_inv_bhn.'</div>';
				$row[]  = '<div class="text-center">'.$r->no_timb.'</div>';
				$row[]  = '<div class="text-center">'.$r->tgl_inv_bhn.'</div>';
				$row[]  = $r->nm_hub;
				$row[]  = '<div class="text-right">'.number_format($r->qty, 0, ",", ".").'</div>';
				$row[]  = '<div class="text-right">'.number_format($r->nominal, 0, ",", ".").'</div>';
				$row[]  = '<div class="text-right">'.number_format($r->qty * $r->nominal, 0, ",", ".").'</div>';
				$row[]  = '
						<div class="text-center"><a style="text-align: center;" class="btn btn-sm '.$btn2.' " '.$urll2.' title="VERIFIKASI DATA" ><b>'.$i2.' </b> </a><span style="font-size:1px;color:transparent">'.$r->acc_owner.'</span><div>';

				$btncetak ='<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/cetak_inv_bb2?no_inv_bhn="."$r->no_inv_bhn"."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>';

				$btnEdit = '<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $no_inv_bhn . ')" title="EDIT DATA" >
				<b><i class="fa fa-edit"></i> </b></a>';

				$btnHapus = '<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_inv_bhn . ')" class="btn btn-secondary btn-sm">
				<i class="fa fa-trash-alt"></i></button> ';
					
				if (in_array($this->session->userdata('level'), ['Admin','User']))
				{
					$row[] = '<div class="text-center">'.$btnEdit.' '.$btncetak.''.$btnHapus.'</div>';

				}else{
					$row[] = '<div class="text-center">'.$btncetak.'</div>';
				}
				
				$data[] = $row;
				$i++;
			}
		
		}else if ($jenis == "inv_beli_bhn") {			
			$query = $this->db->query("SELECT* from invoice_beli_bhn a
			JOIN m_hub b on a.id_hub=b.id_hub
			order by tgl_inv_bhn desc, id_inv_bhn")->result();
 
			$i               = 1;
			foreach ($query as $r) {

				$id           = "'$r->id_inv_bhn'";
				$no_inv_bhn   = "'$r->no_inv_bhn'";

				if($r->acc_owner=='N')
                {
                    $btn2   = 'btn-warning';
                    $i2     = '<i class="fas fa-lock"></i>';
                } else {
                    $btn2   = 'btn-success';
                    $i2     = '<i class="fas fa-check-circle"></i>';
                }
				
				if (in_array($this->session->userdata('username'), ['owner','developer']))
				{
					$urll2 = "onclick=open_modal('$r->id_inv_bhn','$r->no_inv_bhn')";
				} else {
					$urll2 = '';
				}
					
				$row    = array();
				$row[]  = '<div class="text-center">'.$i.'</div>';
				$row[]  = '<div class="text-center">'.$r->no_inv_bhn.'</div>';
				$row[]  = '<div class="text-center">'.$r->aka.'</div>';
				$row[]  = '<div class="text-center">'.$r->tgl_inv_bhn.'</div>';
				$row[]  = '<div class="text-right">'.number_format($r->qty, 0, ",", ".").'</div>';
				$row[]  = '<div class="text-right">'.number_format($r->nominal, 0, ",", ".").'</div>';
				$row[]  = '<div class="text-right">'.number_format($r->qty * $r->nominal, 0, ",", ".").'</div>';
				$row[]  = '
						<div class="text-center"><a style="text-align: center;" class="btn btn-sm '.$btn2.' " '.$urll2.' title="VERIFIKASI DATA" ><b>'.$i2.' </b> </a><span style="font-size:1px;color:transparent">'.$r->acc_owner.'</span><div>';

				$btncetak ='<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/cetak_nota?no_inv_bhn="."$r->no_inv_bhn"."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>';

				$btnEdit = '<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $no_inv_bhn . ')" title="EDIT DATA" >
				<b><i class="fa fa-edit"></i> </b></a>';

				$btnHapus = '<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_inv_bhn . ')" class="btn btn-secondary btn-sm">
				<i class="fa fa-trash-alt"></i></button> ';
					
				if (in_array($this->session->userdata('level'), ['Admin','User']))
				{
					$row[] = '<div class="text-center">'.$btnEdit.' '.$btncetak.''.$btnHapus.'</div>';

				}else{
					$row[] = '<div class="text-center">'.$btncetak.'</div>';
				}
				
				$data[] = $row;
				$i++;
			}
		
		}else{

		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function deleteTimbangan()
	{
		$result = $this->m_logistik->deleteTimbangan();
		echo json_encode($result);
	}

	function printTimbangan()
	{
		$html   = '';
		$top    = $_GET["top"];
		$id     = $_GET["id"];

		$data = $this->db->query("SELECT*FROM m_jembatan_timbang WHERE id_timbangan='$id'")->row();

		$html .= '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="icon" type="image/png" href="'.base_url('assets/gambar/ppi.png').'">
			<title>TIMBANGAN - '.$data->id_timbangan.'</title>
		</head>
		<body style="font-family: Verdana, Geneva, Tahoma, sans-serif">
		
			<table style="text-align:center;border-collapse:collapse;width:100%;border-bottom:2px solid #000">
				<tr>
					<td style="font-weight:bold">PT. PRIMA PAPER INDONESIA</td>
				</tr>
				<tr>
					<td style="font-size:10px">Timang Kulon, Wonokerto</td>
				</tr>
				<tr>
					<td style="font-size:10px;padding-bottom:15px">WONOGIRI</td>
				</tr>
			</table>
			<table style="margin-bottom:16px;font-size:12px;border-collapse:collapse">
				<tr>
					<td style="padding:2px 0">Suplier</td>
					<td style="padding:0 4px 0 20px">:</td>
					<td style="padding:2px 0">'.$data->suplier.'</td>
				</tr>
				<tr>
					<td style="padding:2px 0">Alamat</td>
					<td style="padding:0 4px 0 20px">:</td>
					<td style="padding:2px 0">'.$data->alamat.'</td>
				</tr>
				<tr>
					<td style="padding:2px 0">No. Polisi</td>
					<td style="padding:0 4px 0 20px">:</td>
					<td style="padding:2px 0">'.$data->no_polisi.'</td>
				</tr>
				<tr>
					<td style="padding:2px 0">Masuk</td>
					<td style="padding:0 4px 0 20px">:</td>
					<td style="padding:2px 0">'.$this->m_fungsi->tanggal_ind(substr($data->date_masuk,0,10)).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.substr($data->date_masuk,11).'</td>
				</tr>
				<tr>
					<td style="padding:2px 0">Keluar</td>
					<td style="padding:0 4px 0 20px">:</td>
					<td style="padding:2px 0">'.$this->m_fungsi->tanggal_ind(substr($data->date_keluar,0,10)).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.substr($data->date_keluar,11).'</td>
				</tr>
				<tr>
					<td style="padding:2px 0">Barang</td>
					<td style="padding:0 4px 0 20px">:</td>
					<td style="padding:2px 0">'.$data->nm_barang.'</td>
				</tr>
			</table>
			<table style="text-align:center;border-collapse:collapse;width:100%" border="1">
				<tr>
					<td style="border:0;width:2%;"></td>
					<td style="border:0;width:30%;font-size:13px">BERAT KOTOR</td>
					<td style="border:0;width:3%;"></td>
					<td style="border:0;width:30%;font-size:13px">BERAT TRUK</td>
					<td style="border:0;width:3%;"></td>
					<td style="border:0;width:30%;font-size:13px">BERAT BERSIH</td>
					<td style="border:0;width:2%;"></td>
				</tr>
				<tr>
					<td style="border:0"></td>
					<td style="padding:4px 0;font-weight:bold;font-size:17px">'.number_format($data->berat_kotor).'</td>
					<td style="border:0"></td>
					<td style="padding:4px 0;font-weight:bold;font-size:17px">'.number_format($data->berat_truk).'</td>
					<td style="border:0"></td>
					<td style="padding:4px 0;font-weight:bold;font-size:17px">'.number_format($data->berat_bersih).'</td>
					<td style="border:0"></td>
				</tr>
				<tr>
					<td style="border:0"></td>
					<td style="border:0;text-align:left;font-size:14px">POTONGAN :</td>
					<td style="border:0"></td>
					<td style="border:0;font-size:14px">'.number_format($data->potongan).' KG</td>
					<td style="border:0"></td>
					<td style="border:0"></td>
					<td style="border:0"></td>
				</tr>
				<tr>
					<td style="border:0;padding:8px 0 23px;font-size:11px;text-align:left" colspan="7">Catatan : '.$data->catatan.'</td>
				</tr>
			</table>
			<table style="width:100%;margin-bottom:5px;text-align:center;border-collapse:collapse;font-size:11px" border="1">
				<tr>
					<td style="border-bottom:0;padding-top:3px;width:32%">PENIMBANG</td>
					<td style="border:0;width:2%"></td>
					<td style="border-bottom:0;padding-top:3px;width:32%">SATPAM</td>
					<td style="border:0;width:2%"></td>
					<td style="border-bottom:0;padding-top:3px;width:32%">SOPIR</td>
				</tr>
				<tr>
					<td style="border-top:0;border-bottom:0;padding:43px 0"></td>
					<td style="border:0"></td>
					<td style="border-top:0;border-bottom:0;padding:43px 0"></td>
					<td style="border:0"></td>
					<td style="border-top:0;border-bottom:0;padding:43px 0"></td>
				</tr>
				<tr>
					<td style="border-top:0;padding-bottom:3px;">'.$data->nm_penimbang.'</td>
					<td style="border:0"></td>
					<td style="border-top:0;padding-bottom:3px;">(. . . . . . . . . .)</td>
					<td style="border:0"></td>
					<td style="border-top:0">'.$data->nm_sopir.'</td>
				</tr>
			</table>
			<table style="width:100%;border-top:2px solid #000">
				<tr>
					<td style="text-align:right;font-size:12px">'.$data->keterangan.'</td>
				</tr>
			</table>

		</body>
		</html>';
		
		// $html .= '<div style="page-break-after:always"></div>';

		// echo $html;
		$judul = 'JEMBATAN TIMBANG - '.$id;
		$this->m_fungsi->newMpdf($judul, '', $html, $top, 3, 3, 3, 'P', 'TT', $judul.'.pdf');
	}

	function lampiranTimbangan()
	{
		$id_timbangan = $_GET["id"];
		$html = '';

		$j_timbangan = $this->db->query("SELECT*FROM m_jembatan_timbang WHERE id_timbangan='$id_timbangan'");

		$html .= '<table style="margin:0;padding:0;font-size:12px;border-collapse:collapse;color:#000;font-family:tahoma;width:100%">
			<tr>
				<th style="font-size:20px" rowspan="3">LAMPIRAN TIMBANGAN</th>
				<th style="text-align:left">UD PATRIOT</th>
			</tr>
			<tr>
				<th style="text-align:left">DUKUH MASARAN RT 34, DESA MASARAN</th>
			</tr>
			<tr>
				<th style="text-align:left">KECAMATAN MASARAN, KABUPATEN SRAGEN, JAWA TENGAH</th>
			</tr>
			<tr>
				<th style="padding:20px 0 40px;font-size:16px" colspan="2">NO TIMBANGAN : '.$j_timbangan->row()->no_timbangan.'</th>
			</tr>
		</table>';

		$html .= '<table style="margin:0;padding:0;font-size:12px;border-collapse:collapse;color:#000;font-family:tahoma;width:100%">
			<tr style="background:#f0b2b4">
				<th style="padding:3px">NO</th>
				<th style="padding:3px;text-align:left">CUSTOMER</th>
				<th style="padding:3px;text-align:left">NO. STOK</th>
				<th style="padding:3px;text-align:left">ITEM</th>
				<th style="padding:3px">KEDATANGAN</th>
			</tr>';

			$data = $this->db->query("SELECT * FROM trs_h_stok_bb a
			INNER JOIN trs_d_stok_bb b ON a.no_stok=b.no_stok 
			INNER JOIN m_hub c ON b.id_hub=c.id_hub
			INNER JOIN m_jembatan_timbang d ON a.no_timbangan=d.no_timbangan
			INNER JOIN trs_po_bhnbk e ON b.no_po_bhn = e.no_po_bhn
			WHERE a.id_timbangan='$id_timbangan'");
			$i = 0;
			foreach($data->result() as $r){
				$i++;
				$html .= '<tr>
					<td style="padding:3px;text-align:center">'.$i.'</td>
					<td style="padding:3px">'.$r->nm_hub.'</td>
					<td style="padding:3px">'.$r->no_stok.'</td>
					<td style="padding:3px">'.$r->nm_barang.'</td>
					<td style="padding:3px;text-align:right">'.number_format($r->datang_bhn_bk,0,',','.').'</td>
				</tr>';
			}


		$html .= '</table>';

		$judul = 'LAMPIRAN';
		$this->m_fungsi->newMpdf($judul, '', $html, 5, 5, 5, 5, 'P', 'A4', $judul.'.pdf');
	}
	
	public function Invoice_bhn_bk()
	{
		$data = array(
			'judul' => "Invoice Bahan Baku",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice_bhn');
		$this->load->view('footer');
	}

	function insert_inv_beli_bhn()
	{
		if($this->session->userdata('username'))
		{ 
			$result = $this->m_logistik->save_inv_beli_bhn();
			echo json_encode($result);
		}
		
	}
	
	public function Beli_bahan()
	{
		$data = array(
			'judul' => "Pembelian Bahan",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_beli_bhn');
		$this->load->view('footer');
	}

	function prosesData()
	{
		$jenis    = $_POST['jenis'];
		$result   = $this->m_logistik->$jenis();

		echo json_encode($result);
	}

	function cetak_inv_bb2()
	{
		$no_inv_bhn        = $_GET['no_inv_bhn'];
 
        $query_header = $this->db->query("SELECT*,b.jns,c.alamat as alamat_hub,b.alamat from invoice_bhn a
			join m_jembatan_timbang b on a.no_timb=b.no_timbangan
			join m_hub c on b.id_hub_occ=c.id_hub
			WHERE no_inv_bhn='$no_inv_bhn'
			order by tgl_inv_bhn desc, id_inv_bhn"); 
        
        $data = $query_header->row();
        
        $querydetail = $this->db->query("SELECT*,b.jns,c.alamat as alamat_hub,b.alamat from invoice_bhn a
			join m_jembatan_timbang b on a.no_timb=b.no_timbangan
			join m_hub c on b.id_hub_occ=c.id_hub
			WHERE no_inv_bhn='$no_inv_bhn'
			order by tgl_inv_bhn desc, id_inv_bhn");

		$html = '';

		// header

		$nm_toko    = $data->nm_hub;
		$logo_hub   = $data->logo;
		$alamat     = $data->alamat_hub;
		$alamat2    = $data->alamat2;
		// $alamat2  = 'Kecamatan Masaran, Kabupaten Sragen, Jawa Tengah';
		$phone      = $data->no_telp;
		$whatsapp   = $data->no_telp;
		$kodepos    = $data->kode_pos;
		$npwp       = '-';
		$html .= "
			 <table style=\"border-collapse:collapse;font-family: Century Gothic; font-size:12px; color:#000;\" width=\"100%\"  border=\"\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
			 <thead>
				<tr>            
					<td colspan=\"20\" style=\"background-color:#386fa4;font-size:20px;text-align:center;font-weight:bold\" >&nbsp;</td>
				</tr>
				
				<tr>            
					<td colspan=\"20\" style=\"font-size:10px;\" >&nbsp;</td>
				</tr>

				  <tr>
					   <td rowspan=\"5\" align=\"center\">
							<img src=\"" . base_url() . "assets/gambar/".$logo_hub."\"  width=\"100\" height=\"100\" />
					   </td>
					   <td colspan=\"20\">
							<b>
								 <tr>
									  <td align=\"left\" style=\"font-size:28;border-bottom: none;\"><b>$nm_toko</b></td>
								 </tr>
								 <tr>
									  <td align=\"left\" style=\"font-size:10px;\">$alamat</td>
								 </tr>
								 <tr>
									  <td align=\"left\" style=\"font-size:10px;\">$alamat2  Kode Pos $kodepos </td>
								 </tr>
								 <tr>
									  <td align=\"left\" style=\"font-size:10px;\">Wa : $whatsapp  |  Telp : $phone </td>
								 </tr>
							</b>
					   </td>
				  </tr>
			 </table>";
		$html .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:6px\" width=\"100%\" align=\"center\" border=\"0\">
				  <tr>
					   <td> &nbsp; </td>
				  </tr> 
			 </table>";

		$html .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:2px\" width=\"100%\" align=\"center\" border=\"1\">     
				  <tr>
					   <td colspan=\"20\" style=\"border-top: none;border-right: none;border-left: none;\"></td>
				  </tr> 
			 </table>";
		$html .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:4px\" width=\"100%\" align=\"center\" border=\"1\">     
				  <tr>
					   <td colspan=\"20\" style=\"border-top: none;border-right: none;border-left: none;border-bottom: 2px solid black;font-size:5px\"></td>
				  </tr> 
			 </table>";
		$html .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:8px\" width=\"100%\" align=\"center\" border=\"0\">     
				  <tr> <td>&nbsp;</td> </tr> 
			 </table>";
		// end header

		$html .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:8px\" width=\"100%\" align=\"center\" border=\"0\">     
				  <tr> <td>&nbsp;</td> </tr> 
				  <tr> <td>&nbsp;</td> </tr> 
			 </table>";

		if ($query_header->num_rows() > 0) {

            $html .= '<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: &quot;YACgEe79vK0 0&quot;, _fb_, auto;">

            <tr>
				<td width="40%" rowspan="3" align="center" style="font-size:35px;"><b>INVOICE</b></td>
				<td width="20%" rowspan="4"></td>
				<td width="40%">Kepada</td>
			</tr>
            <tr>
				<td><b><br>PT Prima Paper Indonesia</b></td>
			</tr>
            <tr>
				<td>Timang Kulon, Wonokerto, Kec. Wonogiri, <br>Kabupaten Wonogiri, Jawa Tengah</td>
			</tr>
            <tr>
				<td align="center">No.'.$data->no_inv_bhn.'</td>
			</tr>
            </table><br><br>';

			$html .= '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
                        <tr style="background-color: #386fa4;color:white;">
                            <th style="color:white;" width="2%" align="center">NO</th>
                            <th style="color:white;" width="10%" align="center">ITEM</th>
                            <th style="color:white;" width="10%" align="center">JUMLAH</th>
                            <th style="color:white;" width="12%" align="center">SATUAN</th>
                            <th style="color:white;" width="8%" align="center">HARGA</th>
                            <th style="color:white;" width="10%" align="center">TOTAL </th>
						</tr>';

			$html .= '
				<tr>
					<td colspan="6" >&nbsp;</td>
				</tr>';
			$no = 1;
			$tot_qty = $tot_value = $tot_total = 0;
			foreach ($querydetail->result() as $r) {

                $total = $r->nominal*$r->qty;
				$html .= '
				<tr >
					<td align="center">' . $no . '</td>
					<td align="center">' . $r->nm_barang . '</td>
					<td align="center">' . number_format($r->qty, 0, ",", ".") . '</td>
					<td align="center">Kg</td>
					<td align="right">' . number_format($r->nominal, 0, ",", ".") . '</td>
					<td align="right">' . number_format($total, 0, ",", ".") . '</td>
					</tr>';

				$no++;
				$tot_total += $total;
			}
			$html .= '</table>';

			
			// $ppn11       = 0.11 * $tot_total;
			$ppn11       = 0;
			$total_all   = $ppn11 + $tot_total;

			$html .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:8px\" width=\"100%\" align=\"center\" border=\"0\">     
				  <tr> <td>&nbsp;</td> </tr> 
				  <tr> <td>&nbsp;</td> </tr> 
				  <tr> <td>&nbsp;</td> </tr> 
				  <tr> <td>&nbsp;</td> </tr>  
			 </table>";


		$html .= '
		<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: &quot;YACgEe79vK0 0&quot;, _fb_, auto;">
			<tr> 
				<td colspan="4" style="border-width:2px 0;border-top:1px solid #000;">&nbsp;</td>
			</tr>
            <tr>
				<td width="50%" ><b>TERBILANG :</b></td>
				<td width="15%" ><b></b></td>
				<td width="20%" ><b></b></td>
				<td width="15%" align="right" ></td>
			</tr>
            <tr>
				<td style="font-size:10px;"><b>'.$this->m_fungsi->terbilang($total_all).'</b></td>
				<td><b></b></td>
				<td><b>Total Incl</b></td>
				<td align="right"><b>Rp.' . number_format($total_all, 0, ",", ".") . '</b></td>
			</tr>
			<tr> 
				<td colspan="4" style="border-width:2px 0;border-bottom:1px solid #000;">&nbsp;</td>
			</tr>

            </table><br><br>';

		$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;">
			<tr>
				<td style="">Di Bayarkan Kepada :</td>
				<td style="text-align:center">Sragen, '.$this->m_fungsi->tanggal_format_indonesia($data->tgl_inv_bhn).'</td> 
			</tr>
			<tr>
				
				<td style="">'.$data->nm_bank.' '.$data->no_rek.' </td>
				<td style=""></td>
			</tr>
			<tr>
				
				<td style="">A.n '.$data->nm_hub.'</td>
				<td style=""></td>
			</tr>
			<tr>
				
				<td style="">&nbsp;</td>
				<td style=""></td>
			</tr>
			<tr>
				<td style="">&nbsp;</td>
				<td style="border-bottom:1px solid #000;"></td>
			</tr>
			<tr>
				<td style="">&nbsp;</td>
				<td style="text-align:center">Finance</td>
			</tr>		
			</table>
			';


		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$judul    = 'INVOICE';
		$jdl_save = $no_inv_bhn;
		$position = 'P';
		$cekpdf   = '1';

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($html);
				break;

			case 1;
				$this->m_fungsi->_mpdf_hari($position, 'A4', $judul, $html, $jdl_save.'.pdf', 5, 5, 5, 10,'','','',$data->nm_hub);
				break;
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('app/master_cetak', $data);
				break;
		}
	}

	function cetak_nota()
	{
		$no_inv_bhn        = $_GET['no_inv_bhn'];
 
        $query_header = $this->db->query("SELECT* from invoice_beli_bhn a
			JOIN m_hub b on a.id_hub=b.id_hub
			where no_inv_bhn='$no_inv_bhn'
			order by tgl_inv_bhn desc, id_inv_bhn"); 
        
        $data = $query_header->row();
        
        $querydetail = $this->db->query("SELECT* from invoice_beli_bhn a
			JOIN m_hub b on a.id_hub=b.id_hub
			where no_inv_bhn='$no_inv_bhn'
			order by tgl_inv_bhn desc, id_inv_bhn");

		$html = '';

		
		$html   = '';
		$top    = 5;
		$id     = $data->no_inv_bhn;
		if ($query_header->num_rows() > 0) 
		{


		$html .= '
			<table style="border-collapse:collapse;font-family: Century Gothic; font-size:12px; color:#000;" width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" >
			 <thead>			

				<tr>
					<td rowspan="5" align="center">
						<img src="'.base_url('assets/gambar/').$data->logo.'" width="70" height="70" />
					</td>
					<td>
						<b>
						<tr>
							<td align="center" style="font-size:20;border-bottom: none;"><b>'.$data->nm_hub.'</b></td>
						</tr>
						<tr>
							<td align="center" style="font-size:10px;">'.$data->alamat2.'  Kode Pos '.$data->kode_pos.' </td>
						</tr>
						<tr>
							<td align="center" style="font-size:10px;">Wa : '.$data->no_telp.'  |  Telp : '.$data->no_telp.' </td>
						</tr>
						</b>
					</td>
				</tr>

				<tr>            
					<td style="font-size:3px;text-align:center;font-weight:bold" >&nbsp;</td>
				</tr>

				<tr>            
					<td colspan="3" style="background-color:#000;font-size:2px;text-align:center;font-weight:bold" >&nbsp;</td>
				</tr>
				<tr>            
					<td style="font-size:3px;text-align:center;font-weight:bold" >&nbsp;</td>
				</tr>
			</table>';

		$html .= '
			<table style="margin-bottom:16px;font-size:12px;border-collapse:collapse" border="0" width="100%">
			
				<tr>
					<td width="20%" >No. Nota </td>
					<td width="5%" >:</td>
					<td width="75%" >'.$data->no_inv_bhn.'</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td>'.$data->tgl_inv_bhn.'</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td>'.$data->suplier.'</td>
				</tr>
			</table> ';

		$html .= '
			<table style="margin-bottom:16px;font-size:12px;border-collapse:collapse;" border="1" width="100%" cellspacing="1" cellpadding="1">
			
				<tr>
					<td width="25%" align="center" style="background-color:#386fa4; font-weight:bold;color:#fff;" >Barang</td>
					<td width="25%" align="center" style="background-color:#386fa4; font-weight:bold;color:#fff;" >Qty (Kg)</td>
					<td width="25%" align="center" style="background-color:#386fa4; font-weight:bold;color:#fff;" >Harga (Rp)</td>
					<td width="25%" align="center" style="background-color:#386fa4; font-weight:bold;color:#fff;" >Jumlah (Rp)</td>
				</tr>
				<tr>
					<td align="left">KARDUS BEKAS</td>
					<td align="center">'.number_format($data->qty, 0, ",", ".").'</td>
					<td align="center">'.number_format($data->nominal, 0, ",", ".").'</td>
					<td align="center">'.number_format($data->qty*$data->nominal, 0, ",", ".").'</td>
				</tr>';

			for ( $i=0;$i<8;$i++)
			{
			$html .= '
				<tr> 
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>';
			}
			$html .= '
				<tr>
					<td colspan="3" style="border:none" align="right"><b>TOTAL &nbsp; Rp.</b></td>
					<td align="right"><b>'.number_format($data->qty*$data->nominal, 0, ",", ".").'</b></td>
				</tr>
				<tr>
					<td style="border:none" colspan="3" align="right"></td>
					<td style="border-bottom:2px solid #000;border-right:none;border-left:none;font-size:1px;">&nbsp;</td>
				</tr>';

				$url= "".base_url().'assets/gambar/pil.png';

				$html .= '
				<tr>
					<td style="border:none;" colspan="2" align="center">Hormat kami					
					<td style="border:0;" align="right">&nbsp;</td>
					<td style="border:0" >&nbsp;</td>
				</tr>';

				$html .= '
				<tr>
					<td style="border:none" colspan="4" align="center">&nbsp;</td>
				</tr>
				<tr>
					<td style="border:none" colspan="4" align="center">&nbsp;</td>
				</tr>
				<tr>
					<td style="border:none;border-top:1px solid #000;" colspan="2" align="center">admin pembelian</td>
					<td style="border:none" colspan="2"></td>
				</tr>
			</table>
			';


		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$judul    = 'INVOICE';
		$jdl_save = $no_inv_bhn;
		$position = 'P';
		$cekpdf   = '1';

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($html);
				break;

			case 1;
			$judul = 'NOTA PEMBELIAN - '.$id;
				$this->m_fungsi->newMpdf($judul, '-', $html, $top, 3, 3, 3, 'P', 'TT', $judul.'.pdf');
				break;
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('app/master_cetak', $data);
				break;
		}
	}
	
	function load_hub()
    {
        $query = $this->db->query("SELECT*FROM m_hub order by id_hub")->result();

            if (!$query) {
                $response = [
                    'message'	=> 'not found',
                    'data'		=> [],
                    'status'	=> false,
                ];
            }else{
                $response = [
                    'message'	=> 'Success',
                    'data'		=> $query,
                    'status'	=> true,
                ];
            }
            $json = json_encode($response);
            print_r($json);
    }

	function load_sj($searchTerm="")
	{
		// ASLI
		$db2        = $this->load->database('database_simroll', TRUE);
		$type_po    = $this->input->post('type_po');
		$tgl        = $this->input->post('tgl_sj');
		$stat       = $this->input->post('stat');
		
		if ($type_po == 'roll')
		{
			$tbl1          = 'pl';
			$tbl2          = 'm_timbangan';
			$perusahaan    = 'm_perusahaan';
			$where_po      = '';
			$join_po       = '';
		}else{
			if ($type_po == 'box')
			{				
				$where_po    = 'and d.po ="box"';
			}else{
				$where_po    = 'and d.po is null';
			}
			
			$tbl1          = 'pl_box';
			$tbl2          = 'm_box';
			$perusahaan    = 'm_perusahaan2';

			$join_po       = 'JOIN po_box_master d ON a.no_po=d.no_po and b.ukuran=d.ukuran';
		}

		if($stat == 'add')
		{
			$where_status = 'and a.no_pl_inv = "0" ';
		}else{
			$where_status = '';

		}

		$query = $db2->query("SELECT DATE_FORMAT(a.tgl, '%d-%m-%Y')tgll,a.*,c.id as id_perusahaan, c.nm_perusahaan as nm_perusahaan , c.pimpinan as pimpinan, c.alamat as alamat_perusahaan, c.no_telp as no_telp FROM $tbl1 a
			JOIN $tbl2 b ON a.id = b.id_pl
			LEFT JOIN $perusahaan c ON a.id_perusahaan=c.id
			$join_po
			WHERE a.tgl = '$tgl' 
			-- and a.id_perusahaan not in ('210','217') 
			$where_status $where_po 
			GROUP BY a.tgl,a.id_perusahaan
			ORDER BY a.tgl,a.id_perusahaan,a.no_pl_inv")->result();

		if (!$query) {
			$response = [
				'message'	=> 'not found',
				'data'		=> [],
				'status'	=> false,
			];
		}else{
			$response = [
				'message'	=> 'Success',
				'data'		=> $query,
				'status'	=> true,
			];
		}
		$json = json_encode($response);
		print_r($json);
    }

	function list_item()
	{
		// ASLI
		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');
		$type_po          = $this->input->post('type_po');
		$tgl              = $this->input->post('tgl_sj');
		$db2              = $this->load->database('database_simroll', TRUE);
		
		if ($type_po == 'roll')
		{
			$query = $db2->query("SELECT c.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight)-SUM(seset) AS weight,b.no_po,b.no_po_sj,b.no_surat
			FROM m_timbangan a 
			INNER JOIN pl b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			WHERE b.no_pl_inv = '0' AND b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
			GROUP BY b.no_po,a.nm_ker,a.g_label,a.width 
			ORDER BY a.g_label,b.no_surat,b.no_po,a.nm_ker DESC,a.g_label,a.width ")->result();
		}else{
			if ($type_po == 'box')
			{				
				$where_po    = 'and d.po ="box"';
			}else{
				$where_po    = 'and d.po is null';
			}
			$query = $db2->query("SELECT b.id as id_pl, a.qty, a.qty_ket, b.tgl, b.id_perusahaan, c.nm_perusahaan, b.no_surat, b.no_po, b.no_kendaraan, d.item, d.kualitas, d.ukuran2,d.ukuran, 
			d.flute, d.po
			FROM m_box a 
			JOIN pl_box b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan2 c ON b.id_perusahaan=c.id
			JOIN po_box_master d ON b.no_po=d.no_po and a.ukuran=d.ukuran
			WHERE b.no_pl_inv = '0' AND b.tgl = '$tgl_sj' AND b.id_perusahaan='$id_perusahaan' $where_po
			ORDER BY b.tgl desc ")->result();
		}
		
		if (!$query) {
			$response = [
				'message'	=> 'not found',
				'data'		=> [],
				'status'	=> false,
			];
		}else{
			$response = [
				'message'	=> 'Success',
				'data'		=> $query,
				'status'	=> true,
			];
		}
		$json = json_encode($response);
		print_r($json);
    }

	function insert_inv_bhn()
	{
		if($this->session->userdata('username'))
		{ 
			$result = $this->m_logistik->save_inv_bhn();
			echo json_encode($result);
		}
		
	}

	function update_inv()
	{

		if($this->session->userdata('username'))
		{
			$c_no_inv_kd   = $this->input->post('no_inv_kd');
			$c_no_inv      = $this->input->post('no_inv');
			$c_no_inv_tgl  = $this->input->post('no_inv_tgl');
			$cek_inv       = $this->input->post('cek_inv2');
			$no_inv_old    = $this->input->post('no_inv_old');
			$c_type_po     = $this->input->post('type_po2');
			$c_pajak       = $this->input->post('pajak2');

			($c_type_po=='roll')? $type_ok=$c_type_po : $type_ok='SHEET_BOX';
			
			($c_pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
	
			$no_urut         = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok);

			$no_inv_ok       = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;

			$query_cek_no    = $this->db->query("SELECT*FROM invoice_header where no_invoice='$no_inv_ok' and no_invoice <> '$no_inv_old' ")->num_rows();

			if($query_cek_no>0)
			{
				echo json_encode(array("status" => "3","id" => '0'));
			}else if($c_no_inv>$no_urut)
			{
				echo json_encode(array("status" => "4","id" => $no_urut));
			}else{
				
				$asc = $this->m_logistik->update_invoice();
		
				if($asc){
		
					echo json_encode(array("status" =>"1","id" => $asc));
		
				}else{
					echo json_encode(array("status" => "2","id" => $asc));
		
				}

			}

		}

		
		
	}
	
	function get_edit()
	{
		$id    = $this->input->post('id');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		if ($jenis == "trs_po") {
			$header =  $this->m_master->get_data_one($jenis, $field, $id)->row();
			// $data = $this->m_master->get_data_one("trs_po_detail", "no_po", $header->no_po)->result();
			$data = $this->db->query("SELECT * FROM trs_po a 
                    JOIN trs_po_detail b ON a.no_po = b.no_po
                    JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
                    LEFT JOIN m_kab d ON c.kab=d.kab_id
                    LEFT JOIN m_produk e ON b.id_produk=e.id_produk
					WHERE a.no_po = '".$header->no_po."'
				")->result();

		} else if ($jenis == "trs_so_detail") {
			$data =  $this->db->query(
				"SELECT * 
                FROM trs_so_detail a
                JOIN m_produk b ON a.id_produk=b.id_produk
                JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
                WHERE id = '$id' "
			)->row();
		} else if ($jenis == "trs_wo") {
			// $header =  $this->m_master->get_data_one($jenis, $field, $id)->row();
			$header =  $this->db->query("SELECT a.* ,CONCAT(b.no_so,'.',urut_so,'.',rpt) as no_so_1 from $jenis a LEFT JOIN trs_so_detail b ON a.no_so = b.id WHERE a.id='$id' ")->row();
			$detail = $this->m_master->get_data_one("trs_wo_detail", "no_wo", $header->no_wo)->row();

			$data = ["header" => $header, "detail" => $detail];
		} else if ($jenis == "SJ") {
			$header =  $this->db->query("SELECT a.*,IFNULL(qty_sj,0)qty_sj FROM trs_po_detail a 
                                    LEFT JOIN 
                                    (
                                    SELECT no_po,kode_mc,SUM(qty) AS qty_sj FROM `trs_surat_jalan` WHERE STATUS <> 'Batal' GROUP BY no_po,kode_mc
                                    )AS t_sj
                                    ON a.`no_po` = t_sj.no_po
                                    AND a.kode_mc = t_sj.kode_mc
                                    WHERE a.no_po ='$id' AND (a.qty - ifnull(qty_sj,0)) <> 0")->result();

			$data = ["header" => $header, "detail" => ""];
		} else if ($jenis == "SJView") {
			$header =  $this->db->query("SELECT a.*,IFNULL(qty_sj,0)qty_sj FROM trs_po_detail a 
                                    LEFT JOIN 
                                    (
                                    SELECT no_po,kode_mc,SUM(qty) AS qty_sj FROM `trs_surat_jalan` WHERE STATUS <> 'Batal' GROUP BY no_po,kode_mc
                                    )AS t_sj
                                    ON a.`no_po` = t_sj.no_po
                                    AND a.kode_mc = t_sj.kode_mc
                                    WHERE a.no_po ='$id' ")->result();

			$data = ["header" => $header, "detail" => ""];
		} else {
			$data =  $this->m_master->get_data_one($jenis, $field, $id)->row();
		}
		echo json_encode($data);
	}
	
	function hapus()
	{
		$jenis    = $_POST['jenis'];
		$field    = $_POST['field'];
		$id       = $_POST['id'];

		if ($jenis == "invoice") {
			$no_inv          = $_POST['no_inv'];			
			// ubah no pl
			$query_cek = $this->db->query("SELECT*FROM invoice_detail where no_invoice ='$no_inv'")->result();

			foreach( $query_cek as $row)
			{
				$db2            = $this->load->database('database_simroll', TRUE);

				if($row->type=='roll'){
					$update_no_pl   = $db2->query("UPDATE pl set no_pl_inv = 0 where id ='$row->id_pl'");					
				}else{
					$update_no_pl   = $db2->query("UPDATE pl_box set no_pl_inv = 0 where id ='$row->id_pl'");					

				}
			}

			if($update_no_pl)
			{

				$result          = $this->db->query("DELETE FROM invoice_header WHERE  $field = '$id'");

				$result          = $this->db->query("DELETE FROM invoice_detail WHERE  no_invoice = '$no_inv'");
			}
			
			
			
		} else {

			$result = $this->db->query("DELETE FROM $jenis WHERE  $field = '$id'");
		}

		echo json_encode($result);
	}

	function Cetak_Invoice()
	{
        $no_invoice = $_GET['no_invoice'];
        $ctk = 0;
        $html = '';

		//////////////////////////////////////// K O P ////////////////////////////////////////

        $data_detail = $this->db->query("SELECT * FROM invoice_header WHERE no_invoice='$no_invoice'")->row();
		$ppnpph = $data_detail->pajak;

		$html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">';

        if($ppnpph == 'nonppn'){
            $html .= '<tr>
                <th style="border:0;height:92px"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid #000;padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        }else{
            $html .= '<tr>
                <th style="border:0;width:15%;height:0"></th>
                <th style="border:0;width:55%;height:0"></th>
                <th style="border:0;width:25%;height:0"></th>
            </tr>

            <tr>
				<td rowspan="3" align="center">
					<img src="' . base_url() . 'assets/gambar/ppi.png"  width="80" height="70" />
				</td>
		   
                <td style="font-size:20px;" align="left">PT. PRIMA PAPER INDONESIA</td>

            </tr>
            <tr>
                <td style="font-size:11px" align="left">Dusun Timang Kulon, Desa Wonokerto, Kec.Wonogiri, Kab.Wonogiri</td>
                <td></td>
            </tr>
            <tr>
                <td style="font-size:11px;" align="left">WONOGIRI - JAWA TENGAH - INDONESIA Kode Pos 57615</td>
                <td style=""></td>
            </tr>
			<tr><td>&nbsp;<br></td></tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">
            <tr>
                <th style="height:0"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid #000;padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        }       

		//////////////////////////////////////// D E T A I L //////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="border:0;padding:2px 0;height:0;width:14%"></th>
            <th style="border:0;padding:2px 0;height:0;width:1%"></th>
            <th style="border:0;padding:2px 0;height:0;width:40%"></th>
            <th style="border:0;padding:2px 0;height:0;width:12%"></th>
            <th style="border:0;padding:2px 0;height:0;width:1%"></th>
            <th style="border:0;padding:2px 0;height:0;width:32%"></th>
        </tr>';

        $html .= '
        <tr>
            <td colspan="3"></td>
            <td style="padding:3px 0 20px;font-weight:bold">NOMOR</td>
            <td style="padding:3px 0 20px;font-weight:bold">:</td>
            <td style="padding:3px 0 20px;font-weight:bold">'.$data_detail->no_invoice.'</td>
        </tr>
        <tr>
            <td style="padding:3px 0">Nama Perusahaan</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->nm_perusahaan.'</td>
            <td style="padding:3px 0;font-weight:bold">Jatuh Tempo</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:3px 0;font-weight:bold;color:#f00">'.$this->m_fungsi->tanggal_format_indonesia($data_detail->tgl_jatuh_tempo).'</td>
        </tr>';

		$html .= '<tr>
			<td style="padding:3px 0">Alamat</td>
			<td style="padding:3px 0">:</td>
			<td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->alamat_perusahaan.'</td>
			<td style="padding:3px 0">No. PO</td>
			<td style="padding:3px 0">:</td>
			<td style="padding:0;line-height:1.8">';

			// KONDISI JIKA LEBIH DARI 1 PO
			$result_po = $this->db->query("SELECT * FROM invoice_detail WHERE no_invoice='$no_invoice' GROUP BY no_po ORDER BY no_po");
			if($result_po->num_rows() == '1'){
				$html .= $result_po->row()->no_po;;
			}else{
				foreach($result_po->result() as $r){
					$html .= $r->no_po.'<br/>';
				}
			}
		$html .= '</td>
		</tr>';

        $html .= '<tr>
            <td style="padding:3px 0">Kepada</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->kepada.'</td>
            <td style="padding:3px 0">No. Surat Jalan</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0;line-height:1.8">';

			// KONDISI JIKA LEBIH DARI 1 SURAT JALAN
			$result_sj = $this->db->query("SELECT * FROM invoice_detail WHERE no_invoice='$no_invoice' GROUP BY no_surat ORDER BY no_surat");
			if($result_sj->num_rows() == '1'){
				$html .= $result_sj->row()->no_surat;;
			}else{
				foreach($result_sj->result() as $r){
					$html .= $r->no_surat.'<br/>';
				}
			}
		$html .= '</td>
		</tr>';

        $html .= '</table>';

		/////////////////////////////////////////////// I S I ///////////////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="border:0;height:15px;width:30%"></th>
            <th style="border:0;height:15px;width:10%"></th>
            <th style="border:0;height:15px;width:15%"></th>
            <th style="border:0;height:15px;width:7%"></th>
            <th style="border:0;height:15px;width:10%"></th>
            <th style="border:0;height:15px;width:8%"></th>
            <th style="border:0;height:15px;width:20%"></th>
        </tr>';

        $html .= '<tr>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">NAMA BARANG</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">SATUAN</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">JUMLAH</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold" colspan="2">HARGA</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold" colspan="2">TOTAL</td>
        </tr>';
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';
		
		if($data_detail->type== 'roll')
		{
			$sqlLabel = $this->db->query("SELECT*FROM invoice_detail WHERE no_invoice='$no_invoice' GROUP BY nm_ker DESC,g_label ASC,no_po");
			// TAMPILKAN DULU LABEL
			$totalHarga = 0;
			foreach($sqlLabel->result() as $label){

				if($label->nm_ker == 'MH'){
					$jnsKertas = 'KERTAS MEDIUM';
				}else if($label->nm_ker == 'WP'){
					$jnsKertas = 'KERTAS COKLAT';
				}else if($label->nm_ker == 'BK'){
					$jnsKertas = 'KERTAS B-KRAFT';
				}else if($label->nm_ker == 'MEDIUM LINER'){
					$jnsKertas = 'KERTAS MEDIUM LINER';
				}else if($label->nm_ker == 'MH COLOR'){
					$jnsKertas = 'KERTAS MEDIUM COLOR';
				}else if($label->nm_ker == 'MN'){
					$jnsKertas = 'KERTAS MEDIUM NON SPEK';
				}else{
					$jnsKertas = '';
				}
				$html .= '<tr>
					<td style="border:0;padding:5px 0" colspan="7">'.$jnsKertas.' ROLL '.$label->g_label.' GSM</td>
				</tr>';

				// TAMPILKAN ITEMNYA
				$weightNmLbPo = 0;
				$sqlWidth = $this->db->query("SELECT*FROM invoice_detail
				WHERE no_invoice='$label->no_invoice' AND nm_ker='$label->nm_ker' AND g_label='$label->g_label' AND no_po='$label->no_po'
				ORDER BY width ASC");
				foreach($sqlWidth->result() as $items){
					// BERAT SESETAN
					$qty        = $items->qty - $items->retur_qty;
					$fixBerat   = $items->weight - $items->seset;
					$html .= '<tr>
						<td style="border:0;padding:5px 0">LB '.round($items->width,2).' = '.$qty.' ROLL</td>
						<td style="border:0;padding:5px 0;text-align:center">KG</td>
						<td style="border:0;padding:5px 0;text-align:right">'.number_format($fixBerat, 0, ",", ".").'</td>
						<td style="border:0;padding:5px 0" colspan="4"></td>
					</tr>';

					// TOTAL BERAT PER GSM - LABEL - PO
					$weightNmLbPo += $fixBerat;
				}

				// CARI HARGANYA
				$sqlHargaPo = $this->db->query("SELECT*FROM invoice_detail
				WHERE no_invoice='$label->no_invoice' AND nm_ker='$label->nm_ker' AND g_label='$label->g_label' AND no_po='$label->no_po'")->row();
				// PERKALIAN ANTARA TOTAL BERAT DAN HARGA PO
				$weightXPo = round($weightNmLbPo * $sqlHargaPo->harga);
				$html .= '<tr>
					<td style="border:0;padding:5px 0" colspan="2"></td>
					<td style="border-top:1px solid #000;padding:5px 0;text-align:right">'.number_format($weightNmLbPo, 0, ",", ".").'</td>
					<td style="border-top:1px solid #000;padding:5px 0 0 15px;text-align:right">Rp</td>
					<td style="border-top:1px solid #000;padding:5px 0;text-align:right">'.number_format($sqlHargaPo->harga, 0, ",", ".").'</td>
					<td style="border:0;padding:5px 0 0 15px;text-align:right">Rp</td>
					<td style="border:0;padding:5px 0;text-align:right">'.number_format($weightXPo, 0, ",", ".").'</td>
				</tr>';

				$totalHarga += $weightXPo;
			}

		}else{

			$sqlLabel = $this->db->query("SELECT*FROM invoice_detail WHERE no_invoice='$no_invoice' GROUP BY nm_ker DESC,g_label ASC,no_po");
			// TAMPILKAN DULU LABEL
			$totalHarga = 0;
			foreach($sqlLabel->result() as $label){

				$ukuran         = str_replace("X","x",$label->g_label);
				$total_harga    = round(($label->qty - $label->retur_qty) * $label->harga);

				$html .= '<tr>
					<td style="padding:5px 0">'.$label->nm_ker.' &nbsp;'.$ukuran.' &nbsp;'. $label->kualitas.'</td>
					<td style="padding:5px 0;text-align:center"> PCS</td>
					<td style="solid #000;padding:5px 0;text-align:right">'. number_format(($label->qty-$label->retur_qty), 0, ",", ".").'</td>
					<td style="solid #000;padding:5px 0 0 15px;text-align:right">Rp</td>
					<td style="solid #000;padding:5px 0;text-align:right">'. number_format($label->harga, 0, ",", ".").'</td>
					<td style="padding:5px 0 0 15px;text-align:right">Rp</td>
					<td style="padding:5px 0;text-align:right">'.number_format($total_harga, 0, ",", ".") .'</td>
				</tr>';


				$totalHarga += $total_harga;
			}
			

		}
		
		
		// T O T A L //
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

        // RUMUS
		if($ppnpph == 'ppn'){ // PPN 10 %
			if($data_detail->inc_exc=='Include')
			{
				$terbilang = round($totalHarga);
			}else if($data_detail->inc_exc=='Exclude')
			{
				$terbilang = round($totalHarga + (0.11 * $totalHarga));
			}else{
				$terbilang = '';
			}


			$rowspan = 3;
		}else if($ppnpph == 'ppn_pph'){ // PPH22

			if($data_detail->inc_exc=='Include')
			{
				$terbilang = round($totalHarga + (0.011 * $totalHarga));
			}else if($data_detail->inc_exc=='Exclude')
			{
				$terbilang = round($totalHarga + (0.11 * $totalHarga) + (0.011 * $totalHarga));
			}else{
				$terbilang = '';
			}
			
			$rowspan = 4;
		}else{ // NON
			$terbilang = $totalHarga;
			$rowspan = 2;
		}

		$html .= '<tr>
			<td style="border-width:2px 0;border:1px solid;font-weight:bold;padding:5px 0;line-height:1.8;text-transform:uppercase" colspan="3" rowspan="'.$rowspan.'">Terbilang :<br/><b><i>'.$this->m_fungsi->terbilang($terbilang).'</i></b></td>

			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0 0 15px" colspan="2">Sub Total</td>

			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0 0 15px">Rp</td>

			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0;text-align:right">'.number_format($totalHarga, 0, ",", ".").'</td>
		</tr>';

		// PPN - PPH22
		$ppn10 = 0.11 * $totalHarga;
        $pph22 = 0.011 * $totalHarga;
		if($data_detail->pajak=='ppn')
		{
			if($data_detail->inc_exc=='Include')
			{
				$nominal = 'KB';
			}else if($data_detail->inc_exc=='Exclude')
			{				
				$nominal = number_format($ppn10, 0, ",", ".");
			}else{
				$nominal = '';
			}

		}else{
			if($data_detail->inc_exc=='Include')
			{
				$nominal = 'KB';
			}else if($data_detail->inc_exc=='Exclude')
			{
				$nominal = number_format($ppn10, 0, ",", ".") ;
			}else{
				$nominal = '';
			}
		}
		$txtppn10 = '<tr>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px" colspan="2">Ppn 11%</td>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;font-weight:bold;padding:5px 0;text-align:right">'.$nominal.'</td>
			</tr>';

		if($ppnpph == 'ppn'){ // PPN 10 %
			$html .= $txtppn10;
		}else if($ppnpph == 'ppn_pph'){ // PPH22
			// pph22
			$html .= $txtppn10.'<tr>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px" colspan="2">Pph 22</td>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;font-weight:bold;padding:5px 0;text-align:right">'.number_format($pph22, 0, ",", ".").'</td>
			</tr>';
		}else{
			$html .= '';
		}

		$html .= '<tr>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0 0 15px" colspan="2">Total</td>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0 0 15px">Rp</td>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0;text-align:right">'.number_format($terbilang, 0, ",", ".").'</td>
		</tr>';

		//////////////////////////////////////////////// T T D ////////////////////////////////////////////////
		
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

		if($data_detail->bank=='BNI')
		{
			if($data_detail->pajak=='nonppn')
			{
				$norek='5758699099';
			}else{
				$norek='5758699690';
			}
		}else{
			if($data_detail->pajak=='nonppn')
			{
				$norek='078 795 5758';
			}else{
				$norek='078 027 5758';
			}
		}
		$html .= '<tr>
			<td style="border:0;padding:5px" colspan="3"></td>
			<td style="border:0;padding:5px;text-align:center" colspan="4">Wonogiri, '.$this->m_fungsi->tanggal_format_indonesia($data_detail->tgl_invoice).'</td> 
		</tr>
		<tr>
			<td style="border:0;padding:0 0 15px;line-height:1.8" colspan="3">Pembayaran Full Amount ditransfer ke :<br/>'.$data_detail->bank.' '.$norek.' (CABANG SOLO)<br/>A.n PT. PRIMA PAPER INDONESIA</td>
			<td style="border:0;padding:0" colspan="4"></td>
		</tr>
		<tr>
			<td style="border:0;padding:0;line-height:1.8" colspan="3">* Harap bukti transfer di email ke</td>
			<td style="border-bottom:1px solid #000;padding:0" colspan="4"></td>
		</tr>
		<tr>
			<td style="border:0;padding:0;line-height:1.8" colspan="3">primapaperin@gmail.com / bethppi@yahoo.co.id</td>
			<td style="border:0;padding:0;line-height:1.8;text-align:center" colspan="4">Finance</td>
		</tr>
		';

        $html .= '</table>';

        // $this->m_fungsi->newPDF($html,'P',77,0);
		$this->m_fungsi->_mpdf_hari('P', 'A4', 'INVOICE', $html, 'INVOICE.pdf', 5, 5, 5, 10);
		// echo $html;

    }

	public function coba_api()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.rajaongkir.com/starter/province?id=12",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"key: c479d0aa6880c0337184539462eeec6f"
		),
		));

		$response   = curl_exec($curl);
		$err        = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// echo $response;
			echo json_encode($response);
		}
	}

	//

	function Gudang()
	{
		$data_header = array(
			'judul' => "Gudang",
		);

		$this->load->view('header', $data_header);

		$jenis = $this->uri->segment(3);
		if($jenis == 'Add'){
			if(in_array($this->session->userdata('level'), ['Admin','Gudang'])){
				$this->load->view('Logistik/v_gudang_add');
			}else{
				$this->load->view('home');
			}
		}else{
			if(in_array($this->session->userdata('level'), ['Admin', 'Gudang'])){
				$this->load->view('Logistik/v_gudang');
			}else{
				$this->load->view('home');
			}
		}


		$this->load->view('footer');
	}

	function loadGudang()
	{
		$result = $this->m_logistik->loadGudang();
		echo json_encode($result);
	}

	function simpanGudang()
	{
		$result = $this->m_logistik->simpanGudang();
		echo json_encode($result);
	}

	function simpanTimbangan()
	{
		$result = $this->m_logistik->simpanTimbangan();
		echo json_encode($result);
	}

	function plhListPlan()
	{
		$html = '';
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		if($opsi == 'cor'){
			$where = "WHERE g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'flexo'){
			$where = "WHERE g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'finishing'){
			$where = "WHERE g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing!='0'";
		}else{
			$where = "";
		}

		$data = $this->db->query("SELECT p.nm_pelanggan,g.* FROM m_gudang g
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		$where
		GROUP BY p.nm_pelanggan");

		$html .= '<table class="table table-bordered" style="margin:0;border:0">
			<thead>';
				foreach($data->result() as $r){
					if($id_pelanggan == $r->gd_id_pelanggan){
						$bgTd = 'class="h-tlp-td"';
					}else{
						$bgTd = 'class="h-tlpf-td"';
					}

					$html .= '<tr>
						<td '.$bgTd.' style="padding:6px;border-width:0 0 1px">
							<a href="javascript:void(0)" onclick="plhListPlan('."'".$opsi."'".','."'".$r->gd_id_pelanggan."'".')">'.$r->nm_pelanggan.'</a>
						</td>
					</tr>';
				}
			$html .= '</thead>
		</table>';

		echo $html;
	}

	function loadListProduksiPlan()
	{
		$html = '';
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$data = $this->m_logistik->loadListProduksiPlan();

		if($data->num_rows() == 0){
			$html .='LIST';
		}else{
			$html .= '<div id="accordion">
				<div class="card m-0" style="border-radius:0">';
					$i = 0;
					foreach($data->result() as $r){
						$i++;
						$html .= '<div class="card-header" style="padding:0;border-radius:0">
							<a class="d-block w-100" style="font-weight:bold;padding:6px" data-toggle="collapse" href="#collapse'.$i.'" onclick="clickHasilProduksiPlan('."'".$opsi."'".','."'".$r->gd_id_pelanggan."'".','."'".$r->gd_id_produk."'".','."'".$r->kode_po."'".','."'".$i."'".')">
								'.$r->kode_po.' <span id="i_span'.$i.'" class="bg-secondary" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px;border-radius:4px">'.$r->jml_gd.'</span>
							</a>
						</div>
						<div id="collapse'.$i.'" class="collapse" data-parent="#accordion">
							<div id="isi-list-gudang-'.$i.'" style="padding:3px"></div>
						</div>';
					}
				$html .= '</div>
			</div>';
		}

		echo $html;
	}

	function clickHasilProduksiPlan()
	{
		$html = '';
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$no_po = $_POST["no_po"];
		$i = $_POST["i"];
		$data = $this->m_logistik->clickHasilProduksiPlan();

		$html .='<div style="overflow:auto;white-space:nowrap">
			<table class="table table-bordered" style="margin:0;border:0;text-align:center">
				<thead>
					<tr>
						<th style="background:#dee2e6;border-bottom:1px solid #bec2c6;padding:6px">PLAN</th>
						<th style="background:#dee2e6;border-bottom:1px solid #bec2c6;padding:6px">HASIL COR</th>
						<th style="background:#dee2e6;border-bottom:1px solid #bec2c6;padding:6px 25px">GOOD</th>
						<th style="background:#dee2e6;border-bottom:1px solid #bec2c6;padding:6px 18px">REJECT</th>
						<th style="background:#dee2e6;border-bottom:1px solid #bec2c6;padding:6px">AKSI</th>
					</tr>
				</thead>';
				foreach($data->result() as $r){
					// gd_good_qty  gd_reject_qty  gd_cek_spv
					
					if($opsi == 'cor'){
						$shift = $r->shift_plan;
						$mesin = str_replace('CORR', '', $r->machine_plan);
						$tgl = $r->tgl_plan;
					}else if($opsi == 'flexo'){
						$shift = $r->shift_flexo;
						$mesin = str_replace('FLEXO', '', $r->mesin_flexo);
						$tgl = $r->tgl_flexo;
					}else{
						$shift = $r->shift_fs;
						$mesin = substr($r->joint_fs,0,1);
						$tgl = $r->tgl_fs;
					}

					if($r->gd_cek_spv == 'Open'){
						$btnAksi = '<button type="button" id="simpan_gudang'.$r->id_gudang.'" class="btn btn-sm btn-success btn-block" style="font-weight:bold" onclick="simpanGudang('."'".$r->id_gudang."'".','."'".$opsi."'".','."'".$id_pelanggan."'".','."'".$id_produk."'".','."'".$no_po."'".','."'".$i."'".')">SIMPAN</button>';
						$disabledInput = '';
					}else{
						$btnAksi = '<button type="button" class="btn btn-sm btn-secondary btn-block" style="font-weight:bold;cursor:default" disabled)">SIMPAN</button>';
						$disabledInput = 'disabled';
					}

					$html .= '<tr>
						<td style="padding:6px;text-align:left">['.$shift.'.'.$mesin.'] '.substr($this->m_fungsi->getHariIni($tgl),0,3).', '.$this->m_fungsi->tglIndSkt($tgl).'</td>
						<td style="padding:6px">'.number_format($r->gd_hasil_plan,0,",",".").'</td>
						<td style="padding:6px">
							<input type="number" class="form-control" id="good-'.$r->id_gudang.'" autocomplete="off" value="'.$r->gd_good_qty.'" onkeyup="hitungGudang('."'".$r->id_gudang."'".')" '.$disabledInput.'>
						</td>
						<td style="padding:6px">
							<input type="number" class="form-control" id="reject-'.$r->id_gudang.'" autocomplete="off" value="'.$r->gd_reject_qty.'" onkeyup="hitungGudang('."'".$r->id_gudang."'".')" '.$disabledInput.'>
						</td>
						<td style="padding:6px">'.$btnAksi.'</td>
					</tr>';
				}
			$html .= '</table>
		</div>';

		echo $html;
	}

	function timeline()
	{
		$html = '';
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$no_po = $_POST["no_po"];

		if($opsi == 'cor'){
			$tgl = $this->db->query("SELECT*FROM m_gudang g
			INNER JOIN plan_cor c ON g.gd_id_plan_cor=c.id_plan
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL
			GROUP BY c.tgl_plan");
		}else if($opsi == 'flexo'){
			$tgl = $this->db->query("SELECT*FROM m_gudang g
			INNER JOIN plan_flexo fx ON g.gd_id_plan_cor=fx.id_plan_cor AND g.gd_id_plan_flexo=fx.id_flexo
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NULL
			GROUP BY fx.tgl_flexo");
		}else if($opsi == 'finishing'){
			$tgl = $this->db->query("SELECT*FROM m_gudang g
			INNER JOIN plan_finishing fs ON g.gd_id_plan_cor=fs.id_plan_cor AND g.gd_id_plan_flexo=fs.id_plan_flexo AND g.gd_id_plan_finishing=fs.id_fs
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NOT NULL
			GROUP BY fs.tgl_fs");
		}else{
			$tgl = '';
		}

		if($tgl == ''){
			$html .='kosong';
		}else{
			$html .='<div class="timeline">';
				$i = 0;
				foreach($tgl->result() as $r){
					$i++;

					if($opsi == 'cor'){
						$tglList = $r->tgl_plan;
						$list = $this->db->query("SELECT*FROM m_gudang g
						INNER JOIN plan_cor c ON g.gd_id_plan_cor=c.id_plan
						INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
						INNER JOIN m_produk p ON g.gd_id_produk=p.id_produk
						WHERE g.gd_id_pelanggan='$r->gd_id_pelanggan' AND g.gd_id_produk='$r->gd_id_produk' AND w.kode_po='$r->kode_po' AND c.tgl_plan='$r->tgl_plan'
						AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL
						ORDER BY c.tgl_plan");
					}else if($opsi == 'flexo'){
						$tglList = $r->tgl_flexo;
						$list = $this->db->query("SELECT*FROM m_gudang g
						INNER JOIN plan_flexo fx ON g.gd_id_plan_cor=fx.id_plan_cor AND g.gd_id_plan_flexo=fx.id_flexo
						INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
						INNER JOIN m_produk p ON g.gd_id_produk=p.id_produk
						WHERE g.gd_id_pelanggan='$r->gd_id_pelanggan' AND g.gd_id_produk='$r->gd_id_produk' AND w.kode_po='$r->kode_po' AND fx.tgl_flexo='$r->tgl_flexo'
						AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NULL
						ORDER BY fx.tgl_flexo");
					}else if($opsi == 'finishing'){
						$tglList = $r->tgl_fs;
						$list = $this->db->query("SELECT*FROM m_gudang g
						INNER JOIN plan_finishing fs ON g.gd_id_plan_cor=fs.id_plan_cor AND g.gd_id_plan_flexo=fs.id_plan_flexo AND g.gd_id_plan_finishing=fs.id_fs
						INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
						INNER JOIN m_produk p ON g.gd_id_produk=p.id_produk
						WHERE g.gd_id_pelanggan='$r->gd_id_pelanggan' AND g.gd_id_produk='$r->gd_id_produk' AND w.kode_po='$r->kode_po' AND fs.tgl_fs='$r->tgl_fs'
						AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NOT NULL
						ORDER BY fs.tgl_fs");
					}else{
						$tglList = '';
						$list = '';
					}

					$html .='<div class="time-label" style="margin-right:0">
						<span class="bg-gradient-red">'.$i.'. '.substr($this->m_fungsi->getHariIni($tglList),0,3).', '.$this->m_fungsi->tglIndSkt($tglList).'</span>
					</div>';

					$l = 0;
					foreach($list->result() as $r2){
						$l++;

						if($opsi == 'cor'){
							$shift = $r2->shift_plan;
							$txtMesin = 'MESIN';
							$mesin = str_replace('CORR', '', $r2->machine_plan);
						}else if($opsi == 'flexo'){
							$shift = $r2->shift_flexo;
							$txtMesin = 'MESIN';
							$mesin = str_replace('FLEXO', '', $r2->mesin_flexo);
						}else{
							$shift = $r2->shift_fs;
							$txtMesin = 'JOINT';
							$mesin = $r->joint_fs;
						}

						($r2->gd_cek_spv == 'Close') ? $bgBlue = 'bg-blue' : $bgBlue = 'bg-secondary';
						$html .='<div style="margin-right:5px">
							<i class="fas '.$bgBlue.'">'.$l.'</i>
							<div class="timeline-item mr-0">
								<h3 class="timeline-header p-0">
									<table style="width:100%">
										<tr>
											<th colspan="3" style="background:#dee2e6;padding:10px;border-bottom:1px solid #bec2c6">DETAIL</th>
										</tr>
										<tr>
											<th style="padding:5px">NO.WO</th>
											<th>:</th>
											<th style="padding:5px">'.$r2->no_wo.'</th>
										</tr>
										<tr>
											<th style="padding:5px">KD.MC</th>
											<th>:</th>
											<th style="padding:5px">'.$r2->kode_mc.'</th>
										</tr>
										<tr>
											<th colspan="3" style="background:#dee2e6;padding:10px;border:1px solid #bec2c6;border-width:1px 0">PRODUKSI</th>
										</tr>
										<tr>
											<th style="padding:5px">SHIFT</th>
											<th>:</th>
											<th style="padding:5px">'.$shift.'</th>
										</tr>
										<tr>
											<th style="padding:5px">'.$txtMesin.'</th>
											<th>:</th>
											<th style="padding:5px">'.$mesin.'</th>
										</tr>
										<tr>
											<th style="padding:5px">HASIL</th>
											<th>:</th>
											<th style="padding:5px">'.number_format($r2->gd_hasil_plan,0,",",".").'</th>
										</tr>';
										if($r2->gd_cek_spv == 'Close'){
											$html .='<tr>
												<th colspan="3" style="background:#dee2e6;padding:10px;border:1px solid #bec2c6;border-width:1px 0">GUDANG</th>
											</tr>
											<tr>
												<th style="padding:5px">GOOD</th>
												<th>:</th>
												<th style="padding:5px">'.number_format($r2->gd_good_qty,0,",",".").'</th>
											</tr>
											<tr>
												<th style="padding:5px">REJECT</th>
												<th>:</th>
												<th style="padding:5px">'.number_format($r2->gd_reject_qty,0,",",".").'</th>
											</tr>';
										}
									$html .='</table>
								</h3>
							</div>
						</div>';
					}
				}
				$html .='<div>
					<i class="fas fa-clock bg-gray"></i>
				</div>
			</div>';
		}

		echo $html;
	}

}
