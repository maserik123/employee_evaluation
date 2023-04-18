<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-EMSys
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if (isset($active_dashboard)) {
                            echo $active_dashboard;
                        } else {
                        } ?>">
        <a class="nav-link" href="<?php echo base_url('administrator') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <li class="nav-item ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>User Managements</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data:</h6>
                <a class="collapse-item <?php if (isset($active_user)) {
                                            echo $active_user;
                                        } else {
                                        } ?>" href="<?php echo base_url('administrator/user') ?>">User Lists</a>

            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data:</h6>
                <a class="collapse-item <?php if (isset($active_employee)) {
                                            echo $active_employee;
                                        } else {
                                        } ?>" href="<?php echo base_url('administrator/employee') ?>">Employee</a>
                <a class="collapse-item <?php if (isset($active_criteria)) {
                                            echo $active_criteria;
                                        } else {
                                        } ?>" href="<?php echo base_url('administrator/criteria') ?>">Criteria</a>
                <a class="collapse-item <?php if (isset($active_weight)) {
                                            echo $active_weight;
                                        } else {
                                        } ?>" href="<?php echo base_url('administrator/weight') ?>">Weight (Based on Criteria)</a>
            </div>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Calculation</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data:</h6>
                <a class="collapse-item <?php if (isset($active_matrixCalculation)) {
                                            echo $active_matrixCalculation;
                                        } else {
                                        } ?>" href="<?php echo base_url('administrator/matrixCalculation') ?>">Matrix </a>
                <a class="collapse-item <?php if (isset($active_normalization)) {
                                            echo $active_normalization;
                                        } else {
                                        } ?>" href="<?php echo base_url('administrator/normalization') ?>"> Calculation</a>

            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item <?php if (isset($active_matrixCalculation)) {
                            echo $active_matrixCalculation;
                        } else {
                        } ?>">
        <a class="nav-link" href="<?php echo base_url('administrator/result') ?>">
            <i class="fas fa-fw fa-check-double"></i>
            <span>Results</span></a>
    </li>
    <!-- <li class="nav-item <?php if (isset($active_calculation)) {
                                    echo $active_calculation;
                                } else {
                                } ?>">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Normalization Calculation</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <p class="text-center mb-2"><strong>Employee Evaluation</strong> Management System</p>
        <a class="btn btn-success btn-sm" onclick="logout()" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
    </div>

</ul>