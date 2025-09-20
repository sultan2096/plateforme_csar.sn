@extends('layouts.admin')

@section('title', $speech->title)
@section('page-title', $speech->title)
@section('page-subtitle', $speech->author)

@section('content')
<div class="admin-card">
    <div style="display: flex; align-items: center; gap: 2rem; margin-bottom: 2rem;">
        @if($speech->portrait)
            <img src="{{ asset('storage/'.$speech->portrait) }}" alt="Portrait" style="max-width: 120px; border-radius: 12px;">
        @endif
        <div>
            <h2 style="margin: 0;">{{ $speech->author }}</h2>
            <p style="color: #6b7280; margin: 0;">{{ $speech->date ? \Carbon\Carbon::parse($speech->date)->format('d/m/Y') : '' }}</p>
        </div>
    </div>
    <h3 style="margin-bottom: 1rem;">{{ $speech->title }}</h3>
    @if($speech->excerpt)
        <blockquote style="font-style: italic; color: #374151; border-left: 4px solid #059669; padding-left: 1rem; margin-bottom: 1.5rem;">“{{ $speech->excerpt }}”</blockquote>
    @endif
    <div style="margin-bottom: 2rem; white-space: pre-line; color: #111827;">
        {!! nl2br(e($speech->content)) !!}
    </div>
    <a href="{{ route('admin.speeches.edit', $speech) }}" class="admin-btn">✏️ Modifier</a>
    <a href="{{ route('admin.speeches.index') }}" class="admin-btn-secondary">⬅️ Retour</a>
</div>
@endsection 