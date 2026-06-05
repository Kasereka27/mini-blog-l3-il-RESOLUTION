# Évaluation — Mini Blog Laravel / Blade

**Module :** Développement Web avec Laravel
**Niveau :** L3 — Informatique et Logiciels
**Dépôt GitHub :** [Dr-Lab1/mini-blog-l3-il](https://github.com/Dr-Lab1/mini-blog-l3-il)

---

## Mise en place du projet

Avant de commencer l'évaluation, effectuez les étapes suivantes dans l'ordre :

```bash
# 1. Cloner le dépôt GitHub
git clone https://github.com/Dr-Lab1/mini-blog-l3-il.git

# 2. Se déplacer dans le répertoire du projet
cd mini-blog-l3-il

# 3. Installer les dépendances PHP
composer install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé de l'application
php artisan key:generate
```

> Assurez-vous d'avoir **PHP 8.1+**, **Composer** et **Laravel 10+** installés sur votre machine avant de commencer.

---

## Travail à réaliser

### Question 1 — Layouts Blade (racines des deux parties)

Créez deux fichiers root Blade distincts :

- `resources/views/App.blade.php` → pour la **partie publique** du blog
- `resources/views/Dashboard.blade.php` → pour la **partie dashboard** (administration)

Chaque root doit utiliser les directives `@yield` pour définir les zones dynamiques (au minimum : `title`, `content`). Chaque vue enfant devra utiliser `@extends` pour hériter du bon layout et `@section` / `@endsection` pour injecter son contenu dans les zones correspondantes.

**Questions :**

**1. Quelle est la différence entre `@yield('title')` et `@yield('title', 'Valeur par défaut')` ?**
`@yield('title')` affichera un contenu vide si la section 'title' n'est pas définie dans la vue enfant, tandis que `@yield('title', 'Valeur par défaut')` affichera "Valeur par défaut" si la vue enfant ne définit pas de section title.

**2. Pourquoi utilise-t-on `@extends` plutôt que d'inclure le header et le footer manuellement dans chaque fichier de vue ?**
`@extends` permet d'inverser le contrôle (héritage de gabarit) : on définit un squelette global une seule fois dans le layout et on y injecte le contenu de la vue enfant via les sections. C'est plus propre, évite les doublons HTML lourds (comme les ouvertures `<html>`, `<head>`, etc.) et facilite la maintenance.

**3. Comment s'assure-t-on qu'une vue du dashboard n'étende jamais accidentellement le layout public ?**
Il suffit de vérifier la structure appelée par `@extends`. Une vue d'administration appellera `@extends('dashboard')` (ou `@extends('layouts.dashboard')`), alors qu'une vue publique fera `@extends('app')`. Garder les vues bien séparées en sous-dossiers aide aussi.

---

### Question 2 — Assets & Composants de la partie publique

1. Déplacez le fichier `index.css` dans le dossier `public/css/`.
2. Référencez-le dans vos layouts en utilisant la fonction **`asset()`** de Laravel.
3. Créez deux **composants Blade anonymes** :
    - `resources/views/components/header.blade.php`
    - `resources/views/components/footer.blade.php`
4. Incluez ces composants dans le layout public en utilisant la syntaxe `@include()`.

---

### Question 3 — Assets & Composants du dashboard

1. Déplacez le fichier `Dashboard.css` dans le dossier `public/css/`.
2. Référencez-le dans vos layouts en utilisant la fonction **`asset()`**.
3. Créez deux composants Blade pour le dashboard :
    - `resources/views/components/dashboard/topbar.blade.php`
    - `resources/views/components/dashboard/sidebar.blade.php`
4. Incluez ces composants dans `Dashboard.blade.php`.

**Questions :**

**1. Comment rendre la classe `active` d'un lien de la sidebar **dynamique** selon la route courante, en utilisant `request()->routeIs()` ou `Route::currentRouteName()` ?**
On peut ajouter une condition ternaire dans l'attribut class du lien, par exemple : `class="nav-item {{ request()->routeIs('dashboard.articles') ? 'active' : '' }}"`. Si le nom de la route actuelle correspond, la classe `active` est ajoutée.

**2. Pourquoi est-il préférable de placer les composants du dashboard dans un sous-dossier `components/dashboard/` plutôt que directement dans `components/` ?**
Cela permet d'organiser et de séparer logiquement les composants réservés à l'administration de ceux créés pour le site public. Cela évite surtout les conflits de noms (par exemple avoir deux `sidebar.blade.php`, l'une pour l'admin, l'autre pour la vitrine).

---

### Question 4 — Création des routes

Dans le fichier `routes/web.php`, déclarez une route nommée pour chacune des vues suivantes :

**Partie publique :**

| URL                | Nom de la route    | Description          |
| ------------------ | ------------------ | -------------------- |
| `/`                | `home`             | Page d'accueil       |
| `/articles`        | `articles.index`   | Liste des articles   |
| `/articles/{slug}` | `articles.show`    | Détail d'un article  |
| `/categories`      | `categories.index` | Liste des catégories |
| `/about`           | `about`            | Page à propos        |

**Questions :**

**1. Quelle est la différence entre `Route::get()` et `Route::post()` ? Dans quel cas utilise-t-on l'un plutôt que l'autre ?**
`Route::get()` est utilisé pour récupérer et lire des ressources/données depuis le serveur (ex: afficher une page web). `Route::post()` est utilisé pour envoyer des données au serveur pour qu'il les traite (ex: ajouter un record en base via un formulaire).

**2. Comment déclarer et nommer une route avec la méthode `->name()` ? Pourquoi les noms de routes sont-ils indispensables pour utiliser `route()` dans les vues Blade ?**
On le fait en chaînant `->name('mon.nom')` à la définition. Par exemple : `Route::get('/about', [...])->name('about');`. Les noms de routes permettent à la fonction `route()` de générer directement l'URL. Si l'URL physique change dans le fichier web.php, aucune vue Blade utilisant la fonction `route()` n'a besoin d'être modifiée.

**3. Qu'est-ce qu'un paramètre de route dynamique comme `{id}` ? Comment le récupérer dans le contrôleur ?**
C'est un segment variable dans l'URL (qui peut identifier un article précis, par ex). On le récupère simplement en l'ajoutant aux arguments de la méthode du contrôleur : `public function show($id) { ... }`.

**4. Que se passe-t-il si deux routes ont la même URL mais des méthodes HTTP différentes (`GET` et `POST`) ?**
Il n'y a pas de conflit. Laravel identifiera correctement la route à appeler selon le verbe HTTP de la requête (affichera la page avec GET, traitera son formulaire de soumission avec POST).

---

### Question 5 — Groupement des routes du dashboard

Créez un **groupe de routes** pour toutes les pages du dashboard en utilisant `Route::prefix()` et `->group()`.

Toutes les routes du dashboard doivent :

- Avoir le **préfixe d'URL** `/dashboard`
- Avoir le **préfixe de nom** `dashboard.`
- Pointer vers les méthodes de `DashboardController`

Exemple de routes attendues :

| URL                       | Nom de la route        | Méthode du contrôleur |
| ------------------------- | ---------------------- | --------------------- |
| `/dashboard`              | `dashboard.index`      | `index`               |
| `/dashboard/articles`     | `dashboard.articles`   | `articles`            |
| `/dashboard/categories`   | `dashboard.categories` | `categories`          |
| `/dashboard/utilisateurs` | `dashboard.users`      | `users`               |
| `/dashboard/commentaires` | `dashboard.comments`   | `comments`            |
| `/dashboard/reglages`     | `dashboard.settings`   | `settings`            |

**Questions :**

**1. Quelle est la syntaxe complète pour créer un groupe de routes avec un préfixe d'URL et un préfixe de nom en même temps ?**
`Route::prefix('/dashboard')->name('dashboard.')->group(function () { ... });`

**2. Quelle est la différence entre `Route::prefix()` et `Route::middleware()` dans un groupe de routes ?**
`Route::prefix()` regroupe des routes en leur ajoutant un segment d'URL commun au début (ex. ajoute "/dashboard" à toutes). `Route::middleware()`, en revanche, applique des filtres d'interception (comme par exemple la vérification d'authentification ou les droits d'accès) avant de laisser la requête atteindre ces routes.

**3. Qu'est-ce que `Route::resource()` ? Pour quelles ressources (articles, catégories, utilisateurs) serait-il pertinent de l'utiliser et quelles routes génère-t-il automatiquement ?**
`Route::resource('articles', ArticleController::class)` permet de déclarer en une seule ligne l'ensemble des routes CRUD (Create, Read, Update, Delete) standards (ex: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`). C'est optimal pour l'administration des Articles, des Catégories et des Utilisateurs afin d'avoir une convention standardisée de gestion.

---

### Question 6 — Création des contrôleurs

Générez les deux contrôleurs suivants via la commande `php artisan make:controller` :

**`MainController`** — gérera toutes les vues publiques :

- `index()` → vue de la page d'accueil
- `articles()` → vue de la liste des articles
- `article($slug)` → vue du détail d'un article
- `categories()` → vue de la liste des catégories
- `about()` → vue de la page à propos

**`DashboardController`** — gérera toutes les vues du dashboard :

- `index()` → vue principale du dashboard
- `articles()` → vue des articles (admin)
- `categories()` → vue des catégories (admin)
- `users()` → vue des utilisateurs
- `comments()` → vue des commentaires
- `settings()` → vue des réglages

Chaque méthode doit retourner sa vue correspondante avec `return view('...')`.

**Questions :**

**1. Quelle est la commande artisan pour générer un contrôleur ? Quelle option ajouter pour générer directement un **contrôleur de ressource** avec toutes les méthodes CRUD ?**
La commande de base est `php artisan make:controller NomController`. Pour le générer en tant que constructeur de ressources CRUD, on ajoute le flag `--resource` ou `-r` : `php artisan make:controller NomController --resource`.

**2. Quelle est la convention de nommage des méthodes d'un contrôleur de ressource Laravel (`index`, `show`, `create`, `store`, `edit`, `update`, `destroy`) ? À quelle action correspond chacune ?**

- `index` : Afficher la liste / le tableau des ressources
- `create` : Afficher le formulaire de création
- `store` : Enregistrer la nouvelle ressource (soumission POST de create)
- `show` : Récupérer et afficher une seule ressource spécifique
- `edit` : Afficher le formulaire de modification (pré-rempli) d'une ressource
- `update` : Mettre à jour la ressource (soumission PUT/PATCH de edit)
- `destroy` : Supprimer la ressource (soumission DELETE)

**3. Quelle est la différence entre ces trois façons de passer des données à une vue depuis un contrôleur ?**

```php
return view('articles', ['posts' => $posts]);
return view('articles', compact('posts'));
return view('articles')->with('posts', $posts);
```

Dans les trois cas, il n'y a absolument aucune différence d'un point de vue fonctionnel ou de résultat. La variable `$posts` sera transmise à la vue sous le nom de variable `$posts`. Ce sont simplement diverses conventions syntaxiques : un tableau natif PHP clés/valeurs, une fonction native PHP pour créer un tableau depuis une variable (`compact`), et une interface dite "fluent" propre à Laravel (`with`).

---

### Question 7 — Liens et navigation

Sont concernés (liste non exhaustive) :

- Les liens de la navbar publique (Accueil, Articles, Catégories, À propos)
- Les liens de la sidebar du dashboard (Dashboard, Articles, Catégories, Utilisateurs, Commentaires, Réglages)
- Le lien « Voir le blog » dans la topbar du dashboard
- Le lien « Dashboard / Admin » dans le footer public
- Les liens « Voir tout → » sur la page d'accueil
- Les liens sur les cartes d'articles (qui mènent vers le détail d'un article)
- Le breadcrumb sur la page article
- Le bouton « ↗ Voir le blog » dans le dashboard

---

## 📁 Structure de fichiers attendue

À la fin de l'évaluation, votre projet doit respecter l'arborescence suivante :

```
resources/
└── views/
    ├── app.blade.php       ← Layout partie publique
    ├── dashboard.blade.php ← Layout dashboard
    ├── components/
    │   ├── header.blade.php           ← Header public
    │   ├── footer.blade.php           ← Footer public
    │   └── dashboard/
    │       ├── topbar.blade.php       ← Topbar dashboard
    │       └── sidebar.blade.php      ← Sidebar dashboard
    ├── public/                        ← Vues publiques
    │   ├── index.blade.php
    │   ├── articles.blade.php
    │   ├── article.blade.php
    │   ├── categories.blade.php
    │   └── about.blade.php
    └── dashboard/                     ← Vues dashboard
        ├── index.blade.php
        ├── articles.blade.php
        ├── categories.blade.php
        ├── users.blade.php
        ├── comments.blade.php
        └── settings.blade.php

app/
└── Http/
    └── Controllers/
        ├── MainController.php
        └── DashboardController.php

public/
└── css/
    ├── public.css
    └── dashboard.css

routes/
└── web.php
```

---

## Critères d'évaluation

| Critère                                                            | Points     |
| ------------------------------------------------------------------ | ---------- |
| Layouts Blade corrects avec `@extends`, `@yield`, `@section`       | 3 pts      |
| Composants publics (header, footer) fonctionnels avec `asset()`    | 3 pts      |
| Composants dashboard (topbar, sidebar) fonctionnels avec `asset()` | 3 pts      |
| Routes publiques nommées et correctement déclarées                 | 3 pts      |
| Routes dashboard groupées avec préfixe et nommage cohérent         | 3 pts      |
| Contrôleurs créés avec les bonnes méthodes et retours de vues      | 3 pts      |
| Liens Blade partout                                                | 4 pts      |
| Réponses aux questions théoriques                                  | 8 pts      |
| **Total**                                                          | **30 pts** |

---

## Consignes générales

- Le travail est **individuel**.
- Soumettez votre travail en poussant votre code sur un dépôt GitHub **personnel** et en partageant le lien.
- Le dépôt doit contenir un fichier `.env.example` à jour mais **jamais** le fichier `.env` lui-même.
- Toute ressemblance de code entre deux rendus entraînera un **zéro** pour les deux parties concernées.
- Les réponses aux questions théoriques sont à rédiger directement dans ce fichier `README.md`, sous chaque question.

**Bonne évaluation !**
