/* -------------------------------------------------------------------------- */
/*                               Données de test                              */
/* -------------------------------------------------------------------------- */

USE daw;

/* ------------------------------ Utilisateurs ------------------------------ */

-- Mot de passe : user
INSERT INTO Utilisateur VALUES (1, 'user', 'user@user.com', '$2y$10$BCgBoDXrwNCxvszH8cBLJOoZSjH0g1j19fRaMeSwiSNY4c3psezOC', NULL, DEFAULT, 'CLAIR', 0, 0);
-- Mot de passe : admin
INSERT INTO Utilisateur VALUES (2, 'admin', 'admin@admin.com', '$2y$10$OjW6AfwmVhbp4azK7OOzcO6cafird2KuKYurMVbrvSeiUmndbsYW6', '2.png', DEFAULT, 'SOMBRE', 1, 0);

/* ---------------------------------- Cours --------------------------------- */

INSERT INTO Cours VALUES (1, 'Découvrir C++', 'Découvrir le C++ avec ce cours.', NULL, 10, 'DEBUTANT', 'LANGAGES', DEFAULT, 'TEXTE');
INSERT INTO CoursTexte VALUES (1, '1.pdf');

INSERT INTO Cours VALUES (2, 'Maîtriser C++', 'Maîtriser le C++ avec ce cours.', NULL, 15, 'INTERMEDIAIRE', 'LANGAGES', DEFAULT, 'TEXTE');
INSERT INTO CoursTexte VALUES (2, '2.pdf');

INSERT INTO Cours VALUES (3, 'Expert C++', 'Devenir expert en C++ avec ce cours.', NULL, 20.5, 'AVANCE', 'LANGAGES', DEFAULT, 'VIDEO');
INSERT INTO CoursVideo VALUES (3);
INSERT INTO CoursVideosUrl VALUES (3, 'https://youtu.be/vLnPwxZdW4Y', 1), (3, 'https://youtu.be/zuegQmMdy8M', 2);

INSERT INTO Cours VALUES (4, 'Découvrir JS', 'Découvrir le JS avec ce cours', '4.png', NULL, 'DEBUTANT', 'WEB', DEFAULT, 'TEXTE');
INSERT INTO CoursTexte VALUES (4, '4.pdf');

/* ----------------------------------- QCM ---------------------------------- */

INSERT INTO QCM VALUES (1, 'QCM C++', 'LANGAGES', 'Testez-vous sur le C++', DEFAULT, '1.xml');
INSERT INTO QuestionQCM VALUES (1, 1, 'Question 1 : blabla... (bonne réponse : oui)', 'CHOIX');
INSERT INTO QuestionChoix VALUES (1, 0);
INSERT INTO ChoixQuestion VALUES (1, 1, 'oui', 1, 1);
INSERT INTO ChoixQuestion VALUES (2, 1, 'non', 0, 0);
INSERT INTO QuestionQCM VALUES (2, 1, 'Question 2 : blabla... (bonne réponse : 1 et 3)', 'CHOIX');
INSERT INTO QuestionChoix VALUES (2, 1);
INSERT INTO ChoixQuestion VALUES (3, 2, '1', 1, 0.5);
INSERT INTO ChoixQuestion VALUES (4, 2, '2', 0, -1);
INSERT INTO ChoixQuestion VALUES (5, 2, '3', 1, 0.5);

INSERT INTO QCM VALUES (2, 'QCM JS', 'WEB', 'Testez-vous sur le JS', DEFAULT, '2.xml');
INSERT INTO QuestionQCM VALUES (3, 2, 'Question 1 : blabla... (bonne réponse : "test")', 'SAISIE');
INSERT INTO QuestionSaisie VALUES (3, 'Saisir la réponse...', 'test', 1);

INSERT INTO QCM VALUES (3, 'QCM JS (RÉEL)', 'WEB', 'Un vrai QCM sur JS', DEFAULT, '3.xml');
INSERT INTO QuestionQCM VALUES (4, 3, 'Quelle est l''année de création de JS ?', 'SAISIE');
INSERT INTO QuestionSaisie VALUES (4, 'Saisir l''année de création...', '1996', 1);
INSERT INTO QuestionQCM VALUES (5, 3, 'Donner la fonction pour afficher dans la console "Bonjour"', 'SAISIE');
INSERT INTO QuestionSaisie VALUES (5, '___.___("Bonjour");', 'console.log("Bonjour");', 2);
INSERT INTO QuestionQCM VALUES (6, 3, 'Quels sont tous les mots-clés pour déclarer une variable ?', 'CHOIX');
INSERT INTO QuestionChoix VALUES (6, 1);
INSERT INTO ChoixQuestion VALUES (6, 6, 'var', 1, 0.5);
INSERT INTO ChoixQuestion VALUES (7, 6, 'set', 0, -0.5);
INSERT INTO ChoixQuestion VALUES (8, 6, 'let', 1, 0.5);
INSERT INTO ChoixQuestion VALUES (9, 6, 'new', 0, -0.5);
INSERT INTO ChoixQuestion VALUES (10, 6, 'const', 1, 0.5);
INSERT INTO QuestionQCM VALUES (7, 3, 'Qu''est-ce qu''une expression ternaire ?', 'CHOIX');
INSERT INTO QuestionChoix VALUES (7, 0);
INSERT INTO ChoixQuestion VALUES (11, 7, 'Un moyen concis d''écrire un if-else', 1, 1);
INSERT INTO ChoixQuestion VALUES (12, 7, 'Un moyen d''appeler trois fonctions en même temps', 0, -1);
INSERT INTO ChoixQuestion VALUES (13, 7, 'Un calcul mathématique impliquant trois variables', 0, -1);

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

INSERT INTO TentativeQCM VALUES (1, 2, NULL, 0, 0, DEFAULT, NULL, NULL);
INSERT INTO UtilisateurTentativesQCM VALUES (1, 2);
INSERT INTO TentativeQCM VALUES (2, 1, 12, 2, 1, DEFAULT, '2023-01-01 00:00:00', NULL);
INSERT INTO UtilisateurTentativesQCM VALUES (2, 2);