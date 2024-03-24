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
(1, 'Single'), 
(2, 'Double'), 
(3, 'Suite');

-- Insertion dans la table 'compte'
INSERT INTO compte (email, numlicence, password, roles) VALUES 
('participant@example.com', '123456', 'password', 'ROLE_USER'),
('organisateur@example.com', '234567', 'password', 'ROLE_ORGANIZER'),
('intervenant@example.com', '345678', 'password', 'ROLE_SPEAKER'),
('benevole@example.com', '456789', 'password', 'ROLE_VOLUNTEER');

-- Insertion dans la table 'hotel'
INSERT INTO hotel (pnom, adresse1, adresse2, cp, ville, tel, mail) VALUES 
('Hôtel de l\'Épée', '123 rue du Fleuret', 'Bat A', '75001', 'Paris', '0123456789', 'contact@hotelepee.paris'),
('Auberge du Sabre', '456 allée du Sabre', 'Bat B', '75002', 'Paris', '0987654321', 'contact@aubergesabre.paris'),
('Hôtel du Fleuret', '789 voie du Fleuret', '', '75003', 'Paris', '0112233445', 'contact@hotelfleuret.paris');

-- Insertion dans la table 'inscription'
INSERT INTO inscription (compte_id, date_inscription) VALUES 
(1, '2024-07-01 08:00:00'),
(2, '2024-07-01 08:15:00'),
(3, '2024-07-01 08:30:00'),
(4, '2024-07-01 08:45:00');

-- Utilisation de INSERT IGNORE pour éviter les erreurs de doublons
INSERT IGNORE INTO inscription_atelier (inscription_id, atelier_id) VALUES 
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(1, 3),
(2, 4),
(3, 4),
(4, 3);

-- Insertion dans la table 'restauration'
INSERT INTO restauration (date_restauration, type_repas) VALUES 
('2024-07-01 08:00:00', 'Petit-déjeuner'),
('2024-07-01 12:00:00', 'Déjeuner'),
('2024-07-01 19:00:00', 'Dîner');

-- Insertion dans la table 'inscription_restauration'
INSERT INTO inscription_restauration (inscription_id, restauration_id) VALUES 
(1, 1),
(2, 1),
(3, 2),
(4, 2);

-- Insertion dans la table 'nuite'
INSERT INTO nuite (inscription_id, categorie_id, hotel_id, date_nuitee) VALUES 
(1, 1, 1, '2024-07-01 00:00:00'), 
(2, 2, 2, '2024-07-01 00:00:00'), 
(3, 3, 3, '2024-07-01 00:00:00'), 
(4, 1, 1, '2024-07-02 00:00:00');

-- Insertion dans la table 'proposer'
INSERT INTO proposer (hotel_id, categorie_id, tarif_nuite) VALUES 
(1, 1, 80.0),
(2, 2, 150.0),
(3, 3, 200.0);

-- Insertion dans la table 'vacation'
INSERT INTO vacation (atelier_id, dateheure_debut, dateheure_fin) VALUES  
(1, '2024-07-01 09:00:00', '2024-07-01 12:00:00'), 
(1, '2024-07-01 13:00:00', '2024-07-01 17:00:00'), 
(2, '2024-07-02 09:00:00', '2024-07-02 12:00:00'), 
(2, '2024-07-02 13:00:00', '2024-07-02 17:00:00');

-- Insérer dans `atelier_theme`
INSERT INTO atelier_theme (atelier_id, theme_id) VALUES 
(1, 1), -- Lier 'Atelier Découverte' à 'Escrime Classique'
(1, 2), -- Lier 'Atelier Découverte' à 'Escrime Moderne'
(2, 1), -- Lier 'Atelier Avancé' à 'Escrime Classique'
(2, 2); -- Lier 'Atelier Avancé' à 'Escrime Moderne'
