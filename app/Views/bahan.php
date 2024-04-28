<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="bahan" data-flashdata="<?= session()->getFlashdata('bahan'); ?>"></div>
<div class="gagal_simpan" data-flashdata="<?= session()->getFlashdata('gagal_simpan'); ?>"></div>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Bahan Cucian</h6>
        <div class="d-flex justify-content-between">
            <a href="laporan-bahan" target="_blank" class="btn btn-sm btn-success mr-1"><i class="fas fa-fw fa-download"></i> Buat Laporan</a>
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
                        <th>Harga</th>
                        <th>Stok</th>
                        <?php if (session()->get('role') == 'Admin') { ?>
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($bahan as $m) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $m['nama_bahan']; ?></td>
                            <td>Rp. <?= number_format($m['harga'], 0, ",", "."); ?></td>
                            <td><?= $m['stok']; ?></td>
                            <?php if (session()->get('role') == 'Admin') { ?>
                                <td class="text-center">
                                    <a data-toggle="modal" data-target="#ubah<?= $m['id_bahan'] ?>" class="btn btn-warning btn-sm" title="Ubah"><i class="fas fa-pen"></i></a>
                                    <a href="hapus-bahan/<?= $m['id_bahan']; ?>" class="btn btn-danger btn-sm tombol-hapus" title="Hapus Data"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header card-header px-4">
                <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah Data Bahan Cucian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-primary">&times;</span>
                </button>
            </div>
            <form method="post" action="tambah-bahan">
                <div class="modal-body">
                    <?php if (session('validation_tambah')) : ?>
                        <div class="alert alert-danger">
                            <?php foreach (session('validation_tambah')->getErrors() as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <div class="mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama_bahan" autocomplete="off" value="<?= old('nama_bahan'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" autocomplete="off" value="<?= old('harga'); ?>">
                    </div>
                    <div>
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" autocomplete="off" value="<?= old('stok'); ?>">
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
foreach ($bahan as $row) : ?>
    <div class="modal fade" id="ubah<?= $row['id_bahan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header card-header px-4">
                    <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Ubah Data Bahan Cucian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-primary">&times;</span>
                    </button>
                </div>
                <form method="post" action="ubah-bahan">
                    <div class="modal-body">
                        <?php if (session('validation_ubah' . $row['id_bahan'])) : ?>
                            <div class="alert alert-danger">
                                <?php foreach (session('validation_ubah' . $row['id_bahan'])->getErrors() as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <input type="hidden" name="id_bahan" value="<?= $row['id_bahan'] ?>">
                        <div class="mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama_bahan" value="<?= $row['nama_bahan'] ?>" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" value="<?= $row['harga'] ?>" autocomplete="off">
                        </div>
                        <div>
                            <label for="stok">Stok</label>
                            <input type="text" class="form-control" id="stok" name="stok" value="<?= $row['stok'] ?>" autocomplete="off">
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