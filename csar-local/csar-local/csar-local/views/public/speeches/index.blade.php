@extends('layouts.public')

@section('title', 'Discours Officiels')

@section('content')
<div class="container" style="max-width: 900px; margin: 0 auto;">
    <h1 class="section-title">Discours Officiels</h1>
    <p class="section-subtitle">Messages de la Direction Générale et du Ministère</p>
    <div class="speeches-list" style="display: flex; flex-direction: column; gap: 2rem; margin-top: 2rem;">
        @forelse($speeches as $speech)
        <div class="speech-card" style="display: flex; gap: 2rem; align-items: flex-start; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 1.5rem;">
            @if($speech->portrait)
                <img src="{{ asset('storage/'.$speech->portrait) }}" alt="Portrait" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px;">
            @endif
            <div style="flex: 1;">
                <h2 style="margin: 0 0 0.5rem 0; font-size: 1.25rem; color: #059669;">{{ $speech->title }}</h2>
                <div style="color: #374151; font-weight: 600; margin-bottom: 0.25rem;">{{ $speech->author }}</div>
                <div style="color: #6b7280; font-size: 0.95rem; margin-bottom: 0.5rem;">{{ $speech->date ? \Carbon\Carbon::parse($speech->date)->format('d/m/Y') : '' }}</div>
                @if($speech->excerpt)
                    <blockquote style="font-style: italic; color: #374151; border-left: 4px solid #059669; padding-left: 1rem; margin-bottom: 1rem;">“{{ $speech->excerpt }}”</blockquote>
                @endif
                <a href="{{ route('speech', $speech->id) }}" class="btn btn-primary" style="margin-top: 0.5rem;">Lire le discours complet</a>
            </div>
        </div>
        @empty
        <div style="text-align: center; color: #6b7280; padding: 2rem;">Aucun discours officiel pour le moment.</div>
        @endforelse
    </div>
</div>
@endsection 