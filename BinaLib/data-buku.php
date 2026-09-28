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

    <title>BinaLib - Data Buku</title>

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
                        class="active"
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

                        <h1>Data Buku</h1>

                        <p>
                            Kelola katalog, stok, dan gambar buku
                            yang akan tampil otomatis pada layanan User.
                        </p>

                    </div>

                    <button
                        class="btn btn-primary"
                        id="addBook"
                    >
                        + Tambah Buku
                    </button>

                </section>

                <section class="card">

                    <div class="toolbar">

                        <input
                            class="input"
                            id="bookSearch"
                            placeholder="Cari kode, judul, atau penulis..."
                        >

                        <button
                            class="btn btn-outline"
                            id="refreshBooks"
                        >
                            Refresh
                        </button>

                    </div>

                    <div class="table-wrap">

                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Kode</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Tahun</th>
                                    <th>Stok</th>
                                    <th class="actions">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="bookRows"></tbody>

                        </table>

                    </div>

                </section>

                <div
                    class="modal-backdrop"
                    id="bookModal"
                >

                    <div class="modal">

                        <h2 id="modalTitle">
                            Tambah Buku
                        </h2>

                        <p>
                            Data buku yang disimpan di sini otomatis
                            digunakan oleh tampilan User. Tidak diperlukan
                            database tambahan.
                        </p>

                        <form id="bookForm">

                            <div class="form-grid">

                                <div class="field">

                                    <label>Kode Buku</label>

                                    <input
                                        class="input"
                                        name="code"
                                        required
                                    >

                                </div>

                                <div class="field">

                                    <label>Tahun Terbit</label>

                                    <input
                                        class="input"
                                        name="year"
                                        type="number"
                                        min="1900"
                                        max="2100"
                                        required
                                    >

                                </div>

                                <div class="field full">

                                    <label>Judul Buku</label>

                                    <input
                                        class="input"
                                        name="title"
                                        required
                                    >

                                </div>

                                <div class="field">

                                    <label>Penulis</label>

                                    <input
                                        class="input"
                                        name="author"
                                        required
                                    >

                                </div>

                                <div class="field">

                                    <label>Stok</label>

                                    <input
                                        class="input"
                                        name="stock"
                                        type="number"
                                        min="0"
                                        required
                                    >

                                </div>

                                <div class="field full">

                                    <label>
                                        Gambar / Cover Buku
                                    </label>

                                    <input
                                        class="input"
                                        name="image"
                                        type="file"
                                        accept="image/*"
                                    >

                                    <small class="form-help">
                                        Opsional. Gambar akan disimpan
                                        di browser dan langsung muncul
                                        di katalog User.
                                    </small>

                                    <div
                                        id="imagePreview"
                                        style="margin-top:10px"
                                    ></div>

                                </div>

                            </div>

                            <div class="modal-actions">

                                <button
                                    type="button"
                                    class="btn btn-outline"
                                    id="closeBook"
                                >
                                    Batal
                                </button>

                                <button
                                    class="btn btn-primary"
                                >
                                    Simpan Buku
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
                document.getElementById('bookRows');

            const search =
                document.getElementById('bookSearch');

            const modal =
                document.getElementById('bookModal');

            const form =
                document.getElementById('bookForm');

            const title =
                document.getElementById('modalTitle');

            const preview =
                document.getElementById('imagePreview');

            let editId = 0;
            let imageData = '';

            function render() {
                const q = search.value
                    .trim()
                    .toLowerCase();

                const books = BinaLib
                    .get('books')
                    .filter(
                        b =>
                            [
                                b.code,
                                b.title,
                                b.author,
                                b.year
                            ].some(
                                v =>
                                    String(v)
                                        .toLowerCase()
                                        .includes(q)
                            )
                    );

                rows.innerHTML = books.length
                    ? books
                        .map(
                            b => `
                                <tr>

                                    <td>
                                        ${
                                            b.imageData
                                                ? `
                                                    <img
                                                        src="${BinaLib.escapeHtml(
                                                            b.imageData
                                                        )}"
                                                        style="width:42px;height:54px;object-fit:cover;border-radius:6px;border:1px solid #dde8e1"
                                                    >
                                                `
                                                : `
                                                    <span class="badge badge-green">
                                                        Default
                                                    </span>
                                                `
                                        }
                                    </td>

                                    <td>
                                        <strong>
                                            ${BinaLib.escapeHtml(b.code)}
                                        </strong>
                                    </td>

                                    <td>
                                        ${BinaLib.escapeHtml(b.title)}
                                    </td>

                                    <td>
                                        ${BinaLib.escapeHtml(b.author)}
                                    </td>

                                    <td>
                                        ${b.year}
                                    </td>

                                    <td>
                                        <span
                                            class="badge ${
                                                b.stock > 0
                                                    ? 'badge-green'
                                                    : 'badge-red'
                                            }"
                                        >
                                            ${b.stock} tersedia
                                        </span>
                                    </td>

                                    <td class="actions">

                                        <button
                                            class="btn btn-outline"
                                            data-edit="${b.id}"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            class="btn btn-danger"
                                            data-delete="${b.id}"
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
                                colspan="7"
                                class="empty"
                            >
                                Data buku tidak ditemukan.
                            </td>
                        </tr>
                    `;
            }

            function showPreview(src) {
                imageData = src || '';

                preview.innerHTML = imageData
                    ? `
                        <img
                            src="${BinaLib.escapeHtml(imageData)}"
                            style="width:70px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #dde8e1"
                        >
                    `
                    : `
                        <small class="form-help">
                            Belum ada gambar.
                        </small>
                    `;
            }

            function open(b) {
                editId = b?.id || 0;
                imageData = b?.imageData || '';

                title.textContent = editId
                    ? 'Edit Buku'
                    : 'Tambah Buku';

                [
                    'code',
                    'title',
                    'author',
                    'year',
                    'stock'
                ].forEach(
                    k => {
                        form.elements[k].value =
                            b?.[k] ?? '';
                    }
                );

                form.elements.image.value = '';

                showPreview(imageData);

                modal.classList.add('open');

                form.elements.title.focus();
            }

            function close() {
                modal.classList.remove('open');

                form.reset();

                editId = 0;
                imageData = '';

                showPreview('');
            }

            document.getElementById(
                'addBook'
            ).onclick = () => open();

            document.getElementById(
                'closeBook'
            ).onclick = close;

            document.getElementById(
                'refreshBooks'
            ).onclick = render;

            search.oninput = render;

            form.elements.image.onchange = () => {
                const file =
                    form.elements.image.files?.[0];

                if (!file) {
                    return;
                }

                const reader =
                    new FileReader();

                reader.onload = e => {
                    showPreview(
                        e.target.result
                    );
                };

                reader.readAsDataURL(file);
            };

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
                        BinaLib.book(
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
                            .activeBorrowings()
                            .some(
                                x =>
                                    Number(x.bookId) === id
                            )
                    ) {
                        return BinaLib.saveToast(
                            'Buku masih dipinjam dan tidak bisa dihapus.'
                        );
                    }

                    if (confirm('Hapus buku ini?')) {
                        if (
                            BinaLib.remove(
                                'books',
                                id
                            )
                        ) {
                            render();

                            BinaLib.saveToast(
                                'Buku dihapus.'
                            );
                        }
                    }
                }
            };

            form.onsubmit = e => {
                e.preventDefault();

                const f = new FormData(form);
                const books = BinaLib.get('books');

                const code = String(
                    f.get('code')
                ).trim();

                const stock = Math.max(
                    0,
                    Number(
                        f.get('stock')
                    ) || 0
                );

                if (
                    books.some(
                        b =>
                            String(b.code)
                                .toLowerCase() ===
                            code.toLowerCase() &&
                            Number(b.id) !== editId
                    )
                ) {
                    return BinaLib.saveToast(
                        'Kode buku sudah digunakan.'
                    );
                }

                const activeCount = editId
                    ? BinaLib
                        .activeBorrowings()
                        .filter(
                            x =>
                                Number(x.bookId) ===
                                editId
                        )
                        .reduce(
                            (n, x) =>
                                n +
                                Math.max(
                                    1,
                                    Number(x.quantity) || 1
                                ),
                            0
                        )
                    : 0;

                if (stock < activeCount) {
                    return BinaLib.saveToast(
                        `Stok tidak boleh kurang dari ${activeCount} buku yang sedang dipinjam.`
                    );
                }

                const item = {
                    id:
                        editId ||
                        BinaLib.uid(books),

                    code,

                    title: String(
                        f.get('title')
                    ).trim(),

                    author: String(
                        f.get('author')
                    ).trim(),

                    year: Number(
                        f.get('year')
                    ),

                    stock,

                    imageData
                };

                BinaLib.set(
                    'books',
                    editId
                        ? books.map(
                            b =>
                                Number(b.id) ===
                                editId
                                    ? {
                                        ...b,
                                        ...item
                                    }
                                    : b
                        )
                        : [
                            ...books,
                            item
                        ]
                );

                close();
                render();

                BinaLib.saveToast(
                    editId
                        ? 'Data buku diperbarui.'
                        : 'Buku berhasil ditambahkan.'
                );
            };

            modal.onclick = e => {
                if (e.target === modal) {
                    close();
                }
            };

            render();

            window.addEventListener(
                'storage',
                render
            );
        })();
    </script>

</body>

</html>