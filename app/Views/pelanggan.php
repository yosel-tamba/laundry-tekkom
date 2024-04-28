<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="pelanggan" data-flashdata="<?= session()->getFlashdata('pelanggan'); ?>"></div>
<div class="gagal_simpan" data-flashdata="<?= session()->getFlashdata('gagal_simpan'); ?>"></div>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
        <div class="d-flex justify-content-between">
            <div class="dropdown mr-1">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Jenis Kelamin</div>
                    <a class="dropdown-item" href="filter-pelanggan?jk=Semua">Semua</a>
                    <a class="dropdown-item" href="filter-pelanggan?jk=Laki-Laki">Laki-Laki</a>
                    <a class="dropdown-item" href="filter-pelanggan?jk=Perempuan">Perempuan</a>
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
                        <th>Telepon</th>
                        <th>Kelamin</th>
                        <th>Alamat</th>
                        <?php if (session()->get('role') == 'Admin') { ?>
                            <th class="text-center">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($member as $m) {
                        $kalimat = $m['alamat'];
                        $limit = 40;
                        if (strlen($kalimat) > $limit) {
                            $alamat = substr($kalimat, 0, $limit) . "...";
                        } else {
                            $alamat = $kalimat;
                        }
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $m['nama_member']; ?></td>
                            <td><?= $m['tlp']; ?></td>
                            <td><?= $m['jenis_kelamin']; ?></td>
                            <td><?= $alamat; ?></td>
                            <?php if (session()->get('role') == 'Admin') { ?>
                                <td class="text-center">
                                    <a data-toggle="modal" data-target="#ubah<?= $m['id_member'] ?>" class="btn btn-warning btn-sm" title="Ubah"><i class="fas fa-pen"></i></a>
                                    <a href="hapus-pelanggan/<?= $m['id_member']; ?>" class="btn btn-danger btn-sm tombol-hapus" title="Hapus Data"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Kelamin</th>
                        <th>Alamat</th>
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
                <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-primary">&times;</span>
                </button>
            </div>
            <form method="post" action="tambah-pelanggan">
                <div class="modal-body">
                    <?php if (session('validation_tambah')) : ?>
                        <div class="alert alert-danger">
                            <?php foreach (session('validation_tambah')->getErrors() as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <div class="row px-2">
                        <div class="col">
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama_member" autocomplete="off" value="<?= old('nama_member'); ?>">
                                </div>
                                <div class="col">
                                    <label for="tlp">Nomor Telepon</label>
                                    <input type="number" class="form-control" id="tlp" name="tlp" autocomplete="off" value="<?= old('tlp'); ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" autocomplete="off" value="<?= old('alamat'); ?>">
                                </div>
                                <div class="col">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control border-secondary border" data-live-search="true" name="jenis_kelamin">
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-Laki" <?= old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : null ?>>Laki-Laki</option>
                                        <option value="Perempuan" <?= old('jenis_kelamin') == 'Perempuan' ? 'selected' : null ?>>Perempuan</option>
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
<?php foreach ($member as $row) : ?>
    <div class="modal fade" id="ubah<?= $row['id_member'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header card-header px-4">
                    <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Ubah Data Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-primary">&times;</span>
                    </button>
                </div>
                <form method="post" action="ubah-pelanggan">
                    <div class="modal-body">
                        <?php if (session('validation_ubah' . $row['id_member'])) : ?>
                            <div class="alert alert-danger">
                                <?php foreach (session('validation_ubah' . $row['id_member'])->getErrors() as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <div class="row px-2">
                            <div class="col">
                                <div class="mb-3 row">
                                    <input type="hidden" name="id_member" value="<?= $row['id_member'] ?>">
                                    <div class="col">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama_member" value="<?= $row['nama_member'] ?>" autocomplete="off" required>
                                    </div>
                                    <div class="col">
                                        <label for="tlp">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="tlp" name="tlp" value="<?= $row['tlp'] ?>" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $row['alamat'] ?>" autocomplete="off" required>
                                    </div>
                                    <div class="col">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control border-secondary border" data-live-search="true" name="jenis_kelamin">
                                            <option value="Laki-Laki" <?= $row['jenis_kelamin'] == "Laki-Laki" ? 'selected' : null ?>>Laki-Laki</option>
                                            <option value="Perempuan" <?= $row['jenis_kelamin'] == "Perempuan" ? 'selected' : null ?>>Perempuan</option>
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

<?= $this->endSection() ?>