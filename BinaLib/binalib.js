(() => {
    const routes = {
        dashboard: 'dashboard.php',
        'data-siswa': 'data-siswa.php',
        'registrasi-rfid': 'registrasi-rfid.php',
        'data-buku': 'data-buku.php',
        'riwayat-peminjaman': 'riwayat.php',
        laporan: 'laporan.php',
        pengaturan: 'pengaturan.php'
    };

    const cache = {};

    const apiBase = location.pathname.includes('/user/')
        ? '../api.php'
        : 'api.php';

    function req(action, opt = {}) {
        const m = opt.method || 'GET';
        const p = new URLSearchParams();

        p.set('action', action);

        Object.entries(opt.query || {}).forEach(([k, v]) => {
            p.set(k, String(v));
        });

        const x = new XMLHttpRequest();

        x.open(
            m,
            apiBase + '?' + p.toString(),
            false
        );

        x.setRequestHeader(
            'Accept',
            'application/json'
        );

        if (m !== 'GET') {
            x.setRequestHeader(
                'Content-Type',
                'application/json;charset=UTF-8'
            );
        }

        x.send(
            m === 'GET'
                ? null
                : JSON.stringify(opt.body || {})
        );

        let r = {};

        try {
            r = JSON.parse(
                x.responseText || '{}'
            );
        } catch (_) {}

        if (
            x.status < 200 ||
            x.status >= 300 ||
            r.ok === false
        ) {
            throw new Error(
                r.message ||
                'Permintaan ke server gagal.'
            );
        }

        return r.data;
    }

    function read(k, f = []) {
        if (k in cache) {
            return cache[k];
        }

        try {
            const v = req('get', {
                query: {
                    key: k
                }
            });

            cache[k] = v;

            return v ?? f;
        } catch (e) {
            if (!e.message.includes('Akses admin')) {
                toast(e.message);
            }

            return f;
        }
    }

    function write(k, v) {
        try {
            req('save_key', {
                method: 'POST',
                body: {
                    key: k,
                    value: v
                }
            });

            cache[k] = v;

            return true;
        } catch (e) {
            toast(e.message);
            return false;
        }
    }

    function toast(m) {
        const t = document.createElement('div');

        t.textContent = m;
        t.className = 'binalib-toast';

        document.body.appendChild(t);

        setTimeout(
            () => t.remove(),
            2500
        );
    }

    function uid(a) {
        return a.length
            ? Math.max(
                ...a.map(
                    x => Number(x.id) || 0
                )
            ) + 1
            : 1;
    }

    function student(id) {
        return read('students', []).find(
            s => Number(s.id) === Number(id)
        );
    }

    function book(id) {
        return read('books', []).find(
            b => Number(b.id) === Number(id)
        );
    }

    function findStudentRFID(uid) {
        try {
            return req('find_rfid', {
                query: {
                    uid: String(uid || '').trim()
                }
            });
        } catch (e) {
            toast(e.message);
            return null;
        }
    }

    function activeBorrowings(id = null) {
        if (id != null) {
            try {
                return req('active_borrowings', {
                    query: {
                        student_id: id
                    }
                }) || [];
            } catch (e) {
                toast(e.message);
                return [];
            }
        }

        return read('borrowings', []).filter(
            x => x.status === 'Dipinjam'
        );
    }

    function todayISO() {
        const d = new Date();

        return new Date(
            d.getTime() -
            d.getTimezoneOffset() * 60000
        )
            .toISOString()
            .slice(0, 10);
    }

    function formatDate(v) {
        if (!v) {
            return '-';
        }

        const d = new Date(
            String(v).length === 10
                ? v + 'T00:00:00'
                : v
        );

        return isNaN(d)
            ? '-'
            : d.toLocaleDateString(
                'id-ID',
                {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                }
            );
    }

    function formatDateTime(v) {
        if (!v) {
            return '-';
        }

        const d = new Date(
            String(v).length === 10
                ? v + 'T00:00:00'
                : v
        );

        if (isNaN(d)) {
            return '-';
        }

        return (
            d.toLocaleDateString(
                'id-ID',
                {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                }
            ) +
            ' • ' +
            d.toLocaleTimeString(
                'id-ID',
                {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }
            )
        );
    }

    function sameDay(v) {
        if (!v) {
            return false;
        }

        const d = new Date(
            String(v).length === 10
                ? v + 'T00:00:00'
                : v
        );

        return (
            !isNaN(d) &&
            d.toLocaleDateString('en-CA') === todayISO()
        );
    }

    function esc(v) {
        return String(v ?? '').replace(
            /[&<>'"]/g,
            c => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            })[c]
        );
    }

    function settings() {
        const s = read('settings', {});

        return {
            maxPersonalCopies: Math.max(
                1,
                Number(s.maxPersonalCopies) || 1
            ),

            maxClassCopies: Math.max(
                1,
                Number(s.maxClassCopies) || 30
            ),

            libraryName: String(
                s.libraryName || 'BinaLib'
            ),

            adminName: String(
                s.adminName || 'Admin'
            )
        };
    }

    function setSettings(v) {
        const s = settings();

        const next = {
            maxPersonalCopies: Math.max(
                1,
                Number(
                    v.maxPersonalCopies ??
                    s.maxPersonalCopies
                ) || 1
            ),

            maxClassCopies: Math.max(
                1,
                Number(
                    v.maxClassCopies ??
                    s.maxClassCopies
                ) || 1
            ),

            libraryName: String(
                v.libraryName ?? s.libraryName
            ).trim() || 'BinaLib',

            adminName: String(
                v.adminName ?? s.adminName
            ).trim() || 'Admin'
        };

        const ok = write(
            'settings',
            next
        );

        if (ok) {
            applyIdentity(next);
        }

        return ok;
    }

    function applyIdentity(s = settings()) {
        const libraryName = String(
            s.libraryName || 'BinaLib'
        );

        const adminName = String(
            s.adminName || 'Admin'
        );

        document
            .querySelectorAll(
                '.brand strong,#libraryNameLabel,[data-library-name]'
            )
            .forEach(e => {
                e.textContent = libraryName;
            });

        document
            .querySelectorAll(
                '.userbox strong,.profile b,[data-admin-name]'
            )
            .forEach(e => {
                e.textContent = adminName;
            });

        document.title = document.title.replace(
            /BinaLib/g,
            libraryName
        );

        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT
        );

        const nodes = [];

        while (walker.nextNode()) {
            nodes.push(walker.currentNode);
        }

        nodes.forEach(n => {
            if (
                n.parentElement?.closest(
                    'script,style,noscript'
                )
            ) {
                return;
            }

            if (
                n.nodeValue &&
                n.nodeValue.includes('BinaLib')
            ) {
                n.nodeValue = n.nodeValue.replaceAll(
                    'BinaLib',
                    libraryName
                );
            }
        });
    }

    function remove(k, id) {
        try {
            req('delete', {
                method: 'POST',
                body: {
                    key: k,
                    id
                }
            });

            delete cache[k];

            return true;
        } catch (e) {
            toast(e.message);
            return false;
        }
    }

    function createBorrowing(v) {
        try {
            const r = req(
                'create_borrowing',
                {
                    method: 'POST',
                    body: v
                }
            );

            delete cache.books;
            delete cache.borrowings;

            return r;
        } catch (e) {
            toast(e.message);
            return null;
        }
    }

    function passwordChange(v) {
        return req(
            'change_password',
            {
                method: 'POST',
                body: v
            }
        );
    }

    function returnBorrowings(v) {
        try {
            const r = req(
                'return_borrowings',
                {
                    method: 'POST',
                    body: v
                }
            );

            delete cache.books;
            delete cache.borrowings;

            return r;
        } catch (e) {
            toast(e.message);
            return null;
        }
    }

    document
        .querySelectorAll('[data-path]')
        .forEach(a => {
            const p = a.dataset.path;

            if (p === 'login') {
                a.href = 'index.php';

                a.addEventListener(
                    'click',
                    e => {
                        e.preventDefault();

                        try {
                            req('logout');
                        } catch (_) {}

                        location.replace(
                            'index.php'
                        );
                    }
                );
            } else if (routes[p]) {
                a.href = routes[p];
            }
        });

    applyIdentity();

    window.BinaLib = {
        get: read,
        set: write,
        remove,
        uid,
        student,
        book,
        findStudentRFID,
        activeBorrowings,
        todayISO,
        nowISO: () => new Date().toISOString(),
        formatDate,
        formatDateTime,
        sameDay,
        escapeHtml: esc,
        saveToast: toast,
        getSettings: settings,
        setSettings,
        applyIdentity,
        passwordChange,
        createBorrowing,
        returnBorrowings,

        refresh: k => {
            delete cache[k];

            return read(k);
        }
    };

    requestAnimationFrame(
        () => {
            document.documentElement.classList.add(
                'binalib-ready'
            );
        }
    );
})();