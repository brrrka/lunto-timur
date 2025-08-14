@extends('user.layout.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Sejarah Desa Lunto Timur</h2>

            <div class="row align-items-center"> {{-- align-items-center untuk menengahkan konten secara vertikal --}}
                <div class="col-lg-4 col-md-5 mb-4 mb-md-0 d-flex justify-content-center"> {{-- Flexbox untuk memusatkan gambar di tengah kolom --}}
                    <img src="{{ asset('images/logo_nagari.png') }}" alt="Logo Nagari Guguak Malalo" class="img-fluid" style="max-width: 250px;"> {{-- max-width untuk kontrol ukuran --}}
                </div>

                <div class="col-lg-8 col-md-7">
                    <p class="mb-4">
                        Nagari Lunto Timur merupakan salah satu nagari yang sarat akan nilai sejarah dan budaya di Kota Sawahlunto, Sumatera Barat. Terletak di kawasan perbukitan yang sejuk dan dikelilingi oleh alam yang asri, nagari ini tumbuh dan berkembang seiring perjalanan panjang masyarakat Minangkabau. Sejak masa kolonial, wilayah Lunto Timur telah dikenal sebagai bagian dari daerah tambang batu bara yang penting di Sumatera, menjadikannya saksi bisu dinamika sosial dan ekonomi yang membentuk karakter masyarakatnya.
                    </p>
                </div>
                <div class="mt-4">
                    <p class="mb-4">
                        Meski kini aktivitas pertambangan tidak lagi menjadi sektor utama, semangat gotong royong dan nilai-nilai adat Minangkabau tetap hidup dalam kehidupan sehari-hari masyarakat. Penduduk Lunto Timur sebagian besar bekerja sebagai petani, pedagang, dan pelaku usaha kecil, yang menggambarkan semangat kemandirian dan kebersamaan yang kuat. Seperti halnya nagari-nagari lain di Minangkabau, falsafah "Adat Basandi Syarak, Syarak Basandi Kitabullah" menjadi pijakan dalam menjalani kehidupan, baik dalam bermasyarakat maupun dalam pengambilan keputusan adat. Beragam tradisi dan upacara adat masih dijaga dan dirawat, memperlihatkan kuatnya akar budaya yang diwariskan dari generasi ke generasi.
                    </p>
                    <p class="mb-4">
                        Asal-usul masyarakat Lunto Timur tidak terlepas dari perkembangan awal Kota Sawahlunto sebagai pusat penambangan batu bara pada masa kolonial Belanda. Banyak masyarakat dari nagari-nagari sekitar, termasuk dari Tanah Datar, Solok, dan Lintau, yang bermigrasi ke daerah ini untuk bekerja dan menetap. Lambat laun, komunitas ini membentuk struktur sosial tersendiri, tetap berpegang teguh pada nilai-nilai adat Minangkabau yang mengedepankan musyawarah, gotong royong, dan sopan santun dalam kehidupan sehari-hari.
                    </p>
                    <p class="mb-4">
                        Seperti halnya nagari-nagari lain di Ranah Minang, masyarakat Lunto Timur menjunjung tinggi falsafah "Adat Basandi Syarak, Syarak Basandi Kitabullah". Kehidupan adat berjalan berdampingan dengan nilai-nilai keagamaan, menciptakan harmoni dalam kehidupan bermasyarakat. Fungsi ninik mamak, alim ulama, dan cadiak pandai masih terjaga sebagai pilar kehidupan sosial yang menuntun generasi muda dalam menjaga tradisi dan tata kehidupan nagari.
                    </p>
                    <p class="mb-4">
                        Dalam perjalanan sejarahnya, Lunto Timur mengalami berbagai dinamika, mulai dari masa kejayaan tambang hingga masa transisi ekonomi masyarakat pasca-penurunan aktivitas tambang. Namun, semangat masyarakatnya tetap hidup: mereka bangkit melalui sektor pertanian, perdagangan kecil, dan usaha mandiri yang menjadikan nagari ini tetap bertahan dan berkembang.
                    </p>
                    <p class="mb-4">
                        Kini, Nagari Lunto Timur berdiri sebagai nagari yang tidak hanya menjaga warisan adat dan budaya, tetapi juga terus bergerak mengikuti perkembangan zaman. Dengan semangat kolaborasi antara pemerintah nagari dan masyarakat, Lunto Timur terus membangun infrastruktur, meningkatkan pendidikan, serta memperkuat nilai-nilai kearifan lokal untuk diwariskan kepada generasi mendatang.
                    </p>
                </div>
            </div>
        </div> 
    </section>
@endsection