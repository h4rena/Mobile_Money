# Guide CodeIgniter 4 — Structure, Code, Variables, Fonctions, Import/Export

Ce document couvre la structure d'un projet CodeIgniter 4, avec des exemples concrets : controllers, models, views, routes, variables, fonctions, import/export de classes, et un exemple complet de login.

---

## 1. Structure du projet

```
mon-projet/
├── app/
│   ├── Config/          # Fichiers de configuration (Routes, Database, App...)
│   ├── Controllers/     # Contrôleurs
│   ├── Models/          # Modèles (accès base de données)
│   ├── Views/           # Fichiers de vue (HTML/PHP)
│   ├── Helpers/         # Fonctions utilitaires personnalisées
│   ├── Libraries/       # Classes/services personnalisés
│   ├── Filters/         # Filtres (middlewares) - ex: AuthFilter
│   └── Database/
│       ├── Migrations/
│       └── Seeds/
├── public/
│   └── index.php        # Point d'entrée unique de l'application
├── writable/            # Logs, cache, uploads (doit être accessible en écriture)
├── .env                 # Variables d'environnement
└── composer.json
```

**Règle de placement :** chaque type de fichier va dans son dossier dédié sous `app/`. On ne met jamais de logique métier directement dans `public/index.php`.

---

## 2. Configuration de base (`.env`)

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = ma_base
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

Le fichier `.env` contient les **variables d'environnement**. On y accède via la fonction globale `env()` :

```php
$driver = env('database.default.DBDriver', 'MySQLi'); // valeur par défaut si absente
```

---

## 3. Routes (`app/Config/Routes.php`)

C'est ici qu'on définit **quelle URL appelle quel Controller / quelle méthode**.

```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Route simple vers une méthode
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Route avec paramètre
$routes->get('produit/(:num)', 'Produit::show/$1');

// Groupe de routes protégées par un filtre
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('users', 'Admin\Users::index');
});
```

- `(:num)` = capture un nombre
- `(:segment)` = capture un texte sans slash
- `$1` = référence au 1er groupe capturé

---

## 4. Controllers

### 4.1 Structure de base

Un controller **hérite toujours** de `BaseController` (ou d'un contrôleur parent personnalisé).

```php
<?php

namespace App\Controllers;

use App\Models\ProduitModel; // import du Model

class Produit extends BaseController
{
    // Propriété (variable de classe)
    protected $produitModel;

    // Constructeur : s'exécute à chaque instanciation du controller
    public function __construct()
    {
        $this->produitModel = new ProduitModel();
    }

    // Méthode publique = accessible via une URL
    public function index()
    {
        $data = [
            'title'    => 'Liste des produits',
            'produits' => $this->produitModel->findAll(),
        ];

        return view('produit/index', $data);
    }

    public function show($id)
    {
        $produit = $this->produitModel->find($id);

        if ($produit === null) {
            return redirect()->to('/produit')->with('error', 'Produit introuvable');
        }

        return view('produit/show', ['produit' => $produit]);
    }
}
```

### 4.2 Points clés

| Élément | Rôle |
|---|---|
| `namespace App\Controllers;` | Obligatoire, doit correspondre au dossier |
| `use App\Models\XModel;` | **Import** d'une classe externe (équivalent d'un `include` mais orienté objet) |
| `extends BaseController` | Hérite des fonctions communes (`request`, `response`, helpers...) |
| `protected $x` | Variable de classe accessible dans toutes les méthodes du controller via `$this->x` |
| `public function nomMethode()` | Une méthode publique = une action accessible par une route |

---

