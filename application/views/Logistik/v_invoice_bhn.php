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
									<th class="text-center">NO TIMBANGAN</th>
									<th class="text-center">TANGGAL</th>
									<th class="text-center">HUB</th>
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
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_inv_bhn" id="id_inv_bhn">

							<input type="text" class="angka form-control" name="no_inv_bhn" id="no_inv_bhn" value="AUTO" readonly>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">NO TIMBANGAN</div>
						<div class="col-md-3">
							<div class="input-group">								
								<input type="text" class="form-control" id="no_timbangan" name="no_timbangan" value="AUTO" readonly>
								<div class="input-group-append">
									<span class="input-group-text">
										<a onclick="search_timb(0)">
											<i class="fas fa-search" style="color:red"></i> 
										</a>
									</span>
								</div>
							</div>
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
								<input type="text" class="angka form-control" name="qty" id="qty"  onkeyup="ubah_angka(this.value,this.id),hitung_total()" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>	
									
							</div>
						</div>	
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">								
						
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

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">								
				
						<div class="col-md-2">List Timbangan</div>
						<div class="col-md-9"></div>	
					</div>
					<br>

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						<div class="col-md-2">HUB</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="hub_occ" name="hub_occ" value="AUTO" readonly>
							<input type="hidden" class="form-control" id="aka_hub_occ" name="aka_hub_occ" value="AUTO" readonly>
							</select>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">PERMINTAAN</div>
						<div class="col-md-3">
							<input type="text" name="permintaan" id="permintaan" class="form-control" value="PPI" oninput="this.value = this.value.toUpperCase() " readonly>
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">JENIS</div>
						<div class="col-md-3">	
							<input type="text" class="form-control" id="jns" name="jns" value="AUTO" readonly>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">PENIMBANG</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="penimbang" name="penimbang" value="AUTO" readonly>
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">MASUK</div>
						<div class="col-md-3">
							<input type="datetime-local" name="masuk" id="masuk" class="form-control" readonly>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">CATATAN</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="cttn" name="cttn" value="AUTO" readonly>

						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">KELUAR</div>
						<div class="col-md-3">
							<input type="datetime-local" name="keluar" id="keluar" class="form-control" readonly>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">SUPPLIER</div>
						<div class="col-md-3">							
							<input type="text" class="form-control" id="supplier" name="supplier" value="AUTO" readonly>

						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">BERAT KOTOR</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
															
								<input type="text" class="form-control" id="b_kotor" name="b_kotor" value="AUTO" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b></span>
								</div>
							</div>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">ALAMAT</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="alamat" name="alamat" value="AUTO" readonly>
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">BERAT TRUK</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
								<input type="text" class="form-control" id="berat_truk" name="berat_truk" value="AUTO" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b></span>
								</div>
							</div>			

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">NO POLISI</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="nopol" name="nopol" value="AUTO" readonly>
						</div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">BERAT BERSIH</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
							<input type="text" class="form-control" id="berat_bersih" name="berat_bersih" value="AUTO" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b></span>
								</div>
							</div>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">BARANG</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="barang" name="barang" value="AUTO" readonly>
						</div>
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">POTONGAN</div>
						<div class="col-md-3">
							<div class="input-group mb-3">
								<input type="text" class="form-control" id="pot" name="pot" value="AUTO" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b></span>
								</div>
							</div>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">SOPIR</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="sopir" name="sopir" value="AUTO" readonly>
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

<!-- Modal search stok -->
<div class="modal fade list_timb" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" style="width:100%;margin:auto">

        <div class="modal-content">
            <div class="modal-header">
                <h5><b>PILIH STOK</b></h5>
            </div>
            <div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">

                <table class="table table-bordered table-striped" id="tbl_timb" style="margin:auto !important">
                    <thead class="color-tabel">
						<tr>
							<th style="text-align: center; width:5%">NO.</th>
							<th style="text-align: center; width:10%">NO TIMBANGAN</th>
							<th style="text-align: center; width:15%">TGL MASUK</th>
							<th style="text-align: center; width:20%">NOPOL</th>
							<th style="text-align: center; width:20%">SOPIR</th>
							<th style="text-align: center; width:20%">CUST</th>
							<th style="text-align: center; width:10%">JENIS</th>
							<th style="text-align: center; width:20%">CATATAN</th>
							<th style="text-align: center; width:10%">BERAT BERSIH</th>
							<th style="text-align: center; width:10%">AKSI</th>
						</tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<!-- Modal search stok -->

