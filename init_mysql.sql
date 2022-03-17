/* -------------------------------------------------------------------------- */
/*                        Schéma de la base de données                        */
/* -------------------------------------------------------------------------- */

DROP DATABASE IF EXISTS daw;

CREATE DATABASE daw;

USE daw;

CREATE TABLE Utilisateur (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  pseudo        VARCHAR(128) NOT NULL UNIQUE,
  email         VARCHAR(128) NOT NULL UNIQUE,
  passHash      VARCHAR(256) NOT NULL,
  imageUrl      VARCHAR(1024),
  dateCreation  DATETIME DEFAULT CURRENT_TIMESTAMP,
  theme         ENUM('CLAIR', 'SOMBRE') NOT NULL DEFAULT 'CLAIR',
  isAdmin       BOOLEAN NOT NULL DEFAULT 0,
  isConnecte    BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE Cours (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  titre             VARCHAR(128) NOT NULL,
  `description`     TEXT,
  imageUrl          VARCHAR(1024),
  tempsMoyen        FLOAT DEFAULT 0,
  niveauRecommandé  ENUM('DEBUTANT', 'INTERMEDIAIRE', 'AVANCE') NOT NULL DEFAULT 'DEBUTANT',
  categorie         ENUM('AUCUNE', 'PROGRAMMATION', 'WEB') NOT NULL DEFAULT 'AUCUNE',
  dateCreation      DATETIME DEFAULT CURRENT_TIMESTAMP,
  `format`          ENUM('DIAPO', 'VIDEO', 'TEXTE') NOT NULL
);

CREATE TABLE CoursDiapo (
  idCours     INT PRIMARY KEY,
  fichierUrl  VARCHAR(1024) NOT NULL,
  CONSTRAINT FK_CoursDiapo_Cours FOREIGN KEY (idCours) REFERENCES Cours(id) ON DELETE CASCADE
);

CREATE TABLE CoursTexte (
  idCours     INT PRIMARY KEY,
  fichierUrl  VARCHAR(1024) NOT NULL,
  CONSTRAINT FK_CoursTexte_Cours FOREIGN KEY (idCours) REFERENCES Cours(id) ON DELETE CASCADE
);

CREATE TABLE CoursVideo (
  idCours INT PRIMARY KEY,
  CONSTRAINT FK_CoursVideo_Cours FOREIGN KEY (idCours) REFERENCES Cours(id) ON DELETE CASCADE
);

CREATE TABLE CoursVideosUrl (
  idCours   INT,
  videoUrl  VARCHAR(1024) NOT NULL,
  ordre     SMALLINT NOT NULL,
  PRIMARY KEY (idCours, videoUrl),
  CONSTRAINT FK_CoursVideosUrl_Cours FOREIGN KEY (idCours) REFERENCES Cours(id) ON DELETE CASCADE
);

CREATE TABLE QCM (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  titre         VARCHAR(128) NOT NULL,
  categorie     ENUM('AUCUNE', 'PROGRAMMATION', 'WEB') NOT NULL DEFAULT 'AUCUNE',
  `description` TEXT,
  dateCreation  DATETIME DEFAULT CURRENT_TIMESTAMP,
  xmlUrl        VARCHAR(1024) NOT NULL
);

CREATE TABLE CoursRecommandeQCM (
  idQCM   INT,
  idCours INT,
  moyMin  FLOAT NOT NULL,
  moyMax  FLOAT NOT NULL,
  PRIMARY KEY (idQCM, idCours),
  CONSTRAINT FK_CoursRecommande_QCM FOREIGN KEY (idQCM) REFERENCES QCM(id) ON DELETE CASCADE,
  CONSTRAINT FK_CoursRecommande_Cours FOREIGN KEY (idCours) REFERENCES Cours(id) ON DELETE CASCADE
);

CREATE TABLE QuestionQCM (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  idQCM     INT,
  question  TEXT NOT NULL,
  `type` ENUM('CHOIX_UNIQUE', 'CHOIX_MULTIPLES', 'SAISIE') NOT NULL,
  CONSTRAINT FK_QuestionQCM_QCM FOREIGN KEY (idQCM) REFERENCES QCM(id) ON DELETE CASCADE
);

CREATE TABLE QuestionChoixUnique (
  idQuestionQCM INT PRIMARY KEY,
  CONSTRAINT FK_QuestionChoixUnique_Parent FOREIGN KEY (idQuestionQCM) REFERENCES QuestionQCM(id) ON DELETE CASCADE
);

CREATE TABLE QuestionChoixMultiples (
  idQuestionQCM INT PRIMARY KEY,
  CONSTRAINT FK_QuestionChoixMultiples_Parent FOREIGN KEY (idQuestionQCM) REFERENCES QuestionQCM(id) ON DELETE CASCADE
);

CREATE TABLE QuestionSaisie (
  idQuestionQCM INT PRIMARY KEY,
  placeholder   TEXT,
  bonneReponse  TEXT,
  points        FLOAT,
  CONSTRAINT FK_QuestionSaisies_Parent FOREIGN KEY (idQuestionQCM) REFERENCES QuestionQCM(id) ON DELETE CASCADE
);

CREATE TABLE ChoixQuestion (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  idQuestion  INT,
  intitule    TEXT,
  isValide    BOOLEAN,
  points      FLOAT,
  CONSTRAINT FK_ChoixQuestion_Question FOREIGN KEY (idQuestion) REFERENCES QuestionQCM(id) ON DELETE CASCADE
);

CREATE TABLE TentativeQCM (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  idQCM               INT,
  moy                 FLOAT,
  pointsActuels       FLOAT,
  isTermine           BOOLEAN,
  dateCommence        DATETIME DEFAULT CURRENT_TIMESTAMP,
  dateTermine         DATETIME,
  numQuestionCourante SMALLINT,
  CONSTRAINT FK_TentativeQCM_QCM FOREIGN KEY (idQCM) REFERENCES QCM(id) ON DELETE CASCADE
);

CREATE TABLE UtilisateurTentativesQCM (
  idTentativeQCM  INT,
  idUtilisateur   INT,
  PRIMARY KEY (idTentativeQCM, idUtilisateur),
  CONSTRAINT FK_UtilisateurTentativesQCM_TentativeQCM FOREIGN KEY (idTentativeQCM) REFERENCES TentativeQCM(id) ON DELETE CASCADE,
  CONSTRAINT FK_UtilisateurTentativesQCM_Utilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(id) ON DELETE CASCADE
);

CREATE TABLE TentativeCours (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  idCours       INT,
  isTermine     BOOLEAN,
  dateCommence  DATETIME DEFAULT CURRENT_TIMESTAMP,
  dateTermine   DATETIME,
  CONSTRAINT FK_TentativeCours_Cours FOREIGN KEY (idCours) REFERENCES Cours(id) ON DELETE CASCADE
);

CREATE TABLE UtilisateurTentativesCours (
  idTentativeCours  INT,
  idUtilisateur     INT,
  PRIMARY KEY (idTentativeCours, idUtilisateur),
  CONSTRAINT FK_UtilisateurTentativesCours_TentativeCours FOREIGN KEY (idTentativeCours) REFERENCES TentativeCours(id) ON DELETE CASCADE,
  CONSTRAINT FK_UtilisateurTentativesCours_Utilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(id) ON DELETE CASCADE
);