@php
    $rtlLocales = ['ar', 'fa', 'he']; // Arabic, Persian, Hebrew
    $dir = in_array(app()->getLocale(), $rtlLocales) ? 'rtl' : 'ltr';
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('mail.subject') }}</title>
</head>

<body dir="{{ $dir }}"
    style="background-color:#f8f4f0;
             color:#000000 !important;
             padding:20px;
             font-family:Arial, sans-serif;
             font-size:large;
             direction:{{ $dir }};
             text-align:{{ $dir == 'rtl' ? 'right' : 'left' }};">
    {{-- Logo --}}
    <div style="margin-bottom: 20px; text-align: center;">
        <img src="{{ url('https://www2.0zz0.com/2025/08/28/13/180370951.png') }}" alt="ceo logo" width="80"
            height="80">
    </div>
    {{-- Greeting --}}
    <h2 style="margin-bottom: 10px;">
        {{ __('mail.greeting') }} {{ $user['first_name'] }}
    </h2>

    {{-- Welcome --}}
    <p style="margin-bottom: 20px; white-space: pre-line;">
        {{ __('mail.welcome') }}
    </p>

    {{-- Instruction --}}
    <p style="margin-bottom: 15px;">
        {{ __('mail.instruction') }}
    </p>

    {{-- OTP Box --}}
    <div style="margin: 30px 0;">
        <span
            style="display: inline-block; background-color: #1a1a1a; color: #ffc107;
                     font-size: 22px; font-weight: bold; padding: 10px 20px; border-radius: 6px;">
            {{ $code }}
        </span>
    </div>

    {{-- Expiry & Ignore --}}
    <p style="margin-bottom: 10px;">
        {{ __('mail.expiry') }}
    </p>
    <p style="margin-bottom: 20px;">
        {{ __('mail.ignore') }}
    </p>

    {{-- Thanks --}}
    <p style="white-space: pre-line;">
        {{ __('mail.thanks') }}
    </p>

</body>

</html>
