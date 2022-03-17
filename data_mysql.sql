/* -------------------------------------------------------------------------- */
/*                               Données de test                              */
/* -------------------------------------------------------------------------- */

USE daw;

/* ------------------------------ Utilisateurs ------------------------------ */

INSERT INTO Utilisateur VALUES (1, 'user', 'user@user.com', '', 'Jean', 'Dupont', NULL, DEFAULT, 'CLAIR', 0);
INSERT INTO Utilisateur VALUES (2, 'admin', 'admin@admin.com', '', 'Fabrice', 'Pierre', '2.png', DEFAULT, 'SOMBRE', 1);

/* ---------------------------------- Cours --------------------------------- */

INSERT INTO Cours VALUES (1, 'Découvrir C++', 'Découvrir le C++ avec ce cours.', NULL, 10, 'DEBUTANT', 'PROGRAMMATION', DEFAULT, 'DIAPO');
INSERT INTO CoursDiapo VALUES (1, '1.ppt');

INSERT INTO Cours VALUES (2, 'Maîtriser C++', 'Maîtriser le C++ avec ce cours.', NULL, 15, 'INTERMEDIAIRE', 'PROGRAMMATION', DEFAULT, 'TEXTE');
INSERT INTO CoursTexte VALUES (2, '2.pdf');

INSERT INTO Cours VALUES (3, 'Expert C++', 'Devenir expert en C++ avec ce cours.', NULL, 20.5, 'AVANCE', 'PROGRAMMATION', DEFAULT, 'VIDEO');
INSERT INTO CoursVideo VALUES (3);
INSERT INTO CoursVideosUrl VALUES (3, 'https://youtu.be/vLnPwxZdW4Y', 1), (3, 'https://youtu.be/zuegQmMdy8M', 2);

INSERT INTO Cours VALUES (4, 'Découvrir JS', 'Découvrir le JS avec ce cours', '4.png', NULL, 'DEBUTANT', 'WEB', DEFAULT, 'TEXTE');
INSERT INTO CoursTexte VALUES (4, '4.pdf');

/* ----------------------------------- QCM ---------------------------------- */

INSERT INTO QCM VALUES (1, 'QCM C++', 'PROGRAMMATION', 'Testez-vous sur le C++', DEFAULT, '1.xml');
INSERT INTO QuestionQCM VALUES (1, 1, 'Question 1 : blabla... (bonne réponse : oui)', 'CHOIX_UNIQUE');
INSERT INTO QuestionChoixUnique VALUES (1);
INSERT INTO ChoixQuestion VALUES (1, 1, 'oui', 1, 1);
INSERT INTO ChoixQuestion VALUES (2, 1, 'non', 0, 0);
INSERT INTO QuestionQCM VALUES (2, 1, 'Question 2 : blabla... (bonne réponse : 1 et 3)', 'CHOIX_MULTIPLES');
INSERT INTO QuestionChoixMultiples VALUES (2);
INSERT INTO ChoixQuestion VALUES (3, 2, '1', 1, 0.5);
INSERT INTO ChoixQuestion VALUES (4, 2, '2', 0, 0);
INSERT INTO ChoixQuestion VALUES (5, 2, '3', 1, 0.5);

INSERT INTO QCM VALUES (2, 'QCM JS', 'WEB', 'Testez-vous sur le JS', DEFAULT, '2.xml');
INSERT INTO QuestionQCM VALUES (3, 2, 'Question 1 : blabla... (bonne réponse : "test")', 'SAISIE');
INSERT INTO QuestionSaisie VALUES (3, 'Saisir la réponse...', 'test', 1);

INSERT INTO QCM VALUES (3, 'QCM JS (2)', 'WEB', 'Descriptif du QCM...', DEFAULT, '3.xml');

INSERT INTO CoursRecommandeQCM VALUES (1, 1, 0, 9);
INSERT INTO CoursRecommandeQCM VALUES (1, 2, 10, 14);
INSERT INTO CoursRecommandeQCM VALUES (1, 3, 15, 20);
INSERT INTO CoursRecommandeQCM VALUES (2, 4, 0, 20);
INSERT INTO CoursRecommandeQCM VALUES (3, 4, 0, 20);

/* --------------------------- Tentative de cours --------------------------- */

INSERT INTO TentativeCours VALUES (1, 4, 0, DEFAULT, NULL);
INSERT INTO UtilisateurTentativesCours VALUES (1, 1);
INSERT INTO TentativeCours VALUES (2, 1, 1, DEFAULT, '2023-01-01 00:00:00');
INSERT INTO UtilisateurTentativesCours VALUES (2, 1);

/* ---------------------------- Tentative de QCM ---------------------------- */

INSERT INTO TentativeQCM VALUES (1, 2, NULL, 0, 0, DEFAULT, NULL, 0);
INSERT INTO UtilisateurTentativesQCM VALUES (1, 2);
INSERT INTO TentativeQCM VALUES (2, 1, 12, 2, 1, DEFAULT, '2023-01-01 00:00:00', 1);
INSERT INTO UtilisateurTentativesQCM VALUES (2, 2);