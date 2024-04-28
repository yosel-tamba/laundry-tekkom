<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="transaksi" data-flashdata="<?= session()->getFlashdata('transaksi'); ?>"></div>
<div class="gagal_simpan" data-flashdata="<?= session()->getFlashdata('gagal_simpan'); ?>"></div>

<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
        <form action="tanggal-filter-transaksi" method="post">
            <div class="d-flex justify-content-end align-items-center">
                <div class="input-group input-group-sm mr-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="dari">Dari</span>
                    </div>
                    <input type="date" class="form-control form-control-sm" id="dari" name="dari" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="input-group input-group-sm mr-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="sampai">Sampai</span>
                    </div>
                    <input type="date" class="form-control form-control-sm" id="sampai" name="sampai" value="<?= date('Y-m-d') ?>">
                </div>
                <input type="submit" class="btn btn-info btn-sm" value="Filter Data">
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered nowrap" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Masuk</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <?php if (session()->get('role') != 'Owner') { ?>
                            <th>Aksi</th>
                        <?php } ?>
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
                            <td><?= $no++; ?></td>
                            <td><?= $m['kode_invoice']; ?></td>
                            <td><?= $m['nama_member']; ?></td>
                            <td><?= $m['tgl']; ?></td>
                            <td>Rp. <?= number_format($total_biaya, 0, ",", ".") ?></td>
                            <td class="fw-bold
                            <?= $m['status'] == 'baru' ? 'text-danger' : null ?>
                            <?= $m['status'] == 'proses' ? 'text-warning' : null ?>
                            <?= $m['status'] == 'selesai' ? 'text-primary' : null ?>
                            <?= $m['status'] == 'diambil' ? 'text-success' : null ?>
                        "><?= $m['status']; ?></td>
                            <?php if (session()->get('role') == 'Admin') { ?>
                                <td class="text-center">
                                    <a href="detail-transaksi?id=<?= $m['id_transaksi']; ?>" class=" btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="hapus-transaksi/<?= $m['id_transaksi']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-trash"></i></a>
                                </td>
                            <?php } ?>
                            <?php if (session()->get('role') == 'Kasir') { ?>
                                <td class="text-center">
                                    <a href="detail-transaksi?id=<?= $m['id_transaksi']; ?>" class=" btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Masuk</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <?php if (session()->get('role') != 'Owner') { ?>
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>