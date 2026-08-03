<?php

/**
 * Identitas wilayah yang dipakai section peta di bagian bawah setiap halaman publik.
 *
 * PERIKSA SEBELUM RILIS: alamat dan titik koordinat di bawah adalah nilai awal
 * tingkat kecamatan, bukan hasil pengukuran di lapangan. Samakan dengan alamat
 * resmi kantor kecamatan lewat .env sebelum situs dipublikasikan.
 */
return [
    'nama' => env('KECAMATAN_NAMA', 'Kecamatan Tambaksari'),
    'kota' => env('KECAMATAN_KOTA', 'Kota Surabaya, Jawa Timur'),

    // Isi dengan alamat lengkap kantor kecamatan.
    'alamat' => env('KECAMATAN_ALAMAT', 'Kantor Kecamatan Tambaksari, Kota Surabaya, Jawa Timur'),

    'telepon' => env('KECAMATAN_TELEPON'),

    // Titik tengah wilayah kecamatan, dipakai sebagai penanda peta.
    'lat' => (float) env('KECAMATAN_LAT', -7.2459),
    'lng' => (float) env('KECAMATAN_LNG', 112.7647),

    'zoom' => (int) env('KECAMATAN_ZOOM', 13),

    /*
     * Penyedia peta: 'google' atau 'osm'.
     *
     * Bawaannya Google karena petak petanya berupa gambar biasa sehingga tetap
     * tampil di ponsel lama. Embed OpenStreetMap kini menuntut WebGL dan hanya
     * menampilkan pesan galat di perangkat tanpa dukungan itu — pilih 'osm'
     * hanya bila pengunjung dipastikan memakai peramban modern dan kamu ingin
     * menghindari pelacak pihak ketiga.
     */
    'peta_provider' => env('KECAMATAN_PETA_PROVIDER', 'google'),

    // Setengah lebar kotak peta dalam derajat, khusus mode 'osm'.
    'span_lat' => (float) env('KECAMATAN_SPAN_LAT', 0.032),
    'span_lng' => (float) env('KECAMATAN_SPAN_LNG', 0.042),

    'kelurahan' => [
        'Tambaksari', 'Pacar Kembang', 'Ploso', 'Rangkah', 'Gading',
        'Pacar Keling', 'Dukuh Setro', 'Kapas Madya Baru',
    ],
];
