<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Permohonan Bantuan BERKAT')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF5722;
            --primary-dark: #E64A19;
            --primary-light: #FF9E64;
            --secondary-color: #1F1F1F;
            --accent-color: #FFC3AE;
            --danger-color: #E53935;
            --success-color: #4CAF50;
            --warning-color: #F59E0B;
            --info-color: #2563EB;
            --light-bg: #FFF7F3;
            --white: #FFFFFF;
            --text-dark: #171717;
            --text-muted: #6B7280;
            --border-light: #ECE7E4;
            --dark-card: #2C2C2C;
            --light-gray: #FCFBFA;
            --surface-soft: rgba(255, 255, 255, 0.78);
            --shadow-sm: 0 16px 40px rgba(23, 23, 23, 0.06);
            --shadow-md: 0 24px 60px rgba(23, 23, 23, 0.1);
            --shadow-lg: 0 32px 90px rgba(23, 23, 23, 0.14);
            --radius-lg: 26px;
            --radius-md: 18px;
            --radius-sm: 12px;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(255, 87, 34, 0.09), transparent 28%),
                radial-gradient(circle at top right, rgba(31, 31, 31, 0.05), transparent 24%),
                linear-gradient(180deg, #fffdfc 0%, var(--light-gray) 38%, #f7f4f2 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.01em;
            line-height: 1.65;
        }

        main {
            flex: 1;
            padding: 28px 0 56px;
        }

        p, li, input, select, textarea, button, .table {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Sora', sans-serif;
            letter-spacing: -0.03em;
        }

        a {
            text-decoration: none;
        }

        /* Navigation Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            box-shadow: 0 10px 40px rgba(23, 23, 23, 0.06);
            border-bottom: 1px solid rgba(23, 23, 23, 0.06);
            padding: 1.05rem 0;
        }

        .navbar-brand {
            font-size: 1.18rem;
            font-weight: 700;
            color: var(--secondary-color) !important;
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
        }

        .navbar-brand strong {
            color: var(--primary-color);
        }

        .navbar-brand .logo-img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            border-radius: 6px;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 600;
            font-size: 0.94rem;
            margin: 0 4px;
            padding: 0.7rem 0.95rem !important;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 999px;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(255, 87, 34, 0.08);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 14px;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
            border-radius: 999px;
        }

        .nav-link:hover::after {
            width: calc(100% - 28px);
        }

        /* Container Styling */
        .container, .container-fluid {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Heading Styling */
        h1 {
            color: var(--text-dark);
            margin-bottom: 30px;
            font-weight: 700;
            font-size: clamp(2rem, 4vw, 3.15rem);
            position: relative;
            padding-bottom: 18px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 78px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), rgba(255, 87, 34, 0.14));
            border-radius: 999px;
        }

        h2 {
            color: var(--text-dark);
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 18px;
        }

        h5, h6 {
            color: var(--text-dark);
            font-weight: 600;
        }

        .page-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 87, 34, 0.08);
            color: var(--primary-dark);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1rem;
        }

        .page-subtitle {
            max-width: 780px;
            color: var(--text-muted);
            font-size: 1.02rem;
            margin-top: -0.35rem;
            margin-bottom: 0;
        }

        /* Card Styling */
        .card {
            border: 1px solid rgba(23, 23, 23, 0.05);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.92);
            transition: all 0.3s ease;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }

        .stat-card {
            padding: 1.5rem;
            border-radius: 24px;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            gap: 0.35rem;
            border: 1px solid rgba(23, 23, 23, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .stat-card-dark {
            background: linear-gradient(145deg, #191919 0%, #2a2a2a 100%);
            color: var(--white);
        }

        .stat-card-dark::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 87, 34, 0.12);
            border-radius: 50%;
        }

        .stat-card-orange {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
            position: relative;
            z-index: 1;
        }

        .stat-card-orange::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: -1;
        }

        /* Light Card Style */
        .stat-card-light {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 247, 243, 0.96) 100%);
            border: 1px solid var(--border-light);
            box-shadow: 0 12px 28px rgba(23, 23, 23, 0.04);
        }

        .stat-card-light:hover {
            border-color: var(--primary-color);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 1.05rem 1.4rem;
            font-size: 1rem;
        }

        .card-body {
            padding: 1.45rem;
        }

        /* Button Styling */
        .btn {
            border-radius: 999px;
            font-weight: 600;
            padding: 0.78rem 1.4rem;
            border: none;
            transition: all 0.3s ease;
            text-transform: none;
            font-size: 0.94rem;
            letter-spacing: -0.01em;
            box-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            box-shadow: 0 18px 30px rgba(255, 87, 34, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #c84316);
            box-shadow: 0 24px 38px rgba(255, 87, 34, 0.24);
            transform: translateY(-2px) scale(1.01);
            color: var(--white);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #2E7D32);
            color: var(--white);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #388E3C, #256b29);
            box-shadow: 0 24px 38px rgba(76, 175, 80, 0.24);
            transform: translateY(-2px);
            color: var(--white);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f6c453, #f59e0b);
            color: #2f2306;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #efb73b, #d97706);
            box-shadow: 0 24px 38px rgba(245, 158, 11, 0.22);
            transform: translateY(-2px);
            color: #2f2306;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #2f2f2f, #1f1f1f);
            color: var(--white);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #1f1f1f, #121212);
            box-shadow: 0 24px 38px rgba(31, 31, 31, 0.24);
            transform: translateY(-2px);
            color: var(--white);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #c62828);
            color: var(--white);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            box-shadow: 0 24px 38px rgba(229, 57, 53, 0.24);
            transform: translateY(-2px);
            color: var(--white);
        }

        .btn-outline-soft {
            background: rgba(255, 255, 255, 0.74);
            color: var(--text-dark);
            border: 1px solid rgba(23, 23, 23, 0.08);
        }

        .btn-outline-soft:hover {
            color: var(--primary-dark);
            border-color: rgba(255, 87, 34, 0.18);
            background: rgba(255, 87, 34, 0.08);
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 18px;
            border-left: 4px solid;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background-color: #E8F5E9;
            border-left-color: var(--success-color);
            color: #1B5E20;
        }

        .alert-danger {
            background-color: #FFEBEE;
            border-left-color: var(--primary-color);
            color: #B71C1C;
        }

        .alert-warning {
            background-color: #FFF3E0;
            border-left-color: var(--warning-color);
            color: #E65100;
        }

        .alert-info {
            background-color: #EAF2FF;
            border-left-color: var(--info-color);
            color: #153D7A;
        }

        /* Table Styling */
        .table {
            background-color: transparent;
            border-collapse: collapse;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
        }

        .table thead th {
            border: none;
            font-weight: 600;
            padding: 1rem 1.1rem;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
        }

        .table tbody td {
            padding: 1.05rem 1.1rem;
            border-color: var(--border-light);
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.88);
        }

        .table tbody tr:hover {
            background-color: rgba(255, 247, 243, 0.6);
        }

        /* Badge Styling */
        .badge {
            padding: 0.52rem 0.78rem;
            font-weight: 600;
            border-radius: 999px;
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .bg-success {
            background-color: var(--success-color) !important;
        }

        .bg-warning {
            background-color: var(--warning-color) !important;
            color: var(--white) !important;
        }

        .bg-danger {
            background-color: var(--danger-color) !important;
            color: var(--white) !important;
        }

        .bg-info {
            background-color: var(--primary-color) !important;
        }

        /* Form Styling */
        .form-control, .form-select {
            border: 1.5px solid var(--border-light);
            border-radius: 16px;
            padding: 0.88rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.24rem rgba(255, 87, 34, 0.12);
            background-color: var(--white);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.7rem;
            font-size: 0.93rem;
        }

        .form-hint {
            color: var(--text-muted);
            font-size: 0.84rem;
            margin-top: 0.5rem;
        }

        /* Dropdown Styling */
        .dropdown-menu {
            border: 1px solid rgba(23, 23, 23, 0.06);
            box-shadow: var(--shadow-sm);
            border-radius: 18px;
            padding: 0.4rem;
            overflow: hidden;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            border-radius: 12px;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 87, 34, 0.08);
            color: var(--primary-color);
            padding-left: 1rem;
        }

        /* Footer Styling */
        footer {
            background: linear-gradient(180deg, #1e1e1e 0%, #141414 100%);
            color: var(--white);
            padding: 52px 0 0;
            margin-top: auto;
            border-top: 1px solid rgba(255, 87, 34, 0.4);
        }

        footer h5 {
            color: #ffd2c2;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        footer p {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 0.5rem;
        }

        footer a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: var(--primary-color);
        }

        footer hr {
            opacity: 0.3;
            margin: 20px 0;
        }

        footer .text-center {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 18px 0;
            margin-top: 26px;
        }

        /* Pagination Styling - Bootstrap 5 Compatible */
        nav[aria-label="Page navigation"] {
            display: flex;
            justify-content: center;
        }

        .pagination {
            margin-top: 0;
            gap: 0.3rem;
            justify-content: center;
            flex-wrap: wrap;
            border: none;
            --bs-pagination-padding-x: 0.6rem;
            --bs-pagination-padding-y: 0.5rem;
            --bs-pagination-font-size: 0.95rem;
            --bs-pagination-line-height: 1.5;
        }

        .page-item {
            margin: 0;
        }

        .page-link {
            color: var(--primary-color);
            border-color: var(--border-light);
            border-radius: 0.375rem;
            padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
            font-weight: 500;
            font-size: var(--bs-pagination-font-size);
            line-height: var(--bs-pagination-line-height);
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-light);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            white-space: nowrap;
        }

        .page-link:hover {
            color: var(--white);
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            text-decoration: none;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--white);
            box-shadow: 0 2px 6px rgba(255, 87, 34, 0.25);
        }

        .page-item.disabled .page-link {
            color: var(--text-muted);
            background-color: rgba(248, 248, 248, 0.6);
            border-color: var(--border-light);
            cursor: not-allowed;
            opacity: 0.5;
            pointer-events: none;
        }

        /* Pagination wrapper and info text */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2.5rem;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .surface-panel {
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(23, 23, 23, 0.06);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(14px);
        }

        .soft-panel {
            padding: 1.25rem;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 247, 243, 0.95) 0%, rgba(255, 255, 255, 0.95) 100%);
            border: 1px solid rgba(255, 87, 34, 0.08);
        }

        .detail-item {
            padding: 1rem 1.1rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(23, 23, 23, 0.05);
        }

        .detail-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 0.45rem;
        }

        .detail-value {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .muted-block {
            padding: 1.1rem 1.2rem;
            border-radius: 20px;
            background: rgba(248, 248, 248, 0.82);
            border: 1px solid rgba(23, 23, 23, 0.05);
        }

        .section-stack > * + * {
            margin-top: 1rem;
        }

        .sticky-panel {
            position: sticky;
            top: 108px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }

            .container, .container-fluid {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .navbar-brand {
                font-size: 1rem;
            }

            .navbar-brand .logo-img {
                width: 44px;
                height: 44px;
            }

            .btn {
                width: 100%;
            }

            .sticky-panel {
                position: static;
                top: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation Bar -->

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-heart"></i> BERKAT</h5>
                    <p>Sistem Permohonan Bantuan BERKAT membantu memudahkan proses permohonan bantuan kepada anggota organisasi.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-phone"></i> Hubungi Kami</h5>
                    <p>
                        Emel: <a href="mailto:berkat@example.com">berkat@example.com</a><br>
                        Telefon: <a href="tel:+60312345678">+60-3-XXXX-XXXX</a>
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-link"></i> Pautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Bantuan</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Hubungi Kami</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Terma dan Syarat</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p>&copy; 2026 Sistem BERKAT. Hak Cipta Terpelihara.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
