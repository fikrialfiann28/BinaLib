<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width,initial-scale=1"
    >

    <title>BinaLib - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        rel="stylesheet"
        href="simple.css"
    >

    <style>
        html {
            visibility: hidden;
        }

        html.binalib-ready {
            visibility: visible;
        }
    </style>

    <style>
        :root {
            --login-green: #0B6B3A;
            --login-dark: #064E2C;
            --login-soft: #EAF6EE;
            --login-ink: #183126;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
            font-family:
                "Plus Jakarta Sans",
                system-ui,
                sans-serif;
        }

        body.binalib-login {
            background: #edf5f0 !important;
            overflow: hidden;
        }

        .login-page {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;

            background-image:
                linear-gradient(
                    90deg,
                    rgba(5, 45, 29, .18) 0%,
                    rgba(5, 45, 29, .05) 48%,
                    rgba(5, 45, 29, .02) 100%
                ),
                url('assets/login-bg-binar.png');

            background-size: 100% 100%;
            background-position: center;
            isolation: isolate;
        }

        .login-page::before {
            content: "";
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    180deg,
                    rgba(4, 38, 25, .03),
                    rgba(4, 38, 25, .08)
                );

            z-index: -1;
        }

        .login-top-brand {
            position: absolute;
            top: 7.2vh;
            left: 10.3vw;

            display: flex;
            align-items: center;
            gap: 15px;

            color: #fff;

            text-shadow:
                0 2px 12px rgba(0, 0, 0, .20);
        }

        .login-top-brand img {
            width: 76px;
            height: 76px;
            object-fit: contain;

            filter:
                drop-shadow(
                    0 2px 5px rgba(0, 0, 0, .16)
                );
        }

        .login-top-brand .brand-name {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .login-top-brand .brand-sub {
            font-size: 10px;
            letter-spacing: .24em;
            text-transform: uppercase;
            opacity: .95;
            margin-top: 3px;
        }

        .login-card-wrap {
            width: 510px;
            margin-left: 9.45vw;
            padding: 0;
        }

        .login-card {
            width: 100%;
            box-sizing: border-box;

            background: rgba(250, 253, 251, .90);

            border:
                1px solid
                rgba(255, 255, 255, .88);

            border-radius: 22px;

            padding:
                45px
                49px
                42px;

            box-shadow:
                0 22px 70px
                rgba(5, 45, 29, .20);

            backdrop-filter: blur(9px);
        }

        .login-title {
            font-size: 38px !important;
            color: var(--login-ink) !important;
            font-weight: 800 !important;
            letter-spacing: -.045em;
            margin: 0;
        }

        .login-desc {
            margin:
                9px
                0
                29px;

            color: #63756c;
            font-size: 14px;
            line-height: 1.65;
            max-width: 390px;
        }

        .login-field {
            position: relative;
            margin-bottom: 17px;
        }

        .login-field label {
            display: block;

            font-size: 13px;
            font-weight: 700;
            color: var(--login-ink);

            margin-bottom: 8px;
        }

        .login-field input {
            width: 100%;
            height: 55px;
            box-sizing: border-box;

            padding: 0 16px;

            border:
                1px solid
                #cbdad2;

            border-radius: 12px;

            background:
                rgba(255, 255, 255, .82);

            color: var(--login-ink);

            font:
                500 14px
                inherit;

            outline: none;

            transition: .18s;
        }

        .login-field input:focus {
            border-color: var(--login-green);

            box-shadow:
                0 0 0 4px
                rgba(11, 107, 58, .10);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            bottom: 15px;

            border: 0;
            background: transparent;

            color: #60736a;

            cursor: pointer;
            font-size: 12px;
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin:
                3px
                0
                23px;

            font-size: 12px;
            color: #66776e;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;

            cursor: pointer;
        }

        .remember input {
            accent-color: var(--login-green);

            width: 15px;
            height: 15px;
        }

        .login-submit {
            width: 100%;
            height: 55px;

            border: 0;
            border-radius: 12px;

            background: var(--login-green);
            color: #fff;

            font:
                700 14px
                inherit;

            cursor: pointer;

            transition: .18s;

            box-shadow:
                0 8px 20px
                rgba(11, 107, 58, .18);
        }

        .login-submit:hover {
            background: var(--login-dark);
            transform: translateY(-1px);
        }

        .login-error {
            display: none;

            margin:
                0
                0
                16px;

            padding:
                11px
                13px;

            border-radius: 10px;

            background: #fff0f0;
            color: #b42318;

            font-size: 12px;
            font-weight: 600;
        }

        .login-demo {
            margin-top: 18px;

            padding:
                12px
                14px;

            border-radius: 11px;

            background:
                rgba(242, 247, 244, .92);

            color: #66776e;

            font-size: 11px;

            border:
                1px solid
                #e1ebe5;
        }

        .login-demo b {
            color: var(--login-ink);
        }

        .login-footer {
            position: fixed;

            left: 5.4vw;
            bottom: 25px;

            color:
                rgba(255, 255, 255, .88);

            font-size: 11px;

            text-shadow:
                0 1px 8px
                rgba(0, 0, 0, .22);
        }

        @media (max-width: 900px) {

            .login-page {
                align-items: flex-end;

                background-size: cover;
                background-position: center;
            }

            .login-top-brand {
                top: 24px;
                left: 24px;
            }

            .login-top-brand img {
                width: 54px;
                height: 54px;
            }

            .login-top-brand .brand-name {
                font-size: 20px;
            }

            .login-top-brand .brand-sub {
                font-size: 9px;
            }

            .login-card-wrap {
                width: 100%;

                margin: 0;

                padding:
                    110px
                    18px
                    24px;

                box-sizing: border-box;
            }

            .login-card {
                padding:
                    30px
                    24px;

                border-radius: 20px;
            }

            .login-title {
                font-size: 30px !important;
            }

            .login-footer {
                display: none;
            }
        }
    </style>
</head>

<body class="binalib-login">

    <main class="login-page">

        <div class="login-top-brand">

            <img
                src="assets/logo-bina-rahayu.png"
                alt="Logo SMK Bina Rahayu"
            >

            <div>

                <div class="brand-name">
                    SMK Bina Rahayu
                </div>

                <div class="brand-sub">
                    Belajar • Berakhlak • Berhasil
                </div>

            </div>

        </div>

        <div class="login-card-wrap">

            <section
                class="login-card"
                aria-label="Form login BinaLib"
            >

                <h1 class="login-title">
                    Login
                </h1>

                <p class="login-desc">
                    Selamat datang kembali, silakan login
                    ke akun Anda untuk melanjutkan.
                </p>

                <form id="loginForm">

                    <div class="login-field">

                        <label for="username">
                            Username
                        </label>

                        <input
                            id="username"
                            autocomplete="username"
                            placeholder="Masukkan username"
                            required
                        >

                    </div>

                    <div class="login-field">

                        <label for="password">
                            Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >
                            Lihat
                        </button>

                    </div>

                    <div class="login-options">

                        <label class="remember">

                            <input
                                type="checkbox"
                                id="remember"
                            >

                            <span>
                                Remember me
                            </span>

                        </label>

                        <span>
                            BinaLib • Perpustakaan
                        </span>

                    </div>

                    <p
                        id="error"
                        class="login-error"
                    >
                        Username atau password salah.
                    </p>

                    <button
                        class="login-submit"
                        type="submit"
                    >
                        Login
                        <span aria-hidden="true">→</span>
                    </button>

                </form>

                <div class="login-demo">
                    <b>Akun dummy:</b>
                    admin / admin123
                </div>

            </section>

        </div>

        <div class="login-footer">
            BinaLib • Sistem Perpustakaan SMK Bina Rahayu
        </div>

    </main>

    <script>
        (async () => {
            try {
                const r = await fetch(
                    'api.php?action=me',
                    {
                        credentials: 'same-origin'
                    }
                ).then(
                    r => r.json()
                );

                if (
                    r.ok &&
                    r.data?.loggedIn
                ) {
                    location.replace(
                        'dashboard.php'
                    );
                }
            } catch (_) {}

            const f =
                document.getElementById(
                    'loginForm'
                );

            const e =
                document.getElementById(
                    'error'
                );

            const pw =
                document.getElementById(
                    'password'
                );

            const tg =
                document.getElementById(
                    'togglePassword'
                );

            tg.onclick = () => {
                const v =
                    pw.type === 'text';

                pw.type = v
                    ? 'password'
                    : 'text';

                tg.textContent = v
                    ? 'Lihat'
                    : 'Sembunyikan';
            };

            f.onsubmit = async ev => {
                ev.preventDefault();

                e.style.display = 'none';

                try {
                    const r = await fetch(
                        'api.php?action=login',
                        {
                            method: 'POST',

                            credentials:
                                'same-origin',

                            headers: {
                                'Content-Type':
                                    'application/json'
                            },

                            body: JSON.stringify({
                                username:
                                    document
                                        .getElementById(
                                            'username'
                                        )
                                        .value
                                        .trim(),

                                password:
                                    pw.value
                            })
                        }
                    );

                    const d = await r.json();

                    if (
                        !r.ok ||
                        !d.ok
                    ) {
                        throw new Error(
                            d.message ||
                            'Login gagal.'
                        );
                    }

                    location.replace(
                        'dashboard.php'
                    );
                } catch (x) {
                    e.textContent =
                        x.message ||
                        'Username atau password salah.';

                    e.style.display =
                        'block';
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
    </script>

</body>

</html>