<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<h2>Informasi Pendaftaran PRATAMA</h2>

<h3>Halo {{ $user->name }},</h3>

<p>Nama : {{ $user->name }}</p>


<p>
    NIM : {{ $user->nim }}
</p>

<p>
    Program Studi : {{ $user->prodi }}
</p>

<p>
Mohon maaf, pendaftaran akun SIPRESMA Anda belum dapat disetujui oleh administrator.
</p>

<p>
Silakan melakukan pendaftaran ulang atau menghubungi administrator untuk informasi lebih lanjut.
</p>

<p>Terima kasih.</p>

</body>
</html>