Réponses Complètes

## Partie 1 — Blade & Layouts

### 1. Différence entre `@yield('title')` et `@yield('title', 'Valeur par défaut')`
- `@yield('title')` affiche le contenu de la section `title` **uniquement si elle est définie** dans la vue enfant.  
- `@yield('title', 'Valeur par défaut')` affiche la section **ou**, si elle n’existe pas, **la valeur par défaut**.  
➡️ Utile pour éviter un titre vide.

### 2. Pourquoi utiliser `@extends` ?
Parce que `@extends` permet :
- d’hériter d’un layout global (header, footer, structure HTML)  
- d’éviter la duplication de code  
- de centraliser la maintenance du template  
➡️ C’est le principe même du templating Blade : DRY (Don’t Repeat Yourself).

---

## Partie 2 — Sidebar & Organisation

### 1. Rendre un lien actif selon la route courante
Exemples :

```php
<li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
```

ou :

```php
<li class="{{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
```

➡️ Cela permet de styliser automatiquement le lien actif.

### 2. Pourquoi mettre les composants du dashboard dans `components/dashboard/` ?
- meilleure organisation  
- séparation claire entre composants généraux et spécifiques au dashboard  
- maintenance facilitée  
- structure plus professionnelle et scalable  

---

## Partie 3 — Routes

### 1. Différence entre `Route::get()` et `Route::post()`
- `GET` : récupérer et afficher des données (pages, formulaires, listes).  
- `POST` : envoyer des données (formulaires, créations, actions sensibles).  
➡️ On utilise `POST` pour toute action modifiant l’état du serveur.

### 2. Déclarer et nommer une route
```php
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
```

Pourquoi les noms sont indispensables ?
- `route('articles.index')` génère automatiquement l’URL  
- évite les URLs en dur  
- facilite les modifications futures

### 3. Paramètre dynamique `{id}`
Déclaration :
```php
Route::get('/article/{id}', [ArticleController::class, 'show']);
```

Récupération dans le contrôleur :
```php
public function show($id)
```

### 4. Deux routes avec la même URL mais méthodes différentes
Elles coexistent sans conflit :  
- `/login` en `GET` → afficher le formulaire  
- `/login` en `POST` → traiter le formulaire  

---

## Partie 4 — Groupes de routes

### 1. Syntaxe complète avec préfixe d’URL + préfixe de nom
```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', ...)->name('dashboard');
});
```

### 2. Différence entre `prefix()` et `middleware()`
- `prefix()` modifie l’URL (ex : `/admin/...`)  
- `middleware()` applique une couche de sécurité ou logique (auth, role, throttle…)

### 3. `Route::resource()`
Génère automatiquement toutes les routes CRUD pour un contrôleur.

Pertinent pour :
- articles  
- catégories  
- utilisateurs  
- tout modèle CRUD classique

Routes générées :
- index  
- create  
- store  
- show  
- edit  
- update  
- destroy  

---

## Partie 5 — Contrôleurs & Vues

### 1. Commande artisan pour générer un contrôleur
- Simple :
```bash
php artisan make:controller ArticleController
```

- Ressource (CRUD complet) :
```bash
php artisan make:controller ArticleController --resource
```

### 2. Convention des méthodes d’un contrôleur de ressource
| Méthode | Action |
|--------|--------|
| index | liste |
| show | afficher un élément |
| create | afficher le formulaire de création |
| store | enregistrer un nouvel élément |
| edit | afficher le formulaire d’édition |
| update | mettre à jour |
| destroy | supprimer |

### 3. Différence entre les trois façons de passer des données
```php
return view('articles', ['posts' => $posts]); // tableau associatif
return view('articles', compact('posts')); // compact() crée ['posts' => $posts]
return view('articles')->with('posts', $posts); // méthode fluide
```

➡️ Les trois font exactement la même chose, seule la syntaxe change.
