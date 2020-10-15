
DROP TABLE IF EXISTS ExhibitAnimal;
DROP TABLE IF EXISTS Exhibit;
DROP TABLE IF EXISTS Animal;
DROP TABLE IF EXISTS Staff;
DROP TABLE IF EXISTS Species;
DROP TABLE IF EXISTS RedListStatus;

-- Create a new Staff Table
CREATE TABLE Staff (
    StaffID int(10) PRIMARY KEY AUTO_INCREMENT,
    FirstName varchar(20) NULL,
    LastName varchar(30) NULL
);

CREATE TABLE IF NOT EXISTS RedListStatus ( 
    RedListStatusID tinyint(2) PRIMARY KEY AUTO_INCREMENT,
    StatusCode char(2) NOT NULL,
    Description varchar(30) NULL
);

-- Create the Species table with check constraints
CREATE TABLE IF NOT EXISTS Species (
    SpeciesID int(10) PRIMARY KEY AUTO_INCREMENT,
    CommonName varchar(50) NOT NULL,
    ScientificName varchar(80) NOT NULL,
    Class varchar(15) NOT NULL,
    TaxonomyID int(10) NOT NULL,
    Diet char(1) NOT NULL,
    Habitat varchar(50) NULL,
    RedListStatusID tinyint(2) NOT NULL,
    CONSTRAINT CK_Species_Diet CHECK (Diet IN ('C', 'H', 'O')),
    CONSTRAINT FOREIGN KEY FK_Species_RedListStatus (RedListStatusID) REFERENCES RedListStatus(RedListStatusID)
);

-- Create the Animal table with a check constraint and Staff foreigh key
CREATE TABLE IF NOT EXISTS Animal (
    AnimalID int(10) PRIMARY KEY AUTO_INCREMENT,
    SpeciesID int(10) NOT NULL,
    StaffID int(10) NULL,
    Name varchar(30) NOT NULL,
    Gender CHAR(1) NOT NULL,
    Origin varchar(50) NOT NULL,
    WeightLbs float(6,2) NULL,
    DateOfBirth date NULL,
    DateOfDeparture date NULL,
    DepartureCirumstances varchar(30) NULL,
    CONSTRAINT CK_Animal_Gender CHECK (Gender IN('M', 'F')),
    CONSTRAINT FK_Animal_Species FOREIGN KEY (SpeciesID) REFERENCES Species(SpeciesID),
    CONSTRAINT FK_Animal_Staff FOREIGN KEY (StaffID) REFERENCES Staff(StaffID)
);

CREATE TABLE IF NOT EXISTS Exhibit (
    ExhibitID int(10) PRIMARY KEY AUTO_INCREMENT,
    ExhibitName varchar(50) NOT NULL,
    ExhibitDescription text NULL,
    StartDate date NULL,
    EndDate date NULL
);

CREATE TABLE IF NOT EXISTS ExhibitAnimal (
    ExhibitID int(10) NOT NULL,
    AnimalID int(10) NOT NULL,
    CONSTRAINT FK_ExhibitAnimal_Exhibit FOREIGN KEY (ExhibitID) REFERENCES Exhibit(ExhibitID),
    CONSTRAINT FK_ExhibitAnimal_Animal FOREIGN KEY (AnimalID) REFERENCES Animal(AnimalID),
    PRIMARY KEY (ExhibitID, AnimalID)
);

INSERT INTO RedListStatus (RedListStatusID, StatusCode, Description)
VALUES
(NULL, 'NE', 'Not Evaluated'),
(NULL, 'DD', 'Data Deficient'),
(NULL, 'LC', 'Least Concern'),
(NULL, 'NT', 'Near Threatened'),
(NULL, 'VU', 'Vulnerable'),
(NULL, 'EN', 'Endangered'),
(NULL, 'CR', 'Critically Endangered'),
(NULL, 'EW', 'Exctinct in the Wild'),
(NULL, 'EX', 'Extinct');


