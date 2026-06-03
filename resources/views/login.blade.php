<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Ujian Online</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            /* Abu-abu muda */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        :root {
            --primary-green: #059669;
            --dark-green: #047857;
            --light-bg: #f9fafb;
            --border-color: #e5e7eb;
            --white: #ffffff;
            --text-muted: #6b7280;
        }

        /* Header */
        .header {
            background-color: var(--primary-green);
            color: var(--white);
            text-align: center;
            padding: 1.5rem 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-card {
            background-color: var(--white);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        /* Logo Area */
        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            overflow: hidden;
            background-color: var(--light-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid var(--border-color);
        }

        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Form */
        .login-form {
            text-align: left;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--light-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
            background-color: var(--white);
        }

        /* Button */
        .btn-login {
            display: block;
            width: 100%;
            padding: 0.875rem;
            background-color: var(--primary-green);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background-color: var(--dark-green);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(5, 150, 105, 0.2);
        }

        /* Footer */
        .footer {
            background-color: var(--primary-green);
            color: var(--white);
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="header">
        <h1>Sistem Ujian Online</h1>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="login-card">
            <div class="login-logo">
                <!-- Langsung menggunakan logo SMK yg sudah disimpan pengguna -->
                <img src="{{ asset('logo smk.png') }}" alt="Logo SMK">
            </div>

            <form class="login-form" method="POST" action="/login">
                @csrf

                @if ($errors->any())
                    <div
                        style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; text-align: center;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="email" class="form-control" placeholder="Masukkan Username"
                        required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login">Login Wok</button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 SMK Pariwisata Aisyiyah Sumbar</p>
    </footer>

</body>

</html>