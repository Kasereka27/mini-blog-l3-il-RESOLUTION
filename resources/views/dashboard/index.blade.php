@extends('dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Articles publiés</div>
            <div class="stat-value">{{ $stats['posts'] }}</div>
            <div class="stat-change up">Total</div>
        </div>
        <div class="stat-card green">
            <div class="stat-label">Commentaires</div>
            <div class="stat-value">{{ $stats['comments'] }}</div>
            <div class="stat-change">Total</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-label">Utilisateurs</div>
            <div class="stat-value">{{ $stats['users'] }}</div>
            <div class="stat-change up">Total</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-label">Catégories</div>
            <div class="stat-value">{{ $stats['categories'] }}</div>
            <div class="stat-change">Total</div>
        </div>
    </div>

    <div class="dash-grid">
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Articles récents</div>
                <a href="{{ route('dashboard.articles') }}" class="panel-action">Voir tout →</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Auteur</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_articles as $article)
                    <tr>
                        <td class="truncate">{{ $article->title }}</td>
                        <td class="text-muted">{{ $article->category->name }}</td>
                        <td><span class="badge badge-published">{{ $article->user->name }}</span></td>
                        <td class="text-muted">{{ $article->created_at->format('d M. Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center">Aucun article</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Activité récente</div>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-dot green"></div>
                    <div>
                        <div class="activity-text">Nouvel article publié par <strong>Jacklyn Lueilwitz</strong>
                        </div>
                        <div class="activity-time">Il y a 2 heures</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div>
                        <div class="activity-text">Nouveau commentaire sur <strong>Excepturi
                                eligendi...</strong></div>
                        <div class="activity-time">Il y a 4 heures</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot orange"></div>
                    <div>
                        <div class="activity-text">Nouvel utilisateur inscrit : <strong>Mikel Lynch</strong>
                        </div>
                        <div class="activity-time">Il y a 6 heures</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot green"></div>
                    <div>
                        <div class="activity-text">Article modifié par <strong>Dr. Travon Kirlin</strong></div>
                        <div class="activity-time">Hier à 14:32</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div>
                        <div class="activity-text">5 nouveaux commentaires en attente de modération</div>
                        <div class="activity-time">Hier à 09:15</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