## 5. Models

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table            = 'produits';       // nom de la table
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nom', 'prix', 'stock']; // champs modifiables en masse
    protected $returnType       = 'array';           // ou 'object', ou une classe Entity
    protected $useTimestamps    = true;               // gère created_at / updated_at automatiquement

    // Règles de validation (optionnel, utilisées par insert()/update())
    protected $validationRules = [
        'nom'  => 'required|min_length[3]',
        'prix' => 'required|decimal',
    ];

    // Fonction personnalisée en plus des fonctions natives du Model
    public function getProduitsEnStock()
    {
        return $this->where('stock >', 0)->findAll();
    }
}
```

### Fonctions natives héritées de `Model` (les plus utilisées)

```php
$model->find($id);           // trouver par clé primaire
$model->findAll();           // tous les enregistrements
$model->insert($data);       // INSERT (tableau associatif)
$model->update($id, $data);  // UPDATE
$model->delete($id);         // DELETE
$model->where('col', $val)->first(); // requête filtrée
```

---

## 6. Views

Les vues reçoivent les données via un tableau associatif passé à `view()`.

```php
// Dans le controller
return view('produit/index', [
    'title'    => 'Mes produits',
    'produits' => $produits,
]);
```

```php
<!-- app/Views/produit/index.php -->
<h1><?= esc($title) ?></h1>

<ul>
<?php foreach ($produits as $produit): ?>
    <li><?= esc($produit['nom']) ?> - <?= esc($produit['prix']) ?> €</li>
<?php endforeach; ?>
</ul>
```

- `esc()` : fonction qui échappe le HTML (sécurité anti-XSS), **toujours l'utiliser** pour afficher des données utilisateur.
- Les variables du tableau deviennent directement des variables PHP dans la vue (`$title`, `$produits`).

---

## 7. Variables : les différents types

| Type | Exemple | Portée |
|---|---|---|
| Variable locale | `$x = 5;` | Dans la fonction uniquement |
| Propriété de classe | `protected $model;` | Dans toute la classe via `$this->` |
| Variable globale (config) | `env('app.baseURL')` | Partout via fonction |
| Session | `session()->set('user_id', $id);` | Toute la session utilisateur |
| Variable de vue | passée via `view('x', ['y' => $z])` | Dans la vue uniquement |

### Exemple : session

```php
// Écrire en session
session()->set([
    'user_id'    => $user['id'],
    'user_name'  => $user['nom'],
    'isLoggedIn' => true,
]);

// Lire en session
$userId = session()->get('user_id');

// Vérifier
if (session()->get('isLoggedIn')) {
    // ...
}

// Supprimer / déconnexion
session()->remove(['user_id', 'user_name', 'isLoggedIn']);
// ou tout détruire
session()->destroy();
```

---

## 8. Import / Export de classes (namespaces)

CodeIgniter 4 utilise l'autoload PSR-4 via Composer. Pas d'`include`/`require` manuel nécessaire.

```php
// Importer une classe d'un autre dossier de l'app
use App\Models\UserModel;
use App\Libraries\MonService;

// Importer une classe du framework
use CodeIgniter\Model;
use CodeIgniter\Controller;

class MonController extends Controller
{
    public function test()
    {
        $model   = new UserModel();   // classe importée utilisable directement
        $service = new MonService();
    }
}
```

**Créer et utiliser une Library personnalisée :**

```php
<?php
// app/Libraries/MonService.php
namespace App\Libraries;

class MonService
{
    public function calculerTva(float $prixHT): float
    {
        return $prixHT * 1.20;
    }
}
```

```php
// Dans un controller
use App\Libraries\MonService;

$service = new MonService();
$prixTTC = $service->calculerTva(100); // 120.0
```

**Helpers (fonctions globales, pas de classe) :**

```php
<?php
// app/Helpers/mon_helper.php
if (! function_exists('formatPrix')) {
    function formatPrix(float $prix): string
    {
        return number_format($prix, 2, ',', ' ') . ' €';
    }
}
```

```php
// Charger le helper dans un controller
helper('mon_helper');
// ou déclarer $helpers = ['mon_helper']; comme propriété du controller

