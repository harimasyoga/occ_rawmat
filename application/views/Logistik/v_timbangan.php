<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right"></ol>
			</div>
			</div>
		</div>
	</section>

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<section class="content">
		<div class="card shadow mb-3">
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;">		
						<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
						</div>
				</div>
				<div class="card-body" >
					<div class="row">
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','Laminasi','User'])){ ?>
						<div style="margin-bottom:12px; position: absolute;left: 20px;">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>

						<div class="" style="position: absolute;left: 250px; font-weight:bold">
								<select id="list_hub" class="form-control select2" onchange="load_data()">
								<?php
										$query = $this->db->query("SELECT*FROM m_hub order by id_hub");
										$html ='';
										$html .='<option value="">SEMUA</option>';
										foreach($query->result() as $r){
											$html .='<option value="'.$r->id_hub.'">'.$r->nm_hub.'</option>';
										}
										echo $html
									?>
								</select>
						</div>
						<?php } ?>
					</div>
					<br>
					<br>
					
					<div style="overflow:auto;white-space:nowrap">
						<table id="datatable_list" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th style="text-align: center; width:5%">NO.</th>
									<th style="text-align: center; width:10%">NO TIMBANGAN</th>
									<th style="text-align: center; width:10%">REQ</th>
									<th style="text-align: center; width:15%">TGL MASUK</th>
									<th style="text-align: center; width:20%">CUST</th>
									<th style="text-align: center; width:10%">JENIS</th>
									<th style="text-align: center; width:20%">CATATAN</th>
									<th style="text-align: center; width:10%">BERAT BERSIH</th>
									<th style="text-align: center; width:10%">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>			
		</div>
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>INPUT PO BAHAN BAKU</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
								
					<br>
						
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">HUB</div>
						<div class="col-md-9">
							<select id="hub_occ" name="hub_occ" class="form-control select2" style="width: 100%" >
							</select>

						</div>
						<!-- <div class="col-md-6"></div> -->
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">NO TIMBANGAN</div>
						<div class="col-md-3">
							<input type="hidden" id="id_timbangan" name="id_timbangan" value="">
							<input type="hidden" id="sts_input" name="sts_input" value="add">
							<input type="text" class="form-control" id="no_timbangan" name="no_timbangan" value="OTOMATIS" readonly>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">PERMINTAAN</div>
						<div class="col-md-3">
							<input type="text" name="permintaan" id="permintaan" class="form-control" value="PPI" oninput="this.value = this.value.toUpperCase() ">
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">JENIS</div>
						<div class="col-md-3">							
							<select id="jns" name="jns" class="form-control select2" style="width: 100%" >
								<option value="TERIMA">TERIMA</option>
								<option value="KIRIM">KIRIM</option>
								<option value="SUPLAI">SUPLAI</option>
								<!-- <option value="STOK">STOK PPI</option> -->
							</select>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">PENIMBANG</div>
						<div class="col-md-3">
							<select id="penimbang" name="penimbang" class="form-control select2">
								<option value="Feri S">Feri S</option>
								<option value="DWI J">DWI J</option>
							</select>
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">MASUK</div>
						<div class="col-md-3">
							<input type="datetime-local" name="masuk" id="masuk" class="form-control" >

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">CATATAN</div>
						<div class="col-md-3">
							<input type="text" name="cttn" id="cttn" class="form-control" oninput="this.value = this.value.toUpperCase() ">
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">KELUAR</div>
						<div class="col-md-3">
							<input type="datetime-local" name="keluar" id="keluar" class="form-control" >

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">CUSTOMER</div>
						<div class="col-md-3">
							<input type="text" name="supplier" id="supplier" class="form-control" value="PT. PRIMA PAPER INDONESIA" oninput="this.value = this.value.toUpperCase() ">
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">BERAT KOTOR</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
								<input type="text" name="b_kotor" id="b_kotor" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)">
								<div class="input-group-append">
									<span class="input-group-text">Kg</span>
								</div>
							</div>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">ALAMAT</div>
						<div class="col-md-3">
							<input type="text" name="alamat" id="alamat" class="form-control" value="Timang Kulon, Wonokerto, Wonogiri" oninput="this.value = this.value.toUpperCase() ">
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">BERAT TRUK</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
								<input type="text" name="berat_truk" id="berat_truk" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)">
								<div class="input-group-append">
									<span class="input-group-text">Kg</span>
								</div>
							</div>			

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">NO POLISI</div>
						<div class="col-md-3">
							<input type="text" name="nopol" id="nopol" class="form-control" oninput="this.value = this.value.toUpperCase() ">
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">BERAT BERSIH</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
								<input type="text" name="berat_bersih" id="berat_bersih" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)">
								<div class="input-group-append">
									<span class="input-group-text">Kg</span>
								</div>
							</div>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">BARANG</div>
						<div class="col-md-3">
							<input type="text" name="barang" id="barang" class="form-control" value="OCC LOKAL" oninput="this.value = this.value.toUpperCase() ">
						</div>
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">POTONGAN</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
								<input type="text" name="pot" id="pot" class="angka form-control" onkeyup="ubah_angka(this.value,this.id)">
								<div class="input-group-append">
									<span class="input-group-text">Kg</span>
								</div>
							</div>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">SOPIR</div>
						<div class="col-md-3">
							<input type="text" name="sopir" id="sopir" class="form-control" oninput="this.value = this.value.toUpperCase() ">
						</div>
					</div>

					
					<br>
				
					<div class="card-body row"style="font-weight:bold">
						<div class="col-md-4">
							<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
								<i class="fa fa-undo" ></i> Kembali</b>
							</button>

							<span id="btn-simpan"></span>

						</div>
						
						<div class="col-md-6"></div>
						
					</div>

					<br>
					
				</div>
			</form>	
		</div>
		<!-- /.card -->
	</section>
