CREATE DATABASE IF NOT EXISTS bls
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE bls;

-- ============================================
-- ADMIN
-- ============================================

CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL DEFAULT 'Admin',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================
-- SISWA
-- RFID digunakan untuk identifikasi siswa
-- ============================================

CREATE TABLE IF NOT EXISTS students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    library_id VARCHAR(20) NOT NULL UNIQUE,
    nis VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    class_name VARCHAR(100) NOT NULL,
    rfid_uid VARCHAR(100) NOT NULL UNIQUE,
    status ENUM('Aktif', 'Nonaktif')
        NOT NULL DEFAULT 'Aktif',

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_students_rfid (rfid_uid),
    INDEX idx_students_nis (nis),
    INDEX idx_students_status (status)
) ENGINE=InnoDB;


-- ============================================
-- BUKU
-- Tidak menggunakan RFID
-- ============================================

CREATE TABLE IF NOT EXISTS books (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(150) NOT NULL,

    publication_year SMALLINT UNSIGNED NULL,

    stock INT UNSIGNED NOT NULL DEFAULT 0,

    image_data LONGTEXT NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_books_code (code),
    INDEX idx_books_title (title)
) ENGINE=InnoDB;


-- ============================================
-- PEMINJAMAN
--
-- Satu record = satu judul buku yang dipinjam.
-- quantity digunakan untuk jumlah eksemplar.
--
-- Penggunaan Pribadi:
--   default maksimal 1
--
-- Kegunaan Kelas:
--   default maksimal 30
--
-- class_name hanya menyimpan kelas siswa
-- sebagai informasi transaksi, bukan sebagai
-- aturan/filter peminjaman.
-- ============================================

CREATE TABLE IF NOT EXISTS borrowings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    student_id INT UNSIGNED NULL,
    book_id INT UNSIGNED NULL,

    quantity INT UNSIGNED NOT NULL DEFAULT 1,

    loan_type ENUM(
        'Penggunaan Pribadi',
        'Kegunaan Kelas'
    ) NOT NULL DEFAULT 'Penggunaan Pribadi',

    class_name VARCHAR(100) NULL,

    borrowed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    returned_at DATETIME NULL,

    status ENUM(
        'Dipinjam',
        'Dikembalikan'
    ) NOT NULL DEFAULT 'Dipinjam',

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_borrowings_student_status (
        student_id,
        status
    ),

    INDEX idx_borrowings_book_status (
        book_id,
        status
    ),

    INDEX idx_borrowings_borrowed_at (
        borrowed_at
    ),

    CONSTRAINT fk_borrowings_student
        FOREIGN KEY (student_id)
        REFERENCES students(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_borrowings_book
        FOREIGN KEY (book_id)
        REFERENCES books(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE

) ENGINE=InnoDB;


-- ============================================
-- PENGATURAN SISTEM
-- ============================================

CREATE TABLE IF NOT EXISTS settings (
    id TINYINT UNSIGNED PRIMARY KEY,

    max_personal_copies INT UNSIGNED
        NOT NULL DEFAULT 1,

    max_class_copies INT UNSIGNED
        NOT NULL DEFAULT 30,

    library_name VARCHAR(100)
        NOT NULL DEFAULT 'BinaLib',

    admin_name VARCHAR(100)
        NOT NULL DEFAULT 'Admin',

    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);


-- ============================================
-- DEFAULT SETTINGS
-- ============================================

INSERT INTO settings (
    id,
    max_personal_copies,
    max_class_copies,
    library_name,
    admin_name
)
VALUES (
    1,
    1,
    30,
    'BinaLib',
    'Admin'
)
ON DUPLICATE KEY UPDATE
    id = id;


-- ============================================
-- DEFAULT ADMIN
--
-- Username : admin
-- Password : admin123
--
-- Password disimpan dalam bentuk hash.
-- Hash di bawah adalah hasil password_hash()
-- untuk password "admin123".
-- ============================================

INSERT INTO admins (
    username,
    password_hash,
    name
)
VALUES (
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCkE5dQ7z4rRzYQ5xC6W',
    'Admin'
)
ON DUPLICATE KEY UPDATE
    username = username;