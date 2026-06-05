@extends('app')

@section('title', 'Catégories — Le Blog')

@section('content')
    <div class="page-header">
        <div class="page-tag">Explorer</div>
        <h1 class="page-title">Catégories</h1>
        <p class="page-desc">Parcourez notre contenu organisé en {{ $categories->count() }} thématiques distinctes, chacune explorée avec rigueur
            et passion.</p>
    </div>

    <!-- HERO GRID -->
    <div class="cats-hero">
        @forelse ($categories as $index => $item)
        <a href="#cat-{{ $item->id }}" class="cat-hero-card">
            <div class="ch-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
            <div>
                <div class="ch-name">{{ $item->name }}</div>
                <div class="ch-count">{{ $item->articles->count() }} {{ $item->articles->count() <= 1 ? "article": "articles" }}</div>
                <div class="ch-arrow">→</div>
            </div>
        </a>
        @empty
            <div>Pas de catégories disponible.</div>
        @endforelse
    </div>

    <div class="cats-content">

        <!-- VITAE -->
        @forelse ($categories as $index => $item)
        <div class="cat-section" id="cat-{{ $item->id }}">
            <div class="cat-section-header">
                <div class="cat-section-meta">
                    <div class="cs-tag">Catégorie {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="cs-name">{{ $item->name }}</div>
                    <div class="cs-desc">Articles dans la catégorie {{ $item->name }}</div>
                    <div class="cs-count">{{ $item->articles->count() }} {{ $item->articles->count() <= 1 ? "article publié": "articles publiés" }}</div>
                    <a href="{{ route('articles.index') }}" class="cs-link">Voir tous les articles →</a>
                </div>
                <div class="cat-articles">
                    @forelse($item->articles->take(3) as $article)
                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="ca-card">
                            <div class="ca-title">{{ $article->title }}</div>
                            <div class="ca-meta"><span>{{ $article->user->name }}</span><span>{{ $article->created_at->format('d M Y') }}</span></div>
                        </a>
                    @empty
                        <div class="ca-card">Pas d'articles pour cette catégorie.</div>
                    @endforelse
                </div>
            </div>
        </div>
        @empty
            <div>Pas de catégories disponible.</div>
        @endforelse
    </div>

@endsection
