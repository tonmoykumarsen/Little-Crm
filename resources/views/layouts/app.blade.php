<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title') - Little CRM</title>

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    :root {
      --brand: #4f46e5;
      --card-radius: 12px;
      --glass-bg: rgba(255,255,255,0.95);
    }

    html, body { height: 100%; }
    body {
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: #f8fafc;
      color: #0f172a;
    }

    /* Navbar */
    .navbar-brand { font-weight: 700; letter-spacing: 0.2px; }
    .nav-user { color:#fff; font-weight:600; }

    /* Sidebar */
    .sidebar {
      position: sticky;
      top: 0;
      height: 100vh;
      background: var(--glass-bg);
      border-right: 1px solid rgba(0,0,0,0.05);
      padding-top: 1rem;
      box-shadow: 0 6px 18px rgba(0,0,0,0.04);
    }
    .sidebar .nav-link {
      color: #334155;
      border-radius: 8px;
      margin-bottom: 0.35rem;
      font-weight: 600;
    }
    .sidebar .nav-link i { width: 20px; text-align:center; }
    .sidebar .nav-link:hover { background: #eef2ff; color: var(--brand) !important; }
    .sidebar .nav-link.active { background: var(--brand); color: #fff !important; box-shadow: 0 6px 18px rgba(79,70,229,0.12); }

    /* Cards */
    .card {
      border-radius: var(--card-radius);
      border: none;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,0.03);
    }

    .stat-card {
      border-radius: 14px;
      padding: 22px;
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.06);
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .stat-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 30px rgba(0,0,0,0.08);
    }
    .stat-small { font-size: .95rem; opacity:.9; }

    /* List groups */
    .list-group-item {
      border: none;
      border-radius: 10px;
      padding: .9rem;
      margin-bottom: .4rem;
      background: #fff;
      box-shadow: 0 6px 18px rgba(2,6,23,0.02);
    }

    /* Badges */
    .status-badge { padding: .45rem .6rem; border-radius: 999px; font-weight:700; font-size:.85rem; }

    /* Responsive tweaks */
    @media (max-width: 991px) {
      .sidebar { height: auto; position: relative; }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <i class="fas fa-layer-group me-2"></i> Little CRM
      </a>

      <div class="d-flex align-items-center ms-auto">
        <div class="me-3 text-white nav-user">
          <i class="fas fa-user-circle me-1"></i>
          {{ auth()->user()->name ?? 'User' }} 
          <small class="text-muted">({{ auth()->user()->role ?? 'Unknown' }})</small>
        </div>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline-light btn-sm">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Layout -->
  <div class="container-fluid">
    <div class="row g-0">

     <!-- Sidebar -->
<nav class="col-md-3 col-lg-2 sidebar">
    <ul class="nav flex-column px-2">

        <!-- Dashboard -->
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        @if(auth()->user()->role === 'admin')
            <!-- Staff Management -->
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->is('staff*') ? 'active' : '' }}" href="{{ route('staff.index') }}">
                    <i class="fas fa-users me-2"></i> Staff Management
                </a>
            </li>

            <!-- Projects -->
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                    <i class="fas fa-project-diagram me-2"></i> Projects
                </a>
            </li>

            <!-- New Admin Sections -->
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->is('attendances*') ? 'active' : '' }}" href="{{ route('attendances.index') }}">
                    <i class="fas fa-calendar-check me-2"></i> Attendance
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->is('assets*') ? 'active' : '' }}" href="{{ route('assets.index') }}">
                    <i class="fas fa-laptop me-2"></i> Assets
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->is('notices*') ? 'active' : '' }}" href="{{ route('notices.index') }}">
                    <i class="fas fa-bullhorn me-2"></i> Notices
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->is('reports*') ? 'active' : '' }}" href="{{ route('reports.dashboard') }}">
                    <i class="fas fa-chart-bar me-2"></i> Reports
                </a>
            </li>
        @endif

        <!-- Common Items -->
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                <i class="fas fa-tasks me-2"></i> Tasks
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->is('time-logs*') ? 'active' : '' }}" href="{{ route('time-logs.index') }}">
                <i class="fas fa-clock me-2"></i> Time Logs
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->is('profile*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <i class="fas fa-user-cog me-2"></i> My Profile
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->is('leaves*') ? 'active' : '' }}" href="{{ route('leaves.index') }}">
                <i class="fas fa-umbrella-beach me-2"></i> Leave Management
            </a>
        </li>
    </ul>
</nav>


      <!-- Main content -->
      <main class="col-md-9 col-lg-10 px-md-4 py-4">
        @yield('content')
      </main>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
