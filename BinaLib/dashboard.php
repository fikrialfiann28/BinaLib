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

    <title>BinaLib - Dashboard</title>

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
                        class="active"
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
                            Perpustakaan
                        </div>

                        <h1>Dashboard</h1>

                        <p>
                            Ringkasan aktivitas dan kondisi
                            perpustakaan BinaLib.
                        </p>
                    </div>

                </section>

                <section class="stats-grid">

                    <article class="stat-card">

                        <div>
                            <span>Total Siswa</span>
                            <strong id="statStudents">0</strong>
                            <small>data siswa terdaftar</small>
                        </div>

                        <span class="material-symbols-outlined stat-icon">
                            group
                        </span>

                    </article>

                    <article class="stat-card">

                        <div>
                            <span>Total Buku</span>
                            <strong id="statBooks">0</strong>
                            <small>seluruh eksemplar</small>
                        </div>

                        <span class="material-symbols-outlined stat-icon">
                            auto_stories
                        </span>

                    </article>

                    <article class="stat-card">

                        <div>
                            <span>Sedang Dipinjam</span>
                            <strong id="statActive">0</strong>
                            <small>eksemplar aktif</small>
                        </div>

                        <span class="material-symbols-outlined stat-icon">
                            menu_book
                        </span>

                    </article>

                </section>

                <section class="dashboard-grid two-col">

                    <section class="card">

                        <div class="section-title">

                            <div>
                                <div class="eyebrow">
                                    Aktivitas
                                </div>

                                <h2>Peminjaman Terbaru</h2>
                            </div>

                            <a
                                class="text-link"
                                href="riwayat.php"
                            >
                                Lihat semua
                            </a>

                        </div>

                        <div class="table-wrap">

                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Siswa</th>
                                        <th>Buku</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody id="recentRows"></tbody>

                            </table>

                        </div>

                    </section>

                    <section class="card collection-table">

                        <div class="section-title">

                            <div>
                                <div class="eyebrow">
                                    Koleksi
                                </div>

                                <h2>Koleksi Buku</h2>
                            </div>

                            <a
                                class="text-link"
                                href="data-buku.php"
                            >
                                Kelola buku
                            </a>

                        </div>

                        <div class="table-wrap">

                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Judul</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>

                                <tbody id="collectionRows"></tbody>

                            </table>

                        </div>

                    </section>

                </section>

                <section class="dashboard-grid two-col">

                    <section class="card">

                        <div class="section-title">

                            <div>
                                <div class="eyebrow">
                                    Peminjaman
                                </div>

                                <h2>Ringkasan Hari Ini</h2>
                            </div>

                        </div>

                        <div class="metric-row">
                            <span>Peminjaman hari ini</span>
                            <strong id="todayLoans">0</strong>
                        </div>

                        <div class="metric-row">
                            <span>Pengembalian hari ini</span>
                            <strong id="todayReturns">0</strong>
                        </div>

                        <div class="metric-row">
                            <span>Total peminjaman</span>
                            <strong id="totalBorrowings">0</strong>
                        </div>

                    </section>

                    <section class="card">

                        <div class="section-title">

                            <div>
                                <div class="eyebrow">
                                    Kelas
                                </div>

                                <h2>
                                    Sirkulasi Berdasarkan Kelas
                                </h2>
                            </div>

                        </div>

                        <div
                            id="classSummary"
                            class="simple-list"
                        ></div>

                    </section>

                </section>

            </main>

        </div>

    </div>

    <script src="binalib.js"></script>

    <script>
        (() => {
            const students = BinaLib.get('students');
            const books = BinaLib.get('books');
            const bor = BinaLib.get('borrowings');
            const today = BinaLib.todayISO();

            const qty = x =>
                Math.max(
                    1,
                    Number(x.quantity) || 1
                );

            const active = bor.filter(
                x => x.status === 'Dipinjam'
            );

            const totalCopies =
                books.reduce(
                    (n, b) =>
                        n + Number(b.stock || 0),
                    0
                ) +
                active.reduce(
                    (n, x) => n + qty(x),
                    0
                );

            document.getElementById(
                'statStudents'
            ).textContent = students.length;

            document.getElementById(
                'statBooks'
            ).textContent = totalCopies;

            document.getElementById(
                'statActive'
            ).textContent = active.reduce(
                (n, x) => n + qty(x),
                0
            );

            document.getElementById(
                'totalBorrowings'
            ).textContent = bor.length;

            document.getElementById(
                'todayLoans'
            ).textContent = bor
                .filter(
                    x => BinaLib.sameDay(x.borrowedAt)
                )
                .reduce(
                    (n, x) => n + qty(x),
                    0
                );

            document.getElementById(
                'todayReturns'
            ).textContent = bor
                .filter(
                    x => BinaLib.sameDay(x.returnedAt)
                )
                .reduce(
                    (n, x) => n + qty(x),
                    0
                );

            const recent = bor
                .slice()
                .sort(
                    (a, b) =>
                        String(b.borrowedAt)
                            .localeCompare(
                                String(a.borrowedAt)
                            )
                )
                .slice(0, 6);

            document.getElementById(
                'recentRows'
            ).innerHTML = recent.length
                ? recent
                    .map(x => {
                        const s = BinaLib.student(
                            x.studentId
                        );

                        const b = BinaLib.book(
                            x.bookId
                        );

                        return `
                            <tr>
                                <td>
                                    ${BinaLib.formatDate(
                                        x.borrowedAt
                                    )}
                                </td>

                                <td>
                                    <strong>
                                        ${BinaLib.escapeHtml(
                                            s?.name || '-'
                                        )}
                                    </strong>

                                    <small class="table-sub">
                                        ${BinaLib.escapeHtml(
                                            s?.class || ''
                                        )}
                                    </small>
                                </td>

                                <td>
                                    ${BinaLib.escapeHtml(
                                        b?.title || '-'
                                    )}

                                    <small class="table-sub">
                                        ${BinaLib.escapeHtml(
                                            b?.code || ''
                                        )}
                                    </small>
                                </td>

                                <td>
                                    ${qty(x)}
                                </td>

                                <td>
                                    <span
                                        class="badge ${
                                            x.status === 'Dipinjam'
                                                ? 'badge-green'
                                                : 'badge-gold'
                                        }"
                                    >
                                        ${x.status}
                                    </span>
                                </td>
                            </tr>
                        `;
                    })
                    .join('')
                : `
                    <tr>
                        <td
                            colspan="5"
                            class="empty"
                        >
                            Belum ada riwayat peminjaman.
                        </td>
                    </tr>
                `;

            const className = c =>
                String(c || '').trim();

            const rows = books
                .slice()
                .sort(
                    (a, b) =>
                        String(a.code).localeCompare(
                            String(b.code)
                        )
                );

            document.getElementById(
                'collectionRows'
            ).innerHTML = rows.length
                ? rows
                    .map(
                        b => `
                            <tr>
                                <td>
                                    <strong>
                                        ${BinaLib.escapeHtml(
                                            b.code
                                        )}
                                    </strong>
                                </td>

                                <td>
                                    ${BinaLib.escapeHtml(
                                        b.title
                                    )}

                                    <small class="table-sub">
                                        ${BinaLib.escapeHtml(
                                            b.author
                                        )}
                                    </small>
                                </td>

                                <td>
                                    <span
                                        class="badge ${
                                            b.stock
                                                ? 'badge-green'
                                                : 'badge-red'
                                        }"
                                    >
                                        ${b.stock} tersedia
                                    </span>
                                </td>
                            </tr>
                        `
                    )
                    .join('')
                : `
                    <tr>
                        <td
                            colspan="3"
                            class="empty"
                        >
                            Belum ada data buku.
                        </td>
                    </tr>
                `;

            const counts = {};

            students.forEach(s => {
                counts[s.class] =
                    (counts[s.class] || 0) + 1;
            });

            document.getElementById(
                'classSummary'
            ).innerHTML = Object.entries(counts)
                .map(([c, n]) => {
                    const activeClass = active
                        .filter(
                            x =>
                                className(
                                    x.className ||
                                    BinaLib.student(
                                        x.studentId
                                    )?.class
                                ) === className(c)
                        )
                        .reduce(
                            (a, x) => a + qty(x),
                            0
                        );

                    return `
                        <div class="simple-list-item">

                            <div>
                                <strong>
                                    ${BinaLib.escapeHtml(c)}
                                </strong>

                                <small>
                                    ${n} siswa terdaftar
                                </small>
                            </div>

                            <span class="badge badge-green">
                                ${activeClass} buku aktif
                            </span>

                        </div>
                    `;
                })
                .join('')
                || `
                    <div class="empty">
                        Belum ada data kelas.
                    </div>
                `;
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