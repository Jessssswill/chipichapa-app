<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - ChipiChapa</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 50px;">

    <h2>Register User Biasa</h2>

    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf <label>Nama Lengkap:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email (Wajib @gmail.com):</label><br>
        <input type="email" name="email" required><br><br>

        <label>Nomor Handphone (Awali 08):</label><br>
        <input type="text" name="nomor_handphone" required><br><br>

        <label>Password (6-12 huruf):</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Submit Button</button>
    </form>

    <br>
    <a href="/login">Sudah punya akun? Login di sini</a>

</body>
</html>