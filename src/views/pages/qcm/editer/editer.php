<?php

/**
 * Afficher le formulaire d'édition d'un QCM.
 * @param boolean $isEditMode Formulaire est-il en mode d'édition d'un QCM existant ?
 * @param QCM|null $qcm QCM à éditer, sinon `null` si en mode création.
 * @return void
 */
function afficherFormulaire(bool $isEditMode, QCM $qcm = null)
{
  var_dump($isEditMode);
  var_dump($qcm);
}