echo formatPrix(19.9); // "19,90 €"
```

---

## 9. Exemple complet : Login / Authentification

### 9.1 Model utilisateur

```php
<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $allowedFields = ['nom', 'email', 'password'];
    protected $returnType    = 'array';

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}
```

### 9.2 Controller Auth

```php
<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Affiche le formulaire
    public function login()
    {
        return view('auth/login');
    }

    // Traite la soumission du formulaire
    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validation simple
        if (! $this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->findByEmail($email);

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Identifiants invalides');
        }

        // Connexion réussie : on stocke en session
        session()->set([
            'user_id'    => $user['id'],
            'user_nom'   => $user['nom'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
```

### 9.3 Hachage du mot de passe à l'inscription

```php
public function register()
{
    $data = [
        'nom'      => $this->request->getPost('nom'),
        'email'    => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    ];

    $this->userModel->insert($data);

    return redirect()->to('/login')->with('success', 'Compte créé, connectez-vous.');
}
```

### 9.4 Filtre de protection (`app/Filters/AuthFilter.php`)

Un Filter agit comme un **middleware** : il s'exécute avant (ou après) le controller.

```php
<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // rien après par défaut
    }
}
```

Déclaration du filtre dans `app/Config/Filters.php` :

```php
public array $aliases = [
    'auth' => \App\Filters\AuthFilter::class,
];
```

Puis utilisation dans les routes (voir section 3) :

```php
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
});
```

---

## 10. Requêtes SQL directes (Query Builder)

Quand un Model ne suffit pas, on peut utiliser le Query Builder directement :

```php
$db      = \Config\Database::connect();
$builder = $db->table('produits');

$builder->select('id, nom, prix');
$builder->where('stock >', 0);
$builder->orderBy('nom', 'ASC');

$query = $builder->get();
$resultats = $query->getResultArray();
```

---

## 11. Résumé des bonnes pratiques de placement

| Type de code | Où le mettre |
|---|---|
| Logique de route | `app/Config/Routes.php` |
| Logique métier / traitement d'une requête | `app/Controllers/` |
| Accès base de données | `app/Models/` |
| Affichage HTML | `app/Views/` |
| Fonction réutilisable partout (sans état) | `app/Helpers/` |
| Service avec logique complexe réutilisable | `app/Libraries/` |
| Vérification avant d'accéder à une page | `app/Filters/` |
| Configuration (BDD, clés API, etc.) | `.env` + `app/Config/` |

---

## 12. Export CSV

### 12.1 Export simple (sans librairie externe)

```php
<?php
namespace App\Controllers;

use App\Models\ProduitModel;

class Export extends BaseController
{
    public function csv()
    {
        $produitModel = new ProduitModel();
        $produits     = $produitModel->findAll();

        // En-têtes HTTP pour forcer le téléchargement
        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="produits.csv"');

        // fopen sur 'php://output' écrit directement dans la réponse HTTP
        $output = fopen('php://output', 'w');

        // Ligne d'en-tête du CSV
        fputcsv($output, ['ID', 'Nom', 'Prix', 'Stock']);

        foreach ($produits as $produit) {
            fputcsv($output, [
                $produit['id'],
                $produit['nom'],
                $produit['prix'],
                $produit['stock'],
            ]);
        }

        fclose($output);

        return $this->response; // termine la réponse, le fichier CSV part au navigateur
    }
}
```

Route associée :

```php
$routes->get('export/csv', 'Export::csv');
```

### 12.2 Import CSV (upload + insertion en base)

```php
<!-- app/Views/import/form.php -->
<form action="/import/csv" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="file" name="fichier_csv" accept=".csv">
    <button type="submit">Importer</button>
</form>
```

```php
public function importCsv()
{
    $file = $this->request->getFile('fichier_csv');

    if (! $file->isValid()) {
        return redirect()->back()->with('error', 'Fichier invalide');
    }

    $handle    = fopen($file->getTempName(), 'r');
    $enTete    = fgetcsv($handle); // saute la ligne d'en-tête
    $produitModel = new ProduitModel();

    while (($ligne = fgetcsv($handle)) !== false) {
        $produitModel->insert([
            'nom'   => $ligne[0],
            'prix'  => $ligne[1],
            'stock' => $ligne[2],
        ]);
    }

    fclose($handle);

    return redirect()->to('/produit')->with('success', 'Import terminé');
}
```

---

## 13. Export PDF

CodeIgniter 4 n'a pas de générateur PDF intégré : on utilise une librairie externe comme **Dompdf** ou **Mpdf**, installée via Composer.

```bash
composer require dompdf/dompdf
```

```php
<?php
namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\ProduitModel;

