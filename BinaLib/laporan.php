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

    <title>BinaLib - Laporan & Statistik</title>

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
                        class="active"
                        data-path="laporan"
                        href="laporan.php"
                    >
                        <span class="material-symbols-outlined">
                            analytics
                        </span>
                        Laporan
                    </a>

                    <a
                        class=""
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
                            Laporan
                        </div>

                        <h1>
                            Laporan & Statistik
                        </h1>

                        <p>
                            Ringkasan data perpustakaan berdasarkan
                            peminjaman yang tersimpan.
                        </p>

                    </div>

                </section>

                <section class="mini-stats">

                    <div class="mini-stat">
                        <span>Total siswa</span>
                        <strong id="repStudents">0</strong>
                    </div>

                    <div class="mini-stat">
                        <span>Judul buku</span>
                        <strong id="repBooks">0</strong>
                    </div>

                    <div class="mini-stat">
                        <span>Buku sedang dipinjam</span>
                        <strong id="repActive">0</strong>
                    </div>

                    <div class="mini-stat">
                        <span>Total peminjaman</span>
                        <strong id="repTrans">0</strong>
                    </div>

                </section>

                <section class="dashboard-grid two-col">

                    <section class="card">

                        <div class="section-title">

                            <div>

                                <div class="eyebrow">
                                    Koleksi
                                </div>

                                <h2>
                                    Buku Paling Sering Dipinjam
                                </h2>

                            </div>

                        </div>

                        <div
                            id="topBooks"
                            class="simple-list"
                        ></div>

                    </section>

                    <section class="card">

                        <div class="section-title">

                            <div>

                                <div class="eyebrow">
                                    Informasi
                                </div>

                                <h2>
                                    Ringkasan Sistem
                                </h2>

                            </div>

                        </div>

                        <div class="metric-row">
                            <span>Eksemplar tersedia</span>
                            <strong id="repAvailable">0</strong>
                        </div>

                        <div class="metric-row">
                            <span>Eksemplar sedang dipinjam</span>
                            <strong id="repBorrowed">0</strong>
                        </div>

                        <div class="metric-row">
                            <span>Kelas terdaftar</span>
                            <strong id="repClasses">0</strong>
                        </div>

                    </section>

                </section>

            </main>

        </div>

    </div>

    <script src="binalib.js"></script>

    <script>
        (() => {
            const books = BinaLib.get('books');
            const students = BinaLib.get('students');
            const bor = BinaLib.get('borrowings');

            const qty = x =>
                Math.max(
                    1,
                    Number(x.quantity) || 1
                );

            document.getElementById(
                'repStudents'
            ).textContent = students.length;

            document.getElementById(
                'repBooks'
            ).textContent = books.length;

            document.getElementById(
                'repActive'
            ).textContent = bor
                .filter(
                    x => x.status === 'Dipinjam'
                )
                .reduce(
                    (n, x) => n + qty(x),
                    0
                );

            document.getElementById(
                'repTrans'
            ).textContent = bor.length;

            document.getElementById(
                'repAvailable'
            ).textContent = books.reduce(
                (n, b) =>
                    n + Number(b.stock || 0),
                0
            );

            document.getElementById(
                'repBorrowed'
            ).textContent = bor
                .filter(
                    x => x.status === 'Dipinjam'
                )
                .reduce(
                    (n, x) => n + qty(x),
                    0
                );

            document.getElementById(
                'repClasses'
            ).textContent = new Set(
                students.map(
                    s => s.class
                )
            ).size;

            const counts = {};

            bor.forEach(x => {
                counts[x.bookId] =
                    (counts[x.bookId] || 0) +
                    qty(x);
            });

            document.getElementById(
                'topBooks'
            ).innerHTML = Object
                .entries(counts)
                .sort(
                    (a, b) => b[1] - a[1]
                )
                .map(
                    ([id, n], i) => `
                        <div class="simple-list-item">
                            <div>
                                <strong>
                                    ${i + 1}.
                                    ${BinaLib.escapeHtml(
                                        BinaLib.book(id)?.title || '-'
                                    )}
                                </strong>

                                <small>
                                    ${BinaLib.escapeHtml(
                                        BinaLib.book(id)?.author || ''
                                    )}
                                </small>
                            </div>

                            <span class="badge badge-green">
                                ${n}x
                            </span>
                        </div>
                    `
                )
                .join('') ||
                '<div class="empty">Belum ada riwayat peminjaman.</div>';
        })();
    </script>

    <script id="binalib-live-sync">
        window.addEventListener(
            "storage",
            () => location.reload()
        );
    </script>

</body>

</html>