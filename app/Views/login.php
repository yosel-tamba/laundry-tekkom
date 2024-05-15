<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Masuk | TEKKOM Laundry</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" href="img/tint-white.png">
</head>

<body class="bg-gradient-primary">
    <div class="berhasil" data-flashdata="<?= session()->getFlashdata('berhasil'); ?>"></div>
    <div class="belumLogin" data-flashdata="<?= session()->getFlashdata('belumLogin'); ?>"></div>
    <div class="gagal" data-flashdata="<?= session()->getFlashdata('gagal'); ?>"></div>
    <div class="bukanAdmin" data-flashdata="<?= session()->getFlashdata('bukanAdmin'); ?>"></div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="d-flex text-primary align-items-center mb-4 text-decoration-none justify-content-center">
                                <div class="icon h1">
                                    <i class="fas fa-tint"></i>
                                </div>
                                <div class="text mx-3 h1">CleanBe<sup class="h5"></sup></div>
                            </div>
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                            </div>
                            <form class="user" method="post" action="/auth">
                                <div class="form-group">
                                    <label for="username" class="text-gray-900">Username</label>
                                    <input class="form-control" id="username" name="username" placeholder="Masukkan Username" autocomplete="off" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-gray-900">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" autocomplete="off">
                                </div>
                                <input type="submit" class="btn btn-primary btn-block" value="Masuk">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/sa2/sweetalert2.all.min.js"></script>
<script src="js/sa2/alert.js"></script>

</html>