<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary mb-1">TRANSAKSI</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_transaksi; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success mb-1">PELANGGAN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_member; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="mb-4">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning mb-1">PENGGUNA</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_pengguna; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="mb-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger mb-1">PAKET CUCIAN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_paket; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Data Transaksi Terkini</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Masuk</th>
                        <th>Diambil</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($transaksi as $m) {
                        $harga_awal = 0;
                        $qty = 0;

                        foreach ($detail as $data) {
                            if ($data['id_transaksi'] == $m['id_transaksi']) {
                                $qty = $data['qty'];
                                foreach ($paket as $p) {
                                    if ($data['id_paket'] == $p['id_paket']) {
                                        $harga_awal += $p['harga'] * $qty;
                                    }
                                }
                            }
                        }
                        foreach ($biaya_tambahan as $biaya) {
                            if ($biaya['id_transaksi'] == $m['id_transaksi']) {
                                $qty = $biaya['qty'];
                                foreach ($bahan as $p) {
                                    if ($biaya['id_bahan'] == $p['id_bahan']) {
                                        $harga_awal += $p['harga'] * $qty;
                                    }
                                }
                            }
                        }

                        $harga_awal += $m['pajak'];
                        $harga_diskon = ($m['diskon'] / 100) * $harga_awal;
                        $total_biaya = ceil($harga_awal - $harga_diskon);
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <h6><?= $m['kode_invoice']; ?></h6>
                            </td>
                            <td><?= $m['nama_member']; ?></td>
                            <td><?= $m['tgl'] ?></td>
                            <td><?= $m['tgl_bayar']; ?></td>
                            <td>Rp. <?= number_format($total_biaya, 0, ",", ".") ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Masuk</th>
                        <th>Diambil</th>
                        <th>Total Biaya</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>