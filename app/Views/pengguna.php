<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="pengguna" data-flashdata="<?= session()->getFlashdata('pengguna'); ?>"></div>
<div class="gagal_simpan" data-flashdata="<?= session()->getFlashdata('gagal_simpan'); ?>"></div>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
        <div class="d-flex justify-content-between">
            <div class="dropdown mr-1">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Role</div>
                    <a class="dropdown-item" href="filter-pengguna?role=Semua">Semua</a>
                    <a class="dropdown-item" href="filter-pengguna?role=Admin">Admin</a>
                    <a class="dropdown-item" href="filter-pengguna?role=Kasir">Kasir</a>
                    <a class="dropdown-item" href="filter-pengguna?role=Owner">Owner</a>
                </div>
            </div>
            <?php if (session()->get('role') == 'Admin') { ?>
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah" role="button"><i class="fas fa-fw fa-plus"></i> Tambah Data</a>
            <?php } ?>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
                        <?php if (session()->get('role') == 'Admin') { ?>
                            <th class="text-center">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($user as $m) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $m['nama_user']; ?></td>
                            <td><?= $m['username']; ?></td>
                            <td><?= $m['passconf']; ?></td>
                            <td><?= $m['role']; ?></td>
                            <?php if (session()->get('role') == 'Admin') { ?>
                                <td class="text-center">
                                    <a data-toggle="modal" data-target="#ubah<?= $m['id_user'] ?>" class="btn btn-warning btn-sm" title="Ubah"><i class="fas fa-pen"></i></a>
                                    <a href="hapus-pengguna/<?= $m['id_user']; ?>" class="btn btn-danger btn-sm tombol-hapus" title="Hapus Data"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
                        <?php if (session()->get('role') == 'Admin') { ?>
                            <th class="text-center">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header px-4">
                <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-primary">&times;</span>
                </button>
            </div>
            <form method="post" action="tambah-pengguna" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if (session('validation_tambah')) : ?>
                        <div class="alert alert-danger">
                            <?php foreach (session('validation_tambah')->getErrors() as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <div class="row px-2">
                        <div class="col-lg-4">
                            <div class=" text-center ">
                                <label for="nama">Foto Profil</label>
                                <p>
                                    <input accept="image/*" type='file' id="foto" name="foto" onchange="loadFile(event)" style="display: none;">
                                </p>
                                <span>
                                    <img class="rounded-circle border border-secondary" id="output" width="200px" height="200px" src="img/foto_profil/user.png" />
                                </span>
                                <p>
                                    <label for="foto" class="btn btn-info mt-2" style="cursor: pointer;">Unggah Foto</label>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama_user" autocomplete="off" value="<?= old('nama_user'); ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" autocomplete="off" value="<?= old('username'); ?>">
                                </div>
                                <div class="col">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" autocomplete="off" value="<?= old('password'); ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="role">Role</label>
                                    <select class="form-control border-secondary border" data-live-search="true" name="role">
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="Admin" <?= old('role') == 'Admin' ? 'selected' : null ?>>Admin</option>
                                        <option value="Kasir" <?= old('role') == 'Kasir' ? 'selected' : null ?>>Kasir</option>
                                        <option value="Owner" <?= old('role') == 'Owner' ? 'selected' : null ?>>Owner</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah -->
<?php
$no = 1;
foreach ($user as $row) : ?>
    <div class="modal fade" id="ubah<?= $row['id_user'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header card-header px-4">
                    <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Ubah Data Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-primary">&times;</span>
                    </button>
                </div>
                <form method="post" action="ubah-pengguna" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php if (session('validation_ubah' . $row['id_user'])) : ?>
                            <div class="alert alert-danger">
                                <?php foreach (session('validation_ubah' . $row['id_user'])->getErrors() as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <div class="row px-2">
                            <div class="col-lg-4">
                                <div class=" text-center ">
                                    <label for="nama">Foto Profil</label>
                                    <span>
                                        <img class="rounded-circle border border-secondary" id="output1" width="200px" height="200px" src="img/foto_profil/<?= $row['foto'] ?>" />
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="mb-3 row">
                                    <input type="hidden" name="id_user" value="<?= $row['id_user'] ?>">
                                    <div class="col">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama_user" value="<?= $row['nama_user'] ?>" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= $row['username'] ?>" autocomplete="off" required>
                                    </div>
                                    <div class="col">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password" value="<?= $row['passconf'] ?>" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <label for="role">Role</label>
                                        <select class="form-control border-secondary border" data-live-search="true" name="role">
                                            <option value="Admin" <?= $row['role'] == "Admin" ? 'selected' : null ?>>Admin</option>
                                            <option value="Kasir" <?= $row['role'] == "Kasir" ? 'selected' : null ?>>Kasir</option>
                                            <option value="Owner" <?= $row['role'] == "Owner" ? 'selected' : null ?>>Owner</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

<script type="text/javascript">
    // Tambah
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

<?= $this->endSection() ?>