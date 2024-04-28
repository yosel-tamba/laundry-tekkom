const pelanggan = $(".pelanggan").data("flashdata");
const pengguna = $(".pengguna").data("flashdata");
const paket = $(".paket").data("flashdata");
const outlet = $(".outlet").data("flashdata");
const registrasi = $(".registrasi").data("flashdata");
const transaksi = $(".transaksi").data("flashdata");
const bahan = $(".bahan").data("flashdata");
const keluar = $(".keluar").data("flashdata");
const berhasil = $(".berhasil").data("flashdata");
const belumLogin = $(".belumLogin").data("flashdata");
const bukanAdmin = $(".bukanAdmin").data("flashdata");
const gagal = $(".gagal").data("flashdata");
const gagal_simpan = $(".gagal_simpan").data("flashdata");

if (pelanggan) {
  Swal.fire({
    icon: "success",
    title: "Data " + pelanggan,
    text: "Data Pelanggan Berhasil " + pelanggan + "!",
    showConfirmButton: false,
    timer: 2000,
  });
}

if (pengguna) {
  Swal.fire({
    icon: "success",
    title: "Data " + pengguna,
    text: "Data Pengguna Berhasil " + pengguna + "!",
    showConfirmButton: false,
    timer: 1500,
  });
}

if (paket) {
  Swal.fire({
    icon: "success",
    title: "Data " + paket,
    text: "Data Paket Berhasil " + paket + "!",
    showConfirmButton: false,
    timer: 1500,
  });
}

if (outlet) {
  Swal.fire({
    icon: "success",
    title: "Data " + outlet,
    text: "Data Outlet Berhasil " + outlet + "!",
    showConfirmButton: false,
    timer: 1500,
  });
}

if (transaksi) {
  Swal.fire({
    icon: "success",
    title: "Data " + transaksi,
    text: "Data Transaksi Berhasil " + transaksi + "!",
    showConfirmButton: false,
    timer: 1500,
  });
}

if (bahan) {
  Swal.fire({
    icon: "success",
    title: "Data " + bahan,
    text: "Data Bahan Cucian Berhasil " + bahan + "!",
    showConfirmButton: false,
    timer: 1500,
  });
}

if (registrasi) {
  Swal.fire({
    icon: "success",
    title: "Data " + registrasi,
    text: "Data Transaksi Berhasil " + registrasi + "!",
    footer: "Silahkan cek data di menu Transaksi!",
    timer: 3000,
  });
}

// tombol-hapus
$(".tombol-hapus").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    title: "Apakah anda yakin?",
    text: "Data akan Dihapus!",
    icon: "warning",
    showCancelButton: true,
    cancelButtonText: "Batal",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Hapus Data!",
  }).then((result) => {
    if (result.isConfirmed) {
      document.location.href = href;
    }
  });
});

// tombol-keluar
$(".tombol-keluar").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    title: "Apakah anda yakin?",
    text: "Ingin keluar dari aplikasi Wlee Laundry!",
    icon: "question",
    showCancelButton: true,
    cancelButtonText: "Batal",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Keluar",
  }).then((result) => {
    if (result.isConfirmed) {
      document.location.href = href;
    }
  });
});

// Login Logout
if (berhasil) {
  Swal.fire({
    icon: "success",
    title: berhasil + " keluar!",
    showConfirmButton: false,
    timer: 2000,
  });
}

if (gagal) {
  Swal.fire({
    icon: "error",
    title: gagal,
    text: "Username dan Password salah!",
    timer: 3000,
  });
}

if (belumLogin) {
  Swal.fire({
    icon: "warning",
    title: belumLogin,
    text: "Anda harus login terlebih dahulu!",
    timer: 2000,
  });
}

if (bukanAdmin) {
  Swal.fire({
    icon: "warning",
    title: bukanAdmin,
    text: "Anda harus login sebagai admin atau owner terlebih dahulu!",
    timer: 2000,
  });
}

if (gagal_simpan) {
  Swal.fire({
    icon: "error",
    title: "Coba Lagi",
    text: "Gagal Simpan Data " + gagal_simpan + "!",
  });
}
