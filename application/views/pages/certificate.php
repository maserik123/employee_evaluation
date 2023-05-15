<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Search -->
                    <button class="btn btn-primary btn-sm" onclick="<?php echo base_url('administrator/result') ?>" type="button">
                        Back
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="window.print()" type="button">
                        Print
                    </button>

                    <!-- Topbar Navbar -->

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <br>
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <!-- <h6 class="m-0 font-weight-bold text-primary">Certificate</h6> -->

                                </div>
                                <!-- Card Body -->

                                <div class="card-body" style="text-align:center;color:black;position:absolute;padding-top:20%;padding-left:30%;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                    <img src="<?php echo base_url('assets/img/bunga.png') ?>" width="70%" height="70%" alt="">
                                    <br><br>
                                    <h1>CERTIFICATE</h1>
                                    <h2>OF APPRECIATION</h2>
                                    <br><br><br><br><br>
                                    <h3>Proudly Presented to : </h3>
                                    <?php $query = $this->db->query('select e_name from employee where id="' . $e_id . '"')->row_array(); ?>
                                    <br>
                                    <h1><?php echo $query['e_name']; ?></h1>

                                    <br><br><br><br>
                                    <?php $queryBest = $this->db->query('select year from calc_total_weight_normalization where employee_id = "' . $e_id . '"')->row_array(); ?>
                                    <h4>To be the best employee in <?php echo $queryBest['year']; ?></h4>
                                    <h4>Hopefully you are keep spirit </h4>
                                    <h4>and always give the best for our country</h4>
                                    <br>
                                    <h4>PT. ARNIUZ GLOBAL ASIA</h4>

                                </div>

                                <img src="<?php echo base_url('assets/img/piagam.png') ?>" alt="">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assets/') ?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo base_url('assets/') ?>js/demo/chart-area-demo.js"></script>
    <script src="<?php echo base_url('assets/') ?>js/demo/chart-pie-demo.js"></script>

</body>

</html>