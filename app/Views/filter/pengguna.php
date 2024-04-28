<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
        <div>
            <a href="pengguna" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a class="btn btn-success btn-sm" href="laporan-pengguna?role=<?= $role ?>" target="_blank" role="button"><i class="fas fa-fw fa-download"></i> Buat Laporan</a>
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
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>