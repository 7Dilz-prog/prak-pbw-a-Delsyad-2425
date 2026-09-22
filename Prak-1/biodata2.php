<?php

function statusKelulusan(float $ipk): string{
    if ($ipk >= 3.50) return 'Sangat Memuaskan';
    if ($ipk >= 3.00) return 'Memuaskan';
    return 'Perlu Peningkatan';
}

function statusSemester(float $semester): string{
    if ($semester >= 5) return 'Yeay! bentar lagi lulus';
    if ($semester <= 4) return 'Terus Berjuang yah';
}

$mahasiswa = [
    'NPM' => '2024025',
    'Nama' => 'Delsyad Iza',
    'Jenis_Kelamin' => 'Laki-laki',
    'Prodi' => 'Informatika',
    'Semester' => 5,
    'IPK' => 3.97,
    'No_telp' =>'085215770771'
];
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset = "utf-8">
    <title>Biodata</title>
</head>

<body>
    <h1>Biodata Mahasiswa UP</h1>
    <ul>
        <?php foreach ($mahasiswa as $kunci => $nilai): ?>
            <li><?= ucfirst($kunci) ?>: <?=htmlspecialchars((string)$nilai) ?></li>
        <?php endforeach; ?>
    </ul>
    <p>Predikat: <?= statusKelulusan($mahasiswa['IPK']) ?> </p>
    <p> <?= statusSemester($mahasiswa['Semester']) ?> </p>
</body>

</html>
