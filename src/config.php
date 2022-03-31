<?php
/* -------------------------------------------------------------------------- */
/*                               Base de données                              */
/* -------------------------------------------------------------------------- */

define("DB_DBMS", "mysql");
define("DB_HOST", "localhost");
define("DB_NAME", "daw");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_DEBUG_MODE", true);

/* -------------------------------------------------------------------------- */
/*                               Chemins d'accès                              */
/* -------------------------------------------------------------------------- */

define("UPLOADS_COURS_IMGS_DIR", dirname(__FILE__) . "/assets/uploads/cours/imgs/");
define("UPLOADS_COURS_DOCS_DIR", dirname(__FILE__) . "/assets/uploads/cours/docs/");
define("UPLOADS_PROFIL_DIR", dirname(__FILE__) . "/assets/uploads/profils/");
define("UPLOADS_QCM_DIR", dirname(__FILE__) . "/assets/uploads/qcm/");
