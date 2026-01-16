<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Grafik Gabungan</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
        }

        img {
            max-width: 70%;
            height: auto;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <h2>Jumlah Janji Temu per Dokter (Hari Ini)</h2>
    <img src="{{ $img1 }}" alt="Grafik Dokter">

    <h2>Distribusi Status Janji Temu (Hari Ini)</h2>
    <img src="{{ $img2 }}" alt="Grafik Status">
</body>

</html>
