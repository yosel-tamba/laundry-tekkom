<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
        <div>
            <a href="pelanggan" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="laporan-pelanggan?jk=<?= $jenis_kelamin ?>" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-fw fa-download"></i> Buat Laporan</a>
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
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>