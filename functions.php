<?php
function get_image_list() {
    // Menyediakan array gambar yang ada dalam folder "images/"
    return ['bunglon.jpg', 'kelinci.jpg', 'kuda.jpg', 'serigala.jpg'];
}

// Fungsi untuk memeriksa apakah jawaban pemain benar
function check_answer($image_name, $guess) {
    // Mengambil nama gambar tanpa ekstensi
    $answer = pathinfo($image_name, PATHINFO_FILENAME); // Nama gambar tanpa ekstensi
    return strtolower($guess) == strtolower($answer); // Cek jawaban pemain
}
?>