class Export extends BaseController
{
    public function pdf()
    {
        $produitModel = new ProduitModel();
        $produits     = $produitModel->findAll();

        // On génère le HTML à partir d'une vue classique
        $html = view('produit/pdf_template', ['produits' => $produits]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 'I' = affichage dans le navigateur, 'D' = téléchargement forcé
        $dompdf->stream('liste_produits.pdf', ['Attachment' => true]);

        return $this->response;
    }
}
```

```php
<!-- app/Views/produit/pdf_template.php -->
<h2>Liste des produits</h2>
<table border="1" cellpadding="5" style="border-collapse: collapse; width:100%;">
    <tr><th>Nom</th><th>Prix</th><th>Stock</th></tr>
    <?php foreach ($produits as $produit): ?>
    <tr>
        <td><?= esc($produit['nom']) ?></td>
        <td><?= esc($produit['prix']) ?> €</td>
        <td><?= esc($produit['stock']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
```

Route :

```php
$routes->get('export/pdf', 'Export::pdf');
```

**Mpdf** fonctionne de façon très similaire (`composer require mpdf/mpdf`), avec `$mpdf = new \Mpdf\Mpdf(); $mpdf->WriteHTML($html); $mpdf->Output('fichier.pdf', 'D');`.

---

## 14. Ce qu'on doit retrouver dans une bonne application / un bon site

Checklist des éléments essentiels, souvent oubliés dans les projets débutants :

### Sécurité
- **CSRF activé** (`app/Config/Filters.php` → filtre `csrf` global) + `<?= csrf_field() ?>` dans chaque formulaire.
- **Validation systématique** des données entrantes (`$this->validate([...])`), jamais confiance aveugle en `$_POST`.
- **Échappement systématique** en sortie (`esc()`) pour éviter les failles XSS.
- **Mots de passe hachés** avec `password_hash()` / vérifiés avec `password_verify()` (jamais en clair, jamais en MD5/SHA1 seul).
- **Requêtes préparées** via Query Builder ou Model (évite les injections SQL) — éviter les requêtes SQL concaténées à la main.
- **Filtres d'authentification/autorisation** sur les routes sensibles (voir section 9.4).
- **HTTPS en production** + cookies de session sécurisés (`secure`, `httponly`).

### Structure et qualité de code
- **Séparation claire** Controller / Model / View (pas de requêtes SQL dans les vues, pas de HTML dans les controllers).
- **Nommage cohérent** (classes en PascalCase, méthodes en camelCase, tables en snake_case).
- **Gestion des erreurs** : try/catch autour des opérations risquées (BDD, fichiers, appels externes), messages d'erreur clairs pour l'utilisateur, logs détaillés pour le développeur (`log_message('error', $e->getMessage());`).
- **Pagination** sur les listes longues (`$model->paginate($perPage)` + `$pager` dans la vue), jamais un `findAll()` brut sur des milliers de lignes.
- **Fichiers de config centralisés** (`.env`, `app/Config/`), aucune valeur sensible codée en dur dans le code.

### Expérience utilisateur
- **Messages flash** après chaque action (`->with('success', ...)`, `->with('error', ...)`) pour confirmer/informer.
- **Formulaires qui gardent les valeurs saisies** en cas d'erreur (`withInput()`).
- **Responsive design** (site utilisable sur mobile).
- **Page 404 / erreurs personnalisées** (`app/Views/errors/`), jamais une erreur PHP brute affichée à l'utilisateur final.
- **Temps de chargement raisonnable** : requêtes optimisées, indexes en base sur les colonnes filtrées/triées.

### Maintenabilité et exploitation
- **Logs applicatifs** (`writable/logs/`) pour tracer les erreurs et actions sensibles.
- **Sauvegardes régulières** de la base de données.
- **Migrations** (`app/Database/Migrations/`) plutôt que modifier la BDD à la main — permet de reproduire la structure sur un autre environnement.
- **Environnements séparés** (`development` / `testing` / `production`) via `CI_ENVIRONMENT`.
- **Tests** (au moins des tests manuels documentés, idéalement des tests automatisés avec PHPUnit).
- **Documentation minimale** : README avec instructions d'installation, variables d'environnement requises, commandes utiles.

---

*Document de référence CodeIgniter 4 — à adapter selon la structure exacte de ton projet.*
