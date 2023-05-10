<script>
    function updateUserRoleTable() {
        table.ajax.reload(null, false);
    }

    function updateUserTable() {
        table_user.ajax.reload(null, false);
    }

    function updateLoginTable() {
        table_login.ajax.reload(null, false);
    }

    $(document).ready(function() {
        table_login = $('.userLogin').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            "ajax": {
                "url": "<?php echo site_url('administrator/userLogin/getAllData') ?>",
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
    $(document).ready(function() {
        table_user = $('.userManagement').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            "scrollX": true,
            "scrollY": true,
            "ajax": {
                "url": "<?php echo site_url('administrator/user/getAllData') ?>",
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

    $(document).ready(function() {
        table = $('.userRole').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            "ajax": {
                "url": "<?php echo site_url('administrator/userRole/getAllData') ?>",
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
    function addUser() {
        save_method = 'add';
        $('.modal-title').text(' Add Data Users');
        $('.reset-btn').show();
        $('.form-group')
            .removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error')
            .remove();
        $('#modalUser').modal('show');

    }

    function addUserRole() {
        save_method_role = 'add';
        $('.modal-title').text(' Add Data Users Role');
        $('.reset-btn').show();
        $('.form-group')
            .removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error')
            .remove();
        $('#modalUserRole').modal('show');
    }

    function addUserLogin() {
        save_method_login = 'add';
        $('.modal-title').text(' Add Data Users Login');
        $('.reset-btn').show();
        $('.form-group')
            .removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error')
            .remove();
        $('#modalUserLogin').modal('show');
    }
    // End method add

    // Start Method Update
    function update_user(id) {
        save_method = 'update';
        $('#form-user')[0].reset();

        //Load data dari ajax
        $.ajax({
            url: "<?php echo base_url('administrator/user/getById/'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="userid"]').val(data.userid);
                $('[name="full_name"]').val(data.full_name);
                $('[name="nick_name"]').val(data.nick_name);
                $('[name="initial"]').val(data.initial);
                $('[name="NIP"]').val(data.NIP);
                $('[name="email"]').val(data.email);
                $('[name="address"]').val(data.address);
                $('[name="phone_number"]').val(data.phone_number);
                $('#modalUser').modal('show');
                $('.modal-title').text('Edit Data Pengguna');
                console.log(data.userid);
                updateAllTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }

    function update_user_role(id) {
        save_method_role = 'update';
        $('#add-form-role')[0].reset();

        //Load data dari ajax
        $.ajax({
            url: "<?php echo base_url('administrator/userRole/getById/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="user_role_id"]').val(data.user_role_id);
                $('[name="role"]').val(data.role);
                $('[name="description"]').val(data.description);
                $('#modalUserRole').modal('show');
                $('.modal-title').text('Edit Data Role Pengguna');
                // console.log(data.user_role_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }

    function update_user_login(id) {
        save_method_login = 'update';
        $('#add-form-login')[0].reset();

        //Load data dari ajax
        $.ajax({
            url: "<?php echo base_url('administrator/userLogin/getById/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="user_login_id"]').val(data.user_login_id);
                $('[name="userid"]').val(data.userid);
                $('[name="username"]').val(data.username);
                $('[name="password"]').val(data.password);
                $('[name="user_role_id"]').val(data.user_role_id);
                $('[name="block_status"]').val(data.block_status);
                $('#modalUserLogin').modal('show');
                $('.modal-title').text('Edit Data Login Pengguna');
                // console.log(data.user_role_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }

    // End Method Update

    // Start Method delete
    function delete_user(id) {
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
                    url: "<?php echo site_url('administrator/user/delete'); ?>/" + id,
                    type: "POST",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        updateUserTable();
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

    function delete_user_login(id) {
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
                    url: "<?php echo site_url('administrator/userLogin/delete'); ?>/" + id,
                    type: "POST",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        updateLoginTable();
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

    function delete_user_role(id) {
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
                    url: "<?php echo site_url('administrator/userRole/delete'); ?>/" + id,
                    type: "POST",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(data) {
                        updateUserRoleTable();
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
        if (save_method == 'add') {
            url = '<?php echo base_url() ?>administrator/user/insert';
        } else {
            url = '<?php echo base_url() ?>administrator/user/update';
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
                    data: $('#form-user').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result;
                        // csrf_hash = resp.csrf['token']
                        // $('#add-form input[name=' + csrf_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateUserTable();
                            $('.form-group')
                                .removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error')
                                .remove();
                            $('#modalUser').modal('hide');
                            $("#form-user")[0].reset();

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
                            showConfirmButton: false,
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

    function saveUserRole() {
        var url;
        if (save_method_role == 'add') {
            url = '<?php echo base_url() ?>administrator/userRole/insert';
        } else {
            url = '<?php echo base_url() ?>administrator/userRole/update';
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
                    data: $('#add-form-role').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result;
                        // csrf_hash = resp.csrf['token']
                        // $('#add-form input[name=' + csrf_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateUserRoleTable();
                            $('.form-group')
                                .removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error')
                                .remove();
                            $('#modalUserRole').modal('hide');
                            $("#add-form-role")[0].reset();

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

    function saveUserLogin() {
        var url;
        if (save_method_login == 'add') {
            url = '<?php echo base_url() ?>administrator/userLogin/insert';
        } else {
            url = '<?php echo base_url() ?>administrator/userLogin/update';
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
                    data: $('#add-form-login').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result;
                        // csrf_hash = resp.csrf['token']
                        // $('#add-form input[name=' + csrf_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateLoginTable();
                            $('.form-group')
                                .removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error')
                                .remove();
                            $('#modalUserLogin').modal('hide');
                            $("#add-form-login")[0].reset();
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
    <h1 class="h3 mb-2 text-gray-800">Management Users</h1>

    <!-- Data User Login -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">=User Login=</h5>
            <div class="text-right">
                <button class="btn btn-success btn-sm" onclick="addUserLogin()" type="button"><i class="fa fa-plus"></i> Add Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered userLogin" id="dataTable22" style="font-size:13px" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Nick Name</th>
                            <th>Initial</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>No HP</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Block Status</th>
                            <th>Tools</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    <!-- Data User Login -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">=User Managements=</h5>
            <div class="text-right">
                <button class="btn btn-success btn-xs" onclick="addUser()" type="button"><i class="fa fa-plus"></i> Add Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered userManagement" style="font-size:13px" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Nick Name</th>
                            <th>Initial</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th>Tools</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    <!-- Data User Login -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">=User Role=</h5>
            <div class="text-right">
                <button class="btn btn-success btn-xs" onclick="addUserRole()" type="button"><i class="fa fa-plus"></i> Add Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered userRole" id="dataTable1" style="font-size:13px" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- Modal User -->
<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="form-user" action="" method="POST">
                <div class="modal-body">
                    <div class="item form-group">
                        <input type="hidden" name="userid" id="userid">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12 form-group">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-5 col-xs-12 form-group">
                            <input id="full_name" class="form-control" name="full_name" placeholder="Full Name" required="required" type="text">
                        </div>
                        <div class="col-md-12 col-sm-5 col-xs-12 form-group">
                            <input id="nick_name" class="form-control" name="nick_name" placeholder="Nick Name" required="required" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-2 col-xs-12 form-group">Initial/NIP <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-5 col-xs-12 form-group">
                            <input type="text" id="initial" name="initial" required="required" placeholder="Initial" class="form-control">
                        </div>
                        <div class="col-md-12 col-sm-5 col-xs-12 form-group">
                            <input type="text" id="NIP" name="NIP" required="required" placeholder="NIP" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-10 col-xs-12">
                            <input type="email" id="email" name="email" data-validate-linked="email" placeholder="Email" required="required" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Address <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-10 col-xs-12">
                            <input type="text" id="address" name="address" required="required" placeholder="Address" data-validate-minmax="10,100" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-10 col-xs-12">
                            <input type="text" id="phone_number" name="phone_number" required="required" placeholder="Phone Number" class="form-control col-md-12 col-xs-12">
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

<!-- Modal User Role-->
<div class="modal fade" id="modalUserRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="add-form-role" action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name='user_role_id' value="" id='user_role_id'>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Role <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <input type="text" id="role" name="role" placeholder="Role" required="required" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <input type="text" id="description" name="description" required="required" placeholder="Description" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveUserRole()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal User Login-->
<div class="modal fade" id="modalUserLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="add-form-login" action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name='user_login_id' id='user_login_id'>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Choose Users <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <select name="userid" id="userid" class="form-control col-md-12 col-xs-12">
                                <option value="">Choose</option>
                                <?php foreach ($listUser as $row) { ?>
                                    <option value="<?php echo $row->userid ?>"><?php echo $row->full_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Username <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <input type="text" id="username" name="username" required="required" placeholder="Username" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <input type="text" id="password" name="password" required="required" placeholder="Password" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12"> Users Role <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <select name="user_role_id" id="user_role_id" class="form-control col-md-12 col-xs-12">
                                <option value="">Choose User Role</option>
                                <?php foreach ($listUserRole as $row) { ?>
                                    <option value="<?php echo $row->user_role_id ?>"><?php echo $row->role; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-12 col-sm-3 col-xs-12">Block Status <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <select name="block_status" id="block_status" class="form-control col-md-12 col-xs-12">
                                <option value="0">Un Blocked</option>
                                <option value="1"> Blocked</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveUserLogin()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>