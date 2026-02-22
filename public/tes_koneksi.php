<?php

$host = 'sandbox.smtp.mailtrap.io';
$port = 2525;
$timeout = 15; // Waktu tunggu dalam detik

echo "<h3>Mencoba tes koneksi ke Mailtrap...</h3>";
echo "<p>Host: $host<br>Port: $port</p>";
echo "<hr>";

// Menggunakan @ untuk menekan warning default agar kita bisa menampilkan pesan custom
$socket = @fsockopen($host, $port, $errno, $errstr, $timeout);

if (!$socket) {
    // Jika koneksi GAGAL
    echo "<h2 style='color:red;'>KONEKSI GAGAL!</h2>";
    echo "<p><strong>Pesan Error:</strong> $errstr (Error code: $errno)</p>";
    echo "<p><strong>Kesimpulan:</strong> Ini 99% membuktikan ada sesuatu yang memblokir koneksi dari komputer Anda ke Mailtrap di port 2525.</p>";
    echo "<p><strong>Saran:</strong> Coba matikan sementara Antivirus/Firewall Anda, atau coba gunakan koneksi internet lain (misal: tethering dari HP).</p>";
} else {
    // Jika koneksi BERHASIL
    echo "<h2 style='color:green;'>KONEKSI BERHASIL!</h2>";
    echo "<p>Koneksi ke server Mailtrap berhasil dibuat.</p>";
    echo "<p><strong>Kesimpulan:</strong> Jika tes ini berhasil tapi email dari Laravel tetap tidak masuk, masalahnya ada pada konfigurasi PHP atau Laravel yang lebih spesifik (misalnya ekstensi PHP `openssl` yang tidak aktif).</p>";
    fclose($socket);
}
