<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="registrasi" data-flashdata="<?= session()->getFlashdata('registrasi'); ?>"></div>
<div class="gagal_simpan" data-flashdata="<?= session()->getFlashdata('gagal_simpan'); ?>"></div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Registrasi Pelanggan</h6>
    </div>
    <form method="post" action="<?= base_url('tambah-order') ?>">
        <div class="card-body container">
            <?php if (session('validation_tambah')) : ?>
                <div class="alert alert-danger">
                    <?php foreach (session('validation_tambah')->getErrors() as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <div class="mb-3 row">
                <div class="col">
                    <label for="nama_member">Nama</label>
                    <input type="text" class="form-control" id="nama_member" name="nama_member" autocomplete="off" value="<?= old('nama_member'); ?>">
                </div>
                <div class="col">
                    <label for="tlp">Nomor Telepon</label>
                    <input type="number" class="form-control" id="tlp" name="tlp" autocomplete="off" value="<?= old('tlp'); ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label for="alamat">Alamat</label>
                    <textarea type="text" class="form-control" id="alamat" name="alamat" autocomplete="off"><?= old('alamat'); ?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control border-secondary border" name="jenis_kelamin" data-live-search="true">
                        <option selected disabled value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-Laki" <?= old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : null ?>>Laki-Laki</option>
                        <option value="Perempuan" <?= old('jenis_kelamin') == 'Perempuan' ? 'selected' : null ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col">
                    <label for="id_user">Pengguna</label>
                    <select class="form-control border-secondary border" name="id_user" data-live-search="true">
                        <option disabled selected value="">Pilih Pengguna</option>
                        <?php foreach ($user as $u) { ?>
                            <option value="<?= $u['id_user'] ?>" <?= old('id_user') == $u['id_user'] ? 'selected' : null ?>><?= $u['nama_user'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col">
                    <label for="diskon">Diskon</label>
                    <input type="text" class="form-control" id="diskon" name="diskon" autocomplete="off" value="<?= old('diskon'); ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label class="col-form-label">Pilih Paket</label>
                    <div class="row align-content-center">
                        <div class="col table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Paket</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paket as $data) : ?>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" name="id_paket[]" value="<?= $data['id_paket'] ?>" id="<?= $data['id_paket'] ?>">
                                                    <label class="custom-control-label" for="<?= $data['id_paket'] ?>"><?= $data['nama_paket'] ?></label>
                                                </div>
                                            </td>
                                            <td>Rp. <?= number_format($data['harga']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label class="col-form-label">Pilih Bahan Cucian</label>
                    <div class="row align-content-center">
                        <div class="col table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Bahan</th>
                                        <th>harga</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bahan as $data) : ?>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" name="id_bahan[]" value="<?= $data['id_bahan'] ?>" id="<?= $data['id_bahan'] ?>" <?= $data['stok'] == 0 ? 'disabled' : '' ?>>
                                                    <label class="custom-control-label" for="<?= $data['id_bahan'] ?>"><?= $data['nama_bahan'] ?></label>
                                                </div>
                                            </td>
                                            <td>Rp <?= number_format($data['harga'], 0, ",", "."); ?></td>
                                            <td><?= $data['stok'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- hidden -->
            <input type="hidden" name="kode_invoice" value="<?= "INVC-" . (rand(100000000, 999999999)); ?>">
            <input type="hidden" name="tgl" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="status" value="baru">
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Data</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>