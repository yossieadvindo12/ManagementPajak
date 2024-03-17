<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/index">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-solid fa-file"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Management Pajak</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="/index">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Karyawan

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="/employee">
                <i class="fas fa-fw fa fa-users"></i>
                <span>Employee</span>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="/company">
                <i class="fas fa-fw fa fa-building"></i>
                <span>Company</span>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="/Bpjs">
                <i class="fas fa-fw fa fa-shield-alt"></i>
                <span>BPJS</span>
            </a>

        </li>

    </div>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="/reportBpjs">
                <i class="fas fa-fw fa fa-file-alt"></i>
                <span>Laporan BPJS</span>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="/company">
                <i class="fas fa-fw fa fa-file-alt"></i>
                <span>Laporan PPH 21</span>
            </a>

        </li>

    </div>



</ul>
<script>
    var path = window.location.pathname;
    var navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(function(item) {
        var href = item.querySelector('a').getAttribute('href');
        if (href === path) {
            item.classList.add('active');
        }
    });
</script>
