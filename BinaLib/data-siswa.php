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

    <title>BinaLib - Data Siswa</title>

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
                        class="active"
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

                        <h1>Data Siswa</h1>

                        <p>
                            Data siswa yang terdaftar di database
                            perpustakaan BinaLib.
                        </p>

                    </div>

                    <a
                        class="btn btn-primary"
                        href="registrasi-rfid.php"
                    >
                        + Registrasi RFID
                    </a>

                </section>

                <section class="card">

                    <div class="toolbar">

                        <input
                            class="input"
                            id="studentSearch"
                            placeholder="Cari ID anggota, nama, NIS, kelas, atau RFID..."
                        >

                        <button
                            class="btn btn-outline"
                            id="refreshStudents"
                        >
                            Refresh
                        </button>

                    </div>

                    <div class="table-wrap">

                        <table class="table">

                            <thead>
                                <tr>
                                    <th>ID Anggota</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>RFID UID</th>
                                    <th class="actions">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="studentRows"></tbody>

                        </table>

                    </div>

                </section>

                <div
                    class="modal-backdrop"
                    id="studentModal"
                >

                    <div class="modal">

                        <h2 id="studentModalTitle">
                            Tambah Siswa
                        </h2>

                        <p>
                            Masukkan identitas siswa dan UID kartu RFID.
                        </p>

                        <form id="studentForm">

                            <div class="form-grid">

                                <div class="field">

                                    <label>NIS</label>

                                    <input
                                        class="input"
                                        name="nis"
                                        required
                                    >

                                </div>

                                <div class="field">

                                    <label>Kelas</label>

                                    <select
                                        class="input"
                                        name="class"
                                        required
                                    >
                                        <option value="">
                                            Pilih kelas
                                        </option>

                                        <option value="Kelas 10">
                                            Kelas 10
                                        </option>

                                        <option value="Kelas 11">
                                            Kelas 11
                                        </option>

                                        <option value="Kelas 12">
                                            Kelas 12
                                        </option>

                                        <option value="10 KU-Binar">
                                            10 KU-Binar
                                        </option>

                                        <option value="11 KU-Binar">
                                            11 KU-Binar
                                        </option>

                                        <option value="12 KU-Binar">
                                            12 KU-Binar
                                        </option>
                                    </select>

                                </div>

                                <div class="field full">

                                    <label>Nama Siswa</label>

                                    <input
                                        class="input"
                                        name="name"
                                        required
                                    >

                                </div>

                                <div class="field full">

                                    <label>RFID UID</label>

                                    <input
                                        class="input"
                                        name="rfid"
                                        required
                                    >

                                </div>

                            </div>

                            <div class="modal-actions">

                                <button
                                    type="button"
                                    class="btn btn-outline"
                                    id="closeStudent"
                                >
                                    Batal
                                </button>

                                <button
                                    class="btn btn-primary"
                                >
                                    Simpan Siswa
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </main>

        </div>

    </div>

    <script src="binalib.js"></script>

    <script>
        (() => {
            const rows =
                document.getElementById('studentRows');

            const search =
                document.getElementById('studentSearch');

            const modal =
                document.getElementById('studentModal');

            const form =
                document.getElementById('studentForm');

            const title =
                document.getElementById(
                    'studentModalTitle'
                );

            let editId = 0;

            function render() {
                const q = search.value
                    .trim()
                    .toLowerCase();

                const students = BinaLib
                    .get('students')
                    .filter(
                        s =>
                            [
                                s.libraryId,
                                s.nis,
                                s.name,
                                s.class,
                                s.rfid
                            ].some(
                                v =>
                                    String(v)
                                        .toLowerCase()
                                        .includes(q)
                            )
                    );

                rows.innerHTML = students.length
                    ? students
                        .map(
                            s => `
                                <tr>

                                    <td>
                                        <strong>
                                            ${BinaLib.escapeHtml(
                                                s.libraryId || '-'
                                            )}
                                        </strong>
                                    </td>

                                    <td>
                                        ${BinaLib.escapeHtml(s.nis)}
                                    </td>

                                    <td>
                                        ${BinaLib.escapeHtml(s.name)}
                                    </td>

                                    <td>
                                        <span class="student-class-badge">
                                            ${BinaLib.escapeHtml(s.class)}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-green">
                                            ${BinaLib.escapeHtml(s.rfid)}
                                        </span>
                                    </td>

                                    <td class="actions">

                                        <button
                                            class="btn btn-outline"
                                            data-edit="${s.id}"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            class="btn btn-danger"
                                            data-delete="${s.id}"
                                        >
                                            Hapus
                                        </button>

                                    </td>

                                </tr>
                            `
                        )
                        .join('')
                    : `
                        <tr>
                            <td
                                colspan="6"
                                class="empty"
                            >
                                Data siswa tidak ditemukan.
                            </td>
                        </tr>
                    `;
            }

            function open(s) {
                editId = s?.id || 0;

                title.textContent = editId
                    ? 'Edit Siswa'
                    : 'Tambah Siswa';

                [
                    'nis',
                    'name',
                    'class',
                    'rfid'
                ].forEach(
                    k => {
                        form.elements[k].value =
                            s?.[k] ?? '';
                    }
                );

                modal.classList.add('open');

                form.elements.name.focus();
            }

            function close() {
                modal.classList.remove('open');

                form.reset();

                editId = 0;
            }

            document
                .getElementById('addStudent')
                ?.addEventListener(
                    'click',
                    () => open()
                );

            document.getElementById(
                'closeStudent'
            ).onclick = close;

            document.getElementById(
                'refreshStudents'
            ).onclick = render;

            search.oninput = render;

            rows.onclick = e => {
                const ed =
                    e.target.closest(
                        '[data-edit]'
                    );

                const del =
                    e.target.closest(
                        '[data-delete]'
                    );

                if (ed) {
                    open(
                        BinaLib.student(
                            Number(
                                ed.dataset.edit
                            )
                        )
                    );
                }

                if (del) {
                    const id =
                        Number(
                            del.dataset.delete
                        );

                    if (
                        BinaLib
                            .activeBorrowings(id)
                            .length
                    ) {
                        return BinaLib.saveToast(
                            'Siswa masih memiliki buku yang dipinjam.'
                        );
                    }

                    if (confirm('Hapus siswa ini?')) {
                        if (
                            BinaLib.remove(
                                'students',
                                id
                            )
                        ) {
                            render();

                            BinaLib.saveToast(
                                'Siswa dihapus.'
                            );
                        }
                    }
                }
            };

            form.onsubmit = e => {
                e.preventDefault();

                const f = new FormData(form);
                const students =
                    BinaLib.get('students');

                const nis = String(
                    f.get('nis')
                ).trim();

                const rfid = String(
                    f.get('rfid')
                ).trim();

                if (
                    students.some(
                        s =>
                            String(s.nis)
                                .toLowerCase() ===
                            nis.toLowerCase() &&
                            Number(s.id) !== editId
                    )
                ) {
                    return BinaLib.saveToast(
                        'NIS sudah digunakan.'
                    );
                }

                if (
                    students.some(
                        s =>
                            String(s.rfid)
                                .toLowerCase() ===
                            rfid.toLowerCase() &&
                            Number(s.id) !== editId
                    )
                ) {
                    return BinaLib.saveToast(
                        'RFID UID sudah terdaftar.'
                    );
                }

                const existing = editId
                    ? students.find(
                        s =>
                            Number(s.id) ===
                            editId
                    )
                    : null;

                const item = {
                    id:
                        editId ||
                        BinaLib.uid(students),

                    libraryId:
                        existing?.libraryId ||
                        `LIB-${String(
                            BinaLib.uid(students)
                        ).padStart(5, '0')}`,

                    nis,

                    name: String(
                        f.get('name')
                    ).trim(),

                    class: String(
                        f.get('class')
                    ).trim(),

                    rfid,

                    status:
                        existing?.status ||
                        'Aktif'
                };

                BinaLib.set(
                    'students',
                    editId
                        ? students.map(
                            s =>
                                Number(s.id) ===
                                editId
                                    ? item
                                    : s
                        )
                        : [
                            ...students,
                            item
                        ]
                );

                close();
                render();

                BinaLib.saveToast(
                    editId
                        ? 'Data siswa diperbarui.'
                        : 'Siswa berhasil ditambahkan.'
                );
            };

            modal.onclick = e => {
                if (e.target === modal) {
                    close();
                }
            };

            render();
        })();
    </script>

</body>

</html>