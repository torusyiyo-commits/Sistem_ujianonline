<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Ujian Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #f0fdf4; color: #1f2937; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background-color: #059669; color: white; padding: 2rem 1rem; display: flex; flex-direction: column; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; text-align: center; }
        .nav-item { padding: 0.75rem 1rem; color: white; text-decoration: none; border-radius: 0.5rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem; transition: background-color 0.2s; }
        .nav-item:hover, .nav-item.active { background-color: #047857; }
        .main-content { flex: 1; padding: 2rem; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1rem 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .card { background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 1.5rem; }
        .btn { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; border: none; }
        .btn-primary { background-color: #10b981; color: white; }
        .btn-primary:hover { background-color: #059669; }
        .btn-danger { background-color: #ef4444; color: white; }
        .btn-danger:hover { background-color: #dc2626; }
        .btn-warning { background-color: #f59e0b; color: white; }
        .btn-warning:hover { background-color: #d97706; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f9fafb; font-weight: 600; }
        .form-group { margin-bottom: 1rem; }
        .form-control { width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; margin-top: 0.25rem; }
        .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; }
        .alert-success { background-color: #d1fae5; color: #065f46; }
        .alert-danger { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand"><i class="fas fa-user-shield"></i> Admin Panel</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Kelola Pengguna</a>
        <a href="{{ route('admin.roles.index') }}" class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"><i class="fas fa-key"></i> Hak Akses</a>
        <a href="{{ route('admin.ujian.index') }}" class="nav-item {{ request()->routeIs('admin.ujian.*') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> Data Ujian</a>
        <a href="{{ route('admin.hasil_ujian') }}" class="nav-item {{ request()->routeIs('admin.hasil_ujian') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Hasil Ujian</a>
        <a href="{{ route('admin.monitoring') }}" class="nav-item {{ request()->routeIs('admin.monitoring') ? 'active' : '' }}"><i class="fas fa-desktop"></i> Monitoring Siswa</a>
        <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fas fa-cog"></i> Pengaturan Sistem</a>
        
        <div style="margin-top: auto;">
            <a href="{{ route('logout') }}" class="nav-item" style="background-color: rgba(0, 0, 0, 0.15); border: 1px solid rgba(255,255,255,0.1);" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='rgba(0, 0, 0, 0.15)'" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">@csrf</form>
        </div>
    </aside>

    <main class="main-content">
        <header class="header">
            <h2 style="color: #065f46;">@yield('title', 'Dashboard')</h2>
            <div style="font-weight: 500;">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
