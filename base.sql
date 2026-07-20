CREATE TABLE prefixes(
    id_prefixe INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL
);

CREATE TABLE users(
    id_user INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    mot_de_passe TEXT NOT NULL
);

CREATE TABLE operateurs(
    id_operateur INTEGER PRIMARY KEY AUTOINCREMENT,
    id_prefixe INTEGER,
    nom_operateur TEXT NOT NULL,
    FOREIGN KEY (id_prefixe) REFERENCES prefixes(id_prefixe) ON DELETE CASCADE
);

CREATE TABLE type_operation(
    id_type_operation INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE clients(
    id_client INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_client TEXT NOT NULL,
    numero TEXT NOT NULL,
    solde REAL NOT NULL
);

CREATE TABLE montant_frais(
    id_montant_frais INTEGER PRIMARY KEY AUTOINCREMENT,
    montant1 REAL NOT NULL,
    montant2 REAL NOT NULL,
    frais REAL NOT NULL
);


CREATE TABLE operations(
    id_operation INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operateur INTEGER,
    id_type_operation INTEGER,
    id_client INTEGER,
    montant REAL NOT NULL,
    date_operation DATETIME NOT NULL,
    FOREIGN KEY (id_operateur) REFERENCES operateurs(id_operateur) ON DELETE CASCADE,
    FOREIGN KEY (id_type_operation) REFERENCES type_operation(id_type_operation) ON DELETE CASCADE,
    FOREIGN KEY (id_client) REFERENCES clients(id_client) ON DELETE CASCADE
);

CREATE TABLE historique_operations(
    id_historique INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operation INTEGER,
    date_historique DATETIME NOT NULL,
    FOREIGN KEY (id_operation) REFERENCES operations(id_operation) ON DELETE CASCADE
);

INSERT INTO prefixes (prefixe) VALUES
('032'),
('033'),
('034'),
('038');

-- OPERATEURS
INSERT INTO operateurs (id_prefixe, nom_operateur) VALUES
(1, 'Orange Money'),
(2, 'Airtel Money'),
(3, 'Telma Money'),
(4, 'MVola');

INSERT INTO users (email, mot_de_passe) VALUES
('vola@vola.mg', 'mdp1');

-- TYPES D'OPERATION
INSERT INTO type_operation (libelle) VALUES
('Depot'),
('Retrait'),
('Transfert'),
('Paiement'),
('Achat de credit');

-- CLIENTS
INSERT INTO clients (nom_client, numero, solde) VALUES
('Jean Rakoto', '0321234567', 250000),
('Marie Rasoanaivo', '0339876543', 180000),
('Paul Andry', '0341122334', 95000),
('Sarah Randria', '0385566778', 320000),
('Lucas Rakotomalala', '0329988776', 120000),
('Nina Razafindra', '0334455667', 75000);

-- MONTANTS / FRAIS
INSERT INTO montant_frais (montant1, montant2, frais) VALUES
(0, 1000, 50),
(1001, 5000, 100),
(5001, 10000, 250),
(10001, 50000, 500),
(50001, 100000, 1000),
(100001, 500000, 2000);

-- OPERATIONS
INSERT INTO operations (
    id_operateur,
    id_type_operation,
    id_client,
    montant,
    date_operation
) VALUES
(1, 1, 1, 50000, '2026-07-01 09:15:00'),
(4, 3, 1, 20000, '2026-07-02 14:30:00'),
(2, 2, 2, 10000, '2026-07-03 11:00:00'),
(3, 4, 3, 5000, '2026-07-04 16:45:00'),
(4, 5, 4, 2000, '2026-07-05 08:20:00'),
(1, 3, 5, 75000, '2026-07-06 13:10:00'),
(2, 1, 6, 30000, '2026-07-07 17:40:00'),
(3, 2, 2, 25000, '2026-07-08 10:25:00'),
(4, 4, 3, 15000, '2026-07-09 12:00:00'),
(1, 5, 4, 1000, '2026-07-10 18:15:00');