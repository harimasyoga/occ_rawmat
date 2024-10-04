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
				
				<div class="card-body">
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">JENIS</div>
						<div class="col-md-3">
							<select id="plh_bayar" class="form-control select2">
								<option value="">SEMUA</option>
								<option value="BOX">BOX</option>
								<option value="DUPLEX">DUPLEX</option>
								<option value="LAIN">LAIN - LAIN</option>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">TYPE</div>
						<div class="col-md-3">
							<select id="pilih_type" class="form-control select2" style="font-weight:bold" onchange="cek_periode()" >
								<option value="HARIAN">HARIAN</option>
								<option value="BULANAN">BULANAN</option>
								<option value="TAHUNAN">TAHUNAN</option>
								<option value="CUSTOM">CUSTOM</option>
								<option value="all">ALL</option>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold;" id="list_harian">						
						<div class="col-md-2">TGL INV</div>
						<div class="col-md-3">
							<input type="date" id="tgl_harian" class="form-control" value="<?= date("Y-m-d")?>">
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="list_custom">						
						<div class="col-md-2">TGL INV</div>
						<div class="col-md-3">
							<input type="date" id="tgl1_inv" class="form-control" value="<?= date("Y-m-d")?>">
						</div>
						<div class="col-md-1">S/D</div>
						<div class="col-md-3">
							<input type="date" id="tgl2_inv" class="form-control" value="<?= date("Y-m-d")?>">
						</div>
						<div class="col-md-2"></div>
					</div>

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="list_bln">	
						<div class="col-md-2" >BULAN</div>
						<div class="col-md-3">
							<div class="input-group">								
								<input type="month" class="form-control " name="bulan" id="bulan">
							</div>
						</div>	
						<div class="col-md-6"></div>
						
					</div>

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="list_thn">						
						<div class="col-md-2">TAHUN</div>
						<div class="col-md-3">
						<?php 
							$thang =  date("Y"); 
							$thang_min = $thang - 5 ;
						?>
							<select class="form-control select2" name ="thun" id="thun" onchange="load_data()" > 
						<?php 									
							for ($th=$thang_min ; $th<=$thang ; $th++)
							{
								if ($th==$thang) {
									echo "<option selected value=$th>$thang</option>";
									}
								else {	
								echo "<option value=$th>$th</option>";
								}
							}		
						?>  
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold;" >
						<div class="col-md-2">
							<button type="button" class="btn btn-danger" onclick="cetak_data()"><i class="fas fa-print"></i></button>
						</div>
						
						<div class="col-md-9"></div>
					</div>

					<div style="overflow:auto;white-space:nowrap">
						<div id="tampil_lap_inv"></div>
					</div>
				</div>
				
			</div>			
		</div>
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>Input <?=$judul?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>

			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
					<br>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						<div class="col-md-2">No Invoice</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="pilihan" id="pilihan" value="UMUM">
							<input type="hidden" name="id_inv_bhn" id="id_inv_bhn">

							<input type="text" class="angka form-control" name="no_inv_bhn" id="no_inv_bhn" value="AUTO" readonly>
						</div>
						
						<div class="col-md-1"></div>
						<div class="col-md-2">HUB</div>
						<div class="col-md-3">
							<select id="hub_bhn" name="hub_bhn" class="form-control select2" style="width: 100%" >
							</select>

						</div>
					</div>

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">		
						<div class="col-md-2">Tanggal Invoice</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_inv" id="tgl_inv" value ="<?= date('Y-m-d') ?>" >
						</div>
						
						<div class="col-md-1"></div>
						<div class="col-md-2">Qty</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<input type="text" class="angka form-control" name="qty" id="qty"  onkeyup="ubah_angka(this.value,this.id),hitung_total()" >
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>	
									
							</div>
						</div>	

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
						<div class="col-md-2">Jenis</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name="jenis" id="jenis" oninput="this.value = this.value.toUpperCase()">
						</div>
						<div class="col-md-1"></div>	
						<div class="col-md-2">Harga</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" class="angka form-control" name="nom" id="nom"  onkeyup="ubah_angka(this.value,this.id),hitung_total()">
									
							</div>
						</div>
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
						<div class="col-md-2">Keterangan</div>
						<div class="col-md-3">
							<textarea name="ket" id="ket" class="form-control" value="-" placeholder="-" ></textarea>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">Total Bayar</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" class="angka form-control" name="total_bayar" id="total_bayar"  readonly>
									
							</div>
						</div>
					</div>
					<hr>

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
		load_jenis()
		$('.select2').select2();
	});
	
	var rowNum = 0;

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

					$('#hub_bhn').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";			
					$('#hub_bhn').html(option);					
					swal.close();
				}
			}
		});
	}

	function cek_periode()
    {
		$cek = $('#pilih_type').val();

		if($cek=='HARIAN' )
		{
			$('#list_harian').show("1000");
			$('#list_bln').hide("1000");
			$('#list_thn').hide("1000");
			$('#list_custom').hide("1000");
		}else if($cek=='BULANAN' )
		{
			$('#list_harian').hide("1000");
			$('#list_bln').show("1000");
			$('#list_thn').hide("1000");
			$('#list_custom').hide("1000");
		}else if($cek=='TAHUNAN' )
		{
			$('#list_harian').hide("1000");
			$('#list_bln').hide("1000");
			$('#list_thn').show("1000");
			$('#list_custom').hide("1000");
		}else if($cek=='CUSTOM' )
		{
			$('#list_harian').hide("1000");
			$('#list_bln').hide("1000");
			$('#list_thn').hide("1000");
			$('#list_custom').show("1000");
		}else{
			$('#list_harian').hide("1000");
			$('#list_bln').hide("1000");
			$('#list_thn').hide("1000");
			$('#list_custom').hide("1000");
		}
    }
	
	function hitung_total()
	{
		var qty           = $("#qty").val()
		var nom           = $("#nom").val()
		var total_bayar   = $("#total_bayar").val()

		nom_ok            = (nom=='' || nom == null) ? '0' : nom;
		var nom_total     = parseInt(nom_ok.split('.').join(''))
		
		qty_ok            = (qty=='' || qty == null) ? '0' : qty;
		var qty_total     = parseInt(qty_ok.split('.').join(''))
		
		var total_nominal = nom_total*qty_total

		$("#total_bayar").val(format_angka(total_nominal))	
	}
	
	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/inv_beli_umum')?>',
				"type": "POST",
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
	
	function edit_data(id,no_inv_bhn)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)
		// $("#btn-simpan").html(``)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id : no_inv_bhn, tbl:'invoice_beli_bhn', jenis :'edit_inv_beli_bhn',field :'no_inv_bhn'  },
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
					$("#id_inv_bhn").val(data.header.id_inv_bhn);
					$("#no_inv_bhn").val(data.header.no_inv_bhn);
					$("#hub_bhn").val(data.header.id_hub).trigger('change');
					$("#tgl_inv").val(data.header.tgl_inv_bhn);
					$("#qty").val(format_angka(data.header.qty));
					$("#nom").val(format_angka(data.header.nominal));
					$("#jenis").val(data.header.jenis);
					$("#ket").val(data.header.ket);
					var total = data.header.qty*data.header.nominal
					$("#total_bayar").val(format_angka(total));	

					swal.close();
					hitung_total()	

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

	function cetak_data()
	{
		var pilih_type    = $('#pilih_type').val()
		var tgl_harian    = $('#tgl_harian').val()
		var tgl1_inv      = $('#tgl1_inv').val()
		var tgl2_inv      = $('#tgl2_inv').val()
		var bulan         = $('#bulan').val()
		var thun          = $('#thun').val()

		var url    = "<?php echo base_url('Laporan/cetak_data'); ?>";
		window.open(url+'?a='+pilih_type+'&b='+tgl_harian+'&c='+tgl1_inv+'&d='+tgl2_inv+'&e='+bulan+'&f='+thun, '_blank');  
	}

	function acc_inv(acc_owner) 
	{	
		var user        = "<?= $this->session->userdata('username')?>"
		var no_inv      = $('#m_no_inv_bhn').val()
		
		if(user=='owner' || user=='developer')
		{
			acc = acc_owner
		}else{
			acc = ''
		}

		// console.log(user)
		// console.log(acc)
		if (acc=='N')
		{
			var html = 'VERIFIKASI'
			var icon = '<i class="fas fa-check"></i>'
		}else{
			var html = 'BATAL VERIFIKASI'
			var icon = '<i class="fas fa-lock"></i>'
		}
		
		swal({
			title              : html,
			html               : "<p> Apakah Anda yakin ?</p><br>",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>'+icon+' '+html+'</b>',
			cancelButtonText   : '<b><i class="fas fa-undo"></i> Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			confirmButtonColor : '#28a745',
			cancelButtonColor  : '#d33'
		}).then(() => {

				$.ajax({
					url: '<?= base_url(); ?>Logistik/prosesData',
					data: ({
						no_inv    : no_inv,
						acc       : acc,
						jenis     : 'verif_inv_bhn'
					}),
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
					success: function(data) {
						toastr.success('Data Berhasil Diproses');
						// swal({
						// 	title               : "Data",
						// 	html                : "Data Berhasil Diproses",
						// 	type                : "success",
						// 	confirmButtonText   : "OK"
						// });
						
						// setTimeout(function(){ location.reload(); }, 1000);
						// location.href = "<?= base_url()?>Logistik/Invoice";
						// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+id+"&statuss=Y&no_inv="+no_inv+"&acc=1";
						reloadTable()
						close_modal()
						swal.close();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// toastr.error('Terjadi Kesalahan');
						swal({
							title               : "Cek Kembali",
							html                : "Terjadi Kesalahan",
							type                : "error",
							confirmButtonText   : "OK"
						});
						return;
					}
				});
		
		});

	}
	
	function close_modal()
	{
		$('#modalForm').modal('hide');
		reloadTable()
	}
	
	function kosong()
	{
		var tgl = '<?= date('Y-m-d') ?>'	
		$("#id_inv_bhn").val('');
		$("#ket").val('');
		$("#no_inv_bhn").val('AUTO');			
		$("#nom").val(format_angka(0));						
		$("#qty").val(format_angka(0));
		$("#tgl_inv").val(tgl);
		$("#hub_bhn").val('').trigger('change');
		hitung_total()		
		swal.close()
	}

	function simpan() 
	{
		var id_stok_d   = $("#id_stok_d").val();
		var nom         = $("#nom").val();
		var total_bayar = $("#total_bayar").val();
		var jenis       = $("#jenis").val();
		var hub_bhn     = $("#hub_bhn").val();
		
		if ( id_stok_d == '' || nom== '' || total_bayar == '' || total_bayar == 0 || jenis == '' || hub_bhn=='' ) 
		{
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/insert_inv_beli_bhn',
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
					kosong();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					kembaliList()
					load_data()
					
				} else {
					// toastr.error('Gagal Simpan');
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

	function deleteData(id,no_inv_bhn) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no_inv_bhn+ " </strong> ",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>Hapus</b>',
			cancelButtonText   : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			cancelButtonColor  : '#d33'
		}).then(() => {

		// if (cek) {
			$.ajax({
				url: '<?= base_url(); ?>Logistik/hapus',
				data: ({
					id         : no_inv_bhn,
					jenis      : 'invoice_beli_bhn',
					field      : 'no_inv_bhn'
				}),
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
				success: function(data) {
					toastr.success('Data Berhasil Di Hapus');
					swal.close();

					// swal({
					// 	title               : "Data",
					// 	html                : "Data Berhasil Di Hapus",
					// 	type                : "success",
					// 	confirmButtonText   : "OK"
					// });
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// toastr.error('Terjadi Kesalahan');
					swal({
						title               : "Cek Kembali",
						html                : "Terjadi Kesalahan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			});
		// }

		});


	}
</script>
