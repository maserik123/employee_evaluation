<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <?php $queryku = $this->db->query('select 
                            b.e_name, 
                            a.value as value_S
                            from calc_total_weight_normalization a 
                            inner join employee b on b.id = a.employee_id
                            inner join calc_max_weight_normalization c on c.employee_id = a.employee_id
                            order by value_S ASC LIMIT 1')->result(); ?>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Recommendation Employee</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $queryku[0]->e_name; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Earnings (Monthly) Card Example -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Pending Requests Card Example -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Content Row -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card-header font-weight-bold text-primary">
                <h4>Daftar 10 Karyawan Teratas</h4>
                <hr>
            </div>
        </div>
        <!-- Content Column -->
        <?php foreach ($getListEmployee->result() as $row) { ?>
            <div class="col-md-3 mb-3">
                <!-- Project Card Example -->
                <div class="card shadow mb-2">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $row->e_name; ?></h6>
                    </div>
                    <div class="card-body">
                        <?php $warna = array();
                        $warna = ['bg-danger', 'bg-warning', 'bg-primary', 'bg-info', 'bg-success', '', '', '']; ?>

                        <?php $query_show = $this->db->query("SELECT b.criteria_code, b.criteria_detail, a.value FROM calc_criteria_employee a INNER JOIN criteria b
ON b.id = a.criteria_id WHERE a.employee_id = '" . $row->e_id . "'");
                        $i = 0;
                        foreach ($query_show->result() as $b) {
                        ?>
                            <h4 class="small font-weight-bold">(<?php echo $b->criteria_code; ?>) <?php echo $b->criteria_detail; ?><span class="float-right"><?php echo (($b->value / 5) * 100); ?></span></h4>
                            <div class="progress mb-1">
                                <div class="progress-bar <?php echo $warna[$i++]; ?> " role="progressbar" style="width: <?php echo (($b->value / 5) * 100); ?>%" aria-valuenow="<?php echo (($b->value / 5) * 100); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>