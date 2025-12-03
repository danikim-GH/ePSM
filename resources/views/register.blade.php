<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
</head>
<body>
    <h2>Daftar Pengguna Baru</h2>

    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <input type="text" name="Nama" placeholder="Nama" required>
        <input type="text" name="NoKP" placeholder="No KP" required>
        <input type="email" name="emel" placeholder="Email" required>
        <input type="text" name="hp" placeholder="Phone" required>
        <input type="password" name="katalaluan" placeholder="Katalaluan" required>
        <button type="submit">Daftar</button>
    </form>
</body>
</html>
