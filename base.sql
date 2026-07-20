CREATE TABLE prefixes(
    id_prefixe INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL
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
    id_clients INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_clients TEXT NOT NULL,
    numero TEXT NOT NULL
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
    FOREIGN KEY (id_operateur) REFERENCES operateurs(id_operateur) ON DELETE CASCADE,
    FOREIGN KEY (id_type_operation) REFERENCES type_operation(id_type_operation) ON DELETE CASCADE,
    FOREIGN KEY (id_client) REFERENCES clients(id_client) ON DELETE CASCADE
);

INSERT INTO prefixes (prefixe) VALUES ('033'), ('034'), ('035'), ('036'), ('037'), ('038'), ('039');