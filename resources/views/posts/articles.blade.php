@extends('app')

@section('title', 'Articles — Le Blog')
@section('content')

    <div class="page-header">
        <div class="page-tag">Blog</div>
        <h1 class="page-title">Tous les articles</h1>
        <p class="page-count">{{ $stats['posts'] }} articles publiés dans {{ $stats['categories'] }} catégories</p>
    </div>

    <div class="filters-bar">
        <div class="search-wrap">
            <input type="search" placeholder="Rechercher un article...">
        </div>
        <div class="filter-cats">
            <a href="#" class="cat-pill active">Tout</a>
            @foreach($categories as $category)
                <a href="#" class="cat-pill">{{ $category->name }}</a>
            @endforeach
        </div>
        <select class="sort-select">
            <option>Plus récents</option>
            <option>Plus anciens</option>
            <option>Plus commentés</option>
        </select>
    </div>

    <div class="main-layout">
        <div class="articles-col">
            <div class="articles-list">
            @forelse ($articles as $index => $item)
                <a href="{{ route('articles.show', ["slug" => $item->slug]) }}" class="article-item">
                    <div>
                        <div class="ai-cat">{{ $item->category->name }}</div>
                        <div class="ai-title">{{ $item->title }}</div>
                        <div class="ai-excerpt">{{ Str::limit($item->content, 100) }}</div>
                        <div class="ai-meta"><span>{{ $item->user->name }}</span><span>{{ $item->created_at->format('d F Y') }}</span>
                            <span>{{ $item->comment->count() }}
                                commentaires</span></div>
                    </div>
                    <div class="ai-thumb c1">E</div>
                </a>
            @empty
                <div>Pas d'article disponible.</div>
            @endforelse

            </div>
            <div class="pagination">
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <a href="#" class="page-btn">4</a>
                <a href="#" class="page-btn">5</a>
                <a href="#" class="page-btn">→</a>
            </div>
        </div>

        <aside class="sidebar-col">
            <div class="sidebar-block">
                <div class="sidebar-label">Catégories</div>
                @foreach($categories as $category)
                    <a href="#" class="cat-item">{{ $category->name }} <span class="cat-count">{{ $category->articles->count() }} articles</span></a>
                @endforeach
            </div>

            <div class="sidebar-block">
                <div class="sidebar-label">Articles populaires</div>
                <a href="article.html" class="popular-item">
                    <div class="pop-num">01</div>
                    <div>
                        <div class="pop-title">Excepturi eligendi aliquid iste laboriosam</div>
                        <div class="pop-cat">Optio</div>
                    </div>
                </a>
                <a href="article.html" class="popular-item">
                    <div class="pop-num">02</div>
                    <div>
                        <div class="pop-title">Aut repellat ut qui et</div>
                        <div class="pop-cat">Aperiam</div>
                    </div>
                </a>
                <a href="article.html" class="popular-item">
                    <div class="pop-num">03</div>
                    <div>
                        <div class="pop-title">Blanditiis commodi qui iure optio</div>
                        <div class="pop-cat">Dignissimos</div>
                    </div>
                </a>
                <a href="article.html" class="popular-item">
                    <div class="pop-num">04</div>
                    <div>
                        <div class="pop-title">Veritatis ut corrupti minus harum</div>
                        <div class="pop-cat">Optio</div>
                    </div>
                </a>
                <a href="article.html" class="popular-item">
                    <div class="pop-num">05</div>
                    <div>
                        <div class="pop-title">Sed laudantium facilis dolore non sunt</div>
                        <div class="pop-cat">Tenetur</div>
                    </div>
                </a>
            </div>

            <div class="sidebar-block">
                <div class="sidebar-label">Tags</div>
                <div class="tag-cloud">
                    <a href="#" class="tag">Vitae</a>
                    <a href="#" class="tag">Eligendi</a>
                    <a href="#" class="tag">Laboriosam</a>
                    <a href="#" class="tag">Optio</a>
                    <a href="#" class="tag">Soluta</a>
                    <a href="#" class="tag">Repellat</a>
                    <a href="#" class="tag">Blanditiis</a>
                    <a href="#" class="tag">Veniam</a>
                </div>
            </div>
        </aside>
    </div>

@endsection
