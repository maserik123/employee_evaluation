<script>
    function updateTable() {
        table.ajax.reload(null, false);
    }

    $(document).ready(function() {
        table = $('#dataTable').DataTable({

        });
        table = $('#dataTable1').DataTable({

        });
    });

    var save_method;
    var save_method_role;
    var save_method_login;


    // Start Method add

    function add() {
        save_method_role = 'add';
        $('.modal-title').text(' Add Data Criteria');
        $('.reset-btn').show();
        $('.form-group')
            .removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error')
            .remove();
        $('#modalCriteria').modal('show');
    }

    // End method add

    // Start Method Update


    function updateCriteria(id) {
        save_method_role = 'update';
        $('#formCriteria')[0].reset();

        //Load data dari ajax
        $.ajax({
            url: "<?php echo base_url('administrator/criteria/getById/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                console.log(data.id);
                $('[name="id"]').val(data.id);
                $('[name="criteria_code"]').val(data.criteria_code);
                $('[name="criteria_detail"]').val(data.criteria_detail);
                $('#modalCriteria').modal('show');
                $('.modal-title').text('Edit Data Criteria');
                // console.log(data.user_role_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }



    // End Method Update

    // Start Method delete

    function deleteCriteria(id) {
        swal({
            title: "Apakah Yakin Akan Dihapus?",
            icon: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Ya",
            closeOnConfirm: false
        }).then(
            function() {
                $.ajax({
                    url: "<?php echo site_url('administrator/criteria/delete'); ?>/" + id,
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
            }
        );
    }
    // End Method delete

    var csrf_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
    var csrf_hash = ''


    function save() {
        var url;
        if (save_method_role == 'add') {
            url = '<?php echo base_url() ?>administrator/criteria/insert';
        } else {
            url = '<?php echo base_url() ?>administrator/criteria/update';
        }

        swal({
            title: "Apakah anda sudah yakin ?",
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
                    data: $('#formCriteria').serialize(),
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
                            $('#modalCriteria').modal('hide');
                            $("#formCriteria")[0].reset();

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
    <div class="row">
        <div class="col-md-6">
            <!-- Data  -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">=Alternative Calculation=</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered employeeData" style="font-size:13px" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <?php $maxS = $this->db->query('select max(value) as maxS_value from calc_total_weight_normalization')->row(); ?>
                                <?php $minS = $this->db->query('select min(value) as minS_value from calc_total_weight_normalization')->row(); ?>
                                <?php $maxR = $this->db->query('select max(value) as maxR_value from calc_max_weight_normalization')->row(); ?>
                                <?php $minR = $this->db->query('select min(value) as minR_value from calc_max_weight_normalization')->row(); ?>
                                <tr>
                                    <th colspan="2" style="background-color:cyan">Maximum</th>
                                    <th style="background-color:cyan"><?php echo $maxS->maxS_value ?></th>
                                    <th style="background-color:cyan"><?php echo $maxR->maxR_value ?></th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="background-color:brown">Minimum</th>
                                    <th style="background-color:brown"><?php echo $minS->minS_value ?></th>
                                    <th style="background-color:brown"><?php echo $minR->minR_value ?></th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>S Value</th>
                                    <th>R Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $querySumMax = $this->db->query('select 
                            b.e_name, 
                            a.value as value_sum, 
                            c.value as value_max
                            from calc_total_weight_normalization a 
                            inner join employee b on b.id = a.employee_id
                            inner join calc_max_weight_normalization c on c.employee_id = a.employee_id')->result(); ?>
                                <?php
                                $no = 0;
                                foreach ($querySumMax as $rr) { ?>

                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $rr->e_name; ?></td>
                                        <td><?php echo $rr->value_sum; ?></td>
                                        <td><?php echo $rr->value_max; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Data  -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">=Rank Index Data=</h5>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered employeeData" style="font-size:13px" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Index Value</th>
                                    <th>Rank</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $maxS = $this->db->query('select max(value) as maxS_value from calc_total_weight_normalization')->row(); ?>
                                <?php $minS = $this->db->query('select min(value) as minS_value from calc_total_weight_normalization')->row(); ?>
                                <?php $maxR = $this->db->query('select max(value) as maxR_value from calc_max_weight_normalization')->row(); ?>
                                <?php $minR = $this->db->query('select min(value) as minR_value from calc_max_weight_normalization')->row(); ?>
                                <?php $querySumMax = $this->db->query('select 
                            b.e_name, 
                            a.value as value_S, 
                            c.value as value_R
                            from calc_total_weight_normalization a 
                            inner join employee b on b.id = a.employee_id
                            inner join calc_max_weight_normalization c on c.employee_id = a.employee_id
                            order by value_S asc')->result(); ?>
                                <?php
                                $no = 0;
                                $rank = 1;
                                foreach ($querySumMax as $rr) { ?>

                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $rr->e_name; ?></td>
                                        <td><?php echo ((((($rr->value_S) - ($minS->minS_value)) / (($maxS->maxS_value) - ($minS->minS_value))) * 0.5) + (((($rr->value_R) - ($minR->minR_value)) / (($maxR->maxR_value) - ($minR->minR_value))) * 0.5)); ?></td>
                                        <td><?php echo $rank++; ?></td>
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