<script>
    function updateTable() {
        table.ajax.reload(null, false);
    }

    $(document).ready(function() {
        table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            "ajax": {
                "url": "<?php echo site_url('administrator/weight/getAllData') ?>",
                "type": "POST",
                "data": {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "center"
            }]
        });
    });

    var save_method;
    var save_method_role;
    var save_method_login;


    // Start Method add

    function add() {
        save_method_role = 'add';
        $('.modal-title').text(' Add Data Weight');
        $('.reset-btn').show();
        $('.form-group')
            .removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error')
            .remove();
        $('#modalWeight').modal('show');
    }

    // End method add

    // Start Method Update


    function updateWeight(id) {
        save_method_role = 'update';
        $('#formWeight')[0].reset();

        //Load data dari ajax
        $.ajax({
            url: "<?php echo base_url('administrator/weight/getById/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                console.log(data.id);
                $('[name="weight_id"]').val(data.weight_id);
                $('[name="criteria_id"]').val(data.criteria_id);
                $('[name="weight_value"]').val(data.weight_value);
                $('#modalWeight').modal('show');
                $('.modal-title').text('Edit Data Weight');
                // console.log(data.user_role_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }



    // End Method Update

    // Start Method delete

    function deleteWeight(id) {
        swal({
            title: "Are you sure ?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true,
            },
        }).then((result) => {
            if (result == true) {

                $.ajax({
                    url: "<?php echo site_url('administrator/weight/delete'); ?>/" + id,
                    type: "POST",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        updateTable();
                        return swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            icon: data['status']
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error Deleting Data');
                    }
                });
            } else {
                return swal({
                    title: 'Transaksi telah dibatalkan !',
                    content: true,
                    timer: 1300,
                    icon: 'warning'
                });
            }
        });
    }
    // End Method delete

    var csrf_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
    var csrf_hash = ''


    function save() {
        var url;
        if (save_method_role == 'add') {
            url = '<?php echo base_url() ?>administrator/weight/insert';
        } else {
            url = '<?php echo base_url() ?>administrator/weight/update';
        }

        swal({
            title: "Are you sure ?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true,
            },
        }).then((result) => {
            if (result == true) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#formWeight').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result;
                        // csrf_hash = resp.csrf['token']
                        // $('#add-form input[name=' + csrf_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateTable();
                            $('.form-group')
                                .removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error')
                                .remove();
                            $('#modalWeight').modal('hide');
                            $("#formWeight")[0].reset();

                        } else {
                            $.each(data['messages'], function(key, value) {
                                var element = $('#' + key);
                                element
                                    .closest('div.form-group')
                                    .removeClass('has-error')
                                    .addClass(
                                        value.length > 0 ?
                                        'has-error' :
                                        'has-success'
                                    )
                                    .find('#text-error')
                                    .remove();
                                element.after(value);
                            });
                        }
                        return swal({
                            html: true,
                            timer: 1300,
                            title: data['msg'],
                            icon: data['status']
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error adding/updating data');
                    }
                });
            } else {
                return swal({
                    title: 'Transaksi telah dibatalkan !',
                    content: true,
                    timer: 1300,
                    icon: 'warning'
                });
            }
        });
    }
</script>
<style>
    .table-wrapper {
        width: 100%;
        overflow-x: scroll;
        overflow-y: hidden;
    }
</style>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Weight (Base on Criteria Data)</h1>


    <!-- Data  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">=Weight Data (Based on Criteria Data)=</h5>
            <div class="text-right">
                <button class="btn btn-success btn-xs" onclick="add()" type="button"><i class="fa fa-plus"></i> Add Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered weightData" style="font-size:13px" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Criteria</th>
                            <th>Weight Value (Converted to Decimals) (%)</th>
                            <th>Tools</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>



</div>
<!-- Modal User Role-->
<div class="modal fade" id="modalWeight" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="formWeight" action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name='weight_id' value="" id='weight_id'>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Criteria<span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <select name="criteria_id" id="criteria_id" class="form-control">
                                <option value="">Select Criteria</option>
                                <?php foreach ($getCriteria as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->criteria_code; ?></option>
                                <?php } ?>
                            </select>
                            <!-- <input type="text" id="criteria" name="criteria" required="required" class="form-control "> -->
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Weight Value (%)<span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <input type="number" id="weight_value" name="weight_value" required="required" placeholder="Ex. 100" class="form-control ">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>