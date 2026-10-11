<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &mdash; SEC SMKN1 Purwokerto</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: "Inter", sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: #0f172a;
            background-image: radial-gradient(ellipse at 20% 50%, rgba(29,78,216,0.15) 0%, transparent 50%),
                              radial-gradient(ellipse at 80% 20%, rgba(220,38,38,0.1) 0%, transparent 50%); }
        .login-box { width: 100%; max-width: 400px; padding: 1rem; }
        .login-card { background: #1e293b; border: 1px solid #334155; border-radius: 20px; padding: 2rem; }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-logos { display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 1rem; }
        .login-logos img { width: 52px; height: 52px; object-fit: contain; border-radius: 50%; }
        .login-logos .divider { width: 1px; height: 40px; background: #334155; }
        .login-header h1 { font-size: 1.3rem; font-weight: 700; color: #f1f5f9; }
        .login-header p { font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: 0.8rem; font-weight: 500; color: #94a3b8; margin-bottom: 0.4rem; }
        input[type=email], input[type=password] { width: 100%; padding: 0.65rem 0.875rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; color: #f1f5f9; font-size: 0.875rem; outline: none; font-family: inherit; transition: border-color 0.2s; }
        input:focus { border-color: #3b82f6; background: rgba(59,130,246,0.08); }
        .btn-login { width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #1d4ed8, #2563eb); color: white; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; font-family: inherit; margin-top: 0.25rem; transition: opacity 0.2s; }
        .btn-login:hover { opacity: 0.9; }
        .error-msg { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #f87171; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.8rem; margin-bottom: 1rem; }
        .remember-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .remember-row label { display: flex; align-items: center; gap: 0.4rem; cursor: pointer; margin: 0; font-size: 0.8rem; color: #94a3b8; }
        .footer-note { text-align: center; margin-top: 1.5rem; font-size: 0.72rem; color: #475569; }
        .demo-accounts { margin-top: 1.25rem; padding: 0.875rem; background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); border-radius: 10px; }
        .demo-accounts h4 { font-size: 0.72rem; font-weight: 600; color: #60a5fa; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .demo-row { display: flex; justify-content: space-between; font-size: 0.72rem; color: #94a3b8; padding: 0.15rem 0; }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logos">
                <img src="/images/logo-sec.jpg" alt="SEC">
                <div class="divider"></div>
                <img src="/images/logo-smkn1.jpg" alt="SMKN1">
            </div>
            <h1>Selamat Datang di SEC</h1>
            <p>English Community · SMKN 1 Purwokerto</p>
        </div>

        @if($errors->any())
        <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@ekskul.test">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="••••••••">
            </div>
            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember" style="accent-color:#3b82f6;">
                    Ingat saya
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:0.8rem;color:#3b82f6;text-decoration:none;">Lupa password?</a>
                @endif
            </div>
            <button type="submit" class="btn-login">Masuk ke Sistem</button>
        </form>

        <div class="demo-accounts">
            <h4>🔑 Akun Login (Password: password)</h4>
            <div class="demo-row" style="color:#60a5fa;font-weight:600;"><span>⚡ Admin</span><span>admin@email.com</span></div>
            <div class="demo-row" style="color:#34d399;font-weight:600;"><span>👤 User</span><span>user@email.com</span></div>
            <div style="border-top:1px solid rgba(255,255,255,0.08);margin:0.35rem 0;"></div>
            <div class="demo-row"><span>👑 Ketua</span><span>ketua@ekskul.test</span></div>
            <div class="demo-row"><span>✍️ Sekretaris</span><span>sekretaris@ekskul.test</span></div>
            <div class="demo-row"><span>💰 Bendahara</span><span>bendahara@ekskul.test</span></div>
            <div class="demo-row"><span>👤 Anggota</span><span>anggota@ekskul.test</span></div>
            <div class="demo-row"><span>🎓 Pembina</span><span>pembina@ekskul.test</span></div>
        </div>

        <div class="footer-note">Sistem Manajemen Ekskul &copy; {{ date("Y") }}</div>
    </div>
</div>
</body>
</html>