<!-- MODAL box -->
<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header" style="font-family:Cambria;" >
				<h4 class="card-title" style="color:#4e73df;" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="col-md-12">
				<br>				
					
				<div class="modal-body row" style="padding-bottom:1px;font-weight:bold">						
					<div class="col-md-2">No Invoice</div>
					<div class="col-md-3">
						<input type="text" class="angka form-control" name="m_no_inv_bhn" id="m_no_inv_bhn" value="AUTO" readonly>
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-2">NO TIMBANGAN</div>
					<div class="col-md-3">
						<div class="input-group">								
							<input type="text" class="form-control" id="m_no_timbangan" name="m_no_timbangan" value="AUTO" readonly>
						</div>
					</div>	

				</div>
				
				<div class="modal-body row" style="padding-bottom:1px;font-weight:bold">			
					<div class="col-md-2">Tanggal Invoice</div>
					<div class="col-md-3">
						<input type="date" class="form-control" name="m_tgl_inv" id="m_tgl_inv" value ="<?= date('Y-m-d') ?>" readonly>
					</div>
					<div class="col-md-1"></div>	
					<div class="col-md-2">Qty</div>
					<div class="col-md-3">
						<div class="input-group mb-1">
							<input type="text" class="angka form-control" name="m_qty" id="m_qty"  onkeyup="ubah_angka(this.value,this.id),hitung_total()" readonly>
							<div class="input-group-append">
								<span class="input-group-text"><b>Kg</b>
								</span>
							</div>	
								
						</div>
					</div>	
				</div>
				
				<div class="modal-body row" style="padding-bottom:1px;font-weight:bold">								
					
					<div class="col-md-2">Harga</div>
					<div class="col-md-3">
						<div class="input-group mb-1">
							<div class="input-group-append">
								<span class="input-group-text"><b>Rp</b>
								</span>
							</div>	
							<input type="text" class="angka form-control" name="m_nom" id="m_nom"  onkeyup="ubah_angka(this.value,this.id),hitung_total()" readonly>
								
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
							<input type="text" class="angka form-control" name="m_total_bayar" id="m_total_bayar"  readonly>
								
						</div>
					</div>
				</div>
					
				
				<br>

				<div class="modal-footer"style="font-weight:bold">
					<!-- <div class="col-md-4"> -->
						<!-- <span id="btn-simpan"></span> -->
						<span id="modal_btn_verif"></span>
						
						<button type="button" class="btn btn-danger" data-dismiss="modal"  ><i class="fa fa-undo"></i> <b> Batal</b></button>


					<!-- </div> -->
					
					<!-- <div class="col-md-6"></div> -->
					
				</div>

				<br>				
					
			</div>
		</div>
	</div>
</div>
<!-- /.MODAL -->

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
					option += "<option value='"+val.id_hub+"'>"+val.nm_hub+"</option>";
					});

					$("#id_hub").prop("readonly", true);
					$('#id_hub').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#id_hub').html(option);					
					swal.close();
				}
			}
		});
		
	}
	
	function search_timb()
	{
		$('.list_timb').modal('show');
		
		var table   = $('#tbl_timb').DataTable();
		table.destroy();
		tabel = $('#tbl_timb').DataTable({
			"processing"   : true,
			"pageLength"   : true,
			"paging"       : true,
			"ajax": {
				"url"   : '<?php echo base_url('Logistik/load_data/search_timbangan')?>',
				"type"  : "POST",
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function spilldata(id,no_timbangan)
	{		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			dataType   : "JSON", 
			data       : { id : no_timbangan, jenis:'spill_timb',field :'no_timbangan' },
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
				// console.log(data)
				if(data){		 	
					// header
					$("#no_timbangan").val(data.header.no_timbangan);
					$("#hub_occ").val(data.header.nm_hub);
					$("#aka_hub_occ").val(data.header.aka);
					$("#jns").val(data.header.jns);
					$("#penimbang").val(data.header.nm_penimbang);
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
					$("#qty").val(format_angka(data.header.berat_bersih));					
					$("#cttn").val(data.header.catatan);					
					$("#pot").val(format_angka(data.header.potongan));	
					hitung_total();
					swal.close();
					$('.list_timb').modal('hide');

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

	function hitung_total()
	{
		var qty           = $("#qty").val()
		var nom           = $("#nom").val()
		var total_bayar   = $("#total_bayar").val()

		nom_ok            = (nom=='' || isNaN(nom) || nom == null) ? '0' : nom;
		var nom_total     = parseInt(nom_ok.split('.').join(''))
		
		qty_ok            = (qty=='' || isNaN(qty) || qty == null) ? '0' : qty;
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
				"url": '<?php echo base_url('Logistik/load_data/inv_bhn')?>',
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
			data       : { id : no_inv_bhn, tbl:'invoice_bhn', jenis :'edit_inv_bhn',field :'no_inv_bhn'  },
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
					$("#qty").val(format_angka(data.header.qty));
					$("#nom").val(format_angka(data.header.nominal));
					var total = data.header.qty*data.header.nominal
					$("#total_bayar").val(format_angka(total));	
					
					// LIST ITEM
					$("#no_timbangan").val(data.header.no_timbangan);
					$("#hub_occ").val(data.header.nm_hub);
					$("#aka_hub_occ").val(data.header.aka);
					$("#jns").val(data.header.jns);
					$("#penimbang").val(data.header.nm_penimbang);
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
					$("#qty").val(format_angka(data.header.berat_bersih));					
					$("#cttn").val(data.header.catatan);					
					$("#pot").val(format_angka(data.header.potongan));	
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

		$("#no_timbangan").val('AUTO');
		$("#hub_occ").val('AUTO');
		$("#jns").val('AUTO');
		$("#penimbang").val('AUTO');
		$("#permintaan").val('AUTO');					
		$("#supplier").val('AUTO');					
		$("#masuk").val('AUTO');					
		$("#alamat").val('AUTO');					
		$("#keluar").val('AUTO');					
		$("#nopol").val('AUTO');					
		$("#b_kotor").val(format_angka('AUTO'));					
		$("#barang").val('AUTO');					
		$("#berat_truk").val(format_angka('AUTO'));					
		$("#sopir").val('AUTO');					
		$("#berat_bersih").val(format_angka('AUTO'));					
		$("#qty").val(format_angka('AUTO'));					
		$("#cttn").val('AUTO');					
		$("#pot").val(format_angka('AUTO'));	
		load_hub()
		hitung_total()
		
		swal.close()
	}

	function simpan() 
	{
		var id_stok_d       = $("#id_stok_d").val();
		var nom             = $("#nom").val();
		var total_bayar     = $("#total_bayar").val();
		var no_timbangan    = $("#no_timbangan").val();
		
		if ( id_stok_d == '' || nom== '' || total_bayar == '' || total_bayar == 0 || no_timbangan == '') 
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
			url        : '<?= base_url(); ?>Logistik/insert_inv_bhn',
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
					jenis      : 'invoice_bhn',
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
