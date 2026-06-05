@extends('dashboard')

@section('content')
        <div class="content">

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon">◇</div>
                    <div class="stat-info">
                        <div class="stat-num">250</div>
                        <div class="stat-lbl">Total</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="color:var(--success)">◈</div>
                    <div class="stat-info">
                        <div class="stat-num">218</div>
                        <div class="stat-lbl">Approuvés</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="color:var(--warning)">◎</div>
                    <div class="stat-info">
                        <div class="stat-num">24</div>
                        <div class="stat-lbl">En attente</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="color:#E74C3C">✕</div>
                    <div class="stat-info">
                        <div class="stat-num">8</div>
                        <div class="stat-lbl">Spam</div>
                    </div>
                </div>
            </div>

            <div class="tabs">
                <button class="tab active">Tous (250)</button>
                <button class="tab">En attente (24)</button>
                <button class="tab">Approuvés (218)</button>
                <button class="tab">Spam (8)</button>
            </div>

            <div class="toolbar">
                <input type="search" class="search-input" placeholder="Rechercher dans les commentaires...">
                <select class="filter">
                    <option>Tous les articles</option>
                </select>
                <button class="btn btn-ghost" style="margin-left:auto">Tout approuver</button>
            </div>

            <div class="comments-list">

                @forelse($comments as $comment)
                <div class="comment-row approved">
                    <div class="c-avatar" style="background:{{ substr(md5($comment->user->id), 0, 7) }};color:#fff">{{ strtoupper(substr($comment->user->name, 0, 2)) }}</div>
                    <div>
                        <div class="c-meta">
                            <span class="c-author">{{ $comment->user->name }}</span>
                            <span class="badge badge-approved">Approuvé</span>
                            <span class="c-date">{{ $comment->created_at->format('d M. Y à H:i') }}</span>
                        </div>
                        <div class="c-article">Sur : <a href="#">{{ $comment->post->title }}</a></div>
                        <div class="c-text" style="margin-top:0.5rem">{{ $comment->content }}</div>
                    </div>
                    <div class="c-actions">
                        <button class="btn btn-success" onclick="openView()">Voir</button>
                        <button class="btn btn-warning">Spam</button>
                        <button class="btn btn-danger">✕</button>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:2rem;">Aucun commentaire.</div>
                @endforelse

            </div>
            
            {{-- <div class="pagination">
                @for($i = 1; $i <= $comments->lastPage(); $i++)
                    <a href="{{ $comments->path() }}?page={{ $i }}" class="page-btn {{ $i == $comments->currentPage() ? "active" : "" }} ">{{ $i }}</a>
                    @endfor
            
            </div> --}}
            <div class="pagination">
                {{-- 1. Bouton Précédent --}}
                @if ($comments->onFirstPage())
                    <span class="page-btn disabled">«</span>
                @else
                    <a href="{{ $comments->previousPageUrl() }}" class="page-btn">«</a>
                @endif

                {{-- 2. Boucle sur les liens de pagination --}}
                @foreach ($comments->linkCollection() as $link)
                    {{-- On ignore les boutons Précédent/Suivant par défaut textuels générés par Laravel --}}
                    @if (!str_contains($link['label'], 'Previous') && !str_contains($link['label'], 'Next'))
                        
                        @if ($link['label'] === '...')
                            {{-- Séparateur trois points --}}
                            <span class="page-btn separator">{{ $link['label'] }}</span>
                        @elseif ($link['active'])
                            {{-- Page active --}}
                            <span class="page-btn active">{{ $link['label'] }}</span>
                        @else
                            {{-- Page cliquable --}}
                            <a href="{{ $link['url'] }}" class="page-btn">{{ $link['label'] }}</a>
                        @endif

                    @endif
                @endforeach

                {{-- 3. Bouton Suivant --}}
                @if ($comments->hasMorePages())
                    <a href="{{ $comments->nextPageUrl() }}" class="page-btn">»</a>
                @else
                    <span class="page-btn disabled">»</span>
                @endif
            </div>
            
        </div>
    </div>

    <!-- VIEW MODAL -->
    <div class="modal-overlay" id="viewModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Détail du commentaire</div>
                <button class="modal-close"
                    onclick="document.getElementById('viewModal').classList.remove('open')">✕</button>
            </div>
            <div class="modal-body">
                <div style="margin-bottom:1.5rem">
                    <div class="info-row"><span class="info-label">Auteur</span><span>Weldon Walter</span></div>
                    <div class="info-row"><span class="info-label">Email</span><span
                            style="color:var(--muted)">luciano.sporer@example.net</span></div>
                    <div class="info-row"><span class="info-label">Article</span><a href="#"
                            style="color:var(--accent);text-decoration:none;font-size:0.85rem">Sed molestiae omnis
                            ratione ea enim ea</a></div>
                    <div class="info-row"><span class="info-label">Date</span><span
                            style="color:var(--muted);font-size:0.85rem">17 avril 2026 à 06:35</span></div>
                    <div class="info-row"><span class="info-label">Statut</span><span class="badge badge-pending">En
                            attente</span></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Contenu du commentaire</label>
                    <textarea class="form-control">Molestiae modi minus molestiae. Perspiciatis blanditiis libero earum quod eos omnis placeat nesciunt ut ut.</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost"
                    onclick="document.getElementById('viewModal').classList.remove('open')">Fermer</button>
                <button class="btn" style="background:transparent;color:#E74C3C;border:1px solid #E74C3C">Marquer
                    spam</button>
                <button class="btn btn-primary">Approuver</button>
            </div>
        </div>
    </div>

    <script>
        function openView() {
            document.getElementById('viewModal').classList.add('open');
        }
        document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => {
            if (e.target === o) o.classList.remove('open');
        }));
        document.querySelectorAll('.tab').forEach(t => t.addEventListener('click', function() {
            document.querySelectorAll('.tab').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
        }));
    </script>
@endsection
