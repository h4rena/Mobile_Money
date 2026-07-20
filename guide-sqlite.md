# Guide complet SQLite (sous Ubuntu)

Documentation de référence SQLite : installation, CLI, création de tables, requêtes, jointures, CASE, sous-requêtes, index, transactions, et plus.

---

## 1. Installation sur Ubuntu

```bash
# Client en ligne de commande + bibliothèque
sudo apt update
sudo apt install sqlite3 libsqlite3-dev

# Vérifier la version installée
sqlite3 --version
```

Pour l'utiliser avec PHP (par ex. avec CodeIgniter) :

```bash
sudo apt install php-sqlite3
```

---

## 2. Créer / ouvrir une base et commandes CLI de base

```bash
# Crée le fichier ma_base.db s'il n'existe pas, puis ouvre le shell SQLite
sqlite3 ma_base.db
```

Une fois dans le shell `sqlite3>` :

```sql
.tables                  -- liste des tables
.schema nom_table         -- structure d'une table (SQL de création)
.headers on               -- affiche les noms de colonnes dans les résultats
.mode column              -- affichage en colonnes alignées
.mode csv                 -- affichage/export en CSV
.quit                     -- quitter le shell
.help                     -- liste des commandes .xxx
.databases                -- fichiers de base attachés
.backup nom_fichier.db    -- sauvegarde de la base
```

> Contrairement à MySQL, **SQLite est un fichier unique** (`.db`, `.sqlite`, `.sqlite3`) : pas de serveur à lancer, pas d'utilisateur/mot de passe.

---

## 3. Types de données SQLite

SQLite utilise un typage dynamique ("type affinity") : une colonne accepte en réalité n'importe quel type, mais on déclare une affinité.

| Type déclaré | Affinité | Exemple |
|---|---|---|
| `INTEGER` | Entier | `1`, `42` |
| `REAL` | Nombre flottant | `3.14` |
| `TEXT` | Chaîne de caractères | `'bonjour'` |
| `BLOB` | Données binaires brutes | image, fichier |
| `NUMERIC` | Entier, réel ou date | `19.99`, dates |

Il n'existe pas de type `DATE`/`DATETIME` natif : on stocke en général en `TEXT` (format `'YYYY-MM-DD HH:MM:SS'`), en `INTEGER` (timestamp Unix), ou en `REAL` (jour julien).

---

## 4. Création de tables (`CREATE TABLE`)

```sql
CREATE TABLE users (
    id       INTEGER PRIMARY KEY AUTOINCREMENT,
    nom      TEXT NOT NULL,
    email    TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    age      INTEGER CHECK (age >= 0),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produits (
    id     INTEGER PRIMARY KEY AUTOINCREMENT,
    nom    TEXT NOT NULL,
    prix   REAL NOT NULL DEFAULT 0,
    stock  INTEGER NOT NULL DEFAULT 0
);

-- Table avec clé étrangère (relation)
CREATE TABLE commandes (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id    INTEGER NOT NULL,
    produit_id INTEGER NOT NULL,
    quantite   INTEGER NOT NULL DEFAULT 1,
    date_cmd   TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE RESTRICT
);
```

**Contraintes courantes :**

| Contrainte | Rôle |
|---|---|
| `PRIMARY KEY` | Clé primaire (identifiant unique de la ligne) |
| `AUTOINCREMENT` | Auto-incrémentation (à utiliser avec `INTEGER PRIMARY KEY`) |
| `NOT NULL` | Valeur obligatoire |
| `UNIQUE` | Valeur unique dans la table |
| `DEFAULT` | Valeur par défaut si non fournie |
| `CHECK (...)` | Contrainte de validation personnalisée |
| `FOREIGN KEY ... REFERENCES` | Clé étrangère vers une autre table |

> Important : par défaut SQLite **n'active pas** la vérification des clés étrangères. Il faut l'activer à chaque connexion :
> ```sql
> PRAGMA foreign_keys = ON;
> ```

### Modifier une table existante

```sql
ALTER TABLE produits ADD COLUMN categorie TEXT DEFAULT 'divers';
ALTER TABLE produits RENAME COLUMN categorie TO type;
ALTER TABLE produits RENAME TO articles;
DROP TABLE articles;
```

> SQLite ne permet pas de supprimer directement une colonne dans les vieilles versions ; il faut recréer la table (dans les versions récentes, `ALTER TABLE ... DROP COLUMN` fonctionne).

---

## 5. Insertion (`INSERT`)

```sql
INSERT INTO produits (nom, prix, stock) VALUES ('Clavier', 25.99, 100);

-- Insertion multiple
INSERT INTO produits (nom, prix, stock) VALUES
    ('Souris', 15.50, 200),
    ('Écran', 129.99, 30),
    ('Casque', 45.00, 50);

-- Récupérer l'id généré après un INSERT
SELECT last_insert_rowid();
```

---

## 6. Lecture (`SELECT`)

