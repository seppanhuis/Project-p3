-- ====================================================================
-- Doel: Maak een nieuwe database voor Fitness
-- ====================================================================

-- Verwijder oude database indien deze bestaat
DROP DATABASE IF EXISTS `fitness`;

-- Maak een nieuwe database
CREATE DATABASE `fitness`;

-- Gebruik de nieuwe database
USE `fitness`;

-- ====================================================================
-- Tabel: Gebruiker
-- ====================================================================
CREATE TABLE Gebruiker (
    Id                 INT             NOT NULL AUTO_INCREMENT,
    Voornaam           VARCHAR(50)     NOT NULL,
    Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
    Achternaam         VARCHAR(50)     NOT NULL,
    Gebruikersnaam     VARCHAR(100)    DEFAULT NULL,
    Email              VARCHAR(50)     NOT NULL,
    Wachtwoord         VARCHAR(20)     NOT NULL,
    IsIngelogd         BIT             NOT NULL DEFAULT 0,
    Uitgelogd          DATE            NOT NULL,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Gebruiker_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;

-- ====================================================================
-- Insert: Gebruiker 
-- ====================================================================
INSERT INTO Gebruiker (
    Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Email, Wachtwoord, 
    IsIngelogd, Uitgelogd, Opmerking, DatumAangemaakt, DatumGewijzigd
) VALUES
('John', 'van', 'Doe', 'jdoe', 'johndoe@example.com', 'password123', 
    0, '2025-03-05', 'Active user', 
    NOW(), NOW()),

('Jane', 'de', 'Smith', 'jsmith', 'janesmith@example.com', 'securepassword', 
    0, '2025-03-06', 'Inactive user', 
    NOW(), NOW()),

('Robert', NULL, 'Johnson', 'rjohnson', 'robert.johnson@example.com', 'mysecretpass', 
    1, '2025-03-07', 'Active user, logged in', 
    NOW(), NOW()),

('Alice', 'van', 'Winkel', 'awinkel', 'alicew@example.com', 'alicepassword', 
    0, '2025-03-08', 'New user, active', 
    NOW(), NOW()),

('Michael', NULL, 'Brown', 'mbrown', 'michaelbrown@example.com', 'mikepass', 
    1, '2025-03-09', 'Test user, active', 
    NOW(), NOW());





-- ====================================================================
-- Tabel: Rol
-- ====================================================================
CREATE TABLE Rol (
    Id                 INT             NOT NULL AUTO_INCREMENT,
    GebruikerId        INT             NOT NULL,
    Naam               VARCHAR(100)    NOT NULL,
    IsActief           BIT             NOT NULL DEFAULT 1,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Rol_Id PRIMARY KEY (Id),
    CONSTRAINT FK_Rol_Gebruiker FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;
-- ====================================================================
-- Insert: Rol 
-- ====================================================================
INSERT INTO Rol (
    GebruikerId, Naam, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd
) VALUES
(1, 'Administrator', 1, 'Has full admin rights', NOW(), NOW()),
(2, 'Member', 1, 'Regular user with limited access', NOW(), NOW()),
(3, 'Guest', 1, 'Temporary guest access', NOW(), NOW()),

(4, 'Moderator', 1, 'Can moderate content and user interactions', NOW(), NOW()),
(5, 'Subscriber', 1, 'User with subscription privileges', NOW(), NOW());

-- ====================================================================
-- Tabel: Medewerker
-- ====================================================================
CREATE TABLE Medewerker (
    Id                 INT             NOT NULL AUTO_INCREMENT,
    Voornaam           VARCHAR(50)     NOT NULL,
    Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
    Achternaam         VARCHAR(50)     NOT NULL,
    Nummer             MEDIUMINT       NOT NULL,
    Medewerkersoort    VARCHAR(20)     NOT NULL,
    IsActief           BIT             NOT NULL DEFAULT 1,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Medewerker_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;

-- ====================================================================
-- Tabel: Lid
-- ====================================================================
CREATE TABLE Lid (
    Id                 INT             NOT NULL AUTO_INCREMENT,
    Voornaam           VARCHAR(50)     NOT NULL,
    Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
    Achternaam         VARCHAR(50)     NOT NULL,
    Relatienummer      MEDIUMINT       NOT NULL,
    Mobiel             VARCHAR(20)     NOT NULL,
    Email              VARCHAR(100)    NOT NULL,
    IsActief           BIT             NOT NULL DEFAULT 1,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Lid_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;


-- ====================================================================
-- Tabel: Les
-- ====================================================================
CREATE TABLE Les (
    Id                 INT             NOT NULL AUTO_INCREMENT,
    Naam               VARCHAR(50)     NOT NULL,
    Datum              DATE            NOT NULL,
    Tijd               TIME            NOT NULL,
    MinAantalPersonen  TINYINT          NOT NULL,
    MaxAantalPersonen  TINYINT          NOT NULL,
    Beschikbaarheid    VARCHAR(50)     NOT NULL,
    IsActief           BIT             NOT NULL DEFAULT 1,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Les_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;



-- ====================================================================
-- Tabel: Reservering
-- ====================================================================
CREATE TABLE Reservering (
    Id                 INT             NOT NULL AUTO_INCREMENT,
    Voornaam           VARCHAR(50)     NOT NULL,
    Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
    Achternaam         VARCHAR(50)     NOT NULL,
    Nummer             MEDIUMINT       NOT NULL,
    Datum              DATE            NOT NULL,
    Tijd               TIME            NOT NULL,
    Reserveringstatus  VARCHAR(20)     NOT NULL,
    IsActief           BIT             NOT NULL DEFAULT 1,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Reservering_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;