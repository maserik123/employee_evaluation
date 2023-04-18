<script>
    function updateTable() {
        table.ajax.reload(null, false);
    }

    $(document).ready(function() {
        table = $('#dataTable1').DataTable({

        });
    });

    $(document).ready(function() {
        table = $('#dataTable2').DataTable({

        });
    });

    $(document).ready(function() {
        table = $('#dataTable3').DataTable({

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


    function updateMatrix(id) {
        save_method_role = 'update';
        $('#formMatrix')[0].reset();
        //Load data dari ajax
        $.ajax({
            url: "<?php echo base_url('administrator/matrixCalculation/getById/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                // $('[name="id"]').val(data.id);
                console.log(data.employee_id);
                $('[name="employee_id"]').val(data.employee_id);
                <?php foreach ($getCriteria as $bb) { ?>
                    console.log('value[<?php echo $bb->criteria_code ?>]');
                    <?php $query = $this->db->query('select value from calc_criteria_employee where criteria_id ="' . $bb->id . '"')->result();
                    foreach ($query as $cc) { ?>
                        $('[name="criteria_id[<?php echo $bb->criteria_code; ?>]"]').html('tes');
                        $('[name="value[<?php echo $bb->criteria_code ?>]"]').val('<?php echo $cc->value; ?>');
                <?php }
                } ?>
                $('#modalMatrix').modal('show');
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
        if (save_method_role == 'add') {
            url = '<?php echo base_url() ?>administrator/matrixCalculation/insert';
        } else {
            url = '<?php echo base_url() ?>administrator/matrixCalculation/update';
        }

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

    function proceedNormalization() {
        $.ajax({
            url: "<?php echo base_url('administrator/normalization/insertNormalization'); ?>",
            type: "POST",
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "JSON",
            success: function(resp) {
                data = resp.result;
                return swal({
                    html: true,
                    timer: 1300,
                    showConfirmButton: false,
                    title: data['msg'],
                    icon: data['status']
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Processing Data');
            }
        });
    }

    function proceedSum() {
        $.ajax({
            url: "<?php echo base_url('administrator/normalization/insertSum'); ?>",
            type: "POST",
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "JSON",
            success: function(resp) {
                data = resp.result;
                return swal({
                    html: true,
                    timer: 1300,
                    showConfirmButton: false,
                    title: data['msg'],
                    icon: data['status']
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Processing Data');
            }
        });
    }

    function proceedMax() {
        $.ajax({
            url: "<?php echo base_url('administrator/normalization/insertMax'); ?>",
            type: "POST",
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "JSON",
            success: function(resp) {
                data = resp.result;
                return swal({
                    html: true,
                    timer: 1300,
                    showConfirmButton: false,
                    title: data['msg'],
                    icon: data['status']
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Processing Data');
            }
        });
    }

    function proceedWeightNormalization() {
        swal({
            title: "Are you sure ?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true,
            },
            // html: true
        }).then((result) => {
            if (result == true) {
                proceedNormalization();
                proceedSum();
                proceedMax();
                $.ajax({
                    url: "<?php echo base_url('administrator/normalization/insertWeightNormalization'); ?>",
                    type: "POST",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result;
                        setInterval(() => {
                            // window.location = '';
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
                        alert('Error Processing Data');
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


    <!-- Data  -->
    <div class="card shadow mb-4">
        <!-- <form action="" method="post"> -->

        <div class="card-header py-3">
            <div class="text-right">
                <button class="btn btn-success btn-sm" onclick="proceedWeightNormalization()" type="button"><i class="fa fa-check"></i> Process/Update All Data </button>
            </div>
            <h5 class="m-0 font-weight-bold text-primary">=Normalization Calculation Data=</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered weightData" style="font-size:13px" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <?php foreach ($getCriteria as $row) { ?>
                                <th><?php echo $row->criteria_code; ?></th>
                            <?php } ?>

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
                                foreach ($getCriteria as $c) { ?>
                                    <!-- <input type='text' id="employee_id" name="employee_id" value="<?php echo $baris->employee_id; ?>"> -->
                                    <!-- <input type='text' id="criteria_id" name="criteria_id" value="<?php echo $c->id; ?>"> -->
                                    <?php $query_value = $this->db->query('select value from calc_criteria_employee where criteria_id = "' . $c->id . '" and employee_id="' . $baris->employee_id . '" group by criteria_id')->row() ?>
                                    <?php $queryMax = $this->db->query('select max(value) as max_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row() ?>
                                    <?php $queryMin = $this->db->query('select min(value) as min_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row() ?>
                                    <?php $maxVal_value = ($queryMax->max_val - $query_value->value); ?>
                                    <?php $maxVal_minVal = ($queryMax->max_val - $queryMin->min_val); ?>
                                    <?php
                                    $divMaxVal_divMaxMinVal = '';
                                    if ($maxVal_minVal == 0) {
                                        $divMaxVal_divMaxMinVal = 'NaN';
                                    } else {
                                        $divMaxVal_divMaxMinVal = ($maxVal_value / $maxVal_minVal);
                                    } ?>
                                    <td><?php echo $divMaxVal_divMaxMinVal; ?></td>
                                    <!-- <input type='text' id="value" name="value" value="<?php echo $divMaxVal_divMaxMinVal; ?>"> -->

                                <?php } ?>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <!-- </form> -->
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <div class="text-right">
                <button class="btn btn-warning btn-sm" onclick="proceedWeightNormalization()" type="button"><i class="fa fa-check"></i> Process W & R Calculation</button>
            </div> -->
            <h5 class="m-0 font-weight-bold text-primary">=W & R Calculation Data=</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered weightData" style="font-size:13px" id="dataTable1" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <?php foreach ($getCriteria as $row) { ?>
                                <th><?php echo $row->criteria_code; ?></th>
                            <?php } ?>

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
                                foreach ($getCriteria as $c) { ?>
                                    <?php $weight = $this->db->query('select weight_value from weight where criteria_id = "' . $c->id . '" group by criteria_id')->row() ?>
                                    <?php $query_value = $this->db->query('select value from calc_criteria_employee where criteria_id = "' . $c->id . '" and employee_id="' . $baris->employee_id . '" group by criteria_id')->row() ?>
                                    <?php $queryMax = $this->db->query('select max(value) as max_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row() ?>
                                    <?php $queryMin = $this->db->query('select min(value) as min_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row() ?>
                                    <?php $maxVal_value = ($queryMax->max_val - $query_value->value); ?>
                                    <?php $maxVal_minVal = ($queryMax->max_val - $queryMin->min_val); ?>
                                    <?php
                                    $divMaxVal_divMaxMinVal = '';
                                    if ($maxVal_minVal == 0) {
                                        $divMaxVal_divMaxMinVal = 'NaN';
                                    } else {
                                        $divMaxVal_divMaxMinVal = ($maxVal_value / $maxVal_minVal);
                                    } ?>
                                    <td><?php echo ($weight->weight_value * $divMaxVal_divMaxMinVal); ?></td>
                                <?php } ?>

                            </tr>
                        <?php } ?>


                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">=Total SUM Calculation Data=</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered weightData" style="font-size:13px" id="dataTable2" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Name</th>
                                    <th>Total Sum Result</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                $showData = $this->db->query('SELECT b.e_name, SUM(a.VALUE) AS sum_val FROM calc_weight_normalization a 
                                inner join employee b on b.id = a.employee_id 
                                GROUP BY employee_id'); ?>
                                <?php foreach ($showData->result() as $baris) { ?>
                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $baris->e_name; ?></td>
                                        <td><?php echo $baris->sum_val; ?></td>
                                    </tr>
                                <?php } ?>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">=Total Max Calculation Data=</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered weightData" style="font-size:13px" id="dataTable3" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Name</th>
                                    <th>Total Sum Result</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                $showData = $this->db->query('SELECT b.e_name, max(a.VALUE) AS max_val FROM calc_weight_normalization a 
                                inner join employee b on b.id = a.employee_id 
                                GROUP BY employee_id'); ?>
                                <?php foreach ($showData->result() as $baris) { ?>
                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $baris->e_name; ?></td>
                                        <td><?php echo $baris->max_val; ?></td>
                                    </tr>
                                <?php } ?>


                            </tbody>
                        </table>

                    </div>
                </div>
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