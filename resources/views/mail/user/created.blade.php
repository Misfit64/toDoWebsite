<h2 style="text-align:center; font-family:Arial, sans-serif;">
    <img
        src="{{ $message->embed(public_path('svg/logo.svg')) }}"
        alt="Logo"
        width="28"
        height="28"
        style="vertical-align:middle; margin-right:8px;"
    >
    <span style="font-weight:600; color:#2c3e50;">
        Welcome, {{ $user->username }}!
    </span>
</h2>
