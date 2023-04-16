<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-4">
                        <!-- Nested Row within Card Body -->
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?php echo base_url('assets/img/employee.png') ?>" alt="" width="150px" height="100px">

                                        <h1 class="h4 text-gray-900 mb-4" style="font-weight: bold;">Employee Evaluation <br>
                                            Management Information System</h1>
                                    </div>
                                    <?php echo form_open("auth", array('method' => 'POST', 'class' => 'form-vertical user')); ?>
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" />
                                    </div>
                                    <label class="text-left">
                                        <?php
                                        $message = $this->session->flashdata('result_login');
                                        if ($message) { ?>
                                            <div style="color: red;"><?php echo $message; ?></div>
                                        <?php } ?>
                                    </label>


                                    <div class="form-actions">
                                        <!-- <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span> -->
                                        <span class="pull-right"><button type="submit" class="btn btn-user btn-block btn-success" />
                                            Masuk Disini </a></span>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assets/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>