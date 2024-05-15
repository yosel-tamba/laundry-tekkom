<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="paket" data-flashdata="<?= session()->getFlashdata('paket'); ?>"></div>
<div class="gagal_simpan" data-flashdata="<?= session()->getFlashdata('gagal_simpan'); ?>"></div>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Paket Cucian</h6>
        <div class="d-flex justify-content-between">
            <div class="dropdown mr-1">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Jenis</div>
                    <a class="dropdown-item" href="filter-paket?jenis=Semua">Semua</a>
                    <a class="dropdown-item" href="filter-paket?jenis=Kiloan">Kiloan</a>
                    <a class="dropdown-item" href="filter-paket?jenis=Satuan">Satuan</a>
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
                        <th>Jenis</th>
                        <th>Harga</th>
                        <?php if (session()->get('role') == 'Admin') { ?>
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($paket as $m) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $m['nama_paket']; ?></td>
                            <td><?= $m['jenis']; ?></td>
                            <td>Rp. <?= number_format($m['harga'], 0, ",", "."); ?></td>
                            <?php if (session()->get('role') == 'Admin') { ?>
                                <td class="text-center">
                                    <a data-toggle="modal" data-target="#ubah<?= $m['id_paket'] ?>" class="btn btn-warning btn-sm" title="Ubah"><i class="fas fa-pen"></i></a>
                                    <a href="hapus-paket/<?= $m['id_paket']; ?>" class="btn btn-danger btn-sm tombol-hapus" title="Hapus Data"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <?php if (session()->get('role') == 'Admin') { ?>
                            <th>Aksi</th>
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
                <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah Data Paket Cucian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-primary">&times;</span>
                </button>
            </div>
            <form method="post" action="tambah-paket">
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
                                    <input type="text" class="form-control" id="nama" name="nama_paket" autocomplete="off" value="<?= old('nama_paket'); ?>">
                                </div>
                                <div class="col">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" autocomplete="off" value="<?= old('harga'); ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="jenis">Jenis Paket</label>
                                    <select class="form-control border-secondary border" data-live-search="true" name="jenis">
                                        <option value="" disabled selected>Pilih Jenis</option>
                                        <option value="Satuan" <?= old('jenis') == 'Satuan' ? 'selected' : null ?>>Satuan</option>
                                        <option value="Kiloan" <?= old('jenis') == 'Kiloan' ? 'selected' : null ?>>Kiloan</option>
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
<?php $no = 1;
foreach ($paket as $row) : ?>
    <div class="modal fade" id="ubah<?= $row['id_paket'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header card-header px-4">
                    <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Ubah Data Paket Cucian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-primary">&times;</span>
                    </button>
                </div>
                <form method="post" action="ubah-paket">
                    <div class="modal-body">
                        <?php if (session('validation_ubah' . $row['id_paket'])) : ?>
                            <div class="alert alert-danger">
                                <?php foreach (session('validation_ubah' . $row['id_paket'])->getErrors() as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <div class="row px-2">
                            <div class="col">
                                <div class="mb-3 row">
                                    <input type="hidden" name="id_paket" value="<?= $row['id_paket'] ?>">
                                    <div class="col">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama_paket" value="<?= $row['nama_paket'] ?>" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control" id="harga" name="harga" value="<?= $row['harga'] ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <label for="jenis">Jenis Paket</label>
                                        <select class="form-control border-secondary border" data-live-search="true" name="jenis">
                                            <option value="Satuan" <?= $row['jenis'] == "Satuan" ? 'selected' : null ?>>Satuan</option>
                                            <option value="Kiloan" <?= $row['jenis'] == "Kiloan" ? 'selected' : null ?>>Kiloan</option>
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