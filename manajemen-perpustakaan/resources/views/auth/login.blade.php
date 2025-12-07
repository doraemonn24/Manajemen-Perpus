<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Taman Buku Ajaib</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%);
            min-height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 380px;
            background: white;
            border-radius: 20px;
            border: 1px solid #fbcfe8;
            box-shadow: 0 10px 30px rgba(236, 72, 153, 0.1);
        }
        .form-control-login {
            border: 1px solid #fbcfe8;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 15px;
        }
        .form-control-login:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 0.2rem rgba(236, 72, 153, 0.15);
        }
        .btn-login {
            background: linear-gradient(45deg, #ec4899, #a855f7);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(236, 72, 153, 0.25);
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100 px-3">

    <div class="login-card p-4 p-md-5">
        
        <!-- Logo -->
        <div class="text-center mb-4">
            <div class="d-inline-block p-3 rounded-circle mb-3" 
                 style="background: linear-gradient(135deg, #ec4899, #a855f7);">
                <div class="p-2 rounded-circle" 
                     style="background: linear-gradient(135deg, #f472b6, #c084fc);">
                    <svg fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24" 
                         style="width: 28px; height: 28px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 
                            9.246 5 7.5 5S4.168 5.477 3 6.253v13
                            C4.168 18.477 5.754 18 7.5 18s3.332.477
                            4.5 1.253m0-13C13.168 5.477 14.754 5 
                            16.5 5c1.746 0 3.332.477 4.5 1.253v13
                            C19.832 18.477 18.246 18 16.5 18
                            c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <h4 class="fw-bold mb-1" style="color: #3730a3;">Selamat Datang</h4>
            <p class="text-muted small mb-4">Login ke Taman Buku Ajaib</p>
        </div>

        <form method="POST" action="/login">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="mb-3">
                <input type="email" name="email" class="form-control form-control-login" 
                       placeholder="Email" required>
            </div>

            <div class="mb-4">
                <input type="password" name="password" class="form-control form-control-login" 
                       placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-login w-100 text-white fw-semibold mb-4">
                Masuk
            </button>

            @if($errors->any())
                <div class="alert alert-light border border-pink-200 text-pink-600 text-center small py-2 mb-3" 
                     style="background: rgba(251, 207, 232, 0.2); border-radius: 10px;">
                    Email atau password salah
                </div>
            @endif
        </form>

        <p class="text-center small text-muted mt-3 mb-0">
            Belum punya akun?
            <a href="/register" class="fw-bold" style="color: #ec4899; text-decoration: none;">
                Daftar di sini
            </a>
        </p>

    </div>

</div>

</body>
</html>