<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
    <link href="<?= base_url('css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link rel="icon" href="<?= base_url('img/wlee.png') ?>">
</head>

<body class="text-dark">
    <div class="d-flex align-items-center mb-1 mt-4 text-decoration-none justify-content-center">
        <div class="icon h1 mr-2">
            <i class="fas fa-tint"></i>
        </div>
        <h3 class="h2 font-weight-bold">TEKKOM Laundry</h3>
    </div>
    <div class="mb-4 text-center">
        Jl. Siliwangi KM. 15, Manggahang, Kec.Baleendah, Bandung Jawa Barat 40375
    </div>
    <div class="container">
        <?php
        $no = 1;
        $harga_awal = 0;
        $tambahan = 0;
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
                    $tambahan += $p['harga'] * $qty;
                }
            }
        }

        $harga_awal += $transaksi['pajak'];
        $harga_diskon = ($transaksi['diskon'] / 100) * $harga_awal;
        $total_biaya = ceil($harga_awal - $harga_diskon);
        ?>
        <div class="d-flex justify-content-between align-items-end mb-3">
            <table>
                <tr>
                    <td>Kode Invoice</td>
                    <td class="px-3">:</td>
                    <td><?= $transaksi['kode_invoice'] ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td class="px-3">:</td>
                    <td><?= $transaksi['nama_member'] ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>Tanggal Nota</td>
                    <td class="px-3">:</td>
                    <td><?= $transaksi['tgl_bayar'] . ' (' . date('H:i:s') . ')' ?></td>
                </tr>
            </table>
        </div>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Paket</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($detail as $data) :
                    foreach ($paket as $p) :
                        if ($data['id_paket'] == $p['id_paket']) : ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td class="text-left"><?= $p['nama_paket'] ?></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp.</span>
                                        <label><?= number_format($p['harga']) ?></label>
                                    </div>
                                </td>
                                <td><?= $data['qty'] ?></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp.</span>
                                        <label><?= number_format($data['qty'] * $p['harga']) ?></label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endforeach ?>
                <tr>
                    <th colspan="4" class="text-right">Biaya Tambahan</th>
                    <td class="text-right">Rp <?= number_format($tambahan) ?></td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Diskon</th>
                    <td class="text-right"><?= $transaksi['diskon'] ?>%</td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Total Bayar</th>
                    <th>
                        <div class="d-flex justify-content-between">
                            <span>Rp.</span>
                            <label><?= number_format($total_biaya) ?></label>
                        </div>
                    </th>
                </tr>
            </tbody>
        </table>
        <div class="mt-5 text-center">
            Tidak Ada Yang Tidak Bisa Kami Bershikan.<br>
            <span class="font-weight-bold">Terima Kasih.</span>
        </div>
    </div>
</body>
<script>
    window.print();
</script>

</html>