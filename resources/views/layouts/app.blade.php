<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Ekskul SEC - SMKN 1 Purwokerto">
    <title>{{ $title ?? "Dashboard" }} &mdash; SEC SMKN1 PWT</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <style>
        :root {
            --primary: #1d4ed8;
            --primary-dark: #1e3a8a;
            --accent: #dc2626;
            --sidebar-bg: #0f172a;
            --sidebar-border: #1e293b;
            --card-bg: #1e293b;
            --body-bg: #0f172a;
            --text-primary: #f1f5f9;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: "Inter", sans-serif; background: var(--body-bg); color: var(--text-primary); min-height: 100vh; display: flex; }
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");

        /* SIDEBAR */
        .sidebar { width: 270px; height: 100vh; background: var(--sidebar-bg); border-right: 1px solid var(--sidebar-border); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 50; transition: transform 0.3s ease; overflow: hidden; }
        .sidebar-logo { padding: 1.25rem; border-bottom: 1px solid var(--sidebar-border); display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }
        .sidebar-logo img { width: 40px; height: 40px; object-fit: contain; border-radius: 50%; }
        .sidebar-logo .logo-text { display: flex; flex-direction: column; }
        .sidebar-logo .logo-name { font-size: 0.95rem; font-weight: 700; color: #f1f5f9; line-height: 1.2; }
        .sidebar-logo .logo-sub { font-size: 0.65rem; color: var(--text-muted); }

        .sidebar-nav { flex: 1; padding: 0.75rem 0; overflow-y: auto; overflow-x: hidden; scrollbar-width: thin; scrollbar-color: rgba(96,165,250,0.3) transparent; min-height: 0; }
        .sidebar-nav::-webkit-scrollbar { width: 5px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(96,165,250,0.5); }
        .nav-section { margin-bottom: 0.25rem; }
        .nav-section-title { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); padding: 0.5rem 1.25rem 0.3rem; }
        .nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.55rem 1.25rem; color: var(--text-muted); text-decoration: none; font-size: 0.85rem; font-weight: 500; border-radius: 0; transition: all 0.2s; border-left: 3px solid transparent; }
        .nav-link:hover { color: #f1f5f9; background: rgba(255,255,255,0.05); border-left-color: #3b82f6; }
        .nav-link.active { color: #60a5fa; background: rgba(59,130,246,0.15); border-left-color: #3b82f6; font-weight: 600; }
        .nav-link .icon { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-footer { padding: 1rem; border-top: 1px solid var(--sidebar-border); flex-shrink: 0; }
        .user-card { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem; background: rgba(255,255,255,0.05); border-radius: 10px; }
        .user-avatar { width: 34px; height: 34px; background: linear-gradient(135deg, #1d4ed8, #7c3aed); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; color: white; flex-shrink: 0; }
        .user-info .user-name { font-size: 0.8rem; font-weight: 600; color: #f1f5f9; }
        .user-info .user-role { font-size: 0.65rem; color: var(--text-muted); text-transform: capitalize; }

        /* MAIN CONTENT */
        .main-wrapper { margin-left: 270px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { height: 60px; background: rgba(15,23,42,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid var(--sidebar-border); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; position: sticky; top: 0; z-index: 40; gap: 1rem; }
        .topbar .page-title { font-size: 1rem; font-weight: 600; color: #f1f5f9; flex: 1; }
        .topbar .topbar-actions { display: flex; align-items: center; gap: 0.75rem; }
        .btn-logout { display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.875rem; background: rgba(220,38,38,0.15); border: 1px solid rgba(220,38,38,0.3); color: #f87171; border-radius: 8px; font-size: 0.8rem; font-weight: 500; text-decoration: none; cursor: pointer; transition: all 0.2s; }
        .btn-logout:hover { background: rgba(220,38,38,0.3); color: #fca5a5; }

        .page-content { flex: 1; padding: 2rem 2.5rem; max-width: 1600px; width: 100%; }

        /* CARDS */
        .card { background: var(--card-bg); border: 1px solid var(--sidebar-border); border-radius: 12px; padding: 1.5rem; }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
        .card-title { font-size: 1rem; font-weight: 600; color: #f1f5f9; }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 500; text-decoration: none; cursor: pointer; border: none; transition: all 0.2s; }
        .btn-primary { background: #1d4ed8; color: white; }
        .btn-primary:hover { background: #1e40af; }
        .btn-success { background: #059669; color: white; }
        .btn-success:hover { background: #047857; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-secondary { background: rgba(255,255,255,0.08); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); color: #f1f5f9; }
        .btn-sm { padding: 0.35rem 0.65rem; font-size: 0.75rem; }
        .btn-warning { background: #d97706; color: white; }
        .btn-warning:hover { background: #b45309; }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; }
        .badge-upcoming { background: rgba(59,130,246,0.2); color: #60a5fa; }
        .badge-ongoing { background: rgba(16,185,129,0.2); color: #34d399; }
        .badge-completed { background: rgba(100,116,139,0.2); color: #94a3b8; }
        .badge-lunas { background: rgba(16,185,129,0.2); color: #34d399; }
        .badge-belum { background: rgba(239,68,68,0.2); color: #f87171; }
        .badge-hadir { background: rgba(16,185,129,0.2); color: #34d399; }
        .badge-izin { background: rgba(245,158,11,0.2); color: #fbbf24; }
        .badge-alpa { background: rgba(239,68,68,0.2); color: #f87171; }

        /* ALERTS */
        .alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 0.75rem; }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399; }
        .alert-danger { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
        .alert-warning { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3); color: #fbbf24; }
        .alert-info { background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.3); color: #60a5fa; }

        /* TABLES */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: rgba(255,255,255,0.05); padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); border-bottom: 1px solid var(--sidebar-border); }
        tbody td { padding: 0.875rem 1rem; font-size: 0.875rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tbody tr:hover { background: rgba(255,255,255,0.03); }
        tbody tr:last-child td { border-bottom: none; }

        /* FORMS */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.8rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem; }
        .form-control { width: 100%; padding: 0.6rem 0.875rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #f1f5f9; font-size: 0.875rem; outline: none; transition: border-color 0.2s; }
        .form-control:focus { border-color: #3b82f6; background: rgba(59,130,246,0.08); }
        select.form-control option { background: #1e293b; color: #f1f5f9; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-error { color: #f87171; font-size: 0.75rem; margin-top: 0.25rem; }

        /* GRID STATS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card { background: var(--card-bg); border: 1px solid var(--sidebar-border); border-radius: 12px; padding: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .stat-card .stat-label { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; color: #f1f5f9; }
        .stat-card .stat-sub { font-size: 0.7rem; color: var(--text-muted); }
        .stat-card.blue { border-color: rgba(59,130,246,0.3); }
        .stat-card.blue .stat-value { color: #60a5fa; }
        .stat-card.green { border-color: rgba(16,185,129,0.3); }
        .stat-card.green .stat-value { color: #34d399; }
        .stat-card.red { border-color: rgba(239,68,68,0.3); }
        .stat-card.red .stat-value { color: #f87171; }
        .stat-card.purple { border-color: rgba(139,92,246,0.3); }
        .stat-card.purple .stat-value { color: #a78bfa; }
        .stat-card.amber { border-color: rgba(245,158,11,0.3); }
        .stat-card.amber .stat-value { color: #fbbf24; }

        /* BANNER */
        .banner-h1 { background: linear-gradient(135deg, rgba(220,38,38,0.2), rgba(239,68,68,0.05)); border: 1px solid rgba(220,38,38,0.4); border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; }
        .banner-h1 .banner-icon { font-size: 1.5rem; }
        .banner-h1 .banner-text .banner-title { font-weight: 700; color: #f87171; font-size: 1rem; }
        .banner-h1 .banner-text .banner-sub { font-size: 0.8rem; color: #fca5a5; margin-top: 0.25rem; }

        /* MOBILE TOGGLE */
        .menu-toggle { display: none; padding: 0.4rem; background: none; border: none; color: #94a3b8; cursor: pointer; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .menu-toggle { display: flex; align-items: center; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR OVERLAY (mobile) -->
<div id="sidebar-overlay" onclick="toggleSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:49;"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo-sec.jpg') }}" alt="Logo SEC">
        <div class="logo-text">
            <span class="logo-name">SEC SMKN 1</span>
            <span class="logo-sub">Purwokerto</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <!-- UMUM -->
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('struktur.index') }}" class="nav-link {{ request()->routeIs('struktur.index') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Struktur Pengurus
            </a>
        </div>

        <!-- DIVISI HUMAS -->
        <div class="nav-section">
            <div class="nav-section-title">Divisi Humas</div>
            <a href="{{ route('pengumuman.index') }}" class="nav-link {{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Papan Pengumuman
            </a>
            <a href="{{ route('kontak.index') }}" class="nav-link {{ request()->routeIs('kontak.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Kontak & Link Resmi
            </a>
        </div>

        <!-- DIVISI ACARA -->
        <div class="nav-section">
            <div class="nav-section-title">Divisi Acara</div>
            @can('jadwal.view')
            <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Kalender Acara
            </a>
            @endcan
            @can('proker.view')
            <a href="{{ route('proker.index') }}" class="nav-link {{ request()->routeIs('proker.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Timeline Proker
            </a>
            @endcan
        </div>

        <!-- DIVISI SEKRETARIS -->
        <div class="nav-section">
            <div class="nav-section-title">Divisi Sekretaris</div>
            @can('notulensi.view')
            <a href="{{ route('notulensi.index') }}" class="nav-link {{ request()->routeIs('notulensi.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Arsip Notulensi
            </a>
            @endcan
            @can('surat.view')
            <a href="{{ route('surat.index') }}" class="nav-link {{ request()->routeIs('surat.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Surat Masuk & Keluar
            </a>
            @endcan
            @can('presensi.view')
            <a href="{{ route('presensi.rekap') }}" class="nav-link {{ request()->routeIs('presensi.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Rekap Presensi
            </a>
            @endcan
        </div>

        <!-- DIVISI BENDAHARA -->
        <div class="nav-section">
            <div class="nav-section-title">Divisi Bendahara</div>
            @can('kas.catat')
            <a href="{{ route('kas.index') }}" class="nav-link {{ request()->routeIs('kas.index') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tracking Uang Kas
            </a>
            @endcan
            @can('kas.view')
            <a href="{{ route('kas.status-saya') }}" class="nav-link {{ request()->routeIs('kas.status-saya') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Status Kas Saya
            </a>
            @endcan
            @can('pengeluaran.view')
            <a href="{{ route('pengeluaran.index') }}" class="nav-link {{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                Buku Kas & Pengeluaran
            </a>
            @endcan
        </div>

        <!-- DIVISI PDD -->
        <div class="nav-section">
            <div class="nav-section-title">Divisi PDD</div>
            @can('drive.view')
            <a href="{{ route('drive.index') }}" class="nav-link {{ request()->routeIs('drive.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Arsip Drive & Pamflet
            </a>
            @endcan
        </div>

        <!-- DIVISI PERKAP -->
        <div class="nav-section">
            <div class="nav-section-title">Divisi Perkap</div>
            @can('inventaris.view')
            <a href="{{ route('inventaris.index') }}" class="nav-link {{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Inventaris & Peminjaman
            </a>
            @endcan
        </div>

        <!-- SUPERADMIN & KETUA / PENGATURAN -->
        @canany(['pengurus.manage', 'user.manage'])
        <div class="nav-section">
            <div class="nav-section-title">Superadmin & Pengurus</div>
            @can('pengurus.manage')
            <a href="{{ route('struktur.manage') }}" class="nav-link {{ request()->routeIs('struktur.manage*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Kelola Struktur Organisasi
            </a>
            @endcan
            @can('user.manage')
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Database Anggota & Akun
            </a>
            @endcan
        </div>
        @endcanany

        {{-- PENGATURAN --}}
        <div class="nav-section">
            <div class="nav-section-title">Akun</div>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan & Profil
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}" class="user-card" style="text-decoration:none; transition: background 0.2s; cursor:pointer;" title="Buka Pengaturan Profil">
            @if(auth()->user()->foto)
                <img src="{{ auth()->user()->fotoUrl() }}" alt="{{ auth()->user()->name }}" class="user-avatar" style="object-fit:cover; border:1px solid #3b82f6;">
            @else
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            @endif
            <div class="user-info" style="flex:1; min-width:0;">
                <div class="user-name" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->kelas ?: (auth()->user()->getRoleNames()->first() ?? 'anggota') }}</div>
            </div>
            <svg width="14" height="14" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</aside>

<!-- MAIN -->
<div class="main-wrapper">
    <header class="topbar">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <span class="page-title">{{ $title ?? "Dashboard" }}</span>
        <div class="topbar-actions">
            <a href="{{ route('profile.edit') }}" title="Profil Anda" style="display:flex; align-items:center; gap:0.5rem; text-decoration:none;">
                @if(auth()->user()->foto)
                    <img src="{{ auth()->user()->fotoUrl() }}" alt="{{ auth()->user()->name }}" style="width:34px; height:34px; object-fit:cover; border-radius:50%; border:2px solid #3b82f6;">
                @else
                    <div style="width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg, #1d4ed8, #7c3aed); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:0.85rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="page-content">
        {{-- Flash Messages --}}
        @if(session("success"))
        <div class="alert alert-success">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session("success") }}
        </div>
        @endif
        @if(session("error"))
        <div class="alert alert-danger">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session("error") }}
        </div>
        @endif

        {{ $slot }}
    </main>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebar-overlay");
    sidebar.classList.toggle("open");
    overlay.style.display = sidebar.classList.contains("open") ? "block" : "none";
}

// Simpan & kembalikan posisi scroll sidebar agar tidak reset ke atas
(function() {
    const nav = document.querySelector('.sidebar-nav');
    if (nav) {
        const savedScroll = sessionStorage.getItem('sidebar_scroll_pos');
        if (savedScroll !== null) {
            nav.scrollTop = parseInt(savedScroll, 10);
        }
        nav.addEventListener('scroll', function() {
            sessionStorage.setItem('sidebar_scroll_pos', nav.scrollTop);
        });
        document.querySelectorAll('.sidebar-nav a').forEach(function(link) {
            link.addEventListener('click', function() {
                sessionStorage.setItem('sidebar_scroll_pos', nav.scrollTop);
            });
        });
    }
})();
</script>
</body>
</html>