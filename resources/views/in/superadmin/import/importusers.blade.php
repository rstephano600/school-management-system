<!DOCTYPE html>
<html>
<head>
    <title>Import and Export CSV/Excel File in Laravel 12</title>
</head>
<body>

<h2>Import Users</h2>
<form action="{{ route('import.user') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import</button>
</form>

<h2>Export Users</h2>
<a href="/export">Download Excel</a>

</body>
</html>