```sql
SELECT * FROM produits;

SELECT nom, prix FROM produits WHERE prix > 20;

SELECT * FROM produits ORDER BY prix DESC LIMIT 5;

SELECT DISTINCT categorie FROM produits;

-- Recherche partielle
SELECT * FROM produits WHERE nom LIKE '%clav%';

-- Plage de valeurs
SELECT * FROM produits WHERE prix BETWEEN 10 AND 50;

-- Liste de valeurs
SELECT * FROM produits WHERE categorie IN ('informatique', 'audio');

-- Agrégation
SELECT categorie, COUNT(*) AS nb, AVG(prix) AS prix_moyen
FROM produits
GROUP BY categorie
HAVING COUNT(*) > 2;
```

---

## 7. Mise à jour et suppression

```sql
UPDATE produits SET prix = prix * 1.10 WHERE categorie = 'informatique';

DELETE FROM produits WHERE stock = 0;

-- Vider une table sans supprimer sa structure
DELETE FROM produits;
```

---

## 8. `CASE WHEN` (condition dans une requête)

Équivalent SQL d'un `if/else` : utile pour créer une colonne calculée selon une condition.

```sql
SELECT
    nom,
    prix,
    CASE
        WHEN prix < 20  THEN 'Bon marché'
        WHEN prix < 100 THEN 'Prix moyen'
        ELSE 'Cher'
    END AS gamme
FROM produits;
```

**CASE dans un ORDER BY** (tri personnalisé) :

```sql
SELECT * FROM produits
ORDER BY
    CASE
        WHEN stock = 0 THEN 1   -- ruptures de stock en dernier
        ELSE 0
    END,
    nom ASC;
```

**CASE dans un agrégat** (compter selon une condition) :

```sql
SELECT
    COUNT(CASE WHEN stock = 0 THEN 1 END) AS nb_rupture,
    COUNT(CASE WHEN stock > 0 THEN 1 END) AS nb_disponible
FROM produits;
```

---

## 9. Jointures (`JOIN`)

Table d'exemple : `commandes.user_id` → `users.id`, `commandes.produit_id` → `produits.id`.

### INNER JOIN — uniquement les lignes qui correspondent dans les deux tables

```sql
SELECT u.nom AS client, p.nom AS produit, c.quantite
FROM commandes c
INNER JOIN users u    ON c.user_id = u.id
INNER JOIN produits p ON c.produit_id = p.id;
```

### LEFT JOIN — toutes les lignes de la table de gauche, même sans correspondance

```sql
-- Tous les users, même ceux qui n'ont jamais commandé (produit_id sera NULL)
SELECT u.nom, c.id AS commande_id
FROM users u
LEFT JOIN commandes c ON c.user_id = u.id;
```

### Trouver les lignes sans correspondance (anti-join)

```sql
-- Utilisateurs qui n'ont jamais passé de commande
SELECT u.*
FROM users u
LEFT JOIN commandes c ON c.user_id = u.id
WHERE c.id IS NULL;
```

### CROSS JOIN — produit cartésien (toutes les combinaisons)

```sql
SELECT u.nom, p.nom
FROM users u
CROSS JOIN produits p;
```

### Auto-jointure (une table jointe à elle-même)

Exemple : table `employes` avec une colonne `manager_id` référençant `employes.id`.

```sql
SELECT e.nom AS employe, m.nom AS manager
FROM employes e
LEFT JOIN employes m ON e.manager_id = m.id;
```

> SQLite ne supporte pas nativement `RIGHT JOIN` ni `FULL OUTER JOIN` dans les anciennes versions (support ajouté depuis SQLite 3.39, 2022). Si absent, on simule un `RIGHT JOIN` en inversant les tables dans un `LEFT JOIN`, et un `FULL OUTER JOIN` avec un `UNION` de deux `LEFT JOIN`.

```sql
-- Simuler un FULL OUTER JOIN (compatibilité anciennes versions)
SELECT u.nom, c.id
FROM users u LEFT JOIN commandes c ON c.user_id = u.id
UNION
SELECT u.nom, c.id
FROM commandes c LEFT JOIN users u ON c.user_id = u.id;
```

---

## 10. Sous-requêtes (subqueries)

```sql
-- Produits plus chers que la moyenne
SELECT * FROM produits
WHERE prix > (SELECT AVG(prix) FROM produits);

-- Utilisateurs ayant au moins une commande (avec EXISTS)
SELECT * FROM users u
WHERE EXISTS (SELECT 1 FROM commandes c WHERE c.user_id = u.id);

-- Sous-requête comme table (dérivée)
SELECT categorie, total
FROM (
    SELECT categorie, SUM(prix * stock) AS total
    FROM produits
    GROUP BY categorie
) AS totaux
WHERE total > 1000;
```

---

## 11. CTE — `WITH` (requêtes nommées, lisibles)