INSERT INTO `Species` (`SpeciesID`, `CommonName`, `ScientificName`, `Class`, `TaxonomyID`, `Diet`, `Habitat`, `RedListStatusID`) 
VALUES 
(NULL, 'Indian Elephant', 'Elephas maximus indicus', 'Mammal', '99487', 'H', 'Tropical', 6),
(NULL, 'Lion', 'Panthera leo', 'Mammal', 9689, 'C', 'Sub-Sahara', 5),
(NULL, 'Tiger', 'Panthera tigris', 'Mammal', 9694, 'C', 'Tropical', 6),
(NULL, 'Groundhog', 'Marmota monax', 'Mammal', 9995, 'O', 'Alpine Meadow', 3),
(NULL, 'Arctic Wolf', 'Canis lupus arctos', 'Mammal', 1320375, 'C', 'Tundra', 3),
(NULL, 'White crested cockatoo', 'Cacatua alba', 'Aves', 141836, 'H', 'Mangrove', 6),
(NULL, 'Common Green Iguana', 'Iguana iguana', 'Reptile', 8517, 'H', 'Rain Forest', 3);

INSERT INTO `Staff` (`StaffID`, `FirstName`, `LastName`) 
VALUES
(NULL, 'Tammy', 'Lee'),
(NULL, 'Han', 'Solo'),
(NULL, 'Leia', 'Organa'),
(NULL, 'Luke', 'Skywalker'),
(NULL, 'Darth', 'Vader');

INSERT INTO `Animal`(`AnimalID`, `SpeciesID`, `StaffID`, `Name`, `Gender`, `Origin`, `WeightLbs`, `DateOfBirth`, `DateOfDeparture`, `DepartureCirumstances`)
VALUES
(NULL, 1, 2, 'George', 'M', 'Rescue', 963, '2018-09-25', NULL, NULL),
(NULL, 2, 2, 'Simba', 'M', 'Zoo birth', 420, '2017-07-17', NULL, NULL),
(NULL, 3, 4, 'Tigra', 'F', 'Rehabilitated', 500, NULL, NULL, NULL),
(NULL, 4, 3, 'Daisy', 'F', 'Zoo birth', 13, '2020-02-13', NULL, NULL),
(NULL, 4, 3, 'Valerian', 'F', 'Zoo birth', 10, '2020-02-13', NULL, NULL),
(NULL, 4, 3, 'Anenome', 'F', 'Zoo birth', 14, '2020-02-13', NULL, NULL),
(NULL, 4, 3, 'Lupine', 'M', 'Zoo birth', 11, '2020-02-13', NULL, NULL),
(NULL, 4, 3, 'Saxifrage', 'M', 'Zoo birth', 12, '2020-02-13', NULL, NULL),
(NULL, 5, 5, 'Bearberry', 'F', 'Rescue', 79, NULL, NULL, NULL),
(NULL, 5, 5, 'Willow', 'F', 'Zoo birth', 79, '2020-05-12', NULL, NULL),
(NULL, 5, 5, 'Moss', 'M', 'Zoo birth', 79, '2020-05-12', NULL, NULL),
(NULL, 5, 5, 'Campion', 'M', 'Zoo birth', 79, '2020-05-12', NULL, NULL),
(NULL, 5, 5, 'Saskatoon', 'F', 'Zoo birth', 79, '2018-11-13', '2019-12-12', 'Breeding program transfer'),
(NULL, 5, 5, 'Labrador', 'M', 'Rescue', 76, NULL, NULL, NULL),
(NULL, 5, 5, 'Pasque', 'M', 'Rehabilitated', 77, NULL, NULL, NULL),
(NULL, 6, 3, 'Melati', 'F', 'Rehabilitated', 1.4, NULL, NULL, NULL),
(NULL, 6, 3, 'Arum', 'M', 'Rehabilitated', 1.7, NULL, NULL, NULL),
(NULL, 6, 3, 'Bulan', 'M', 'Zoo birth', 0.75, '2020-07-25', NULL, NULL),
(NULL, 6, NULL, 'Bangsa', 'M', 'Zoo birth', 1.5, '2019-05-21', NULL, NULL),
(NULL, 6, NULL, 'Puspa', 'F', 'Zoo birth', 1.6, '2019-05-20', NULL, NULL);


INSERT INTO `Exhibit`(`ExhibitID`, `ExhibitName`, `ExhibitDescription`, `StartDate`, `EndDate`)
VALUES
(NULL, 'North American Animals', 'A collection of animals native to North America.', '2020-09-28', '2020-10-28'),
(NULL, 'Tropical Treats', 'Animals you might encounter in a tropical climate.', NULL, NULL);

INSERT INTO `ExhibitAnimal` ( `ExhibitID`, `AnimalID` )
VALUES
(2,3),
(1,4),
(1,7),
(1,8),
(1,9),
(1,10),
(1,11),
(1,13),
(2,1),
(1,15),
(2,16),
(2,17);