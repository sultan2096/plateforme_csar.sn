@extends('layouts.public')

@section('title', 'Missions en images')

@section('content')
<style>
.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border: 2px solid #3b82f6;
}
</style>
<div class="container" style="max-width: 1100px; margin: 0 auto;">
    <h1 class="section-title">Nos Missions en images</h1>
    <p class="section-subtitle">Découvrez les actions, magasins de stockage, livraisons et mobilisations locales du CSAR</p>
    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem; margin-top: 2rem;">
        @forelse($images as $image)
        <a href="{{ asset('storage/'.$image->file) }}" target="_blank" class="gallery-card" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; overflow: hidden; display: flex; flex-direction: column; text-decoration: none; transition: all 0.3s ease; cursor: pointer;">
            <img src="{{ asset('storage/'.$image->file) }}" alt="{{ $image->title }}" style="width: 100%; height: 200px; object-fit: cover;">
            <div style="padding: 1rem; flex: 1; display: flex; flex-direction: column;">
                @if($image->category)
                    <div style="color: #059669; font-size: 0.95rem; font-weight: 600; margin-bottom: 0.25rem;">{{ $image->category }}</div>
                @endif
                @if($image->title)
                    <h2 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; color: #374151;">{{ $image->title }}</h2>
                @endif
                @if($image->description)
                    <div style="color: #6b7280; font-size: 0.95rem; margin-bottom: 0.5rem;">{{ $image->description }}</div>
                @endif
            </div>
        </a>
        @empty
        <div style="text-align: center; color: #6b7280; padding: 2rem;">Aucune image pour le moment.</div>
        @endforelse
    </div>
</div>
@endsection 
        </a>
        @empty
        <div style="text-align: center; color: #6b7280; padding: 2rem;">Aucune image pour le moment.</div>
        @endforelse
    </div>
</div>
@endsection 