# V1 — MobileMoney



## Tache 3945 & 3958 — Modeles & Controllers (CRUD)

### Models crees
- [x] OperateurModel (table: operateurs)
- [x] TypeOperationModel (table: type_operation)
- [x] MontantFraisModel (table: montant_frais)
  - [x] getFraisByMontant() — recupere les frais selon le montant
- [x] OperationModel (table: operations)
- [x] ClientModel (table: clients)
  - [x] getClientByNumero() — cherche client par numero

### Controllers crees (CRUD complet)
- [x] OperateurController — index, create, store, show, edit, update, delete
- [x] TypeOperationController — index, create, store, show, edit, update, delete
- [x] MontantFraisController — index, create, store, show, edit, update, delete
- [x] OperationController — index, show, store, edit, update, delete

### Routes CRUD ajoutees
- [x] Routes dans Routes.php


## Tache 3945 — Cote Client 

### Authentification
- [x] AuthController — login(), log(), dashboard(), logout()
- [x] Stockage du client en session
- [x] Routes: /, /auth/log, /auth/logout, /dashboard


### Dashboard
- [x] Solde dynamique du client
- [x] Boutons -> /depot, /retrait, /transfert
- [x] Deconnexion -> /auth/logout

### Historique
- [x] Vue historique operations (client)
- [x] Lister les operations du client connecte
- [x] Filtrer par type (depot, retrait, transfert)
- [x] Afficher date, type, montant, frais

### Vues Operateur
- [x] Vue liste operateurs (index)
- [x] Vue ajouter un operateur (create)
- [x] Vue modifier un operateur (edit)
- [x] Vue detail d'un operateur (show)
- [x] Vue liste type_operation (index)
- [x] Vue ajouter un type_operation (create)
- [x] Vue modifier un type_operation (edit)
- [x] Vue liste montant_frais (index)
- [x] Vue ajouter un montant_frais (create)
- [x] Vue modifier un montant_frais (edit)
- [x] Vue liste operations (index)
- [x] Vue detail d'une operation (show)



## Tache 3958 — Cote Client

### Operations
- [x] Depot (sans frais)
  - [x] depot.php — formulaire (id_client, id_type_operation=1, montant)
  - [x] logique store(): solde += montant
- [x] Retrait (avec frais)
  - [x] retrait.php — formulaire (id_client, id_type_operation=2, montant)
  - [x] logique store(): solde -= montant + frais
- [x] Transfert (avec frais)
  - [x] transfert.php — formulaire (id_client, id_type_operation=3, montant, numero_destinataire)
  - [x] logique store(): solde emetteur -= montant + frais, solde destinataire += montant
- [x] Auto-detection operateur par numero
  - [x] OperateurModel::getOperateurByNumero()

### Routes operations
- [x] GET /depot, /retrait, /transfert
- [x] POST /operations/store


## Tache 3945 & 3958 — Cote Operateur

### Base
- [x] Tables: prefixes, operateurs
- [x] Tables: operations, type_operation, montant_frais

## Tache 3945 — Cote Client (login)

- [x] AuthController — login(), log()
- [x] Routes: /, /auth/log
- [x] Vue: login.php


## Tache 3945 & 3958 — Design

### Bootstrap local
- [x] Copie Bootstrap 5.3.8 (CSS + JS) dans public/assets/
- [x] Copie Bootstrap Icons 1.13.1 (CSS + fonts) dans public/assets/css/fonts/
- [x] Suppression de toutes les dependances CDN

### CSS custom (style.css)
- [x] Variables CSS (couleurs, radius, shadows)
- [x] Navbar gradiente vert
- [x] Cards avec coins arrondis et ombres
- [x] Boutons avec degrades et effets hover
- [x] Input groups stylises
- [x] Tableaux epures avec hover
- [x] Alerts personnalisees (vert/rouge)
- [x] Avatar rond avec initiale doree
- [x] Animations fade-in

### Vues redesignees
- [x] login.php — fond gradiente anime, card glassmorphism
- [x] dashboard.php — navbar, stat cards, actions rapides, tableau transactions
- [x] depot.php — card centree, icone verte, info client
- [x] retrait.php — card centree, icone rouge, theme rouge
- [x] transfert.php — card centree, icone bleue, theme bleu
- [x] solde.php — card degradee verte, solde en gros, design premium


# V2    

## Taches 3945
- [] separation du cote operateur et client
- [] login operateur et client

## Taches 3958
- [x] Commission inter-operateurs
  - [x] Table commission (source, dest, taux)
  - [x] CommissionModel::getTaux()
  - [x] Logique dans store(): frais_base + commission si inter-operateur