<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
</head>
<body>
    <h2>Daftar Pengguna Baru</h2>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <label for="Nama">Nama:</label><br>
        <input type="text" id="Nama" name="Nama" required><br><br>

        <label for="NoKP">No. Kad Pengenalan:</label><br>
        <input type="text" id="NoKP" name="NoKP" required><br><br>

        <label for="katalaluan">Katalaluan:</label><br>
        <input type="password" id="katalaluan" name="katalaluan" required><br><br>

        <label for="userlevel">User Level:</label><br>
        <select id="userlevel" name="userlevel" required>
            <option value="">-- Pilih User Level --</option>
            <option value="9">9</option>
            <option value="8">8</option>
            <option value="1">1</option>
        </select><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
