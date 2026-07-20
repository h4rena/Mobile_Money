V1

Tache 3945 && 3958
##Cote operateur

Base
    -prefixes valable de l'operateur
        -Table prefixe
        -Table operateurs
    -Creation de type d'operation
        -Table operations
        -Type operation
        -Bareme_frais(Montant1,montant2,frais)
    -situations gain
    -situation compte clients

Suivant -> Créer les vues (operateur/, type_operation/, montant_frais/, operation/)

Cote Client
    Tache 3945
        -login avec numero de telephone
            -routes.php
                -/login
                -/log
            -AuthController.php
                -login()
                -log()
            views:login.php
    Tache 3958
        -operation
            -voir solde
            -faire un depot(automatique) [sans frais]
            -faire un retrait(automatique) [avec frais] [retirer dans le compte]
            -faire un transfer [avec frais ] [retirer dans le compte]
            -hitsorique (a partir de operation)

tache1 de 3958 :
    -Models: OperateurModel, TypeOperationModel, MontantFraisModel, OperationModel
    -Controllers: Operateur, TypeOperation, MontantFrais, Operation (CRUD complet)
    -Routes ajoutées dans Routes.php