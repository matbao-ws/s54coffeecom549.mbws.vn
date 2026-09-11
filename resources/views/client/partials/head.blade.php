<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'S54 COFFEE — Cà Phê Rang Xay & Hòa Tan Thượng Hạng | Good Solutions')</title>
@hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
@else
    <meta name="description" content="S54 COFFEE - Thương hiệu cà phê thượng hạng thuộc Good Solutions Co., Ltd. Cung cấp cà phê rang mộc nguyên chất, cà phê hòa tan 3in1 và giải pháp B2B toàn diện.">
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('client-assets/css/layouts.critical.css') }}?v=2.5">
<link rel="stylesheet" href="{{ asset('client-assets/css/layouts.theme.css') }}?v=2.5">
<link rel="stylesheet" href="{{ asset('client-assets/css/custom.css') }}?v=2.5">
@stack('styles')
