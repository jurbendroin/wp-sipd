# WP-SIPD
Optimasi aplikasi SIPD dengan chrome extension dan plugin wordpress
Semoga bermanfaat

### GRUP telegram https://t.me/sipd_chrome_extension

### Chrome extension https://github.com/agusnurwanto/sipd-chrome-extension

Cara pakai plugin:
- Install wordpress
- Install plugin ini dan aktifkan
- Import SQL file tabel.sql untuk membuat tabel tempat menyimpan data yang diambil dari sipd.kemendagri.go.id
- Copy file config.php.example ke config.php
- Edit nilai dari api key dengan random string untuk keamanan dan pastikan sama dengan nilai dari settingan api key sipd chrome extension
- Untuk menampilkan SSH menggunakan shortcode [datassh]
- Untuk menampilkan akun belanja menggunakan shortcode [rekbelanja]
- Halaman RKA akan otomatis tergenerate dalam bentuk post yang dikelompokan dalam category perangkat daerah ketika melakukan singkronisasi data
- Video: https://youtu.be/t84n2jZUfFo
- Theme yang sudah dites astra theme

Optimasi server apache agar proses pengiriman data dari chrome extension ke server wordpress berjalan lancar (edit file php.ini):
- max_input_vars = 300000
- max_execution_time = 300
- max_input_time = 600
- memory_limit = 3556M
- post_max_size = 20M

Agar pengiriman data dari chrome extension ke WP mulus tambahkan kode berikut ini di file functions.php di folder wp-content/themes/<nama tema yg digunakan>

add_filter('allowed_http_origins', 'add_allowed_origins');

function add_allowed_origins($origins) {
    $origins[] = 'chrome-extension://<ID ekstensi>';
    return $origins;
}

(ID ekstensi dapat dilihat di chrome dengan membuka halaman: chrome://extensions/ )

Permintaan fitur:
- User umum bisa request penambahan fitur dengan membuat issue
