
    <nav>
        {{-- Lien vers la route 'home' (/) --}}
        <a href="{{ route('home') }}" class="nav-logo">@yield('title', 'Le Blog')</a>

        <ul class="nav-links">
            {{-- Utilisation de la fonction route() avec le nom de vos routes dans web.php --}}
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li><a href="{{ route('articles.index') }}">Articles</a></li>
            <li><a href="{{ route('categories.index') }}">Catégories</a></li>
            <li><a href="{{ route('about') }}" class="active">À propos</a></li>

            {{-- Le dashboard (espace d'administration) --}}
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        </ul>
    </nav>
