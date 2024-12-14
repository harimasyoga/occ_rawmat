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
					<?php if(in_array($this->session->userdata('level'), ['Admin','User'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>
					<?php } ?>
					<div style="overflow:auto;">
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th class="text-center">NO</th>
									<th class="text-center">NO INVOICE</th>
									<th class="text-center">HUB</th>
									<th class="text-center">TANGGAL</th>
									<th class="text-center">QTY (Kg)</th>
									<th class="text-center">HARGA (Rp)</th>
									<th class="text-center">TOTAL (Rp)</th>
									<th class="text-center">ACC OWNER</th>
									<th class="text-center">AKSI</th>
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
						<div class="col-md-9">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="pilihan" id="pilihan" value="BAHAN">
							<input type="hidden" name="id_inv_bhn" id="id_inv_bhn">

							<input type="text" class="angka form-control" name="no_inv_bhn" id="no_inv_bhn" value="AUTO" readonly>
						</div>
						<!-- <div class="col-md-1"></div> -->
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						<div class="col-md-2">Jenis Box</div>
						<div class="col-md-3">
							<select id="jenis" name="jenis" class="form-control select2" style="width: 100%" >
								<option value="KARDUS">KARDUS</option>
								<option value="DUPLEX">DUPLEX</option>
								<option value="PLUMPUNG">DUPLEX</option>
							</select>
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
						<div class="col-md-2">Supplier</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<input type="text" class="form-control" name="supp" id="supp" >
							</div>
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
						<div class="col-md-2">Plat Nomor</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<input type="text" class="form-control" name="plat" id="plat" >
							</div>
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
				"url": '<?php echo base_url('Logistik/load_data/inv_beli_bhn')?>',
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
					$("#supp").val(data.header.suplier);
					$("#jenis").val(data.header.jenis).trigger('change');
					$("#plat").val(data.header.plat);
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

	// MODAL //
	function open_modal(id,no_inv_bhn) 
	{		
		$("#modalForm").modal("show");
		$("#judul").html('<h3> VERIFIKASI OWNER </h3>');
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id : no_inv_bhn, tbl:'invoice_bhn', jenis :'edit_inv_bhn',field :'no_inv_bhn' },
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
					$("#m_no_inv_bhn").val(data.header.no_inv_bhn);
					$("#m_no_timbangan").val(data.header.no_timb);
					$("#m_tgl_inv").val(data.header.tgl_inv_bhn);
					$("#m_qty").val(format_angka(data.header.qty));
					$("#m_nom").val(format_angka(data.header.nominal));
					var total = data.header.qty*data.header.nominal
					$("#m_total_bayar").val(format_angka(total));	

					if(data.header.acc_owner == 'Y')
					{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv('Y')"><i class="fas fa-lock"></i><b> BATAL VERIFIKASI </b></button>`)
					}else{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv('N')"><i class="fas fa-check"></i><b> VERIFIKASI </b></button>`)

					}

										
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
		$("#no_inv_bhn").val('AUTO');			
		$("#nom").val(format_angka(0));						
		$("#qty").val(format_angka(0));
		$("#supp").val('');
		$("#plat").val('');
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
		var plat        = $("#plat").val();
		var jenis       = $("#jenis").val();
		var hub_bhn     = $("#hub_bhn").val();
		
		if ( id_stok_d == '' || nom== '' || total_bayar == '' || total_bayar == 0 || plat == '' || jenis == '' || hub_bhn=='' ) 
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
