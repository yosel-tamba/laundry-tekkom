<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="transaksi" data-flashdata="<?= session()->getFlashdata('transaksi'); ?>"></div>
<div class="gagal_simpan" data-flashdata="<?= session()->getFlashdata('gagal_simpan'); ?>"></div>

<?php
$harga_awal = 0;
$qty = 0;

foreach ($detail as $data) {
    $qty = $data['qty'];
    foreach ($paket as $p) {
        if ($data['id_paket'] == $p['id_paket']) {
            $harga_awal += $p['harga'] * $qty;
        }
    }
}

foreach ($biaya_tambahan as $biaya) {
    $qty = $biaya['qty'];
    foreach ($bahan as $p) {
        if ($biaya['id_bahan'] == $p['id_bahan']) {
            $harga_awal += $p['harga'] * $qty;
        }
    }
}

$harga_awal += $transaksi['pajak'];
$harga_diskon = ($transaksi['diskon'] / 100) * $harga_awal;
$total_biaya = ceil($harga_awal - $harga_diskon);
?>
<div class="card shadow">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
    </div>
    <form method="post" name="detail" action="<?= base_url('ubah-transaksi') ?>">
        <input type="hidden" name="id_transaksi" value="<?= $transaksi['id_transaksi'] ?>">
        <div class="card-body">
            <?php if (session('validation_ubah' . $transaksi['id_transaksi'])) : ?>
                <div class="alert alert-danger">
                    <?php foreach (session('validation_ubah' . $transaksi['id_transaksi'])->getErrors() as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <div class="row">
                <div class="col">
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="kode_invoice">Kode Invoice</label>
                            <input type="text" class="form-control" id="kode_invoice" name="kode_invoice" value="<?= $transaksi['kode_invoice'] ?>" disabled>
                        </div>
                        <div class="col">
                            <label for="id_member">Pelanggan</label>
                            <select class="form-control border-secondary border" data-live-search="true" name="id_member">
                                <?php foreach ($member as $m) { ?>
                                    <option value="<?= $m['id_member'] ?>" <?= $transaksi['id_member'] == $m['id_member'] ? 'selected' : null ?>><?= $m['nama_member'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="status">Status</label>
                            <select class="form-control border-secondary border" data-live-search="true" name="status">
                                <option value="baru" <?= $transaksi['status'] == 'baru' ? 'selected' : null ?>>baru</option>
                                <option value="proses" <?= $transaksi['status'] == 'proses' ? 'selected' : null ?>>proses</option>
                                <option value="selesai" <?= $transaksi['status'] == 'selesai' ? 'selected' : null ?>>selesai</option>
                                <option value="diambil" <?= $transaksi['status'] == 'diambil' ? 'selected' : null ?>>diambil</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="id_user">Pengguna</label>
                            <select class="form-control border-secondary border" data-live-search="true" name="id_user">
                                <?php foreach ($pengguna as $u) { ?>
                                    <option value="<?= $u['id_user'] ?>" <?= $transaksi['id_user'] == $u['id_user'] ? 'selected' : null ?>><?= $u['nama_user'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="tgl">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tgl" name="tgl" value="<?= $transaksi['tgl'] ?>">
                        </div>
                        <div class="col">
                            <label for="tgl_bayar">Tanggal Bayar</label>
                            <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="pajak">Pajak</label>
                            <input type="number" class="form-control" id="pajak" name="pajak" value="<?= $transaksi['pajak'] ?>" onfocus="startCalc();" autocomplete="off" onblur="stopCalc();" required>
                        </div>
                        <div class="col">
                            <label for="diskon">Diskon</label>
                            <input type="number" class="form-control" id="diskon" name="diskon" value="<?= $transaksi['diskon'] ?>" onfocus="startCalc();" autocomplete="off" onblur="stopCalc();">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="id_paket">Tambah Paket</label>
                            <select class="form-control border-secondary border" data-live-search="true" id="id_paket" name="id_paket" onChange="document.location.href=this.options[this.selectedIndex].value;">
                                <option value="" disabled selected>-- Pilih Paket --</option>
                                <?php foreach ($paket as $p) { ?>
                                    <option class="d-flex justify-content-between" value="tambah-paket-transaksi/<?= $p['id_paket'] . "/" . $transaksi['id_transaksi'] ?>"><?= $p['nama_paket'] ?> | Rp. <?= $p['harga'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-8">
                            <label for="id_paket">Paket</label>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama Paket</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($detail as $data) {
                                            foreach ($paket as $p) {
                                                if ($data['id_paket'] == $p['id_paket']) {
                                        ?>
                                                    <tr>
                                                        <td class="text-center"><?= $p['nama_paket'] ?></td>
                                                        <td class="text-center">Rp. <?= number_format($p['harga'], 0, ",", ".") ?></td>
                                                        <td class="text-center"><?= $data['qty'] ?></td>
                                                        <td class="text-center">
                                                            <a href="hapus-paket-transaksi/<?= $data['id_detail_transaksi'] . '/' . $transaksi['id_transaksi'] . '/' . $data['id_paket'] ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                        <?php }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="id_bahan">Tambah Bahan Cucian</label>
                            <select class="form-control border-secondary border" data-live-search="true" id="id_bahan" name="id_bahan" onChange="document.location.href=this.options[this.selectedIndex].value;">
                                <option value="" disabled selected>-- Pilih Bahan --</option>
                                <?php foreach ($bahan as $p) { ?>
                                    <option class="d-flex justify-content-between" value="tambah-bahan-transaksi/<?= $p['id_bahan'] . "/" . $transaksi['id_transaksi'] ?>" <?= $p['stok'] == 0 ? 'disabled' : '' ?>><?= $p['nama_bahan'] ?> | Rp. <?= $p['harga'] ?> <?= $p['stok'] == 0 ? '| Stok Habis' : '' ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-8">
                            <label for="id_paket">Bahan Cucian</label>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama Bahan</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($biaya_tambahan as $data) {
                                            foreach ($bahan as $p) {
                                                if ($data['id_bahan'] == $p['id_bahan']) {
                                        ?>
                                                    <tr>
                                                        <td class="text-center"><?= $p['nama_bahan'] ?></td>
                                                        <td class="text-center">Rp. <?= number_format($p['harga'], 0, ",", ".") ?></td>
                                                        <td class="text-center"><?= $data['qty'] ?></td>
                                                        <td class="text-center">
                                                            <a href="hapus-bahan-transaksi/<?= $data['id_biaya'] . '/' . $transaksi['id_transaksi'] . '/' . $data['id_bahan'] ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                        <?php }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-auto">
                    <div class="row d-flex align-items-center">
                        <div class="col-auto">
                            <h3 for="total_biaya" class="fw-bold">Total Biaya</h3>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control fw-bold form-control-lg" id="total_biaya" name="total_biaya" value="Rp. <?= number_format($total_biaya, 0, ",", ".") ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg text-right mt-1">
                    <a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali </a>
                    <a href="nota?id=<?= $transaksi['id_transaksi']; ?>" target="blank" class="btn btn-danger"><i class="fas fa-print"></i> Print Nota </a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>