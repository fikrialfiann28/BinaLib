<?php

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

function input(): array
{
    $x = json_decode(
        file_get_contents('php://input'),
        true
    );

    return is_array($x) ? $x : [];
}

function out($data, int $code = 200): never
{
    http_response_code($code);

    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    exit;
}

function ok($data = null): never
{
    out([
        'ok' => true,
        'data' => $data
    ]);
}

function fail(string $m, int $c = 400): never
{
    out([
        'ok' => false,
        'message' => $m
    ], $c);
}

function admin(): void
{
    if (empty($_SESSION['bls_admin_id'])) {
        fail('Akses admin diperlukan.', 401);
    }
}

function ms(array $r): array
{
    return [
        'id' => (int) $r['id'],
        'libraryId' => $r['library_id'],
        'nis' => $r['nis'],
        'name' => $r['name'],
        'class' => $r['class_name'],
        'rfid' => $r['rfid_uid'],
        'status' => $r['status']
    ];
}

function mb(array $r): array
{
    return [
        'id' => (int) $r['id'],
        'code' => $r['code'],
        'title' => $r['title'],
        'author' => $r['author'],
        'year' => $r['publication_year'] !== null
            ? (int) $r['publication_year']
            : null,
        'stock' => (int) $r['stock'],
        'imageData' => $r['image_data']
    ];
}

function mt(array $r): array
{
    return [
        'id' => (int) $r['id'],
        'studentId' => $r['student_id'] !== null
            ? (int) $r['student_id']
            : null,
        'bookId' => $r['book_id'] !== null
            ? (int) $r['book_id']
            : null,
        'quantity' => (int) $r['quantity'],
        'loanType' => $r['loan_type'],
        'className' => $r['class_name'],
        'borrowedAt' => $r['borrowed_at'],
        'returnedAt' => $r['returned_at'],
        'status' => $r['status']
    ];
}

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$in = input();

