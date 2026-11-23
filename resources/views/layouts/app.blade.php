<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Visitor Desk') · Office Visitor Management</title>
<style>
:root{--ink:#14213d;--muted:#5b6575;--line:#d9dee5;--bg:#f3f5f8;--card:#fff;--accent:#0f766e;--accent-dark:#0b5a54;--danger:#b42318;--ok-bg:#e6f4f1;--err-bg:#fdecea}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink);font:15px/1.5 "Segoe UI",system-ui,-apple-system,sans-serif}
a{color:var(--accent-dark)}
header.top{background:var(--ink);color:#fff}
.bar{max-width:1100px;margin:auto;padding:12px 20px;display:flex;flex-wrap:wrap;gap:8px 22px;align-items:center}
.brand{font-weight:700;font-size:17px;margin-right:auto;color:#fff;text-decoration:none}
.bar a.nav{color:#cfd8e6;text-decoration:none;padding:4px 0;border-bottom:2px solid transparent}
.bar a.nav:hover,.bar a.nav.on{color:#fff;border-color:#5eead4}
.bar form{margin:0}
main{max-width:1100px;margin:28px auto;padding:0 20px}
h1{font-size:24px;margin:0 0 4px}
.sub{color:var(--muted);margin:0 0 22px}
.panel{background:var(--card);border:1px solid var(--line);border-radius:6px;padding:20px;margin-bottom:22px}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:22px}
.stat{background:var(--card);border:1px solid var(--line);border-left:4px solid var(--accent);border-radius:6px;padding:16px 18px}
.stat b{display:block;font-size:34px;line-height:1.1}
.stat span{color:var(--muted)}
table{width:100%;border-collapse:collapse}
th,td{text-align:left;padding:9px 10px;border-bottom:1px solid var(--line);vertical-align:top}
th{font-size:13px;color:var(--muted);font-weight:600;white-space:nowrap}
.scroll{overflow-x:auto}
label{display:block;font-weight:600;margin:14px 0 4px}
input,select{width:100%;padding:9px 10px;border:1px solid #b9c1cc;border-radius:4px;font:inherit;background:#fff}
input:focus,select:focus,button:focus-visible,a:focus-visible{outline:3px solid #5eead4;outline-offset:1px}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:0 18px}
@media(max-width:640px){.grid2{grid-template-columns:1fr}}
.btn{display:inline-block;background:var(--accent);color:#fff;border:0;border-radius:4px;padding:9px 16px;font:inherit;font-weight:600;cursor:pointer;text-decoration:none}
.btn:hover{background:var(--accent-dark)}
.btn.alt{background:#fff;color:var(--ink);border:1px solid #b9c1cc}
.btn.sm{padding:4px 10px;font-size:13px}
.row{display:flex;flex-wrap:wrap;gap:10px;align-items:end}
.row>div{flex:1;min-width:160px}
.flash{background:var(--ok-bg);border:1px solid #9bd3c9;padding:10px 14px;border-radius:4px;margin-bottom:18px}
.errors{background:var(--err-bg);border:1px solid #f1b4ad;color:#7a1810;padding:10px 14px;border-radius:4px;margin-bottom:18px}
.errors ul{margin:0;padding-left:18px}
.tag{display:inline-block;padding:1px 9px;border-radius:99px;font-size:12px;font-weight:600;background:#e4e8ee}
.tag.in{background:var(--ok-bg);color:var(--accent-dark)}
.tag.off{background:var(--err-bg);color:var(--danger)}
.empty{color:var(--muted);text-align:center;padding:26px}
.pagination{list-style:none;display:flex;gap:10px;padding:0;margin:14px 0 0}
.inline{display:inline}
</style>
</head>
<body>
@auth
<header class="top"><div class="bar">
  <a class="brand" href="{{ route('dashboard') }}">Visitor Desk</a>
  <a class="nav {{ request()->routeIs('dashboard') ? 'on' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
  <a class="nav {{ request()->routeIs('visitors.create') ? 'on' : '' }}" href="{{ route('visitors.create') }}">Register visitor</a>
  <a class="nav {{ request()->routeIs('visitors.inside') ? 'on' : '' }}" href="{{ route('visitors.inside') }}">In the office</a>
  <a class="nav {{ request()->routeIs('visitors.index') ? 'on' : '' }}" href="{{ route('visitors.index') }}">Records</a>
  @if(auth()->user()->isAdmin())
    <a class="nav {{ request()->routeIs('reports.*') ? 'on' : '' }}" href="{{ route('reports.index') }}">Reports</a>
    <a class="nav {{ request()->routeIs('staff.*') ? 'on' : '' }}" href="{{ route('staff.index') }}">Staff</a>
    <a class="nav {{ request()->routeIs('logs.*') ? 'on' : '' }}" href="{{ route('logs.index') }}">Activity log</a>
  @endif
  <form method="POST" action="{{ route('logout') }}">@csrf
    <button class="btn alt sm" type="submit">Log out ({{ auth()->user()->name }})</button>
  </form>
</div></header>
@endauth
<main>
  @if(session('status'))<div class="flash" role="status">{{ session('status') }}</div>@endif
  @if($errors->any())
    <div class="errors" role="alert"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif
  @yield('content')
</main>
</body>
</html>
