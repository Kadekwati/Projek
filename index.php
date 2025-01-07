<?php
// Memulai session
session_start();

// Menyertakan file functions.php
include 'functions.php';

// Mendapatkan daftar gambar dari folder "images"
$images = get_image_list();

// Memulai permainan atau melanjutkan permainan yang sedang berjalan
if (!isset($_SESSION['current_image']) || isset($_POST['play_again'])) {
    if (empty($images)) {
        die("Tidak ada gambar di folder images!");
    }
    $_SESSION['current_image'] = $images[array_rand($images)]; // Pilih gambar secara acak
    $_SESSION['attempts'] = 0; // Reset jumlah percobaan
    $_SESSION['score'] = 0; // Reset skor
}

// Gambar dan variabel permainan
$current_image = $_SESSION['current_image'];
$attempts = $_SESSION['attempts'];
$score = $_SESSION['score'];

// Memproses tebakan pemain
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['guess'])) {
        $guess = trim($_POST['guess']);
        if (check_answer($current_image, $guess)) {
            $message = "Jawaban Anda benar!";
            $_SESSION['score']++;
            // Pilih gambar baru secara acak setelah jawaban benar
            $_SESSION['current_image'] = $images[array_rand($images)];
            $_SESSION['attempts'] = 0; // Reset jumlah percobaan untuk gambar baru
        } else {
            $message = "Jawaban Anda salah. Coba lagi!";
        }
        $_SESSION['attempts']++;
    }

    // Permainan selesai dan ingin main lagi
    if (isset($_POST['play_again'])) {
        $_SESSION['current_image'] = $images[array_rand($images)];
        $_SESSION['attempts'] = 0;
        $message = null;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permainan Tebak Gambar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        img {
            max-width: 300px;
            margin: 20px 0;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
        }
        button {
            padding: 10px;
            margin: 10px;
        }
        .result {
            margin: 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>

    <h1>Permainan Tebak Gambar</h1>

    <!-- Menampilkan gambar -->
    <img src="images/<?php echo $current_image; ?>" alt="Gambar untuk ditebak">
    
    <p>Jawab dengan nama gambar </p>

    <!-- Form untuk memasukkan tebakan -->
    <form method="POST">
        <input type="text" name="guess" placeholder="Masukkan jawaban Anda" required>
        <button type="submit">Tebak</button>
    </form>

    <!-- Menampilkan pesan hasil tebakan -->
    <?php if (isset($message)) { ?>
        <div class="result"><?php echo $message; ?></div>
    <?php } ?>

    <!-- Menampilkan skor dan jumlah percobaan -->
    <div class="score">
        <p>Skor Anda: <?php echo $score; ?></p>
        <p>Percobaan: <?php echo $attempts; ?></p>
    </div>

    <!-- Tombol untuk mulai permainan lagi -->
    <form method="POST">
        <button type="submit" name="play_again">Main Lagi</button>
    </form>

</body>
</html>
