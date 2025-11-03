<!DOCTYPE html>
<html>
<head>
    <title>Log Masuk</title>
</head>
<body>
    <h2>Log Masuk Pengguna</h2>

    <form method="POST" action="{{ route('login.check') }}">
        @csrf
        <label for="NoKP">No. Kad Pengenalan:</label><br>
        <input type="text" id="NoKP" name="NoKP" required><br><br>

        <label for="katalaluan">Katalaluan:</label><br>
        <input type="password" id="katalaluan" name="katalaluan" required><br><br>

        <button type="submit">Log Masuk</button>
    </form>

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif
</body>
</html>
