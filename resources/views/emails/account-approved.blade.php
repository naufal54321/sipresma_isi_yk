<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

    <h2>Selamat {{ $user->name }},</h2>

    <h3>
        Akun SIPRESMA Anda telah disetujui oleh Admin.
    </h3>

    <p>Nama : {{ $user->name }}</p>


    <p>
        NIM : {{ $user->nim }}
    </p>

    <p>
        Program Studi : {{ $user->prodi }}
    </p>

    <p>
        Silakan login menggunakan akun yang telah didaftarkan.
    </p>

    <p>
        <a href="{{ url('/login') }}">
            Login Sekarang
        </a>
    </p>

    <br>

    <p>Terima kasih.</p>

</body>


</html>