```sql
WITH ventes_par_produit AS (
    SELECT produit_id, SUM(quantite) AS total_vendu
    FROM commandes
    GROUP BY produit_id
)
SELECT p.nom, v.total_vendu
FROM produits p
JOIN ventes_par_produit v ON v.produit_id = p.id
ORDER BY v.total_vendu DESC;
```

---

## 12. Index

```sql
CREATE INDEX idx_produits_categorie ON produits(categorie);
CREATE UNIQUE INDEX idx_users_email ON users(email);

DROP INDEX idx_produits_categorie;

-- Voir le plan d'exécution d'une requête (vérifier si l'index est utilisé)
EXPLAIN QUERY PLAN
SELECT * FROM produits WHERE categorie = 'informatique';
```

---

## 13. Transactions

Regroupe plusieurs opérations : soit toutes réussissent, soit aucune n'est appliquée.

```sql
BEGIN TRANSACTION;

UPDATE produits SET stock = stock - 1 WHERE id = 3;
INSERT INTO commandes (user_id, produit_id, quantite) VALUES (1, 3, 1);

COMMIT;      -- valide les changements
-- ou
ROLLBACK;    -- annule tout en cas d'erreur
```

---

## 14. Vues (`VIEW`)

Une vue = une requête enregistrée, utilisable comme une table en lecture.

```sql
CREATE VIEW vue_commandes_detail AS
SELECT c.id, u.nom AS client, p.nom AS produit, c.quantite, p.prix * c.quantite AS total
FROM commandes c
JOIN users u    ON c.user_id = u.id
JOIN produits p ON c.produit_id = p.id;

SELECT * FROM vue_commandes_detail WHERE total > 50;

DROP VIEW vue_commandes_detail;
```

---

## 15. Triggers

Un trigger exécute automatiquement une action lors d'un événement (INSERT/UPDATE/DELETE).

```sql
CREATE TRIGGER maj_stock_apres_commande
AFTER INSERT ON commandes
BEGIN
    UPDATE produits
    SET stock = stock - NEW.quantite
    WHERE id = NEW.produit_id;
END;
```

`NEW.colonne` = valeur insérée/modifiée ; `OLD.colonne` = valeur avant modification (utile dans les triggers `UPDATE`/`DELETE`).

---

## 16. Fonctions utiles

```sql
-- Chaînes
SELECT UPPER(nom), LOWER(nom), LENGTH(nom) FROM produits;
SELECT nom || ' - ' || prix || '€' AS affichage FROM produits; -- concaténation

-- Dates
SELECT DATE('now');                  -- date du jour
SELECT DATETIME('now', 'localtime'); -- date + heure locale
SELECT strftime('%Y-%m', date_cmd) AS mois FROM commandes;

-- Mathématiques
SELECT ROUND(prix, 1), ABS(-5), MAX(prix), MIN(prix), SUM(prix) FROM produits;

-- Gestion des NULL
SELECT COALESCE(email, 'non renseigné') FROM users; -- valeur de remplacement si NULL
SELECT IFNULL(stock, 0) FROM produits;
```

---

## 17. Import / Export CSV en ligne de commande

```bash
# Export d'une table entière en CSV
sqlite3 -header -csv ma_base.db "SELECT * FROM produits;" > produits.csv

# Import d'un CSV dans une table existante
sqlite3 ma_base.db
sqlite3> .mode csv
sqlite3> .import --skip 1 produits.csv produits   -- --skip 1 = ignore la ligne d'en-tête
```

---

## 18. Sauvegarde et copie de la base

```bash
# Simple copie du fichier (SQLite = un seul fichier)
cp ma_base.db ma_base_backup.db

# Sauvegarde propre via SQL (évite les problèmes si la base est utilisée en écriture)
sqlite3 ma_base.db ".backup ma_base_backup.db"

# Export complet en script SQL (structure + données), portable
sqlite3 ma_base.db .dump > dump.sql

# Recréer une base depuis un dump SQL
sqlite3 nouvelle_base.db < dump.sql
```

---

## 19. Bonnes pratiques SQLite

- Toujours activer `PRAGMA foreign_keys = ON;` si tu utilises des clés étrangères (désactivé par défaut).
- Utiliser des **transactions** pour les opérations multiples (bien plus rapide et sûr que des `INSERT` un par un).
- Créer des **index** sur les colonnes utilisées dans les `WHERE`, `JOIN`, `ORDER BY` fréquents.
- SQLite convient bien aux applications légères / mono-utilisateur ou faible concurrence ; pour un site à fort trafic avec beaucoup d'écritures simultanées, préférer MySQL/PostgreSQL.
- Toujours faire des **sauvegardes régulières** (`.backup` ou copie du fichier `.db`).
- Utiliser des requêtes préparées (paramètres liés) côté application plutôt que de concaténer des valeurs dans le SQL, pour éviter les injections SQL.

---

*Document de référence SQLite — utilisable en CLI ou intégré dans une application (PHP, Python, etc.).*
