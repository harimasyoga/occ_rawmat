<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Laporan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_laporan');
		$this->load->model('m_fungsi');
	}

	public function Laporan()
	{
		$data = array(
			'judul' => "Laporan",
		);
		$this->load->view('header', $data);
		$this->load->view('Laporan/v_laporan');
		$this->load->view('footer');
	}

	function Laporan_Stok()
	{

		$query = $this->m_master->query("SELECT * FROM m_produk ORDER BY id_produk ");

		$html = '';


		if ($query->num_rows() > 0) {

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td colspan="4" align="center">
                              <h1> Laporan Stok</h1>
                              
                            </td>
                        </tr>
                 </table><br>';

			$html .= '<table width="100%" border="1" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr>
                            <th align="center">ID Produk</th>
                            <th align="center">Nama Produk</th>
                            <th align="center">Satuan</th>
                            <th align="center">Stok</th>
                        </tr>';
			$tot_stok = 0;
			foreach ($query->result() as $r) {
				$html .= '
                            <tr>
                                <td align="center">' . $r->id_produk . '</td>
                                <td align="center">' . $r->nm_produk . '</td>
                                <td align="center">' . $r->satuan . '</td>
                                <td align="center">' . number_format($r->stok, 0, ",", ".") . '</td>
                            </tr>';

				$tot_stok += $r->stok;
			}
			$html .= '
                            <tr style="background-color: #959a9a">
                                <td align="right" colspan="3">Total</td>
                                <td align="center">' . number_format($tot_stok, 0, ",", ".") . '</td>
                            </tr>';
			$html .= '
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$judul = "Laporan Stok";

		if (/*$ctk*/'1' == '0') {
			echo $html;
		} else {
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=$judul.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$data['prev'] = $html;
			$this->load->view('view_excel', $data);
		}
	}

	function lap_cost($periode, $id_kategori, $ctk)
	{
		$data_tgl = $this->db->query("SELECT DATE_FORMAT(tanggal,'%d') day,tanggal FROM `tr_pemakaian` WHERE id_kategori='$id_kategori' AND DATE_FORMAT(tanggal,'%Y-%m') = '$periode' GROUP BY tanggal");

		$nm_kategori = $this->db->query("SELECT nm_kategori from m_kategori where id = '$id_kategori' ")->row("nm_kategori");
		$html = '';


		if ($data_tgl->num_rows() > 0) {
			$colspan = $data_tgl->num_rows() + 2;
			$tot_cost = 0;

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td colspan="' . $colspan . '" align="center"><h1> COST ' . $nm_kategori . '</h1></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="color:blue" colspan="2"><h2>' . $this->m_fungsi->periode_indonesia($periode . "-01") . '</h2>
                            <td colspan="' . $data_tgl->num_rows() . '" align="center"></td>
                        </tr>
                 </table>';

			$html .= '<table width="100%" border="1" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td>Tanggal</td>
                            <td>Harga Satuan</td>';
			foreach ($data_tgl->result() as $r) {
				$html .= '<td>' . $r->day . '</td>';
			}
			$html .= '
                             <td>Total Cost</td>
                        </tr>
                        <tr style="background-color:yellow;font-weight: bold;">
                            <td>Hasil Rewinder</td>
                            <td></td>';
			$tot_rewinder = 0;
			foreach ($data_tgl->result() as $r) {
				$rewinder =  $this->db->query("SELECT nominal FROM `m_rewinder` WHERE  tanggal = '" . $r->tanggal . "' ")->row();
				$html .= '<td align="right">' . number_format($rewinder->nominal, 2, ",", ".") . '</td>';
				$tot_rewinder += $rewinder->nominal;
			}
			$html .= '
                            <td align="right">' . number_format($tot_rewinder, 2, ",", ".") . '</td>
                        </tr>';

			$sub_kategori = $this->db->query("SELECT * FROM `m_sub_kategori` WHERE id_kategori='$id_kategori' and status='1' ORDER BY nm_sub_kategori ")->result();

			$tot_pemakaian = 0;
			foreach ($sub_kategori as $sub) {
				$html .= '
                             <tr style="font-weight: bold;">
                                <td>' . $sub->nm_sub_kategori . '</td>
                                <td></td>';
				foreach ($data_tgl->result() as $r) {

					$html .= '<td></td>';
				}
				$html .= '
                                <td></td>
                             </tr>';


				$produk = $this->db->query("SELECT * FROM `m_produk` WHERE id_kategori='$id_kategori' AND id_sub_kategori='" . $sub->id . "' and status='1' ORDER BY nm_produk ")->result();

				foreach ($produk as $pro) {
					$harga = $this->db->query("SELECT ifnull(harga,0) harga FROM `m_harga` WHERE id_produk='" . $pro->id . "' AND DATE_FORMAT(tanggal,'%Y-%m') = '$periode' ORDER BY id DESC limit 1");

					$html .= '
                                     <tr>
                                        <td style="padding-left:10px"> * ' . $pro->nm_produk . '</td>
                                        <td>' . ($harga->num_rows() > 0 ? number_format($harga->row()->harga, 2, ",", ".") : 0) . '</td>';

					$tot_cost_samping = 0;
					foreach ($data_tgl->result() as $r) {
						$pemakaian = $this->db->query("SELECT ifnull(nominal,0) nominal,ifnull(harga,0) harga FROM `tr_pemakaian` WHERE id_produk='" . $pro->id . "' AND tanggal = '" . $r->tanggal . "' limit 1");



						if ($pro->id == '55') {
							$jum_pemakaian = 0;
						} else if ($pro->id == '56') {
							$pemakaian = $this->db->query("SELECT sum(ifnull(nominal,0)) nominal,ifnull(harga,0) harga FROM `tr_pemakaian` WHERE id_produk in (53) AND tanggal = '" . $r->tanggal . "' limit 1");


							$pemakaian1 = $this->db->query("SELECT sum(ifnull(nominal,0)) nominal,ifnull(harga,0) harga FROM `tr_pemakaian` WHERE id_produk in (54) AND tanggal = '" . $r->tanggal . "' limit 1");


							$jum_pemakaian = ($pemakaian->num_rows() > 0 ? $pemakaian->row()->harga : 0) * ($pemakaian->num_rows() > 0 ? $pemakaian->row()->nominal : 0);

							$jum_pemakaian1 = ($pemakaian1->num_rows() > 0 ? $pemakaian1->row()->harga : 0) * ($pemakaian1->num_rows() > 0 ? $pemakaian1->row()->nominal : 0);

							$jum_pemakaian = ($jum_pemakaian + $jum_pemakaian1) * 0.03;
						} else {

							$jum_pemakaian = ($pemakaian->num_rows() > 0 ? $pemakaian->row()->harga : 0) * ($pemakaian->num_rows() > 0 ? $pemakaian->row()->nominal : 0);
						}

						$html .= '<td align="right">' . number_format(round($jum_pemakaian), 2, ",", ".") . '</td>';

						$tot_cost_samping += $jum_pemakaian;
					}


					$html .= '
                                        <td align="right">' . number_format($tot_cost_samping, 2, ",", ".") . '</td>
                                     </tr>';
				}

				if ($id_kategori == '3') {

					$html .= '
                                 <tr style="font-weight: bold;">
                                    <td>Total </td>
                                    <td></td>';
					foreach ($data_tgl->result() as $r) {
						$pemakaian = $this->db->query("SELECT SUM(nominal) nominal FROM ( SELECT  ((nominal) * (harga)) nominal FROM tr_pemakaian a WHERE id_sub_kategori = '" . $sub->id . "' AND tanggal ='" . $r->tanggal . "' and id_produk <> 55)z")->row("nominal");

						$pemakaian1 = $this->db->query("SELECT SUM(nominal) nominal FROM ( SELECT  ((nominal) * (harga))nominal FROM tr_pemakaian a WHERE id_sub_kategori = '" . $sub->id . "' AND tanggal ='" . $r->tanggal . "' and id_produk in (53,54) )z")->row("nominal");

						if ($sub->id == '17') {
							$pemakaian = $pemakaian + ($pemakaian1 * 0.03);
						}
						$html .= '<td align="right">' . number_format(round($pemakaian), 2, ",", ".") . '</td>';
					}
					$html .= '
                                    <td></td>
                                 </tr>
                                 <tr style="background-color:#3cd7ea;font-weight: bold;">
                                    <td>BIAYA ' . $sub->nm_sub_kategori . ' / KG PAPER</td>
                                    <td></td>';
					foreach ($data_tgl->result() as $r) {
						$pemakaian = $this->db->query("SELECT SUM(nominal) nominal FROM ( SELECT  ((nominal) * (harga)) nominal FROM tr_pemakaian a WHERE id_sub_kategori = '" . $sub->id . "' AND tanggal ='" . $r->tanggal . "' and id_produk <> '55' )z")->row("nominal");

						$rewinder = $this->db->query("SELECT * FROM m_rewinder WHERE  tanggal ='" . $r->tanggal . "'")->row("nominal");

						if ($sub->id == '17') {
							# code...
							$biaya =  ($pemakaian / $rewinder) + (($pemakaian * 0.03) / $rewinder);
						} else {
							$biaya =  ($pemakaian / $rewinder);
						}

						$html .= '<td align="right">' . number_format($biaya, 2, ",", ".") . '</td>';
					}
					$html .= '
                                    <td></td>
                                 </tr>';
				}
			}
			if ($id_kategori != '3') {
				$html .= '
                         <tr style="font-weight: bold;">
                            <td>Total ' . $nm_kategori . '</td>
                            <td></td>';
				$tot_cost = 0;
				foreach ($data_tgl->result() as $r) {

					$tot_pemakaian = $this->db->query("SELECT  SUM(pemakaian) pemakaian FROM (
                                      SELECT (nominal * harga) pemakaian FROM tr_pemakaian a WHERE tanggal ='" . $r->tanggal . "' AND id_kategori = '$id_kategori' )z
                                        ")->row("pemakaian");



					$html .= '<td align="right">' . number_format($tot_pemakaian, 2, ",", ".") . '</td>';
					$tot_cost += $tot_pemakaian;
				}

				//total cost samping
				$tot_cost_samping_bawah = $this->db->query("SELECT sum(total) total FROM ( SELECT ((nominal) * (harga)) total  FROM `tr_pemakaian` 
                                 WHERE DATE_FORMAT(tanggal,'%Y-%m') = '$periode' AND id_kategori = '$id_kategori' AND id_produk NOT IN (28,29,30,31,32,33) )z")->row("total");
				$html .= '
                            <td align="right">' . number_format($tot_cost_samping_bawah, 2, ",", ".") . '</td>
                        </tr>
                         <tr style="font-weight: bold;background-color:#3cd7ea">
                            <td>BIAYA ' . $nm_kategori . ' /KG PAPER </td>
                            <td></td>';
				foreach ($data_tgl->result() as $r) {
					$rewinder =  $this->db->query("SELECT nominal FROM `m_rewinder` WHERE  tanggal = '" . $r->tanggal . "' ")->row();
					$tot_bahan_baku =  $this->db->query("SELECT  SUM(pemakaian) nominal FROM (
                                      SELECT (nominal * harga) pemakaian FROM tr_pemakaian a WHERE tanggal ='" . $r->tanggal . "' AND id_kategori = '$id_kategori' )z
                                        ")->row("nominal");


					$biaya = $tot_bahan_baku / $rewinder->nominal;
					$html .= '<td align="right">' . number_format($biaya, 2, ",", ".") . '</td>';
				}
				$html .= '
                            <td></td>
                        </tr>';
			}

			$html .= '
                    </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$kategori = $this->db->query("SELECT nm_kategori from m_kategori WHERE id='$id_kategori' ")->row("nm_kategori");

		$kategori = str_replace(",", "", $kategori);
		$judul = "Laporan Cost " . $kategori . " periode " . $periode;

		if ($ctk == '0') {
			echo $html;
		} else {
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=$judul.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$data['prev'] = $html;
			$this->load->view('view_excel', $data);
		}
	}

	function cetak_data()
	{
		// $no_stok  = $_GET['no_stok'];
		 
		$pilih_type   = $_GET['a'];
		$tgl_harian   = $_GET['b'];
		$tgl1_inv     = $_GET['c'];
		$tgl2_inv     = $_GET['d'];
		$bulan        = $_GET['e'];
		$thun         = $_GET['f'];
		$html         = '';


		if($pilih_type=='HARIAN')
		{
			$judull    = "HARIAN";
			$judull2   = $this->m_fungsi->tanggal_format_indonesia($tgl_harian);
		}else{

		}
		$html .= '<br>';
		// $html .= '<h1> Data Kosong </h1>';
		$html .= '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:22px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr >
			<td align="center"><b><u>LAPORAN '.$judull.'</u><b></td>
		</tr> 
		<tr >
			<td align="center" style="font-size:15px;"><b>( '.$judull2.' )<b></td>
		</tr> 
		</table>';

		
		$html .= '<br><br>';

		$html .= '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr >
			<td><b>SALDO AWAL : <b></td>
		</tr> 
		</table>';
		
		$html .= '<br>';

		$query_masuk = $this->db->query("SELECT sum(nominal)nominal_masuk from invoice_masuk_umum where tgl_inv_masuk in ('$tgl_harian')")->row();

			
		$html .= '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr >
			<td><b>SALDO MASUK : Rp '.number_format($query_masuk->nominal_masuk, 0, ",", ".").'<b></td>
		</tr> 
		</table>';
		
		$html .= '<br>';

		$html .= '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr >
			<td colspan="2"><b>PEMBELIAN BAHAN BAKU :<b></td>
			<td colspan="4"><b>&nbsp;<b></td>
		</tr> 
		</table>';

		// kardus
		$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr style="background-color: #cccccc;">
			<th style="" width="5%" align="center">NO</th>
			<th style="" width="15%" align="center">JENIS</th>
			<th style="" width="15%" align="center">SUPPLIER</th>
			<th style="" width="15%" align="center">NO PLAT</th>
			<th style="" width="15%" align="center">QTY</th>
			<th style="" width="15%" align="center">HARGA</th>
			<th style="" width="20%" align="center">TOTAL </th>
		</tr>';

		if($pilih_type=='HARIAN')
		{
			$querydetail = $this->db->query("SELECT*from invoice_beli_bhn 
			where tgl_inv_bhn ='$tgl_harian' AND jenis in('KARDUS')
			order by tgl_inv_bhn,pilihan,jenis,suplier");

			$no = 1;
			$tot_qty = $tot_value = $tot_total = 0;
			foreach ($querydetail->result() as $r) {

                $total = $r->nominal*$r->qty;
				$html .= '
				<tr >
					<td align="center">' . $no . '</td>
					<td align="left">' . $r->jenis . '</td>
					<td align="left">' . $r->suplier . '</td>
					<td align="center">' . $r->plat . '</td>
					<td align="right">' . number_format($r->qty, 0, ",", ".") . '</td>
					<td align="right">' . number_format($r->nominal, 0, ",", ".") . '</td>
					<td align="right">' . number_format($total, 0, ",", ".") . '</td>
					</tr>';

				$no++;
				$tot_qty += $r->qty;
				$tot_total += $total;
			}
			$html .= '
				<tr style="background-color: #cccccc;">
					<th style="" colspan="4" align="center">TOTAL BOX</th>
					<th style="" width="15%" align="right">'.number_format($tot_qty, 0, ",", ".").'</th>
					<th style="" width="20%" align="center">&nbsp;</th>
					<th style="" width="20%" align="right">'.number_format($tot_total, 0, ",", ".").' </th>
				</tr>';
			$html .= '</table>';
		}
		
		$html .= '<br>';

		// duplex
		$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr style="background-color: #cccccc;">
			<th style="" width="5%" align="center">NO</th>
			<th style="" width="15%" align="center">JENIS</th>
			<th style="" width="15%" align="center">SUPPLIER</th>
			<th style="" width="15%" align="center">NO PLAT</th>
			<th style="" width="15%" align="center">QTY</th>
			<th style="" width="15%" align="center">HARGA</th>
			<th style="" width="20%" align="center">TOTAL </th>
		</tr>';

		if($pilih_type=='HARIAN')
		{
			$querydetail = $this->db->query("SELECT*from invoice_beli_bhn 
			where tgl_inv_bhn ='$tgl_harian' AND jenis in('DUPLEX')
			order by tgl_inv_bhn,pilihan,jenis");

			$no = 1;
			$tot_qty = $tot_value = $tot_total = 0;
			
			if($querydetail->num_rows()>0)
			{			

				foreach ($querydetail->result() as $r) {

					$total = $r->nominal*$r->qty;
					$html .= '
					<tr >
						<td align="center">' . $no . '</td>
						<td align="left">' . $r->jenis . '</td>
						<td align="left">' . $r->suplier . '</td>
						<td align="center">' . $r->plat . '</td>
						<td align="right">' . number_format($r->qty, 0, ",", ".") . '</td>
						<td align="right">' . number_format($r->nominal, 0, ",", ".") . '</td>
						<td align="right">' . number_format($total, 0, ",", ".") . '</td>
						</tr>';

					$no++;
					$tot_qty += $r->qty;
					$tot_total += $total;
				}

			}else{


				$html .= '
					<tr><td colspan="7">Data Kosong..</td>';

			}
			$html .= '
				<tr style="background-color: #cccccc;">
					<th style="" colspan="4" align="center">TOTAL DUPLEX</th>
					<th style="" width="15%" align="right">'.number_format($tot_qty, 0, ",", ".").'</th>
					<th style="" width="20%" align="center">&nbsp;</th>
					<th style="" width="20%" align="right">'.number_format($tot_total, 0, ",", ".").' </th>
				</tr>';

			$html .= '</table>';
		}

		$html .= '<br>';
		// $html .= '<h1> Data Kosong </h1>';


		$html .= '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr >
			<td colspan="2"><b>PEMBELIAN UMUM :<b></td>
			<td colspan="4"><b>&nbsp;<b></td>
		</tr> 
		</table>';

		// umum
		$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: Trebuchet MS, Helvetica, sans-serif;">
		<tr style="background-color: #cccccc;">
			<th style="" width="5%" align="center">NO</th>
			<th style="" width="15%" align="center">JENIS</th>
			<th style="" width="15%" align="center">QTY</th>
			<th style="" width="15%" align="center">HARGA</th>
			<th style="" width="20%" align="center">TOTAL </th>
		</tr>';

		if($pilih_type=='HARIAN')
		{
			$querydetail = $this->db->query("SELECT*from invoice_beli_bhn 
			where tgl_inv_bhn ='$tgl_harian' AND pilihan in('UMUM')
			order by tgl_inv_bhn,pilihan,jenis");

			$no = 1;
			$tot_qty = $tot_value = $tot_total = 0;
			foreach ($querydetail->result() as $r) {

                $total = $r->nominal*$r->qty;
				$html .= '
				<tr >
					<td align="center">' . $no . '</td>
					<td align="left">' . $r->jenis . '</td>
					<td align="right">' . number_format($r->qty, 0, ",", ".") . '</td>
					<td align="right">' . number_format($r->nominal, 0, ",", ".") . '</td>
					<td align="right">' . number_format($total, 0, ",", ".") . '</td>
					</tr>';

				$no++;
				$tot_qty += $r->qty;
				$tot_total += $total;
			}
			$html .= '
				<tr style="background-color: #cccccc;">
					<th style="" colspan="2" align="center">TOTAL LAIN-LAIN</th>
					<th style="" width="15%" align="right">'.number_format($tot_qty, 0, ",", ".").'</th>
					<th style="" width="20%" align="center">&nbsp;</th>
					<th style="" width="20%" align="right">'.number_format($tot_total, 0, ",", ".").' </th>
				</tr>';
			$html .= '</table>';
		}
		
		$html .= '<br>';
		


		$data['prev']   = $html;
		$judul          = $pilih_type;
		$jdl_save       = $pilih_type;
		$position       = 'P';
		$cekpdf         = '1';

		// echo $html;
		$this->m_fungsi->_mpdf_hari($position, 'A4', $judul, $html, $jdl_save.'.pdf', 5, 5, 5, 10,'','','',$data->nm_hub);
			
	}
}
