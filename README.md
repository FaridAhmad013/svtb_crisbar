# SVTBCrisbar: Aplikasi Pelacakan Nilai Stok Dapur Produksi

Selamat datang di SVTBCrisbar! Aplikasi ini dirancang khusus untuk Central Kitchen Crisbar Melong untuk memecahkan tantangan dalam mengetahui nilai riil bahan baku yang terpakai setiap hari.

Aplikasi ini memiliki dua peran pengguna utama:
1.  **Karyawan**: Bertanggung jawab untuk melakukan pencatatan stok harian.
2.  **Pemilik (Admin)**: Bertanggung jawab untuk memantau laporan dan menganalisis biaya produksi.

## 🚀 Tentang Aplikasi

Setiap hari, dapur produksi mengolah berbagai bahan baku menjadi produk jadi. Namun, seringkali sulit untuk mengetahui secara pasti berapa nilai rupiah dari bahan yang benar-benar terpakai. Aplikasi SVTBCrisbar hadir sebagai solusi untuk:

1.  **Mencatat Stok Awal**: Karyawan mencatat jumlah dan nilai semua bahan baku di pagi hari sebelum proses produksi dimulai.
2.  **Mencatat Stok Akhir**: Setelah produksi selesai, karyawan kembali mencatat sisa bahan baku yang ada.
3.  **Menghitung Nilai Terpakai**: Sistem secara otomatis menghitung selisih stok untuk mendapatkan nilai (Rp) akurat dari bahan yang terpakai dalam satu hari produksi.
4.  **Menyajikan Laporan**: Pemilik dapat melihat laporan yang jelas mengenai biaya produksi harian, membantu dalam analisis biaya dan pengambilan keputusan.

## ✨ Fitur Utama

-   **Input Data Cepat via CSV**: Karyawan dapat dengan mudah mengunggah data stok opname menggunakan template file CSV.
-   **Validasi Data Otomatis**: Sistem akan memvalidasi data yang diunggah untuk mencegah kesalahan input, seperti format yang salah atau nilai yang tidak valid.
-   **Perhitungan Biaya Real-time**: Biaya bahan terpakai dan nilai per produk dihitung secara otomatis setelah opname selesai.
-   **Laporan Produksi Informatif**: Laporan dapat difilter berdasarkan tanggal dan disajikan secara jelas untuk analisis oleh pemilik.
-   **Manajemen Peran Pengguna**: Hak akses dibedakan antara **Pemilik (Admin)** dan **Karyawan**.

---

## ⚙️ Untuk Pengembang: Panduan Instalasi & Setup

Bagian ini ditujukan untuk Anda yang akan melakukan instalasi proyek di lingkungan lokal atau server.

### Prasyarat

Pastikan perangkat Anda telah terpasang:
-   PHP **^8.2**
-   Composer
-   Node.js (**v16 atau lebih baru**) & NPM
-   Database (misalnya: MySQL, MariaDB)

### Langkah-Langkah Instalasi

1.  **Ekstrak File Proyek**
    Ekstrak file `.zip` proyek yang sudah Anda unduh ke direktori kerja Anda. Lalu, buka terminal atau command prompt dan masuk ke dalam folder tersebut.
    ```bash
    cd [NAMA_FOLDER_PROYEK]
    ```

2.  **Install Dependency PHP**
    Karena file ZIP tidak menyertakan folder `vendor`, Anda harus menjalankan perintah ini untuk mengunduh semua library PHP yang dibutuhkan.
    ```bash
    composer install
    ```

3.  **Persiapan File `.env`**
    Salin file konfigurasi environment dan generate kunci aplikasi.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi Database**
    Buka file `.env` dan atur koneksi ke database Anda.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=svtbcrisbar
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Jalankan Migrasi & Seeder Database**
    Perintah ini akan membuat semua tabel yang dibutuhkan dan mengisi data awal (termasuk akun pengguna default).
    ```bash
    php artisan migrate --seed
    ```

6.  **Install & Build Aset Frontend**
    Perintah ini akan menginstall dependency JavaScript dan mengkompilasi aset (CSS/JS) untuk aplikasi.
    ```bash
    npm install
    npm run build
    ```

7.  **Hubungkan Folder Storage**
    Agar file publik seperti template unduhan dapat diakses, jalankan:
    ```bash
    php artisan storage:link
    ```

8.  **Jalankan Server Lokal**
    Selamat! Aplikasi Anda siap dijalankan.
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang dapat diakses melalui **http://127.0.0.1:8000**.

> **Catatan Untuk Development Aktif**: Jika Anda sedang aktif melakukan perubahan pada file CSS atau JavaScript, jalankan `npm run dev` di terminal terpisah. Perintah ini akan otomatis me-refresh browser setiap kali ada perubahan pada kode frontend.

---

## 👨‍🍳 Untuk Pengguna: Panduan Aplikasi

Bagian ini menjelaskan cara menggunakan aplikasi setelah terpasang.

### 🔑 Akses Login

Gunakan akun di bawah ini untuk masuk ke dalam sistem. Anda bisa mengubah password setelah login pertama kali.

| Peran             | Email                | Password |
| :---------------- | :------------------- | :------- |
| **Pemilik (Admin)** | `admin@gmail.com`    | `rahasia`  |
| **Karyawan** | `karyawan@gmail.com` | `rahasia`  |

### Alur Kerja (Role: Karyawan)

Ini adalah rutinitas harian yang akan dilakukan oleh pengguna dengan peran **Karyawan**.

**1. Pagi Hari (Sebelum Produksi Dimulai)**
-   Login ke sistem.
-   Masuk ke menu **Proses Produksi Harian** -> **Opname (Pre-Production)**.
-   Klik tombol **`+ Tambah Data Produksi`**.
-   Isi nama produk yang akan dibuat (contoh: "Bumbu Crisbar Melong 500gr").
-   Unduh template CSV, lalu isi dengan semua bahan baku yang disiapkan untuk produksi hari itu.
-   Unggah kembali file CSV tersebut, lihat preview untuk memastikan data benar, lalu simpan.

**2. Sore/Malam Hari (Setelah Produksi Selesai)**
-   Masuk kembali ke menu produksi.
-   Pilih data opname pagi yang sesuai.
-   Lanjutkan ke tahap **Opname (Post-Production)** untuk mencatat sisa bahan.
-   Masuk ke menu **Catat Hasil Produksi** untuk menginput jumlah produk jadi yang berhasil dibuat.
-   Simpan data. Sistem akan otomatis menghitung nilai bahan yang terpakai.

### Alur Kerja (Role: Pemilik)

Pengguna dengan peran **Pemilik** memiliki tugas untuk memantau dan menganalisis.

-   Login ke sistem.
-   Masuk ke menu **Dashboard** untuk melihat ringkasan visual biaya produksi, tren, dan KPI lainnya.
-   Masuk ke menu **Laporan** -> **Laporan Produksi** untuk melihat data mendetail.
-   Gunakan filter untuk melihat data pada rentang tanggal tertentu untuk analisis lebih mendalam.

## 📄 Lisensi

Proyek ini dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).
