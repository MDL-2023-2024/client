SET FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE atelier_theme;
TRUNCATE TABLE vacation;
TRUNCATE TABLE proposer;
TRUNCATE TABLE nuite;
TRUNCATE TABLE inscription_restauration;
TRUNCATE TABLE restauration;
TRUNCATE TABLE inscription_atelier;
TRUNCATE TABLE inscription;
TRUNCATE TABLE hotel;
TRUNCATE TABLE compte;
TRUNCATE TABLE categorie_chambre;
TRUNCATE TABLE atelier;
TRUNCATE TABLE theme;

SET FOREIGN_KEY_CHECKS=1;

-- Insertion dans la table 'theme'
INSERT INTO theme (libelle) VALUES 
('Escrime Classique'), 
('Escrime Moderne'), 
('Techniques d\'Épée'), 
('Histoire de l\'Escrime');

-- Insertion dans la table 'atelier'
INSERT INTO atelier (libelle, nb_places_maxi) VALUES 
('Atelier Découverte', 20), 
('Atelier Avancé', 10), 
('Atelier Compétition', 15), 
('Atelier Histoire', 10);

INSERT INTO categorie_chambre (id, libelle_categorie) VALUES 
(1, 'Simple'), 
(2, 'Double');

-- Insertion dans la table 'hotel'
INSERT INTO hotel (pnom, adresse1, adresse2, cp, ville, tel, mail) VALUES 
('Ibis Styles Lille Centre Gare Beffroi', '172 rue Pierre Mauroy', null, '59000', 'Lille', '0320300054', 'H1384@accor.com'),
('Ibis budget Lile Centre', '10 Rue de Courtrai', null, '59000', 'Lille', '0892683078', 'H5208@accor.com');

-- Insertion dans la table 'proposer'
INSERT INTO proposer (hotel_id, categorie_id, tarif_nuite) VALUES 
(2, 1, 70.0),
(2, 2, 80.0),
(1, 1, 95.0),
(1, 2, 105.0);

-- Insérer dans `atelier_theme`
INSERT INTO atelier_theme (atelier_id, theme_id) VALUES 
(1, 1), -- Lier 'Atelier Découverte' à 'Escrime Classique'
(1, 2), -- Lier 'Atelier Découverte' à 'Escrime Moderne'
(2, 1), -- Lier 'Atelier Avancé' à 'Escrime Classique'
(2, 2); -- Lier 'Atelier Avancé' à 'Escrime Moderne'