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
- [x] separation du cote operateur et client
- [x] login operateur et client

## Taches 3958
- [x] Commission inter-operateurs
  - [x] Table commission (source, dest, taux)
  - [x] CommissionModel::getTaux()
  - [x] Logique dans store(): frais_base + commission si inter-operateur
  - [x] CommissionController — CRUD complet (index, create, store, edit, update, delete)
  - [x] CommissionModel — CRUD + getTaux()
  - [x] Vues commission: index.php, create.php, edit.php
  - [x] Routes commission dans Routes.php

## Refonte UI Operateur — Bootstrap local + style.css
- [x] operateur/login.php — flash messages + lien retour client
- [x] operateur/dashboard.php — Bootstrap local + navbar-vola responsive + avatar
- [x] operateur/situation.php — Bootstrap local + navbar-vola responsive + avatar
- [x] operateur/commission/index.php — navbar-vola responsive + csrf_field
- [x] operateur/commission/create.php — navbar-vola responsive
- [x] operateur/commission/edit.php — navbar-vola responsive
- [x] montant_frais/index.php — Bootstrap local + style.css + navbar-vola
- [x] montant_frais/create.php — Bootstrap local + style.css + input-groups
- [x] montant_frais/edit.php — Bootstrap local + style.css + input-groups
- [x] Organiser vues commission dans operateur/commission/ (index, create, edit)
- [x] OperateurController — passage de $operateur (session) aux vues

## Transfert — Option inclure frais de retrait
- [x] Checkbox "Inclure les frais de retrait" dans transfert.php (cochee par defaut)
- [x] Logique controller: frais = fraisBase + commission si inter-op, fraisBase si meme op
- [x] Validation JS: desactiver checkbox si prefixe destinataire different
- [x] Message "Frais de retrait non applicables en inter-opérateur"
- [x] Condition serveur: inter-op = commission seulement, pas de frais de retrait

## Envoi multiple (meme operateur uniquement)
- [x] Liste dynamique de destinataires dans transfert.php (ajouter/retirer)
- [x] Validation JS: prefixe不同 = erreur + blocage
- [x] Apercu temps reel: "Chaque destinataire recevra X Ar"
- [x] Controller: tableau numero_destinataire[] + validation chaque dest
- [x] Controller: montant / nombre_destinataires
- [x] Controller: verification tous meme operateur que l'expediteur
- [x] Transaction DB: debiter expediteur + crediter chaque destinataire + INSERT operations

## Situation gains — Separation par operateur
- [x] OperateurController: regrouper gains par operateur (gainsParOperateur + totalParOperateur)
- [x] situation.php: une card par operateur avec header + total + sous-table
- [x] Badge total gains par operateur dans le header de chaque card
