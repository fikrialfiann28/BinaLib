<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BinaLib - Layanan Perpustakaan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../simple-v4.css">
    <link rel="stylesheet" href="user.css">

    <style>
        html {
            visibility: hidden;
        }

        html.binalib-ready {
            visibility: visible;
        }
    </style>
</head>

<body class="user-page">

    <header class="user-topbar">
        <div class="user-brand">
            <img
                src="../assets/logo-bina-rahayu.png"
                alt="Bina Rahayu"
            >

            <div>
                <strong id="libraryNameLabel">BinaLib</strong>
                <small>LAYANAN PERPUSTAKAAN</small>
            </div>
        </div>

        <div class="user-clock" id="clock"></div>
    </header>

    <main class="user-main">

        <section id="startScreen" class="start-screen">
            <div class="start-inner">

                <div class="eyebrow">
                    LAYANAN MANDIRI
                </div>

                <h1>
                    Pilih Layanan Perpustakaan
                </h1>

                <p>
                    Pilih layanan terlebih dahulu, kemudian tap kartu RFID
                    untuk mengidentifikasi anggota.
                </p>

                <div class="service-buttons">

                    <button
                        class="service-button"
                        data-mode="borrow"
                    >
                        <span class="service-icon">↗</span>

                        <strong>
                            Peminjaman
                        </strong>

                        <small>
                            Pinjam buku dari katalog perpustakaan
                        </small>
                    </button>

                    <button
                        class="service-button"
                        data-mode="return"
                    >
                        <span class="service-icon">↙</span>

                        <strong>
                            Pengembalian
                        </strong>

                        <small>
                            Kembalikan buku yang sedang dipinjam
                        </small>
                    </button>

                </div>
            </div>
        </section>

        <section id="serviceScreen" class="hidden">

            <section id="scanCard" class="card scan-card">

                <div class="scan-heading">

                    <div>
                        <div
                            class="eyebrow"
                            id="serviceEyebrow"
                        >
                            PEMINJAMAN
                        </div>

                        <h1>
                            Scan Kartu RFID
                        </h1>

                        <p class="muted">
                            Tap kartu RFID pada reader atau masukkan UID
                            secara manual.
                        </p>
                    </div>

                    <button
                        id="backBtn"
                        class="back-btn"
                        type="button"
                    >
                        Kembali
                    </button>

                </div>

                <div class="scan-row">

                    <input
                        id="rfidInput"
                        class="input"
                        autocomplete="off"
                        placeholder="Tap kartu atau masukkan UID RFID"
                    >

                    <button
                        id="scanBtn"
                        class="btn btn-primary"
                    >
                        Scan RFID
                    </button>

                </div>

                <div
                    id="rfidWarning"
                    class="notice warning hidden"
                ></div>

            </section>

            <section
                id="memberSection"
                class="hidden"
            >

                <section class="card member-card">

                    <div class="member-avatar">
                        B
                    </div>

                    <div class="member-data">

                        <div>
                            <small>NAMA</small>
                            <strong id="memberName">-</strong>
                        </div>

                        <div>
                            <small>NIS</small>
                            <strong id="memberNis">-</strong>
                        </div>

                        <div>
                            <small>KELAS</small>
                            <strong id="memberClass">-</strong>
                        </div>

                        <div>
                            <small>ID ANGGOTA</small>
                            <strong id="memberId">-</strong>
                        </div>

                    </div>

                </section>

                <section
                    id="borrowContent"
                    class="hidden"
                >

                    <section class="card catalog-section">

                        <div class="section-title catalog-head">

                            <div>
                                <div class="eyebrow">
                                    KATALOG BUKU
                                </div>

                                <h2>
                                    Pilih Buku
                                </h2>

                                <p class="muted">
                                    Pilih satu judul buku. Jumlah eksemplar
                                    diatur setelah buku dipilih.
                                </p>
                            </div>

                            <input
                                id="bookSearch"
                                class="input catalog-search"
                                placeholder="Cari judul, kode, atau penulis..."
                            >

                        </div>

                        <div class="loan-type-wrap">

                            <div>
                                <div class="eyebrow">
                                    JENIS PEMINJAMAN
                                </div>

                                <strong>
                                    Tentukan penggunaan buku
                                </strong>
                            </div>

                            <div class="loan-type-buttons">

                                <button
                                    class="loan-type active"
                                    data-loan-type="pribadi"
                                    type="button"
                                >
                                    Penggunaan Pribadi
                                    <span></span>
                                </button>

                                <button
                                    class="loan-type"
                                    data-loan-type="kelas"
                                    type="button"
                                >
                                    Kegunaan Kelas
                                    <span></span>
                                </button>

                            </div>

                        </div>

                        <div
                            id="catalog"
                            class="book-grid"
                        ></div>

                    </section>

                    <section class="card checkout-card">

                        <div class="section-title">

                            <div>
                                <div class="eyebrow">
                                    CHECKOUT PEMINJAMAN
                                </div>

                                <h2>
                                    Detail Peminjaman
                                </h2>
                            </div>

                        </div>

                        <div
                            id="borrowSummary"
                            class="summary-list"
                        >
                            <div class="empty">
                                Belum ada buku yang dipilih.
                            </div>
                        </div>

                        <div
                            id="quantityBox"
                            class="quantity-box hidden"
                        >

                            <div>
                                <small>
                                    JUMLAH EKSEMPLAR
                                </small>

                                <strong id="quantityLabel">
                                    1 / 1
                                </strong>
                            </div>

                            <div class="qty-control">

                                <button
                                    id="qtyMinus"
                                    type="button"
                                >
                                    −
                                </button>

                                <input
                                    id="quantityInput"
                                    type="number"
                                    min="1"
                                    value="1"
                                    inputmode="numeric"
                                    aria-label="Jumlah eksemplar"
                                >

                                <button
                                    id="qtyPlus"
                                    type="button"
                                >
                                    +
                                </button>

                            </div>

                        </div>

                        <div class="confirm-footer">

                            <div>
                                <span>
                                    Total eksemplar
                                </span>

                                <strong id="totalQty">
                                    0 / 1
                                </strong>
                            </div>

                            <button
                                id="confirmBorrow"
                                class="btn btn-primary"
                                disabled
                            >
                                Konfirmasi Peminjaman
                            </button>

                        </div>

                    </section>

                </section>

                <section
                    id="returnContent"
                    class="hidden"
                >

                    <section class="card return-card">

                        <div class="section-title">

                            <div>
                                <div class="eyebrow">
                                    DETAIL PEMINJAMAN
                                </div>

                                <h2>
                                    Buku yang Sedang Dipinjam
                                </h2>

                                <p class="muted">
                                    Data diambil langsung dari riwayat
                                    peminjaman BinaLib.
                                </p>
                            </div>

                        </div>

                        <div
                            id="returnList"
                            class="return-list"
                        >
                            <div class="empty">
                                Tidak ada buku yang sedang dipinjam.
                            </div>
                        </div>

                        <div class="return-footer">

                            <button
                                id="confirmReturn"
                                class="btn btn-primary"
                                disabled
                            >
                                Konfirmasi Pengembalian
                            </button>

                        </div>

                    </section>

                </section>

            </section>

        </section>

    </main>

    <script src="../binalib.js"></script>
    <script src="user.js"></script>

</body>

</html>