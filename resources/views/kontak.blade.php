@extends('v_layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-4">Hubungi Kami</h2>
            <p class="mb-4">Isi dan Kirimkan form dibawah ini untuk mengkontak Kami.</p>

            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="youremail@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">No Hp*</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+628123456789" required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subjek*</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Masukkan subjek pesan" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Pesan*</label>
                    <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter your Message" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>

        <div class="col-md-6">
            <div class="contact-info">
                <h3 class="mb-4">Cari Kami</h3>

                <div class="mb-4">
                    <p><strong>Email:</strong> rhyru9@bsi.ac.id</p>
                    <p><strong>No Hp:</strong> +62 8123456789</p>
                    <p><strong>Alamat:</strong> Jl. Raya Jatiwaringin No.18, RT.009/RW.005, Jaticempaka, Kec. Pd. Gede, Kota Bks, Jawa Barat 17411</p>
                </div>

                <div class="map-container mb-4">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0002341977815!2d106.90800107581508!3d-6.263697693724922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f32af6703c71%3A0xf89cd7f58da5243f!2sUniversitas%20BSI%20Kampus%20Jatiwaringin!5e0!3m2!1sen!2sid!4v1745700622977!5m2!1sen!2sid"
                        width="100%"
                        height="275"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="links">
                    <a href="#" class="d-block mb-2">Universitas Bina Sarana Informatika, Jatiwaringin.</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
