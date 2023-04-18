<script>
    function updateTable() {
        table.ajax.reload(null, false);
    }

    $(document).ready(function() {
        table = $('#dataTable').DataTable({

        });
    });

    var save_method;
    var save_method_role;
    var save_method_login;


    // Start Method add

    function add() {
        save_method_role = 'add';
        $('.modal-title').text(' Add Calculation Matrix');
        $('.reset-btn').show();
        $('.form-group')
            .removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error')
            .remove();
        $('#modalMatrix').modal('show');
    }

    // End method add

    // Start Method Update


    function updateMatrix(id, criteria_id) {
        save_method_role = 'update';
        //Load data dari ajax

        $.ajax({
            url: "<?php echo base_url('administrator/matrixCalculation/getByEmpIdCritId/'); ?>" + id + '/' + criteria_id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="employee_id"]').val(data.employee_id);
                $('[name="criteria_id"]').val(data.criteria_id);
                $('[name="value"]').val(data.value);
                $('#modalUpdateMatrix').modal('show');
                $('.modal-title').text('Edit Data Matrix ');
                // console.log(data.user_role_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }



    // End Method Update

    // Start Method delete

    function deleteMatrix(id) {
        swal({
            title: "Are you sure ?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true,
            },
            html: true
        }).then((result) => {
            if (result == true) {
                $.ajax({
                    url: "<?php echo site_url('administrator/matrixCalculation/delete'); ?>/" + id,
                    type: "POST",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        setInterval(() => {
                            window.location = '';
                        }, 1500);
                        // updateTable();
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
        url = '<?php echo base_url() ?>administrator/matrixCalculation/insert';
        <?php foreach ($getCriteria as $baris) { ?>
            var valCriteria = document.getElementById("value[<?php echo $baris->criteria_code; ?>]").value;
            if (!((valCriteria >= 1) && (valCriteria <= 5))) {
                alert('Is not allowed if larger than 5');
                return;
            }
        <?php } ?>

        swal({
            title: "Are you sure ?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true,
            },
            html: true
        }).then((result) => {
            if (result == true) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#formMatrix').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result;
                        // csrf_hash = resp.csrf['token']
                        // $('#add-form input[name=' + csrf_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            $('.form-group')
                                .removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error')
                                .remove();
                            $('#modalMatrix').modal('hide');
                            setInterval(() => {
                                window.location = '';
                            }, 1500);
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

    function saveUpdate() {
        var url;
        url = '<?php echo base_url() ?>administrator/matrixCalculation/update';

        swal({
            title: "Are you sure ?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true,
            },
            html: true
        }).then((result) => {
            if (result == true) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#formUpdateMatrix').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result;
                        // csrf_hash = resp.csrf['token']
                        // $('#add-form input[name=' + csrf_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            $('.form-group')
                                .removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error')
                                .remove();
                            $('#modalUpdateMatrix').modal('hide');
                            setInterval(() => {
                                window.location = '';
                            }, 1500);
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
    <h1 class="h3 mb-2 text-gray-800">Matrix Calculation</h1>


    <!-- Data  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">=Matrix Calculation Data=</h5>
            <div class="text-left card-header" style="background-color:darkgrey;color:white">
                <small>
                    Notes : *
                    <br><br>
                    Data berikut merupakan perhitungan matrix untuk mendapatkan hasil komparasi nilai berdasarkan kriteria dan nilai bobot yang di berikan.
                    <br> Nilai bobot dari matrix memiliki batas bawah dan batas atas.
                    <br> Batas bawah dari nilai adalah 1 dan batas atas adalah memiliki nilai 5.
                    <br> Berikut detailnya :
                    <br> Nilai 1 = Sangat Buruk
                    <br> Nilai 2 = Buruk
                    <br> Nilai 3 = Cukup
                    <br> Nilai 4 = Baik
                    <br> Nilai 5 = Sangat Baik
                    <br>
                    <br>
                    Data Nilai ini dapat berubah sesuai dengan kebijakan yang berlaku pada perusahaan.

                </small>

            </div>
            <br>
            <div class="text-right">
                <button class="btn btn-success btn-xs" onclick="add()" type="button"><i class="fa fa-plus"></i> Add Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered weightData" style="font-size:13px" id="dataTable" width="100%">
                    <thead>

                        <tr>
                            <th colspan="2" style="background-color: cyan;font-color:black">Maximum Value</th>
                            <?php foreach ($getMaxMin as $row) { ?>
                                <th style="background-color: cyan;font-color:black"><?php echo $row->max_val; ?></th>
                            <?php } ?>
                            <th style="font-color:black;text-align:left;background-color:powderblue"><em class="fa fa-list    "></em>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" style="background-color:red;color:black;">Minimum Value</th>
                            <?php foreach ($getMaxMin as $row) { ?>
                                <th style="background-color:red;color:black;"><?php echo $row->min_val; ?></th>
                            <?php } ?>
                            <th style="background-color:red;text-align:left;color:black;"><em class="fa fa-list   "></em></th>
                        </tr>

                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <?php foreach ($getCriteria as $row) { ?>
                                <th><?php echo $row->criteria_code; ?></th>
                            <?php } ?>
                            <th>
                                <em class="fa fa-cogs"></em>
                                Tools
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        $showData = $this->db->query('select distinct a.employee_id, b.e_name from calc_criteria_employee a inner join employee b on b.id = a.employee_id'); ?>
                        <?php foreach ($showData->result() as $baris) { ?>
                            <tr>
                                <td><?php echo ++$no; ?></td>
                                <td><?php echo $baris->e_name; ?></td>
                                <?php $getValue = $this->db->query('select criteria_id,value from calc_criteria_employee where employee_id = "' . $baris->employee_id . '"');
                                foreach ($getValue->result() as $c) { ?>
                                    <td><?php echo $c->value; ?>
                                        <button class="btn btn-primary btn-sm" type="button" style="font-size:8px" onclick="updateMatrix(<?php echo $baris->employee_id; ?>,<?php echo $c->criteria_id; ?>)">
                                            <em class="fa fa-edit"></em>
                                        </button>
                                    </td>
                                <?php } ?>
                                <td>
                                    <button class="btn btn-danger btn-sm" type="button" onclick="deleteMatrix(<?php echo $baris->employee_id; ?>)">
                                        <em class="fa fa-trash"></em>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>


                    </tbody>
                </table>

            </div>
        </div>
    </div>



</div>
<!-- Modal User Role-->
<div class="modal fade" id="modalMatrix" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="formMatrix" action="" method="POST">
                <div class="modal-body">
                    <!-- <input type="hidden" name='id' value="" id='id'> -->

                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Employee Name<span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <select name="employee_id" class="form-control" id="employee_id">
                                <option value="">Select Employee</option>
                                <?php foreach ($getEmployee as $b) { ?>
                                    <option value="<?php echo $b->id; ?>"><?php echo $b->e_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php foreach ($getCriteria as $row) { ?>
                        <div class="item form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12"><?php echo $row->criteria_code . ' (' . $row->criteria_detail . ')'; ?><span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-9 col-xs-12">
                                <input type="hidden" id="criteria_id[<?php echo $row->criteria_code; ?>]" value="<?php echo $row->id; ?>" name="criteria_id[<?php echo $row->criteria_code; ?>]">
                                <input type="number" id="value[<?php echo $row->criteria_code; ?>]" name="value[<?php echo $row->criteria_code; ?>]" required="required" placeholder="" class="form-control ">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateMatrix" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="formUpdateMatrix" action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name='employee_id' value="" id='employee_id'>
                    <input type="hidden" name='criteria_id' value="" id='criteria_id'>

                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Value<span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <input type="number" id="value" name="value" required="required" placeholder="" class="form-control ">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveUpdate()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>