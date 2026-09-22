<?php

// Menentukan predikat secara Otomatis
function statusKelulusan(float $ipk): string{
    if ($ipk >= 3.50) return 'Sangat Memuaskan';
    if ($ipk >= 3.00) return 'Memuaskan';
    return 'Perlu Peningkatan';
}

// Pesan otomatis sesuai semester yang ditempuh
function statusSemester(float $semester): string{
    if ($semester >= 5) return 'Yeay! bentar lagi lulus';
    if ($semester <= 4) return 'Terus Berjuang yah';
}

// Output data dari Website
$mahasiswa = [
    'NPM'           => '2024025',
    'Nama'          => 'Delsyad Iza',
    'Jenis_Kelamin' => 'Laki-laki',
    'Prodi'         => 'Informatika',
    'Semester'      => 5,
    'IPK'           => 3.97,
    'No_telp'       =>'085215770771'
];
?>

<!-- Bagian Front-end -->
<!doctype html>
<html lang="id">

<head>
    <meta charset = "utf-8">
    <title>Biodata</title>
</head>

<body>
    <h1>Biodata Mahasiswa UP</h1>
    <hr>

    <!-- Memunculkan nilai data output -->
    <ul>
        <?php foreach ($mahasiswa as $kunci => $nilai): ?>
            <li><?= ucfirst($kunci) ?>: <?=htmlspecialchars((string)$nilai) ?></li>
        <?php endforeach; ?>
    </ul>
    <p>Predikat: <?= statusKelulusan($mahasiswa['IPK']) ?> </p>
    <hr>
    <span> <?= statusSemester($mahasiswa['Semester']) ?> </span>
</body>

</html>

<!-- Membuat Tampilan Style dari Website -->
<style>
    body {background: #0810b0; font-family: Arial, sans-serif; margin: 40px;}
    h1 { text-align: center; font-size: 50px; color: white; }
    hr {border: none; border-top: 2px solid #fffb00;}
    ul {color: white;}
    p {color: white; font-size: 20px}
    span {color: white; padding-top: 50px; text-align: center; display: block; font-size: 40px;}
</style>