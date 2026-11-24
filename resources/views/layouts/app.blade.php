<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Visitor Desk') · CvSU Visitor Management</title>
<style>
:root{--ink:#10233f;--navy:#091b33;--navy-light:#123458;--muted:#68778a;--line:#dbe4ef;--bg:#eef3f8;--card:#fff;--accent:#2563a6;--accent-dark:#174a7d;--danger:#b42318;--ok-bg:#eaf3fb;--err-bg:#fdecea}
*{box-sizing:border-box}
body{margin:0;background:radial-gradient(circle at 100% 0,#dbe9f6 0,transparent 28%),var(--bg);color:var(--ink);font:15px/1.55 "Segoe UI",system-ui,-apple-system,sans-serif;min-height:100vh}
a{color:var(--accent-dark)}
header.top{position:sticky;top:0;z-index:20;background:linear-gradient(120deg,var(--navy) 0%,#0d2a4d 68%,#164875 100%);color:#fff;box-shadow:0 8px 24px rgba(9,27,51,.16)}
.bar{max-width:1180px;margin:auto;padding:10px 24px;display:flex;flex-wrap:wrap;gap:6px 18px;align-items:center}
.brand{display:flex;align-items:center;gap:11px;font-weight:750;font-size:17px;margin-right:auto;color:#fff;text-decoration:none;letter-spacing:.1px}
.brand img{width:46px;height:46px;object-fit:contain;filter:drop-shadow(0 3px 5px rgba(0,0,0,.22))}
.bar a.nav{color:#bcd0e7;text-decoration:none;padding:7px 2px;border-bottom:2px solid transparent;font-size:14px;font-weight:600}
.bar a.nav:hover,.bar a.nav.on{color:#fff;border-color:#69a9df}
.bar form{margin:0}
main{max-width:1180px;margin:32px auto;padding:0 24px 32px}
h1{font-size:28px;line-height:1.2;margin:0 0 5px;letter-spacing:-.35px}
h2{color:var(--ink)}
.sub{color:var(--muted);margin:0 0 24px}
.panel{background:rgba(255,255,255,.96);border:1px solid var(--line);border-radius:12px;padding:22px;margin-bottom:22px;box-shadow:0 10px 30px rgba(20,45,78,.07)}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:18px;margin-bottom:22px}
.stat{position:relative;overflow:hidden;background:linear-gradient(145deg,#fff 0%,#f8fbff 100%);border:1px solid var(--line);border-radius:12px;padding:18px 20px;box-shadow:0 8px 24px rgba(20,45,78,.06)}
.stat:before{content:"";position:absolute;left:0;top:0;bottom:0;width:5px;background:linear-gradient(180deg,#69a9df,var(--accent))}
.stat b{display:block;font-size:38px;line-height:1.1;color:var(--navy)}
.stat span{color:var(--muted);font-weight:600}
table{width:100%;border-collapse:collapse}
th,td{text-align:left;padding:12px 10px;border-bottom:1px solid var(--line);vertical-align:top}
th{font-size:12px;text-transform:uppercase;letter-spacing:.45px;color:#718096;font-weight:750;white-space:nowrap}
tbody tr:hover,table tr:not(:first-child):hover{background:#f8fbff}
.scroll{overflow-x:auto}
label{display:block;font-weight:600;margin:14px 0 4px}
input,select{width:100%;padding:11px 12px;border:1px solid #bbc8d7;border-radius:7px;font:inherit;background:#fff;transition:.18s ease}
input:focus,select:focus,button:focus-visible,a:focus-visible{outline:3px solid #91bfe5;outline-offset:1px;border-color:#2563a6}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:0 18px}
@media(max-width:640px){.grid2{grid-template-columns:1fr}main{margin-top:20px;padding:0 16px 24px}.bar{padding:10px 16px}.brand span{max-width:210px}.bar a.nav{font-size:13px}.brand img{width:40px;height:40px}}
.btn{display:inline-block;background:linear-gradient(135deg,var(--accent),var(--accent-dark));color:#fff;border:0;border-radius:7px;padding:10px 16px;font:inherit;font-weight:700;cursor:pointer;text-decoration:none;box-shadow:0 5px 14px rgba(37,99,166,.18);transition:.18s ease}
.btn:hover{background:var(--accent-dark)}
.btn:hover{transform:translateY(-1px);box-shadow:0 7px 18px rgba(37,99,166,.24)}
.btn.alt{background:rgba(255,255,255,.08);color:#fff;border:1px solid rgba(255,255,255,.24);box-shadow:none}
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
  <a class="brand" href="{{ route('dashboard') }}">
    <img src="{{ asset('cvsu-logo.png') }}" alt="CvSU logo">
    <span>CvSU Visitor Management</span>
  </a>
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
