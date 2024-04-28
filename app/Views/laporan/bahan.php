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
        <h3>Laporan Data Bahan Cucian</h3>
    </div>
    <table id="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Bahan</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($bahan as $m) {
            ?>
                <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $m['nama_bahan']; ?></td>
                    <td>Rp. <?= number_format($m['harga']); ?></td>
                    <td><?= $m['stok']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>