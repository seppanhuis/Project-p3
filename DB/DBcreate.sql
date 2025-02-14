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
    Gebruikersnaam     VARCHAR(100)    NOT NULL,
    Wachtwoord         VARCHAR(20)     NOT NULL,
    IsIngelogd         BIT             NOT NULL DEFAULT 0,
    Ingelogd           DATE            NOT NULL,
    Uitgelogd          DATE            NOT NULL,
    IsActief           BIT             NOT NULL DEFAULT 1,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Gebruiker_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;

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