try {
    $pdo = db();

    switch ($action) {

        case 'login':
            if ($method !== 'POST') {
                fail('Method tidak valid.', 405);
            }

            $u = trim((string) ($in['username'] ?? ''));
            $p = (string) ($in['password'] ?? '');

            $q = $pdo->prepare(
                'SELECT * FROM admins WHERE username=? LIMIT 1'
            );

            $q->execute([$u]);
            $a = $q->fetch();

            if (!$a || !password_verify($p, $a['password_hash'])) {
                fail('Username atau password salah.', 401);
            }

            session_regenerate_id(true);

            $_SESSION['bls_admin_id'] = (int) $a['id'];
            $_SESSION['bls_admin_name'] = $a['name'];

            ok([
                'name' => $a['name']
            ]);

        case 'change_password':
            admin();

            if ($method !== 'POST') {
                fail('Method tidak valid.', 405);
            }

            $current = (string) ($in['currentPassword'] ?? '');
            $new = (string) ($in['newPassword'] ?? '');
            $confirm = (string) ($in['confirmPassword'] ?? '');

            if (
                $current === '' ||
                $new === '' ||
                $confirm === ''
            ) {
                fail('Semua kolom password wajib diisi.');
            }

            if (strlen($new) < 8) {
                fail('Password baru minimal 8 karakter.');
            }

            if ($new !== $confirm) {
                fail('Konfirmasi password tidak sama.');
            }

            $q = $pdo->prepare(
                'SELECT password_hash FROM admins WHERE id=? LIMIT 1'
            );

            $q->execute([
                (int) $_SESSION['bls_admin_id']
            ]);

            $a = $q->fetch();

            if (
                !$a ||
                !password_verify($current, $a['password_hash'])
            ) {
                fail('Password saat ini salah.', 401);
            }

            $hash = password_hash(
                $new,
                PASSWORD_DEFAULT
            );

            $q = $pdo->prepare(
                'UPDATE admins SET password_hash=? WHERE id=?'
            );

            $q->execute([
                $hash,
                (int) $_SESSION['bls_admin_id']
            ]);

            ok();

        case 'logout':
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $p = session_get_cookie_params();

                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $p['path'],
                    $p['domain'],
                    $p['secure'],
                    $p['httponly']
                );
            }

            session_destroy();

            ok();

        case 'me':
            ok([
                'loggedIn' => !empty($_SESSION['bls_admin_id']),
                'adminName' => $_SESSION['bls_admin_name'] ?? null
            ]);

        case 'get':
            $key = (string) ($_GET['key'] ?? '');

            if ($key === 'students') {
                admin();

                $rows = $pdo->query(
                    'SELECT * FROM students ORDER BY id'
                )->fetchAll();

                ok(array_map('ms', $rows));
            }

            if ($key === 'books') {
                $rows = $pdo->query(
                    'SELECT * FROM books ORDER BY code,id'
                )->fetchAll();

                ok(array_map('mb', $rows));
            }

            if ($key === 'borrowings') {
                admin();

                $rows = $pdo->query(
                    'SELECT * FROM borrowings '
                    . 'ORDER BY borrowed_at DESC,id DESC'
                )->fetchAll();

                ok(array_map('mt', $rows));
            }

            if ($key === 'settings') {
                $r = $pdo->query(
                    'SELECT * FROM settings WHERE id=1'
                )->fetch();

                ok([
                    'maxPersonalCopies' => (int) $r['max_personal_copies'],
                    'maxClassCopies' => (int) $r['max_class_copies'],
                    'libraryName' => $r['library_name'],
                    'adminName' => $r['admin_name']
                ]);
            }

            fail('Data tidak ditemukan.', 404);

        case 'find_rfid':
            $uid = trim((string) ($_GET['uid'] ?? ''));

            if (!$uid) {
                fail('UID RFID kosong.');
            }

            $q = $pdo->prepare(
                "SELECT * FROM students
                 WHERE UPPER(TRIM(rfid_uid))
                 = UPPER(TRIM(?))
                 AND status='Aktif'
                 LIMIT 1"
            );

            $q->execute([$uid]);
            $r = $q->fetch();

            ok($r ? ms($r) : null);

        case 'active_borrowings':
            $sid = (int) ($_GET['student_id'] ?? 0);

            if ($sid < 1) {
                fail('ID anggota tidak valid.');
            }

            $q = $pdo->prepare(
                "SELECT * FROM borrowings
                 WHERE student_id=?
                 AND status='Dipinjam'
                 ORDER BY borrowed_at DESC,id DESC"
            );

            $q->execute([$sid]);

            ok(array_map('mt', $q->fetchAll()));

        case 'save_key':
            admin();

            if ($method !== 'POST') {
                fail('Method tidak valid.', 405);
            }

            $key = (string) ($in['key'] ?? '');
            $v = $in['value'] ?? null;

            if ($key === 'students') {

                if (!is_array($v)) {
                    fail('Format data siswa tidak valid.');
                }

                $pdo->beginTransaction();

                $q = $pdo->prepare(
                    'INSERT INTO students('
                    . 'id,library_id,nis,name,class_name,rfid_uid,status'
                    . ') VALUES(?,?,?,?,?,?,?) '
                    . 'ON DUPLICATE KEY UPDATE '
                    . 'library_id=VALUES(library_id),'
                    . 'nis=VALUES(nis),'
                    . 'name=VALUES(name),'
                    . 'class_name=VALUES(class_name),'
                    . 'rfid_uid=VALUES(rfid_uid),'
                    . 'status=VALUES(status)'
                );

                foreach ($v as $s) {
                    $q->execute([
                        $s['id'] ?? null,
                        trim((string) ($s['libraryId'] ?? '')),
                        trim((string) ($s['nis'] ?? '')),
                        trim((string) ($s['name'] ?? '')),
                        trim((string) ($s['class'] ?? '')),
                        trim((string) ($s['rfid'] ?? '')),
                        (string) ($s['status'] ?? 'Aktif')
                    ]);
                }

                $pdo->commit();

                ok();
            }

            if ($key === 'books') {

                if (!is_array($v)) {
                    fail('Format data buku tidak valid.');
                }

                $pdo->beginTransaction();

                $q = $pdo->prepare(
                    'INSERT INTO books('
                    . 'id,code,title,author,publication_year,stock,image_data'
                    . ') VALUES(?,?,?,?,?,?,?) '
                    . 'ON DUPLICATE KEY UPDATE '
                    . 'code=VALUES(code),'
                    . 'title=VALUES(title),'
                    . 'author=VALUES(author),'
                    . 'publication_year=VALUES(publication_year),'
                    . 'stock=VALUES(stock),'
                    . 'image_data=VALUES(image_data)'
                );

                foreach ($v as $b) {
                    $q->execute([
                        $b['id'] ?? null,
                        trim((string) ($b['code'] ?? '')),
                        trim((string) ($b['title'] ?? '')),
                        trim((string) ($b['author'] ?? '')),
                        ($b['year'] ?? '') !== ''
                            ? (int) $b['year']
                            : null,
                        max(
                            0,
                            (int) ($b['stock'] ?? 0)
                        ),
                        $b['imageData'] ?? null
                    ]);
                }

                $pdo->commit();

                ok();
            }

            if ($key === 'settings') {

                if (!is_array($v)) {
                    fail('Format pengaturan tidak valid.');
                }

                $q = $pdo->prepare(
                    'UPDATE settings SET '
                    . 'max_personal_copies=?,'
                    . 'max_class_copies=?,'
                    . 'library_name=?,'
                    . 'admin_name=? '
                    . 'WHERE id=1'
                );

                $q->execute([
                    max(
                        1,
                        (int) ($v['maxPersonalCopies'] ?? 1)
                    ),
                    max(
                        1,
                        (int) ($v['maxClassCopies'] ?? 30)
                    ),
                    trim(
                        (string) ($v['libraryName'] ?? 'BinaLib')
                    ) ?: 'BinaLib',
                    trim(
                        (string) ($v['adminName'] ?? 'Admin')
                    ) ?: 'Admin'
                ]);

                $_SESSION['bls_admin_name'] =
                    trim(
                        (string) ($v['adminName'] ?? 'Admin')
                    ) ?: 'Admin';

                ok();
            }

            fail('Key tidak didukung.');

        case 'delete':
            admin();

            if ($method !== 'POST') {
                fail('Method tidak valid.', 405);
            }

            $key = (string) ($in['key'] ?? '');
            $id = (int) ($in['id'] ?? 0);

            if ($key === 'students') {

                $q = $pdo->prepare(
                    'SELECT COUNT(*) FROM borrowings '
                    . 'WHERE student_id=?'
                );

                $q->execute([$id]);

                if ((int) $q->fetchColumn() > 0) {
                    fail(
                        'Siswa memiliki riwayat peminjaman dan tidak '
                        . 'dapat dihapus. Nonaktifkan datanya jika '
                        . 'diperlukan.'
                    );
                }

                $q = $pdo->prepare(
                    'DELETE FROM students WHERE id=?'
                );

                $q->execute([$id]);

                ok();
            }

            if ($key === 'books') {

                $q = $pdo->prepare(
                    'SELECT COUNT(*) FROM borrowings '
                    . 'WHERE book_id=? AND status="Dipinjam"'
                );

                $q->execute([$id]);

                if ((int) $q->fetchColumn() > 0) {
                    fail(
                        'Buku masih dipinjam dan tidak dapat dihapus.'
                    );
                }

                $q = $pdo->prepare(
                    'DELETE FROM books WHERE id=?'
                );

                $q->execute([$id]);

                ok();
            }

            fail('Key delete tidak didukung.');

        case 'create_borrowing':
            if ($method !== 'POST') {
                fail('Method tidak valid.', 405);
            }

            $sid = (int) ($in['studentId'] ?? 0);
            $bid = (int) ($in['bookId'] ?? 0);
            $qty = max(
                1,
                (int) ($in['quantity'] ?? 1)
            );

            $type = ($in['loanType'] ?? '') === 'Kegunaan Kelas'
                ? 'Kegunaan Kelas'
                : 'Penggunaan Pribadi';

            $set = $pdo->query(
                'SELECT * FROM settings WHERE id=1'
            )->fetch();

            $max = $type === 'Kegunaan Kelas'
                ? (int) $set['max_class_copies']
                : (int) $set['max_personal_copies'];

            if ($qty > $max) {
                fail("Maksimal {$max} eksemplar.");
            }

            $pdo->beginTransaction();

            $q = $pdo->prepare(
                "SELECT * FROM students
                 WHERE id=?
                 AND status='Aktif'
                 FOR UPDATE"
            );

            $q->execute([$sid]);
            $s = $q->fetch();

            if (!$s) {
                $pdo->rollBack();
                fail(
                    'Anggota tidak ditemukan atau tidak aktif.'
                );
            }

            $q = $pdo->prepare(
                'SELECT * FROM books WHERE id=? FOR UPDATE'
            );

            $q->execute([$bid]);
            $b = $q->fetch();

            if (!$b) {
                $pdo->rollBack();
                fail('Buku tidak ditemukan.');
            }

            if ((int) $b['stock'] < $qty) {
                $pdo->rollBack();
                fail('Stok buku tidak mencukupi.');
            }

            $q = $pdo->prepare(
                'UPDATE books SET stock=stock-? WHERE id=?'
            );

            $q->execute([
                $qty,
                $bid
            ]);

            $q = $pdo->prepare(
                'INSERT INTO borrowings('
                . 'student_id,book_id,quantity,loan_type,'
                . 'class_name,borrowed_at,status'
                . ') VALUES(?,?,?,?,?,NOW(),"Dipinjam")'
            );

            $q->execute([
                $sid,
                $bid,
                $qty,
                $type,
                $s['class_name']
            ]);

            $id = (int) $pdo->lastInsertId();

            $pdo->commit();

            ok([
                'id' => $id
            ]);

        case 'return_borrowings':
            if ($method !== 'POST') {
                fail('Method tidak valid.', 405);
            }

            $sid = (int) ($in['studentId'] ?? 0);

            $ids = is_array($in['ids'] ?? null)
                ? array_values(
                    array_filter(
                        array_map(
                            'intval',
                            $in['ids']
                        )
                    )
                )
                : [];

            if ($sid < 1 || !$ids) {
                fail('Pilih minimal satu peminjaman.');
            }

            $pdo->beginTransaction();

            $ph = implode(
                ',',
                array_fill(
                    0,
                    count($ids),
                    '?'
                )
            );

            $q = $pdo->prepare(
                "SELECT * FROM borrowings
                 WHERE student_id=?
                 AND status='Dipinjam'
                 AND id IN($ph)
                 FOR UPDATE"
            );

            $q->execute(
                array_merge(
                    [$sid],
                    $ids
                )
            );

            $rows = $q->fetchAll();

            if (!$rows) {
                $pdo->rollBack();
                fail(
                    'Peminjaman aktif tidak ditemukan.'
                );
            }

            foreach ($rows as $r) {

                $q = $pdo->prepare(
                    'UPDATE borrowings SET '
                    . 'status="Dikembalikan",'
                    . 'returned_at=NOW() '
                    . 'WHERE id=?'
                );

                $q->execute([
                    $r['id']
                ]);

                if ($r['book_id'] !== null) {

                    $q = $pdo->prepare(
                        'UPDATE books SET stock=stock+? '
                        . 'WHERE id=?'
                    );

                    $q->execute([
                        (int) $r['quantity'],
                        (int) $r['book_id']
                    ]);
                }
            }

            $pdo->commit();

            ok([
                'count' => count($rows)
            ]);

        default:
            fail(
                'Action API tidak dikenali.',
                404
            );
    }

} catch (Throwable $e) {

    if (
        isset($pdo) &&
        $pdo->inTransaction()
    ) {
        $pdo->rollBack();
    }

    error_log($e->getMessage());

    fail(
        'Terjadi kesalahan server. Periksa konfigurasi database '
        . 'atau log PHP.',
        500
    );
}