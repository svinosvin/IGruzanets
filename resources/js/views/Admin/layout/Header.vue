<template>
        <!-- Preloader -->
<!--        <div class="preloader flex-column justify-content-center align-items-center">-->
<!--            <p class="animation__shake">Иванец</p>-->
<!--        </div>-->

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            <span class="brand-text font-weight-light">IGruzanets</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <NavLink route="/admin/" icon="pi-home">Главная</NavLink>
                    <NavLink route="/admin/services" icon="pi-user">Услуги</NavLink>
                    <NavLink route="/admin/drivers" icon="pi-user">Водитель</NavLink>
                    <NavLink route="/admin/drivers" icon=" pi-car">Машины</NavLink>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

</template>

<script>

 import NavLink from "./NavLink.vue";
export default {
    name: "Header",
    components :{
        NavLink
    }


}

</script>

<style scoped>

</style>