</div>

<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		load_hub()
		$('.select2').select2();
	});

	function load_hub() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_hub",
			// data       : { idp: pelanggan, kd: '' },
			dataType   : 'json',
			beforeSend: function() {
				swal({
				title: 'loading ...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success:function(data){			
				if(data.message == "Success"){					
					option = `<option value="">-- Pilih --</option>`;	

					$.each(data.data, function(index, val) {
					option += `<option value="${val.id_hub}" data-aka="${val.aka}" >${val.nm_hub}</option>`;

					});

					$('#hub_occ').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";			
					$('#hub_occ').html(option);					
					swal.close();
				}
			}
		});
	}

	function load_aka()
	{
		var aka = $('#hub option:selected').attr('data-aka');
		$("#aka").val(aka)
	}

	function hitung_total()
	{
		var ton   = $("#ton").val().split('.').join('')
		var harga = $("#harga").val().split('.').join('')

		var total = ton*harga		
		$("#total_po").val(format_angka(total))
		
	}

	function reloadTable() 
	{
		table = $('#datatable_list').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		var list_hub    = $("#list_hub").val()
		let table       = $('#datatable_list').DataTable();
		table.destroy();
		tabel = $('#datatable_list').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/Timbangan')?>',
				"type": "POST", 
				"data"  : { id_hub:list_hub },
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			"responsive": false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}
	
	function edit_data(id,no_timbangan)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, tbl:'m_jembatan_timbang', jenis :'timbangan',field :'id_timbangan' },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				if(data){
					// header
					$("#id_timbangan").val(data.header.id_timbangan);
					$("#no_timbangan").val(data.header.no_timbangan);
					$("#hub_occ").val(data.header.id_hub_occ).trigger('change');
					$("#jns").val(data.header.jns).trigger('change');
					$("#penimbang").val(data.header.nm_penimbang).trigger('change');
					$("#permintaan").val(data.header.permintaan);					
					$("#supplier").val(data.header.suplier);					
					$("#masuk").val(data.header.date_masuk);					
					$("#alamat").val(data.header.alamat);					
					$("#keluar").val(data.header.date_keluar);					
					$("#nopol").val(data.header.no_polisi);					
					$("#b_kotor").val(format_angka(data.header.berat_kotor));					
					$("#barang").val(data.header.nm_barang);					
					$("#berat_truk").val(format_angka(data.header.berat_truk));					
					$("#sopir").val(data.header.nm_sopir);					
					$("#berat_bersih").val(format_angka(data.header.berat_bersih));					
					$("#cttn").val(data.header.catatan);					
					$("#pot").val(format_angka(data.header.potongan));		

					swal.close();

				} else {

					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});
	}

	function kosong()
	{
		var tgl_now = '<?= date('Y-m-d') ?>'
		$("#no_po_old").val("")
		$("#id_po_bhn").val("")
		$("#no_po").val("AUTO")
		$("#ton").val("")
		$("#tgl_po").val(tgl_now)
		$("#harga").val("")
		$("#hub").val("")
		$("#total_po").val("")		
		swal.close()
	}

	function simpan() 
	{
		var hub_occ    	  = $("#hub_occ").val();
		var permintaan    = $("#permintaan").val();
		var jns           = $("#jns").val();
		var penimbang     = $("#penimbang").val();
		var masuk         = $("#masuk").val();
		var cttn          = $("#cttn").val();
		var keluar        = $("#keluar").val();
		var supplier      = $("#supplier").val();
		var b_kotor       = $("#b_kotor").val();
		var alamat        = $("#alamat").val();
		var berat_truk    = $("#berat_truk").val();
		var nopol         = $("#nopol").val();
		var berat_bersih  = $("#berat_bersih").val();
		var barang        = $("#barang").val();
		var pot           = $("#pot").val();
		var sopir         = $("#sopir").val();
		
		
		if ( hub_occ  == '' || permintaan == '' || jns == '' || penimbang == '' || masuk == '' || cttn == '' || keluar == '' || supplier == '' || b_kotor == '' || b_kotor == 0 || berat_truk == '' || berat_truk == 0 || berat_bersih == '' || berat_bersih == 0 || alamat == '' || nopol == '' || barang == '' || pot == '' || sopir == '' ) 
		{			
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/simpanTimbangan',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading ...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				if(data == true){
					// toastr.success('Berhasil Disimpan');
					// swal.close();								
					kosong();
					location.href = "<?= base_url()?>Logistik/Timbangan";
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					
				} else {
					// toastr.error('Gagal Simpan');
					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});

	}

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function deleteTimbangan(id_timbangan,no_timb) 
	{
		swal({
			title : "TIMBANGAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no_timb+ " </strong> ",
			type : "question",
			showCancelButton : true,
			confirmButtonText : '<b>Hapus</b>',
			cancelButtonText : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass : 'btn btn-danger',
			cancelButtonColor : '#d33'
		}).then(() => {
			$.ajax({
				url: '<?php echo base_url('Logistik/deleteTimbangan') ?>',
				data: ({ id_timbangan }),
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'loading ...',
						allowEscapeKey    : false,
						allowOutsideClick : false,
						onOpen: () => {
							swal.showLoading();
						}
					})
				},
				success: function(res) {
					data = JSON.parse(res)
					if(data.data){
						reloadTable()
						toastr.success(`<b>BERHASIL HAPUS!</b>`)
						swal.close()
					}
				}
			});
		});
	}
</script>
