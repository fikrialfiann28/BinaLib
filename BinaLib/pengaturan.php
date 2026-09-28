<?php

require_once __DIR__ . "/includes/auth.php";

require_admin();

?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width,initial-scale=1"
    >

    <title>BinaLib - Pengaturan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="simple-v4.css"
    >

    <style>
        html {
            visibility: hidden;
        }

        html.binalib-ready {
            visibility: visible;
        }
    </style>
</head>

<body>

    <div class="shell">

        <aside class="sidebar">

            <div>

                <div class="brand">

                    <img
                        src="assets/logo-bina-rahayu.png"
                        alt="Logo Bina Rahayu"
                    >

                    <div>
                        <strong>BinaLib</strong>
                        <small>SMK BINA RAHAYU</small>
                    </div>

                </div>

                <div class="userbox">
                    <strong>Admin</strong>
                    <small>Pustakawan Admin</small>
                </div>

                <nav class="nav">

                    <a
                        class=""
                        data-path="dashboard"
                        href="dashboard.php"
                    >
                        <span class="material-symbols-outlined">
                            grid_view
                        </span>
                        Dashboard
                    </a>

                    <a
                        class=""
                        data-path="data-siswa"
                        href="data-siswa.php"
                    >
                        <span class="material-symbols-outlined">
                            group
                        </span>
                        Data Siswa
                    </a>

                    <a
                        class=""
                        data-path="registrasi-rfid"
                        href="registrasi-rfid.php"
                    >
                        <span class="material-symbols-outlined">
                            contactless
                        </span>
                        Registrasi RFID
                    </a>

                    <a
                        class=""
                        data-path="data-buku"
                        href="data-buku.php"
                    >
                        <span class="material-symbols-outlined">
                            auto_stories
                        </span>
                        Data Buku
                    </a>

                    <a
                        class=""
                        data-path="riwayat-peminjaman"
                        href="riwayat.php"
                    >
                        <span class="material-symbols-outlined">
                            receipt_long
                        </span>
                        Riwayat Peminjaman
                    </a>

                    <a
                        class=""
                        data-path="laporan"
                        href="laporan.php"
                    >
                        <span class="material-symbols-outlined">
                            analytics
                        </span>
                        Laporan
                    </a>

                    <a
                        class="active"
                        data-path="pengaturan"
                        href="pengaturan.php"
                    >
                        <span class="material-symbols-outlined">
                            settings
                        </span>
                        Pengaturan
                    </a>

                </nav>

            </div>

            <div class="sidebar-bottom">

                <div class="rfid-status">
                    <b>● RFID Terhubung</b>
                    <br>
                    <span>USB reader siap digunakan</span>
                </div>

                <a
                    class="nav logout"
                    data-path="login"
                    href="index.php"
                >
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    Keluar
                </a>

            </div>

        </aside>

        <div class="main">

            <header class="topbar">

                <input
                    class="search"
                    placeholder="Cari buku, siswa, atau peminjaman..."
                >

                <div class="profile">
                    <b>Admin</b>
                    <span>Pustakawan Admin</span>
                </div>

            </header>

            <main class="content">

                <section class="page-head">

                    <div>

                        <div class="eyebrow">
                            Sistem
                        </div>

                        <h1>
                            Pengaturan
                        </h1>

                        <p>
                            Kelola aturan peminjaman dan identitas dasar BinaLib.
                        </p>

                    </div>

                </section>

                <section class="card settings-card settings-card-wide">

                    <div class="section-title">

                        <div>

                            <div class="eyebrow">
                                Aturan Peminjaman
                            </div>

                            <h2>
                                Batas Peminjaman
                            </h2>

                            <p class="muted">
                                Batas ini otomatis digunakan oleh tampilan User
                                saat menentukan jumlah eksemplar.
                            </p>

                        </div>

                    </div>

                    <div class="form-grid settings-grid">

                        <div class="field">

                            <label>
                                Maksimal eksemplar penggunaan pribadi
                            </label>

                            <input
                                class="input"
                                id="maxPersonalCopies"
                                type="number"
                                min="1"
                            >

                        </div>

                        <div class="field">

                            <label>
                                Maksimal eksemplar kegunaan kelas
                            </label>

                            <input
                                class="input"
                                id="maxClassCopies"
                                type="number"
                                min="1"
                            >

                        </div>

                    </div>

                </section>

                <section class="card settings-card settings-card-wide">

                    <div class="section-title">

                        <div>

                            <div class="eyebrow">
                                Identitas Sistem
                            </div>

                            <h2>
                                Informasi BinaLib
                            </h2>

                            <p class="muted">
                                Nama ini dapat digunakan pada tampilan layanan
                                User dan identitas petugas.
                            </p>

                        </div>

                    </div>

                    <div class="form-grid settings-grid">

                        <div class="field">

                            <label>
                                Nama perpustakaan
                            </label>

                            <input
                                class="input"
                                id="libraryName"
                                type="text"
                            >

                        </div>

                        <div class="field">

                            <label>
                                Nama petugas/admin
                            </label>

                            <input
                                class="input"
                                id="adminName"
                                type="text"
                            >

                        </div>

                    </div>

                </section>

                <section class="card settings-card settings-card-wide">

                    <div class="section-title">

                        <div>

                            <div class="eyebrow">
                                Keamanan Admin
                            </div>

                            <h2>
                                Ganti Password Admin
                            </h2>

                            <p class="muted">
                                Gunakan menu ini untuk mengganti password akun
                                admin yang sedang login. Password minimal 8 karakter.
                            </p>

                        </div>

                    </div>

                    <div class="form-grid settings-grid">

                        <div class="field">

                            <label>
                                Password saat ini
                            </label>

                            <input
                                class="input"
                                id="currentPassword"
                                type="password"
                                autocomplete="current-password"
                                placeholder="Masukkan password saat ini"
                            >

                        </div>

                        <div class="field">

                            <label>
                                Password baru
                            </label>

                            <input
                                class="input"
                                id="newPassword"
                                type="password"
                                autocomplete="new-password"
                                placeholder="Minimal 8 karakter"
                            >

                        </div>

                        <div class="field">

                            <label>
                                Konfirmasi password baru
                            </label>

                            <input
                                class="input"
                                id="confirmPassword"
                                type="password"
                                autocomplete="new-password"
                                placeholder="Ulangi password baru"
                            >

                        </div>

                    </div>

                    <div class="form-actions">

                        <button
                            class="btn btn-outline"
                            id="changePassword"
                        >
                            Ganti Password
                        </button>

                    </div>

                </section>

                <section class="card settings-card settings-card-wide">

                    <div class="section-title">

                        <div>

                            <div class="eyebrow">
                                Informasi Sistem
                            </div>

                            <h2>
                                Ketentuan BinaLib
                            </h2>

                        </div>

                    </div>

                    <div class="notice">
                        BinaLib menggunakan RFID untuk identifikasi anggota.
                        Buku tidak menggunakan RFID. Sistem tidak menggunakan
                        jatuh tempo atau denda dan transaksi dicatat berdasarkan
                        waktu peminjaman/pengembalian.
                    </div>

                    <div class="form-actions">

                        <button
                            class="btn btn-primary"
                            id="saveSettings"
                        >
                            Simpan Semua Pengaturan
                        </button>

                    </div>

                </section>

            </main>

        </div>

    </div>

    <script src="binalib.js"></script>

    <script>
        (() => {
            const s = BinaLib.getSettings();

            const maxP =
                document.getElementById(
                    'maxPersonalCopies'
                );

            const maxC =
                document.getElementById(
                    'maxClassCopies'
                );

            const lib =
                document.getElementById(
                    'libraryName'
                );

            const admin =
                document.getElementById(
                    'adminName'
                );

            maxP.value = s.maxPersonalCopies;
            maxC.value = s.maxClassCopies;
            lib.value = s.libraryName;
            admin.value = s.adminName;

            document.getElementById(
                'saveSettings'
            ).onclick = () => {

                if (
                    Number(maxP.value) < 1 ||
                    Number(maxC.value) < 1
                ) {
                    return BinaLib.saveToast(
                        'Batas peminjaman harus lebih dari 0.'
                    );
                }

                if (
                    !lib.value.trim() ||
                    !admin.value.trim()
                ) {
                    return BinaLib.saveToast(
                        'Nama perpustakaan dan nama admin wajib diisi.'
                    );
                }

                if (
                    BinaLib.setSettings({
                        maxPersonalCopies:
                            maxP.value,

                        maxClassCopies:
                            maxC.value,

                        libraryName:
                            lib.value.trim(),

                        adminName:
                            admin.value.trim()
                    })
                ) {
                    BinaLib.saveToast(
                        'Semua pengaturan disimpan.'
                    );
                }
            };

            document.getElementById(
                'changePassword'
            ).onclick = () => {

                const currentPassword =
                    document.getElementById(
                        'currentPassword'
                    ).value;

                const newPassword =
                    document.getElementById(
                        'newPassword'
                    ).value;

                const confirmPassword =
                    document.getElementById(
                        'confirmPassword'
                    ).value;

                if (
                    !currentPassword ||
                    !newPassword ||
                    !confirmPassword
                ) {
                    return BinaLib.saveToast(
                        'Lengkapi semua kolom password.'
                    );
                }

                if (
                    newPassword.length < 8
                ) {
                    return BinaLib.saveToast(
                        'Password baru minimal 8 karakter.'
                    );
                }

                if (
                    newPassword !== confirmPassword
                ) {
                    return BinaLib.saveToast(
                        'Konfirmasi password tidak sama.'
                    );
                }

                try {
                    BinaLib.passwordChange({
                        currentPassword,
                        newPassword,
                        confirmPassword
                    });

                    document.getElementById(
                        'currentPassword'
                    ).value = '';

                    document.getElementById(
                        'newPassword'
                    ).value = '';

                    document.getElementById(
                        'confirmPassword'
                    ).value = '';

                    BinaLib.saveToast(
                        'Password admin berhasil diubah.'
                    );
                } catch (e) {
                    BinaLib.saveToast(
                        e.message
                    );
                }
            };
        })();
    </script>

</body>

</html>