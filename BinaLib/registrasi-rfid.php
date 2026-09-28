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

    <title>BinaLib - Registrasi RFID</title>

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

        .rfid-register-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
        }

        .scan-panel {
            padding: 26px;
        }

        .scan-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;

            background: #EAF6EE;
            color: #0B6B3A;

            display: grid;
            place-items: center;

            margin-bottom: 18px;
        }

        .scan-icon .material-symbols-outlined {
            font-size: 30px;
        }

        .scan-panel h2 {
            margin: 0 0 8px;
        }

        .scan-panel p {
            margin: 0 0 20px;

            color: #66776e;

            line-height: 1.65;
            font-size: 13px;
        }

        .rfid-input-row {
            display: flex;
            gap: 10px;
        }

        .rfid-input-row .input {
            height: 50px;
        }

        .scan-note {
            margin-top: 12px;

            font-size: 12px;
            color: #66776e;
        }

        .result-card {
            padding: 22px;
        }

        .result-card.hidden {
            display: none;
        }

        .result-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 14px;
            margin-bottom: 18px;
        }

        .result-head h3 {
            margin: 0;
            font-size: 17px;
        }

        .member-id {
            font-weight: 800;
            color: #0B6B3A;

            background: #EAF6EE;

            padding:
                7px
                10px;

            border-radius: 9px;

            font-size: 12px;
        }

        .detail-list {
            display: grid;
            gap: 12px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;

            gap: 20px;

            border-bottom:
                1px solid
                #E5EEE9;

            padding-bottom: 11px;

            font-size: 13px;
        }

        .detail-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .detail-item span {
            color: #708078;
        }

        .detail-item strong {
            text-align: right;
            color: #183126;
        }

        .form-card {
            padding: 26px;
        }

        .form-card h2 {
            margin: 0 0 7px;
        }

        .form-card .lead {
            margin: 0 0 22px;

            color: #66776e;

            font-size: 13px;
        }

        .status-message {
            margin-top: 16px;

            padding:
                12px
                14px;

            border-radius: 10px;

            font-size: 12px;

            display: none;
        }

        .status-message.info {
            display: block;

            background: #EFF7F2;
            color: #24553A;

            border:
                1px solid
                #D8E9DE;
        }

        .status-message.warn {
            display: block;

            background: #FFF8E7;
            color: #7A5A10;

            border:
                1px solid
                #F0E0AF;
        }

        .status-message.success {
            display: block;

            background: #EAF6EE;
            color: #17643A;

            border:
                1px solid
                #CFE8D8;
        }

        .readonly {
            background: #F4F7F5 !important;
            color: #53665d !important;
        }

        .form-actions {
            margin-top: 20px;
        }

        @media (max-width: 900px) {

            .rfid-register-grid {
                grid-template-columns: 1fr;
            }

            .rfid-input-row {
                flex-direction: column;
            }
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
                        class="active"
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
                            Keanggotaan Perpustakaan
                        </div>

                        <h1>
                            Registrasi RFID
                        </h1>

                        <p>
                            Daftarkan kartu RFID siswa ke database BinaLib.
                            Data siswa diisi manual karena BinaLib tidak
                            terhubung ke database siswa sekolah.
                        </p>

                    </div>

                </section>

                <section class="rfid-register-grid">

                    <div
                        class="card scan-panel full-width-registration"
                    >

                        <div class="scan-icon">

                            <span class="material-symbols-outlined">
                                contactless
                            </span>

                        </div>

                        <h2>
                            Scan Kartu RFID
                        </h2>

                        <p>
                            Tempelkan kartu RFID yang sudah dimiliki siswa
                            ke reader USB. UID kartu akan terbaca langsung
                            meskipun database BinaLib masih kosong.
                        </p>

                        <div class="rfid-input-row">

                            <input
                                class="input"
                                id="rfidInput"
                                inputmode="numeric"
                                autocomplete="off"
                                placeholder="Scan / masukkan UID RFID..."
                            >

                            <button
                                class="btn btn-primary"
                                id="checkBtn"
                                type="button"
                            >
                                Cek Kartu
                            </button>

                        </div>

                        <div class="scan-note">
                            Reader USB berfungsi seperti keyboard. Setelah
                            UID masuk, tekan Enter atau klik Cek Kartu.
                        </div>

                        <div
                            id="scanMessage"
                            class="status-message"
                        ></div>

                    </div>

                    <div
                        class="card result-card hidden full-width-registration"
                        id="existingCard"
                    >

                        <div class="result-head">

                            <h3>
                                Kartu Sudah Terdaftar
                            </h3>

                            <span
                                class="member-id"
                                id="existingMemberId"
                            >
                                LIB-00000
                            </span>

                        </div>

                        <div class="detail-list">

                            <div class="detail-item">
                                <span>Nama</span>
                                <strong id="existingName">-</strong>
                            </div>

                            <div class="detail-item">
                                <span>NIS</span>
                                <strong id="existingNis">-</strong>
                            </div>

                            <div class="detail-item">
                                <span>Kelas</span>
                                <strong id="existingClass">-</strong>
                            </div>

                            <div class="detail-item">
                                <span>RFID UID</span>
                                <strong id="existingRfid">-</strong>
                            </div>

                        </div>

                        <div
                            class="status-message success"
                            style="display:block;margin-top:18px"
                        >
                            Kartu sudah terhubung dengan data anggota
                            BinaLib. Tidak perlu registrasi ulang.
                        </div>

                    </div>

                </section>

                <section
                    class="card form-card full-width-registration"
                    id="registrationCard"
                    style="margin-top:22px;display:none"
                >

                    <h2>
                        Data Anggota Perpustakaan
                    </h2>

                    <p class="lead">
                        UID belum ditemukan di database BinaLib. Isi data
                        siswa secara manual untuk membuat anggota baru.
                    </p>

                    <form id="registrationForm">

                        <div class="form-grid">

                            <div class="field">

                                <label>
                                    ID Anggota
                                </label>

                                <input
                                    class="input readonly"
                                    id="libraryId"
                                    readonly
                                >

                            </div>

                            <div class="field">

                                <label>
                                    RFID UID
                                </label>

                                <input
                                    class="input readonly"
                                    id="rfidReadonly"
                                    readonly
                                >

                            </div>

                            <div class="field">

                                <label>
                                    NIS
                                </label>

                                <input
                                    class="input"
                                    id="nis"
                                    required
                                    placeholder="Masukkan NIS"
                                >

                            </div>

                            <div class="field">

                                <label>
                                    Kelas
                                </label>

                                <select
                                    class="input"
                                    id="class"
                                    required
                                >
                                    <option value="">
                                        Pilih kelas
                                    </option>

                                    <option>
                                        Kelas 10
                                    </option>

                                    <option>
                                        Kelas 11
                                    </option>

                                    <option>
                                        Kelas 12
                                    </option>

                                    <option>
                                        10 KU-Binar
                                    </option>

                                    <option>
                                        11 KU-Binar
                                    </option>

                                    <option>
                                        12 KU-Binar
                                    </option>
                                </select>

                            </div>

                            <div class="field full">

                                <label>
                                    Nama Siswa
                                </label>

                                <input
                                    class="input"
                                    id="name"
                                    required
                                    placeholder="Masukkan nama siswa"
                                >

                            </div>

                        </div>

                        <div class="form-actions">

                            <button
                                class="btn btn-primary"
                                type="submit"
                            >
                                Simpan Registrasi
                            </button>

                        </div>

                    </form>

                </section>

            </main>

        </div>

    </div>

    <script src="binalib.js"></script>

    <script>
        (() => {
            const rfid =
                document.getElementById(
                    'rfidInput'
                );

            const check =
                document.getElementById(
                    'checkBtn'
                );

            const existing =
                document.getElementById(
                    'existingCard'
                );

            const registration =
                document.getElementById(
                    'registrationCard'
                );

            const message =
                document.getElementById(
                    'scanMessage'
                );

            let currentUID = '';

            function nextLibraryId() {
                const students =
                    BinaLib.get('students');

                const max = students.reduce(
                    (m, s) => {
                        const x =
                            String(
                                s.libraryId || ''
                            ).match(
                                /^LIB-(\d+)$/i
                            );

                        return Math.max(
                            m,
                            x
                                ? Number(x[1])
                                : 0
                        );
                    },
                    0
                );

                return `LIB-${String(max + 1).padStart(5, '0')}`;
            }

            function resetCards() {
                existing.classList.add(
                    'hidden'
                );

                registration.style.display =
                    'none';

                message.className =
                    'status-message';

                message.textContent = '';
            }

            function checkRFID() {
                const uid =
                    String(
                        rfid.value || ''
                    ).trim();

                if (!uid) {
                    return BinaLib.saveToast(
                        'Masukkan atau scan UID RFID terlebih dahulu.'
                    );
                }

                currentUID = uid;

                const member =
                    BinaLib.findStudentRFID(
                        uid
                    );

                if (member) {
                    registration.style.display =
                        'none';

                    existing.classList.remove(
                        'hidden'
                    );

                    document.getElementById(
                        'existingMemberId'
                    ).textContent =
                        member.libraryId || '-';

                    document.getElementById(
                        'existingName'
                    ).textContent =
                        member.name || '-';

                    document.getElementById(
                        'existingNis'
                    ).textContent =
                        member.nis || '-';

                    document.getElementById(
                        'existingClass'
                    ).textContent =
                        member.class || '-';

                    document.getElementById(
                        'existingRfid'
                    ).textContent =
                        member.rfid || uid;

                    message.className =
                        'status-message info';

                    message.textContent =
                        'UID ditemukan di database BinaLib.';

                    return;
                }

                existing.classList.add(
                    'hidden'
                );

                registration.style.display =
                    'block';

                document.getElementById(
                    'libraryId'
                ).value =
                    nextLibraryId();

                document.getElementById(
                    'rfidReadonly'
                ).value =
                    uid;

                document.getElementById(
                    'nis'
                ).value = '';

                document.getElementById(
                    'name'
                ).value = '';

                document.getElementById(
                    'class'
                ).value = '';

                message.className =
                    'status-message warn';

                message.textContent =
                    'UID belum terdaftar. Silakan isi data siswa secara manual.';

                document.getElementById(
                    'nis'
                ).focus();
            }

            check.onclick = checkRFID;

            rfid.addEventListener(
                'keydown',
                e => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        checkRFID();
                    }
                }
            );

            document.getElementById(
                'registrationForm'
            ).addEventListener(
                'submit',
                e => {
                    e.preventDefault();

                    if (!currentUID) {
                        return;
                    }

                    const students =
                        BinaLib.get('students');

                    if (
                        BinaLib.findStudentRFID(
                            currentUID
                        )
                    ) {
                        return checkRFID();
                    }

                    const nis =
                        document.getElementById(
                            'nis'
                        ).value.trim();

                    const name =
                        document.getElementById(
                            'name'
                        ).value.trim();

                    const cls =
                        document.getElementById(
                            'class'
                        ).value;

                    if (
                        !nis ||
                        !name ||
                        !cls
                    ) {
                        return BinaLib.saveToast(
                            'Lengkapi data siswa terlebih dahulu.'
                        );
                    }

                    if (
                        students.some(
                            s =>
                                String(s.nis)
                                    .trim()
                                    .toLowerCase() ===
                                nis.toLowerCase()
                        )
                    ) {
                        return BinaLib.saveToast(
                            'NIS sudah terdaftar di BinaLib.'
                        );
                    }

                    students.push({
                        id: BinaLib.uid(
                            students
                        ),

                        libraryId:
                            document.getElementById(
                                'libraryId'
                            ).value,

                        nis,

                        name,

                        class: cls,

                        rfid: currentUID
                    });

                    BinaLib.set(
                        'students',
                        students
                    );

                    BinaLib.saveToast(
                        'Anggota berhasil didaftarkan ke database BinaLib.'
                    );

                    document.getElementById(
                        'registrationForm'
                    ).reset();

                    document.getElementById(
                        'rfidInput'
                    ).value = '';

                    resetCards();

                    currentUID = '';

                    rfid.focus();
                }
            );

            rfid.addEventListener(
                'input',
                () => {
                    if (
                        rfid.value.trim() !==
                        currentUID
                    ) {
                        resetCards();
                    }
                }
            );

            rfid.focus();
        })();
    </script>

</body>

</html>