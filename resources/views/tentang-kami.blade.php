@extends('v_layouts.app')

@section('title', 'Tentang Kami - Toko Kami')

@section('css')
<style>
    .section-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        position: relative;
    }
    .section-title.left {
        text-align: left;
    }
    .section-title.right {
        text-align: right;
    }
    .section-title.left::after,
    .section-title.right::after {
        content: "";
        position: absolute;
        bottom: -5px;
        width: 60px;
        height: 3px;
        background-color: #e74c3c;
    }
    .section-title.left::after {
        left: 0;
    }
    .section-title.right::after {
        right: 0;
    }

    .section-text, .mission-list, .mission-list li {
        line-height: 1.6;
        margin-bottom: 20px;
        text-align: justify;
    }

    .section-image {
        width: 100%;
        max-width: 300px;
        height: auto;
    }

    .welcome-text {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
    }

    .navbar-brand img {
        max-height: 40px;
    }

    .header-right {
        display: flex;
        align-items: center;
    }

    .header-right .btn {
        margin-left: 10px;
    }

    .divider {
        height: 1px;
        background-color: #ddd;
        margin: 30px 0;
    }

    .mission-list {
        padding-left: 20px;
        list-style-type: disc;
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1200px;
        }
    }

    .mb-50 {
        margin-bottom: 50px;
    }

    .mt-40 {
        margin-top: 40px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .section-title.left,
        .section-title.right {
            text-align: center;
        }

        .section-title.left::after,
        .section-title.right::after {
            left: 50%;
            transform: translateX(-50%);
            right: auto;
        }

        .mission-list {
            padding-left: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- First Section -->
    <h1 class="section-title left">Satu Langkah Kedepan, Toko Kami</h1>

    <div class="row mb-50">
        <div class="col-md-8">
            <p class="section-text">
                <span style="font-weight: bold;">Toko Kami</span> adalah salah satu toko roti terkemuka di Indonesia dengan jaringan cabang yang terus berkembang. Kami melayani berbagai daerah di Indonesia, mulai dari Jabodetabek, Bandung, Surabaya, Lampung, Batam, Pekanbaru, Makassar, Manado, Bali, Solo, Semarang, Balikpapan, hingga Samarinda. Kami akan terus memperluas jangkauan kami untuk mendekatkan produk berkualitas kepada masyarakat di seluruh Indonesia.
            </p>
            <p class="section-text">
                <span style="font-weight: bold;">Toko Kami</span> Berdiri sejak tahun 2025, saat ini Toko Kami dikelola oleh PT. UBSI Jatiwaringin. Kami berkomitmen menghadirkan produk yang sehat, bergizi, dan terjangkau untuk seluruh lapisan masyarakat.
            </p>
        </div>
        <div class="col-md-4 text-center">
            <img src="frontend/img/grocery-store.png" alt="Toko Roti Kami" class="section-image">
        </div>
    </div>

    <!-- Second Section -->
    <div class="divider"></div>

    <!-- Vision and Mission Section -->
    <h2 class="section-title right">Misi dan Visi kami</h2>

    <div class="row mb-50">
        <div class="col-md-4 text-center mb-4 mb-md-0">
            <img src="frontend/img/hacker.png" alt="Produk Toko Kami" class="section-image">
        </div>
        <div class="col-md-8">
            <p class="section-text">
            <span style="font-weight: bold;">Visi</span> kami adalah menjadikan produk Toko Kami sebagai pilihan utama masyarakat Indonesia dalam memenuhi kebutuhan sehari-hari.
            </p>
            <p class="section-text">
                <span style="font-weight: bold;">Misi</span> kami adalah:
            </p>
            <ul class="mission-list">
                <li>Mengembangkan produk berkualitas tinggi, bergizi, dan sehat yang sesuai dengan cita rasa masyarakat Indonesia.</li>
                <li>Terus memperluas jaringan toko agar mudah diakses oleh masyarakat di berbagai daerah.</li>
                <li>Meningkatkan kualitas sumber daya manusia dengan kesejahteraan dan kompetensi yang lebih baik untuk memberikan pelayanan terbaik kepada pelanggan.</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        console.log('Page loaded');
    });
</script>
@endsection
