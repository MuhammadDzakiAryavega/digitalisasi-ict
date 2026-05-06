@extends('layouts.app')

@section('title', $galeri->judul_kegiatan . ' - Unit IT')

@push('styles')
<style>
    :root {
        --primary-blue: #0061ff;
        --secondary-blue: #60efff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --bg-body: #ffffff;
    }

    body { 
        background-color: var(--bg-body);
        color: var(--text-main);
        overflow-x: hidden;
    }

    /* Scroll Progress Bar */
    #scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(to right, var(--primary-blue), var(--secondary-blue));
        z-index: 9999;
        transition: width 0.1s ease;
    }

    /* Animations */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* Header Styling */
    .article-header {
        padding: 4rem 1rem 3rem;
        max-width: 850px;
        margin: 0 auto;
    }

    .category-pill {
        background: rgba(0, 97, 255, 0.08);
        color: var(--primary-blue);
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 2rem;
    }

    .display-title {
        font-weight: 800;
        font-size: clamp(2rem, 5vw, 3.5rem);
        line-height: 1.1;
        letter-spacing: -0.02em;
        margin-bottom: 1.5rem;
    }

    /* Featured Image */
    .image-container {
        max-width: 700px;
        margin: 0 auto 4rem;
        padding: 0 1rem;
    }

    .featured-image {
        width: 100%;
        border-radius: 28px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        object-fit: cover;
        aspect-ratio: 16/9;
    }

    /* Content Body */
    .content-wrapper {
        max-width: 780px;
        margin: 0 auto;
        padding: 0 1.5rem 5rem;
    }

    .article-text {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #334155;
    }

    /* Related Section */
    .related-section {
        background-color: #f8fafc;
        padding: 5rem 0;
        border-top: 1px solid #f1f5f9;
    }

    .card-custom {
        border: none;
        border-radius: 20px;
        transition: transform 0.3s ease;
        background: white;
        padding: 10px;
    }

    .card-custom:hover {
        transform: translateY(-10px);
    }

    .card-custom img {
        border-radius: 15px;
        height: 200px;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div id="scroll-progress"></div>

<article>
    <!-- 1. Header Section -->
    <header class="article-header text-center reveal">
        <span class="category-pill">Dokumentasi Unit IT</span>
        <h1 class="display-title">{{ $galeri->judul_kegiatan }}</h1>
        
        <div class="d-flex justify-content-center align-items-center flex-wrap gap-3 text-muted mb-3">
            <span><i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::parse($galeri->tanggal_kegiatan)->isoFormat('D MMMM Y') }}</span>
            <span class="d-none d-md-block">•</span>
            <span><i class="bi bi-person-circle me-2"></i>Admin IT</span>
        </div>
    </header>

    <!-- 2. Image Section -->
    <div class="image-container reveal">
        @php
            $imageUrl = Str::contains($galeri->thumbnail_url, 'http') 
                        ? $galeri->thumbnail_url 
                        : asset('storage/' . $galeri->thumbnail_url);
        @endphp
        <img src="{{ $imageUrl }}" alt="{{ $galeri->judul_kegiatan }}" class="featured-image shadow-lg">
    </div>

    <!-- 3. Main Content -->
    <div class="content-wrapper">
        <div class="article-text reveal">
            {!! nl2br(e($galeri->deskripsi_singkat)) !!}
        </div>

        <!-- Social Share -->
        <div class="reveal mt-5 d-flex align-items-center justify-content-center gap-3 py-4 border-top border-bottom my-5">
            <span class="text-uppercase fw-bold small text-muted">Bagikan:</span>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($galeri->judul_kegiatan . ' ' . Request::url()) }}" target="_blank" class="btn btn-outline-primary rounded-circle"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" target="_blank" class="btn btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></a>
            <button onclick="copyLink()" class="btn btn-outline-primary rounded-circle"><i class="bi bi-link-45deg"></i></button>
        </div>

        <div class="text-center">
            <a href="{{ route('galeri.index') }}" class="text-muted fw-bold text-decoration-none">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Galeri
            </a>
        </div>
    </div>
</article>

<!-- 4. Suggestion Section -->
@isset($others)
    @if(count($others) > 0)
    <section class="related-section">
        <div class="container">
            <h3 class="fw-bold mb-4 text-center reveal">Kegiatan Lainnya</h3>
            <div class="row g-4">
                @foreach($others as $item)
                <div class="col-md-4 reveal">
                    <a href="{{ route('galeri.show', $item->id_kegiatan) }}" class="text-decoration-none">
                        <div class="card card-custom shadow-sm h-100">
                            <img src="{{ asset('storage/' . $item->thumbnail_url) }}" class="card-img-top" alt="Thumbnail">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-1">{{ Str::limit($item->judul_kegiatan, 50) }}</h6>
                                <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endisset

@endsection

@push('scripts')
<script>
    // 1. Progress Bar Reading
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressEl = document.getElementById("scroll-progress");
        if(progressEl) progressEl.style.width = scrolled + "%";
    });

    // 2. Reveal Animation
    const revealElements = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(el => revealObserver.observe(el));

    // 3. Copy Link Function
    function copyLink() {
        navigator.clipboard.writeText(window.location.href);
        alert("Link berhasil disalin!");
    }
</script>
@endpush