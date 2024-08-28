  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>Blank Page</h1> -->
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if(in_array($level, ['Admin','User','Owner','Keuangan1'])){ ?>
    <!-- REKAP INVOICE BAHAN -->
    <!-- content2 -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <div class="row">

                  <?php if(in_array($level, ['Admin','User','Owner','Hub'])){ ?>
                    
                    <div class="col-md-12 row-jatuh_tempo">
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP INVOICE BAHAN</h3>
                        </div>
                        
                        <!--  AA -->
                        <div class="col-md-12">								
                          <br>						
                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
                            <div class="col-md-2">PERIODE</div>
                            <div class="col-md-3">
                              <select class="form-control select2" name="priode" id="priode" style="width: 100%;" onchange="cek_periode(),load_inv_bahan()">
                                <option value="all">ALL</option>
                                <option value="custom">Custom</option>
                              </select>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2">ATTN</div>
                            <div class="col-md-3">
                              <select class="form-control select2" name="id_hub2" id="id_hub2" style="width: 100%;" onchange="load_inv_bahan()">
                              </select>
                            </div>
                          </div>
                          
                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_awal_list" >						
                            <div class="col-md-2">Tgl Awal</div>
                            <div class="col-md-3">
                              <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" onchange="load_inv_bahan()" value ="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6"></div>
                          </div>

                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_akhir_list" >						
                            <div class="col-md-2">Tgl Akhir</div>
                            <div class="col-md-3">
                              <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" onchange="load_inv_bahan()" value ="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6"></div>
                          </div>
                          
                          <br>
                          <hr>
                        </div>
                        <!-- AA -->

                          <div style="padding:0 10px 20px;">
                            <div style="overflow:auto;white-space:nowrap" >
                              <table id="dt_load_inv_bahan" class="table table-bordered table-striped" width="100%">
                                <thead class="color-tabel">
                                  <tr>
                                    <th style="width:5%">NO.</th>
                                    <th style="width:45%">NO INV</th>
                                    <th style="width:45%">TGL</th>
                                    <th style="width:45%">NM HUB</th>
                                    <th style="width:45%">QTY</th>
                                    <th style="width:40%">HARGA</th>
                                    <th style="width:40%">TOTAL BAYAR</th>
                                    <!-- <th style="width:10%">AKSI</th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="6" class="text-right">
                                      <label for="total">TOTAL</label>
                                    </td>	
                                    <td>
                                      <div class="mb-1 text-right" style="font-weight:bold;color:red">
                                        <!-- <input type="text" size="5" name="total_nom" id="total_nom" style="font-weight:bold;color:red" class="angka form-control text-right" value='0' readonly> -->
                                        <span id="total_all_inv_bhn"></span>
                                      </div>
                                      
                                    </td>	
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                      </div>
                    </div>
                  <?php } ?>

                <br>
                <hr>
                
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    <!-- /.content2 -->
    <!-- END INVOICE BAHAN-->

    <?php } ?>

    
    <?php if(in_array($level, ['Admin','User','Owner','Keuangan1'])){ ?>
    <!-- REKAP TIMBANGAN -->
    <!-- content2 -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <div class="row">

                  <?php if(in_array($level, ['Admin','User','Owner','Hub'])){ ?>
                    
                    <div class="col-md-12 row-jatuh_tempo">
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP TIMBANGAN</h3>
                        </div>
                        
                        <!--  AA -->
                        <div class="col-md-12">								
                          <br>						
                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
                            <div class="col-md-2">PERIODE</div>
                            <div class="col-md-3">
                              <select class="form-control select2" name="priode_timb" id="priode_timb" style="width: 100%;" onchange="cek_periode2()">
                                <option value="all">ALL</option>
                                <option value="custom">Custom</option>
                              </select>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2">ATTN</div>
                            <div class="col-md-3">
                              <select class="form-control select2" name="id_hub_timb" id="id_hub_timb" style="width: 100%;" onchange="">
                              </select>
                            </div>
                          </div>
                          
                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_awal_list_timb" >						
                            <div class="col-md-2">Tgl Awal</div>
                            <div class="col-md-3">
                              <input type="date" class="form-control" name="tgl_awal_timb" id="tgl_awal_timb" onchange="" value ="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6"></div>
                          </div>

                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_akhir_list_timb" >						
                            <div class="col-md-2">Tgl Akhir</div>
                            <div class="col-md-3">
                              <input type="date" class="form-control" name="tgl_akhir_timb" id="tgl_akhir_timb" onchange="" value ="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6"></div>
                          </div>
                          
                          <br>
                          <hr>
                        </div>
                        <!-- AA -->

                          <div style="padding:0 10px 20px;">
                            <div style="overflow:auto;white-space:nowrap" >
                              <table id="dt_load_timb_bahan" class="table table-bordered table-striped" width="100%">
                                <thead class="color-tabel">
                                  <tr>
                                    <th style="width:5%">NO.</th>
                                    <th style="width:45%">NO TIMB</th>
                                    <th style="width:45%">TGL</th>
                                    <th style="width:45%">NM HUB</th>
                                    <th style="width:45%">BERAT BERSIH</th>
                                    <!-- <th style="width:10%">AKSI</th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="6" class="text-right">
                                      <label for="total">TOTAL</label>
                                    </td>	
                                    <td>
                                      <div class="mb-1 text-right" style="font-weight:bold;color:red">
                                        <!-- <input type="text" size="5" name="total_nom_timb" id="total_nom" style="font-weight:bold;color:red" class="angka form-control text-right" value='0' readonly> -->
                                        <span id="total_all_timb_bhn"></span>
                                      </div>
                                      
                                    </td>	
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                      </div>
                    </div>
                  <?php } ?>

                <br>
                <hr>
                
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    <!-- /.content2 -->
    <!-- END INVOICE BAHAN-->

    <?php } ?>
    
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    $(document).ready(function() {
      $(".select2").select2()
      <?php if(in_array($level, ['Admin','User','Owner','Hub'])){ ?>        
        load_inv_bahan()
        // load_timb_bahan()
      <?php } ?>
      load_hub_bhn() 
    });

    function reloadTable() 
    {
      <?php if(in_array($level, ['Admin','User','Owner','Hub'])){ ?>
        load_inv_bahan()  
        // load_timb_bahan()
      <?php } ?>
      load_hub_bhn() 
    }

    function cek_periode()
    {
      $cek = $('#priode').val();

      if($cek=='all' )
      {
        $('#tgl_awal_list').hide("1000");
        $('#tgl_akhir_list').hide("1000");
      }else{
        $('#tgl_awal_list').show("1000");
        $('#tgl_akhir_list').show("1000");
      }
    }

    function cek_periode2()
    {
      $cek = $('#priode_timb').val();

      if($cek=='all' )
      {
        $('#tgl_awal_timb').hide("1000");
        $('#tgl_akhir_timb').hide("1000");
      }else{
        $('#tgl_awal_timb').show("1000");
        $('#tgl_akhir_timb').show("1000");
      }
    }

    function load_hub_bhn() 
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

            $('#id_hub2').html(option);
            $('#id_hub_timb').html(option);
            swal.close();
          }else{	
            option += "<option value=''></option>";
            $('#id_hub2').html(option);					
            $('#id_hub_timb').html(option);					
            swal.close();
          }
        }
      });
      
    }

    function load_inv_bahan() 
    {
      var id_hub    = $('#id_hub2').val()
      var priode    = $('#priode').val()
      var tgl_awal  = $('#tgl_awal').val()
      var tgl_akhir = $('#tgl_akhir').val()
      var table     = $('#dt_load_inv_bahan').DataTable();

      table.destroy();
      tabel = $('#dt_load_inv_bahan').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url": '<?php echo base_url(); ?>Master/rekap_inv_bahan',
          "type": "POST",
          "data" : ({
            priode    : priode,
            id_hub    : id_hub,
            tgl_awal  : tgl_awal,
            tgl_akhir : tgl_akhir
          }),
        },
        responsive: false,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data.."
        }
      });
      total_jt_bhn();
    }

    function total_jt_bhn()
    {
      var id_hub    = $('#id_hub2').val()
      var priode    = $('#priode').val()
      var tgl_awal  = $('#tgl_awal').val()
      var tgl_akhir = $('#tgl_akhir').val()
      var table     = $('#load_data_jt_bhn').DataTable();

      $.ajax({
        url   : '<?= base_url(); ?>Master/rekap_all_inv_bahan',
        type  : "POST",
        data  : {priode    : priode,id_hub    : id_hub,tgl_awal  : tgl_awal,tgl_akhir : tgl_akhir
          },
        dataType   : "JSON",
        
        success: function(data) {
          if(data){
            // header
            $("#total_all_inv_bhn").html(`
            <div> Rp${format_angka(data.rekap_jumlah.jumlah)}
            </div>`);
            swal.close();

          } else {
            swal.close();
            swal({
              title               : "Cek Kembali",
              html                : "Gagal Load Data",
              type                : "error",
              confirmButtonText   : "OK"
            });
            return;
            $("#total_all_inv_bhn").val(0);
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
   
    function load_timb_bahan() 
    {
      var id_hub_timb       = $('#id_hub_timb').val()
      var priode_timb       = $('#priode_timb').val()
      var tgl_awal_timb     = $('#tgl_awal_timb').val()
      var tgl_akhir_timb    = $('#tgl_akhir_timb').val()
      var table = $('#dt_load_timb_bahan').DataTable();

      table.destroy();
      tabel = $('#dt_load_timb_bahan').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url": '<?php echo base_url(); ?>Master/rekap_timb_bahan',
          "type": "POST",
          "data" : ({
            priode    : priode_timb,
            id_hub    : id_hub_timb,
            tgl_awal  : tgl_awal_timb,
            tgl_akhir : tgl_akhir_timb
          }),
        },
        responsive: false,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data.."
        }
      });
      // total_timb_bhn();
    }

    function total_timb_bhn()
    {
      var id_hub_timb    = $('#id_hub_timb').val()
      var priode_timb    = $('#priode_timb').val()
      var tgl_awal_timb  = $('#tgl_awal_timb').val()
      var tgl_akhir_timb = $('#tgl_akhir_timb').val()
      var table     = $('#load_data_jt_bhn').DataTable();

      $.ajax({
        url   : '<?= base_url(); ?>Master/rekap_all_timb_bahan',
        type  : "POST",
        data  : {priode    : priode_timb,id_hub    : id_hub_timb,tgl_awal  : tgl_awal_timb,tgl_akhir : tgl_akhir_timb
          },
        dataType   : "JSON",
        
        success: function(data) {
          if(data){
            // header
            $("#total_all_timb_bhn").html(`
            <div> Rp${format_angka(data.rekap_jumlah.jumlah)}
            </div>`);
            swal.close();

          } else {
            swal.close();
            swal({
              title               : "Cek Kembali",
              html                : "Gagal Load Data",
              type                : "error",
              confirmButtonText   : "OK"
            });
            return;
            $("#total_all_timb_bhn").val(0);
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

    function tampil_data(id_hub,ket)
    {
      $(".row-stok_rinci").attr('style', '')

      load_data_bhn_rinci(id_hub,ket) 
    }

    function kembaliList()
    {
      reloadTable()
      $(".row-stok_rinci").attr('style', 'display:none')
      
      $(".row-stok_bhn").attr('style', '')
      $(".row-omset_hub").attr('style', '')
      $(".row-jatuh_tempo").attr('style', '')
    }

    
  </script>

