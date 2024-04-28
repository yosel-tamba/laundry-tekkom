<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Paket Cucian</h6>
        <div>
            <a href="paket" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="laporan-paket?jenis=<?= $jenis ?>" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-fw fa-download"></i> Buat Laporan</a>
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
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>