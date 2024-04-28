<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?></title>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <div style="text-align:center">
        <h3>Laporan Data Transaksi</h3>
    </div>
    <table id="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kode Invoice</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Bayar</th>
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
                    $qty = $biaya['qty'];
                    foreach ($bahan as $p) {
                        if ($biaya['id_bahan'] == $p['id_bahan']) {
                            $harga_awal += $p['harga'] * $qty;
                        }
                    }
                }

                $harga_awal += $m['pajak'];
                $harga_diskon = ($m['diskon'] / 100) * $harga_awal;
                $total_biaya = ceil($harga_awal - $harga_diskon);
                $total[] = $total_biaya;
                $total_pendapat = array_sum($total);
            ?>
                <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $m['nama_member']; ?></td>
                    <td><?= $m['kode_invoice']; ?></td>
                    <td><?= $m['tgl']; ?></td>
                    <td><?= $m['tgl_bayar']; ?></td>
                    <td>Rp. <?= number_format($total_biaya, 0, ",", ".") ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="5">Total Pendapatan</td>
                <td>Rp. <?= number_format($total_pendapat); ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>