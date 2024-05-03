<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $judul; ?> | TEKKOM Laundry</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" href="img/tint-white.png">

    <style>
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            border-radius: 5px;
            background-color: #e6e6e6;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: #789afa;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #4e73df;
        }

        ::selection {
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: #fff;
        }
    </style>
</head>

<body id="page-top">
    <div class="bukanAdmin" data-flashdata="<?= session()->getFlashdata('bukanAdmin'); ?>"></div>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" title="Wlee Laundry">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="sidebar-brand-text mx-2">TEKKOM<sup>Laundry</sup></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item <?= $judul == 'Dashboard' ? 'active' : null ?>">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Admin -->
            <?php if (session()->get('role') == 'Admin') { ?>
                <li class="nav-item <?= $judul == 'Registrasi' ? 'active' : null ?>">
                    <a class="nav-link" href="registrasi">
                        <i class="fas fa-fw fa-user-plus"></i>
                        <span>Registrasi</span>
                    </a>
                </li>
                <li class="nav-item <?= $judul == 'Pelanggan' ? 'active' : null ?>">
                    <a class="nav-link" href="pelanggan">
                        <i class="fas fa-fw fa-user-alt"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>
                <li class="nav-item <?= $judul == 'Pengguna' ? 'active' : null ?>">
                    <a class="nav-link" href="pengguna">
                        <i class="fas fa-fw fa-user-cog"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
                <li class="nav-item <?= $judul == 'Paket Cucian' ? 'active' : null ?>">
                    <a class="nav-link" href="paket">
                        <i class="fas fa-fw fa-box-open"></i>
                        <span>Paket Cucian</span>
                    </a>
                </li>
                <li class="nav-item <?= $judul == 'Bahan Cucian' ? 'active' : null ?>">
                    <a class="nav-link" href="bahan">
                        <i class="fas fa-fw fa-list"></i>
                        <span>Bahan Cucian</span>
                    </a>
                </li>
            <?php } ?>

            <!-- Kasir -->
            <?php if (session()->get('role') == 'Kasir') { ?>
                <li class="nav-item <?= $judul == 'Registrasi' ? 'active' : null ?>">
                    <a class="nav-link" href="registrasi">
                        <i class="fas fa-fw fa-user-plus"></i>
                        <span>Registrasi</span>
                    </a>
                </li>
            <?php } ?>

            <!-- Owner -->
            <?php if (session()->get('role') == 'Owner') { ?>
                <li class="nav-item <?= $judul == 'Pelanggan' ? 'active' : null ?>">
                    <a class="nav-link" href="pelanggan">
                        <i class="fas fa-fw fa-user-alt"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>
                <li class="nav-item <?= $judul == 'Pengguna' ? 'active' : null ?>">
                    <a class="nav-link" href="pengguna">
                        <i class="fas fa-fw fa-user-cog"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
                <li class="nav-item <?= $judul == 'Paket Cucian' ? 'active' : null ?>">
                    <a class="nav-link" href="paket">
                        <i class="fas fa-fw fa-box-open"></i>
                        <span>Paket Cucian</span>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item <?= $judul == 'Transaksi' ? 'active' : null ?>">
                <a class="nav-link" href="transaksi">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <!-- End of Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <h3 class="mt-2 text-dark" style="font-weight: 500;"><?= $judul ?></h3>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session()->get('nama_user') ?></span>
                                <img class="img-profile rounded-circle" src="img/foto_profil/<?= session()->get('foto') ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-user-alt fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item tombol-keluar" href="keluar">
                                    <i class="fas fa-sign-out-alt fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">

                    <!-- Konten Utama -->
                    <?= $this->renderSection('content'); ?>

                </div>
            </div>
            <footer class="sticky-footer bg-white mt-4">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        Full Made With <i class="fas fa-fw fa-heart text-primary"></i> by <strong class="text-primary">Kelompok 7</strong> 2024
                    </div>
                </div>
            </footer>

            <!-- Modal Profil -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Ubah Profil</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="text-primary">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="ubah-profil" enctype="multipart/form-data">
                            <div class="modal-body">
                                <?php if (session('validation_profil')) : ?>
                                    <div class="alert alert-danger">
                                        <?php foreach (session('validation_profil')->getErrors() as $error) : ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                                <div class="row px-2">
                                    <div class="col-lg-4">
                                        <div class=" text-center ">
                                            <input type='hidden' name="foto_default" value="<?= session()->get('foto') ?>">
                                            <label for="nama">Foto Profil</label>
                                            <p>
                                                <input accept="image/*" type='file' id="foto2" name="foto" onchange="loadFile2(event)" style="display: none;">
                                            </p>
                                            <span>
                                                <img class="rounded-circle border border-secondary" id="output2" width="200px" height="200px" src="img/foto_profil/<?= session()->get('foto') ?>" />
                                            </span>
                                            <p>
                                                <label for="foto2" class="btn btn-info mt-2" style="cursor: pointer;">Unggah Foto</label>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="mb-3 row">
                                            <input type="hidden" name="id_user" value="<?= session()->get('id') ?>">
                                            <div class="col">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama_user" value="<?= session()->get('nama_user') ?>" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?= session()->get('username') ?>" autocomplete="off" required>
                                            </div>
                                            <div class="col">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" value="<?= session()->get('password') ?>" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="role">Role</label>
                                            <select disabled class="form-control border-secondary border" data-live-search="true">
                                                <option value="Admin" <?= session()->get('role') == "Admin" ? 'selected' : null ?>>Admin</option>
                                                <option value="Kasir" <?= session()->get('role') == "Kasir" ? 'selected' : null ?>>Kasir</option>
                                                <option value="Owner" <?= session()->get('role') == "Owner" ? 'selected' : null ?>>Owner</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <input type="submit" class="btn btn-primary " value="Simpan Data">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
            <script type="text/javascript">
                // Ubah Profil
                var loadFile2 = function(event) {
                    var output2 = document.getElementById('output2');
                    output2.src = URL.createObjectURL(event.target.files[0]);
                };
            </script>

            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <script src="js/sb-admin-2.min.js"></script>
            <script src="vendor/chart.js/Chart.min.js"></script>
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
            <script src="js/demo/datatables-demo.js"></script>
            <script src="bootstrap-select/dist/js/bootstrap-select.min.js"></script>
            <script>
                $('select').selectpicker();
            </script>
            <script src="js/sa2/sweetalert2.all.min.js"></script>
            <script src="js/sa2/alert.js"></script>
</body>

</html>