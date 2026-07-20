# V1 — MobileMoney

---

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

---
## Tache 3945 — Cote Client 

### Authentification
- [x] AuthController — login(), log(), dashboard(), logout()
- [x] Stockage du client en session
- [x] Routes: /, /auth/log, /auth/logout, /dashboard


### Dashboard
- [x] Solde dynamique du client
- [x] Boutons -> /depot, /retrait, /transfert
- [x] Deconnexion -> /auth/logout



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

---

## Tache 3945 & 3958 — Cote Operateur

### Base
- [x] Tables: prefixes, operateurs
- [x] Tables: operations, type_operation, montant_frais

---

## Tache 3945 — Cote Client (login)

- [x] AuthController — login(), log()
- [x] Routes: /, /auth/log
- [x] Vue: login.php
