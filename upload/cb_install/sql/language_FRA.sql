INSERT INTO `{tbl_prefix}languages` (`language_name`, `language_active`, `language_default`, `language_code`)
VALUES ('Français', 'yes', 'no', 'fr');

SET @language_id = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_name_error'), 'Merci d\'entrer un nom pour la publicité');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_more'), 'Rajouter');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_exists_error1'), 'La publicité n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_exists_error2'), 'Erreur : Une publicité avec le même nom existe déjà');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_add_msg'), 'La publicité a été ajouté avec succès');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_update_msg'), 'La publicité a été mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_del_msg'), 'La publicité a été supprimé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_deactive'), 'Désactivée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_active'), 'Activée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placment_delete_msg'), 'Le placement a été supprimé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_err1'), 'Placement existe déjà');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_err2'), 'Merci d\'entrer un nom pour le placement');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_err3'), 'Merci d\'entrer un code pour le placement');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_msg'), 'Le placement a été ajouté');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_exist_error'), 'La catégorie n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_add_msg'), 'La catégorie a été ajoutée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_update_msg'), 'Category a été mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_install_msg'), 'Le plugin a été installé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_no_file_err'), 'Aucun fichier n\'a été trouvé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_file_detail_err'), 'Il manque des informations sur le plugin');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_installed_err'), 'Le plugin est déjà installé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_no_install_err'), 'Le plugin n\'est pas installé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_comment_msg'), 'Le commentaire a été ajouté');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cpass_err'), 'Le mot de passe de confirmation ne correspond pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err'), 'L\'ancien mot de passe est incorrect');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cpass_err1'), 'Le mot de passe de confirmation est incorrect');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_exist_err'), 'Cet utilisateur n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_err'), 'L\'identifiant est vide');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_err2'), 'L\'identifiant est déjà utilisé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err2'), 'Le mot de passe est vide');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_err1'), 'L\'email est vide');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_err2'), 'L\'adresse email n\'est pas valide');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_err3'), 'L\'adresse email est déjà utilisée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err3'), 'Les mots de passes le correspondent pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ban_err'), 'Votre compte est banni, veuillez contacter l\'administrateur du site');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_login_err'), 'Le couple identifiant/mot de passe ne correspond à aucun compte');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sub_msg'), 'Vous êtes à présent inscrit à %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uban_msg'), 'L\'utilisateur a été banni');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_upd_succ_msg'), 'User a été mis à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pof_upd_msg'), 'Le profile a été mis à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_no_ans'), 'Non renseigné');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_fr_msg'), 'La vidéo a été ajouté aux vidéos vedettes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_fr_msg1'), 'La vidéo a été retirée des vidéos vedettes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_act_msg'), 'La vidéo a été activée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_act_msg1'), 'La vidéo a été désactivée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_update_msg'), 'Les détails de la vidéo ont été mis à jours');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_unsub_msg'), 'Désinscription enregistrée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_exist_err'), 'Désolé, cette vidéo n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_forgot_username'), 'Identifiant | Mot de passe oublié');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_vids'), 'Gestion des Vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_fav'), 'Gérer les favoris');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_advance_results'), 'Recherche avancée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'featured'), 'Vedette');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all'), 'Tous');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active'), 'Actif');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'activate'), 'Activer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'deactivate'), 'Désactiver');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'by'), 'par');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cancel'), 'Annuler');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'categories'), 'Catégories');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'category'), 'Catégorie');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channels'), 'Chaînes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comments'), 'Commentaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comment'), 'Commentaire');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'country'), 'Pays');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date'), 'Date');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_added'), 'Date d\'ajout');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete'), 'Supprimer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add'), 'Ajouter');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete_selected'), 'Supprimer la sélection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'duration'), 'Durée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'education'), 'Education');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email'), 'email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'female'), 'Femme');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friends'), 'Amis');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'from'), 'De');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'gender'), 'Genre');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'joined'), 'Inscription');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'location'), 'Localisation');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'login'), 'Connexion');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'logout'), 'Déconnexion');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'male'), 'Homme');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'messages'), 'Messages');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'message'), 'Message');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'minute'), 'minute');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'minutes'), 'minutes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sort_by_most_recent'), 'Plus récent');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_account'), 'Mon Compte');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'next'), 'Suivant');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no'), 'Non');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'optional'), 'optionnel');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'password'), 'Mot de passe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reply'), 'Répondre');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'second'), 'seconde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'seconds'), 'secondes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'send'), 'Envoyer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sent'), 'Envoyé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup'), 'S\'inscrire');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subject'), 'Sujet');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'tags'), 'Mots clés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'to'), 'À');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type'), 'Type');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update'), 'Mettre à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload'), 'Téléverser');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos'), 'Vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'yes'), 'Oui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'previous'), 'Précédent');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rating'), 'Note');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove'), 'Retirer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search'), 'Rechercher');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'services'), 'Services');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscribers'), 'Abonnés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'tag_title'), 'Mots clés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'track_title'), 'Piste audio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'username'), 'Identifiant');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'views'), 'Vues');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mostly_viewed'), 'Plus vues');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_comments'), 'Plus commentées');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_title'), 'Titre');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_desc'), 'Description');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat'), 'Catégories de la vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_msg'), 'Vous pouvez sélectionner jusqu\'à %s catégories');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_allow_comm'), 'Autoriser les commentaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_allow_rating'), 'Autoriser la notation de la vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_embed_opt1'), 'Autoriser la publication sur d\'autres sites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_manage_vdeos'), 'Gestion des Vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_status'), 'Statut');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_view_vdos'), 'Afficher les vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_manage_members_title'), 'Gestion des utilisateurs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_title'), 'User Activation');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_message'), 'Mot de passe oublié');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_recover'), 'Récupérer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_reset'), 'Réinitialiser');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_videos'), 'Vidéos favorites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_username'), 'Identifiant oublié');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all_fields_req'), 'Tous les champs sont nécessaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_allowed_format'), 'Lettres A-Z ou a-z, Nombres 0-9 et Underscores _');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_confirm_pass'), 'Confirmation du mot de passe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_date_of_birth'), 'Date de naissance');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_i_agree_to_the'), 'J\'accepte les  <a href="%s" target="_blank">Conditions d\'utilisation<\/a> et la <a href="%s" target="_blank" >Politique de confidentialité<\/a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_relat_status'), 'Relation');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_user_avatar'), 'Avatar de l\'utilisateur');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_change_email'), 'Change Email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_email_address'), 'Adresse email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_s_channel'), 'Chaîne de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_last_login'), 'Dernière connexion');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_send_message'), 'Envoyer un message');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_add_comment'), 'Commenter');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_err2'), 'Vous ne pouvez pas sélectionner plus de %d catégories');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_logged_in'), 'Vous n\'êtes pas connecté');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_thumb_changed'), 'La vignette par défaut de la vidéo a été changée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_thumb_delete_msg'), 'La vignette de la vidéo a été supprimée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_cat_erro'), 'Cette catégorie existe déjà');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_set_default_ok'), 'La catégorie a été définie par défaut');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_thumb_removed_msg'), 'La catégorie a été définie par défaut');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_files_removed_msg'), 'Les fichiers de la vidéo ont été supprimés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_log_delete_msg'), 'Les logs de la vidéo ont été supprimés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_multi_del_erro'), 'Les vidéos ont été supprimées');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_fav_message'), 'Cette %s a été ajoutée à vos favoris');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'obj_not_exists'), '%s n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'already_fav_message'), 'Cette %s a déjà été ajoutée à vos favoris');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'obj_report_msg'), 'Cette %s a été signalée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'obj_report_err'), 'Vous avez déjà signalé cette %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'today'), 'Aujourd\'hui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'yesterday'), 'Hier');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thisweek'), 'Cette semaine');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lastweek'), 'Semaine dernière');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thismonth'), 'Ce mois');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lastmonth'), 'Mois dernier');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thisyear'), 'Cette année');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lastyear'), 'Année dernière');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'favorites'), 'Favorites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'alltime'), 'Toujours');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'bad_date'), 'Jamais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users_videos'), '%s\'s Videos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_subscribe'), 'Veuillez vous connecter pour vous abonner à %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_avatar_bg_update'), 'L\'avatar et l\'image de fond ont été mises à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_fav_photo_confirm'), 'Êtes-vous sûr de vouloir supprimer cette photo de vos favoris ?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_fav_collection_confirm'), 'Êtes-vous sûr de vouloir supprimer cette collection de vos favoris ?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'fav_remove_msg'), 'La %s a été retirée de vos favoris');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unknown_favorite'), '%s favorite introuvable');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unknown_sender'), 'Le destinataire n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_ban_msg'), 'User block list a été mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_user_ban_msg'), 'No user is banned from your account!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thnx_sharing_msg'), 'Merci d\'avoir partagé cette %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comment_exists'), 'Comment does not exist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_create_playlist'), 'Please login to creat playlists');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'play_list_with_this_name_arlready_exists'), 'La playlist \'%s\' existe déjà');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_playlist_name'), 'Veuillez entrer un nom pour la playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'new_playlist_created'), 'La playlist a été créée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_not_exist'), 'Cette playlist n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_item_not_exist'), 'L\'élément de la playlist n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_item_delete'), 'L\'élément a été retiré de la playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'play_list_updated'), 'Playlist a été mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_permission_del_playlist'), 'You do not have permission to delete the playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_delete_msg'), 'La playlist a été supprimée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_name'), 'Nom de la playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_new_playlist'), 'Créer la Playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'this_already_exist_in_pl'), 'Cette %s existe déjà dans votre playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit_playlist'), 'Editer la Playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_playlist_confirm'), 'Êtes-vous sûr de vouloir supprimer cette playlist ?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users'), 'Utilisateurs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_tpl_has_updated'), 'Email Template a été mis à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_updated'), 'Page a été mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thnx_for_voting'), 'Merci d\'avoir voté');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'level_updated'), 'Level a été mis à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'template_activated'), 'Le thème a été activé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_updated'), 'Language a été mis à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_uninstalled'), 'Le plugin a été désinstallé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'account_details'), 'Détails du compte');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_select_img_file'), 'Veuillez sélectionner une image');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'or'), 'ou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pelase_enter_image_url'), 'Veuillez saisir une URL d\'image');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete_this_img'), 'Supprimer cette image');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remember_me'), 'Se souvenir de moi');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'notifications'), 'Notifications');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlists'), 'Playlists');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_playlists'), 'Gestion des Playlists');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_items'), 'Total d\'éléments');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view'), 'Vue');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_fav_vids'), 'Vous n\'avez aucune vidéo favorite');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_ok'), 'Dernière étape');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_ok_description'), 'Un email de validation viens de vous être envoyé, il contient un lien permettant l\'activation définitive de votre compte.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_ok_description_no_email'), 'Les emails ont été désactivés, veuillez contacter un administrateur pour une activation manuelle de votre compte.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_this'), 'Signaler');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_playlist'), 'Ajouter à la playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_profile'), 'Afficher le profile');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscribe'), 'S\'abonner');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more'), 'Plus');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'link_this_video'), 'Lien de la vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'name'), 'Nom');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'spam'), 'Spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_video'), 'Voir la vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'info'), 'Info');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'time_ago'), 'Il y a %s %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'from_now'), 'Depuis %s %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'viewed'), 'Vue');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sort_by_top_rated'), 'Mieux noté');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'searching_keyword_in_obj'), 'Recherche de \'%s\' dans %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_results_found'), 'Aucun résultat disponible');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_val_bw_min_max'), 'Le champ \'%s\' doit avoir une taille comprise entre \'%s\' et \'%s\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'inapp_content'), 'Contenu inapproprié');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'copyright_infring'), 'Violation de copyright');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sexual_content'), 'Contenu à caractère sexuel');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'violence_replusive_content'), 'Contenu violent');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'disturbing'), 'Contenu troublant');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'other'), 'Autre');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'failed'), 'Echec');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_file'), 'Téléverser un fichier');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_featured'), 'La photo a été ajoutée aux photos vedettes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_unfeatured'), 'La photo a été retirée des photos vedettes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_photos'), 'Vous n\'avez aucune photo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_fav_photos'), 'Vous n\'avez aucune photo favorites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_favorite_photos'), 'Gestion des Photos favorites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_photos'), 'Gestion des photos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_not_exist'), 'Cette collection n\'existe pas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_collections'), 'Gestion des collections');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_categories'), 'Gestion des Categories');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_collection'), 'Création d\'une collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'selected_items_removed'), 'Les %s sélectionnées ont été retirées');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection'), 'Collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo'), 'Photo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video'), 'vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photos'), 'Photos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_success_heading'), 'La collection de photo a été mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'share_embed'), 'Partager \/ Intégrer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'item_added_in_collection'), 'La %s a été ajoutée à la collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'object_exists_collection'), 'La %s fait déjà partie de la collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_deleted'), 'La collection a été supprimée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'related_videos'), 'Vidéos similaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_basic_info'), 'Informations basiques');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unsubscribe'), 'Se désabonner');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_have_already_voted_channel'), 'Vous avez déjà voté pour cette chaîne');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_activity'), 'Activités de l\'utilisateur');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_type'), 'Type de collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_my_collection'), 'Ajouter à une collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_rate_own_video'), 'Vous ne pouvez voter pour vos propres vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cannot_rate_own_photo'), 'Vous ne pouvez voter pour vos propres photos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_uploaded_new_video'), '%s a mis en ligne une nouvelle vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_photo'), 'Voir la photo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_created_new_collection'), '%s a créé une nouvelle collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_collection'), 'Voir la collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'share_this_type'), 'Partager cette %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'seperate_usernames_with_comma'), 'Séparer les identifiants par des virgules');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_as_friend'), 'Ajouter comme amis');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_item_was_selected_to_delete'), 'Aucun élement n\'a été sélectionné pour le retrait');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlist_was_selected_to_delete'), 'Veuillez sélectionner une playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'featured_videos'), 'Vidéos Vedettes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'recent_videos'), 'Vidéos Récentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'load_more'), 'Charger plus');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlists'), 'Aucune playlist disponible');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to'), 'Ajouter à');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_my_favorites'), 'Ajouter aux favoris');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_select_playlist'), 'Veuillez sélectionner une playlist ci-dessous');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_new_playlist'), 'Créer une nouvelle playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_playlist'), 'Sélectionner une playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_video'), 'Signaler la vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comment_as'), 'Commenter en tant que');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_cover'), 'Mettre à jour la couverture');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unfriend'), 'Retirer des amis');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'accept_request'), 'Accepter la demande');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'online'), 'En ligne');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'offline'), 'Hors ligne');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_video'), 'Téléverser une vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_photo'), 'Téléverser une photo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'admin_area'), 'Administration');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_channels'), 'Voir les chaînes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_channel'), 'Ma chaîne');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_videos'), 'Gestion des Vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cancel_request'), 'Annuler la demande');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_featured_videos_found'), 'Aucune vidéo vedette disponible');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_recent_videos_found'), 'Aucune vidéo récente disponible');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_new_collection_btn'), 'Créer une nouvelle collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_videos_found'), 'Aucune vidéo trouvée !');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'latest_videos'), 'Dernières vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'since'), 'Depuis');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'last_Login'), 'Dernière connexion');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_friends_in_list'), 'Vous n\'avez aucun amis ajouté');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_pending_friend'), 'Aucune demande d\'amis en attente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'back_to_collection'), 'Retour aux collections');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'public'), 'Public');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'private'), 'Privée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'drag_drop'), 'Glissez & déposez vos fichiers ici');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'popular_videos'), 'Vidéos populaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_photos_found'), 'Aucune photo trouvée !');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search_keyword_feed'), 'Rechercher');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contacts_manager'), 'Gestion des contacts');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'weak_pass'), 'La sécurité du mot de passe est faible');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_account_msg'), 'Inscrivez-vous pour accéder aux vidéos et photos. L\'inscription est gratuite et ne prends que quelques minutes.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'get_your_account'), 'Créez un compte');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_password_here'), 'Mot de passe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_username_here'), 'Identifiant');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watch'), 'Visionner');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'successful'), 'Converti');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'processing'), 'En conversion');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'creating_collection_is_disabled'), 'La création de collection est désactivé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'creating_playlist_is_disabled'), 'La création de playlist est désactivé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'inactive'), 'Inactive');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_ph'), 'Titre');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlist_found'), 'Aucune playlist trouvée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_privacy'), 'Accessibilité');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_collection'), 'Ajouter à la collection');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_added_to_playlist'), 'Cette vidéo a été ajouté à la playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_usr'), 'Signaler');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_playlists'), 'Mes Playlists');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'website_offline'), 'ATTENTION: LE SITE EST EN MODE HORS LIGNE');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'loading'), 'Chargement');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hour'), 'heure');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hours'), 'heures');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'day'), 'jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'days'), 'jours');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'week'), 'semaine');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'weeks'), 'semaines');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'month'), 'mois');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'months'), 'mois');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'year'), 'an');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'years'), 'ans');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'decade'), 'décénnie');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'decades'), 'décénnies');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'your_name'), 'Votre nom');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'your_email'), 'Votre Email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_comment_box'), 'Veuiller saisir quelque chose dans le champ commentaire');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'guest'), 'Invité');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comment_added'), 'Aucun commentaire ajouté');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'register_min_age_request'), 'Vous devez avoir au moins %s ans pour vous enregistrer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_category'), 'Veuillez sélectionner votre catégorie');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'custom'), 'personnalisé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlist_exists'), 'Vous ne disposez d\'aucune playlist');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit'), 'Editer');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_new_account'), 'Créer un compte');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search_too_short'), 'La recherche %s est trop courte!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_allow_comments'), 'Autoriser les commentaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_allow_rating'), 'Autoriser la notation');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlists_have_been_removed'), 'Les playlists ont été supprimées');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_collection_delete'), 'Voulez-vous vraiment supprimer cette collection ?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_select_collection'), 'Veuillez sélectionner une collection ci-dessous');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'resolution'), 'Résolution');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'filesize'), 'Poids du fichier');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_items'), 'Aucun élément');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_recover_user'), 'Identifiant oublié');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reply_to'), 'Répondre à');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mail_type'), 'Type d\'email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user'), 'Utilisateur');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mail_not_send'), 'Email non envoyé à <strong>%s</strong>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mail_send'), 'Email envoyé à <strong>%s</strong>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title'), 'Titre');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_comments'), 'Afficher les commentaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hide_comments'), 'Masquer les commentaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users_categories'), 'Catégories d\'utilisateurs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'popular_users'), 'Utilisateurs populaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel'), 'Chaîne');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_del_photo'), 'Êtes-vous sûr de vouloir supprimer cette photo ?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signups'), 'Inscriptions');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active_users'), 'Utilisateurs actifs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_name_invalid_len'), 'La taille de l\'identifiant est incorrecte');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'username_spaces'), 'L\'identifiant ne peut contenir d\'espaces');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_caption_err'), 'Veuillez entrer une description pour la photo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_collection_err'), 'Veuillez spécifier une collection pour la photo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'details'), 'Détails');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'technical_error'), 'Une erreur technique est survenue !');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'castable_status_fixed'), 'Le statut de cast de %s a été corrigé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'castable_status_failed'), '%s ne peut être casté correctement car il dispose de %s canaux audio, veuillez re-convertir la vidéo avec l\'option de correction Chromecast activée');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'castable_status_check'), 'Vérifier le statut de cast');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos_manager'), 'Gestionnaire de Vidéos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_bits_color'), 'Mettre à jour les bits couleurs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'bits_color'), 'bits couleurs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'bits_color_compatibility'), 'Le format de la vidéo la rend incompatible avec certains navigateurs tels que Firefox, Safari, ...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_logo_reset'), 'Le logo du lecteur a été réinitialisé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_settings_updated'), 'Les paramètres du lecteur ont été mis à jours');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_settings'), 'Lecteur');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'quality'), 'Qualité');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'error_occured'), 'Oops... Quelque chose s\'est mal passé...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'error_file_download'), 'Impossible de récupérer le fichier');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'dashboard_update_status'), 'Statut de mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'dashboard_changelogs'), 'Nouveautés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'dashboard_php_config_allow_url_fopen'), 'Veuillez activer \'allow_url_fopen\' pour pouvoir profiter du statut de mise à jour');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_error_email_unauthorized'), 'Email non autorisé');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_detail_saved'), 'Les détails de la vidéo ont été sauvegardés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_subtitles_deleted'), 'Les sous-titres de la vidéo ont été supprimés');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_no_parent'), 'Aucun parent');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_parent'), 'Collection parent');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_upload_video_limits'), 'Chaque vidéo ne peut excéder un poids de %s Mo, ni une durée de %s minutes, et doit se présenter dans un format vidéo commun');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_upload_video_select'), 'Selectionner une vidéo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_upload_photo_limits'), 'Chaque photo ne peut excéder un poids de %s Mo et doit se présenter dans un format image commun');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_resolution_auto'), 'Auto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_thumbs_regenerated'), 'Les vignettes de la vidéo ont été re-générées');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_allow_comment_vote'), 'Autoriser les votes sur les commentaires');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'language'), 'Langue');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'progression'), 'Progression');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'code'), 'Code');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_tool'), 'Outils d\'administration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'launch'), 'Lancer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'stop'), 'Arrêter', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'in_progress'), 'En cours', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ready'), 'Prêt', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'stopping'), 'En cours d\'arrêt', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate_missing_thumbs_label'), 'Génération des miniatures manquantes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate_missing_thumbs_description'), 'Génération des miniatures pour toutes les vidéos qui n\'ont pas de miniatures', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_castable_status_label'), 'Mise à jour du statut de diffusion des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_castable_status_description'), 'Met à jour le statut de diffusion de toutes les vidéos, en se basant sur les fichiers vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_bits_color_label'), 'Mise à jour du statut d\'encodage des couleurs des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_bits_color_description'), 'Met à jour le statut d\'encodage des couleurs des vidéos, en se basant sur les fichiers vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_videos_duration_label'), 'Mise à jour des durées des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_videos_duration_description'), ' Met à jour la durée de toutes les vidéos, en se basant sur les fichiers vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'need_db_upgrade'), 'Vous avez <b>%s</b> fichiers de mise à jour à exécuter. Pour cela vous pouvez utiliser le lien suivant : ', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'db_up_to_date'), 'Votre base de données est à jour', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_database_version_label'), 'Mise à jour de la base de données à la version actuelle', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_database_version_description'), 'Exécute tous les fichiers nécessaires pour mettre à jour la base de données', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_version'), 'Votre ClipBucket utilise l\'ancien système de mise à jour. Merci d\'exéctuer les fichiers de migration jusqu\'à la version 5.3.0. avant de poursuivre.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_version'), 'Merci de sélectionner votre version et révision courante.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'version'), 'version', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'revision'), 'révision', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'system_info'), 'Information système', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'hosting'), 'Hébergement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_ffmpeg'), 'est utilisé pour convertir des vidéos aux formats FLV, MP4 et de nombreux autres formats.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_box'), 'Boîte à Outils', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_php_cli'), 'est utilisé pour lancer la conversion vidéo en arrière plan', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_media_info'), 'fournit des informations techniques sur un fichier vidéo ou audio', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_ffprobe'), 'est une extension de FFMPEG utilsié pour récupérer des informations pour les fichiers multimédias', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_php_web'), 'est utilisé pour afficher cette page', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'must_be_least'), 'doit être au moins', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'php_cli_not_found'), 'PHP CLI n\'est pas correctement configuré', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cache'), 'cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_cache'), 'Activer le cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_cache_authentification'), 'Activer l\'authentification du cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_cache_label'), 'Réinitialisation du cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_cache_description'), 'Vide toutes les entrées du cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nb_files'), 'Nombre de fichiers', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_file_management'), 'Fichiers vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_video_file'), 'Êtes vous certains de vouloir supprimer la résolution %sp ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_video_log_label'), 'Suppression des logs de conversion', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_video_log_description'), 'Supprime les logs de conversion des vidéos correctement converties', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_conversion_log'), 'Aucun fichier de log disponible', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'watch_conversion_log'), 'Voir le log de conversion', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'conversion_log'), 'Log de conversion', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'open_debug'), 'Requêtes SQL', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_queries'), 'Requêtes Select', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_queries'), 'Requêtes Update', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'delete_queries'), 'Requêtes Delete', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'insert_queries'), 'Requêtes Insert', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'execute_queries'), 'Requêtes Execute', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'expensive_query'), 'Requête la plus lourde', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cheapest_query'), 'Requête la plus légère', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'overall_stats'), 'Statistiques Globales', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'base_directory'), 'Dossier racine', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'queries'), 'Requêtes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'all_queries'), 'Toutes les Requêtes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_db_queries'), 'Nombre total de requêtes SQL', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_cache_queries'), 'Nombre total de requêtes en cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_execution_time'), 'Temps total d\'exécution', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_memory_used'), 'Consomation mémoire totale', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'memory_usage'), 'Consomation mémoire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'everything'), 'Tout', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'display'), 'Afficher', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disable_email'), 'Désactiver les emails', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'number'), 'Numéro', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_subtitle_file'), 'Êtes vous certains de vouloir supprimer la piste de sous titre n°%s ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_subtitle_management'), 'Fichiers sous-titres', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_subtitles_deleted_num'), 'La piste n°%s des sous-titres a été supprimée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'waiting'), 'En attente', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_country'), 'Activer la sélection du pays', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_gender'), 'Activer la sélection du genre', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_category'), 'Activer la sélection de la catégorie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_upload_disabled'), 'L\'envoi de vidéo est désactivé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_compatible'), 'Le plugin est compatible avec la version actuelle de Clipbucket', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_not_compatible'), 'Le plugin peut ne pas être compatible avec la version actuelle de Clipbucket', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_orphan_files_label'), 'Suppression des fichiers orphelins', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_orphan_files_description'), 'Supprime les vidéos, photos, sous-titres, miniatures, logs et activités qui ne sont pas liés à une entrée de la base de données', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'lang_restored'), 'La langue %s a été restaurée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'language_name'), 'Libellé de la langue', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'restore_language'), 'Restaurer une langue', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'restore'), 'Restaurer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'repair_video_duration_label'), 'Corrige la durée des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'repair_video_duration_description'), 'Corrige la durée des vidéos ayant une durée de 0', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_tester'), 'Email Testeur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'manage_tags'), 'Gestion des tags', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'action'), 'Action', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'label'), 'Label', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tag_updated'), 'Le tag a été  mis à jour', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tag_deleted'), 'Le tag a été supprimé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'general'), 'General', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_tag'), 'Êtes-vous certains de vouloir supprimer le tag : %s ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_orphan_tags'), 'Suppression des tags orphelins', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_orphan_tags_description'), 'Supprime les tags qui ne sont pas lié à une video, photo, collection, playlist ou utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cannot_delete_tag'), 'Vous ne pouvez pas supprimer ce tag', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tag_too_short'), 'Les tags de moins de 3 caractères ne sont pas autorisés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tag_type'), 'Type de tag', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'playlist'), 'Playlist', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'profile'), 'Profil', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sign_in_with_your_cb_account'), 'Connectez-vous avec votre compte ClipbucketV5', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photo_is'), 'La photo est %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_is'), 'La vidéo est %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'incorrect_url'), 'URL incorrecte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_firstname_lastname'), 'Activer le nom et prénom', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_relation_status'), 'Activer le statut de relation', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_postcode'), 'Activer code postal', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_hometown'), 'Activer la ville natale', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_city'), 'Activer la ville', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_education'), 'Activer le niveau d\'étude', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_schools'), 'Activer les écoles', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_occupation'), 'Activer la profession', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_compagnies'), 'Activer les sociétés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_hobbies'), 'Activer les passions', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_favorite_movies'), 'Activer les films favoris', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_favorite_music'), 'Activer la musique favorie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_favorite_books'), 'Activer les livres favoris', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_website'), 'Activer le site internet', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_about'), 'Activer à propos de', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_status'), 'Activer le statut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_not_available'), 'Cette vidéo n\'est pas disponible', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_social_sharing'), 'Activer le partage sur les réseaux', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_internal_sharing'), 'Activer le partage interne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_link_sharing'), 'Activer le partage de lien', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'download'), 'Télécharger', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unlisted'), 'Non répertoriée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'of'), 'de', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_not_active'), 'La collection est désactivée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'usr_arr_open_relate'), 'Relation libre', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'already_spammed_comment'), 'Vous avez déjà signaler ce commentaire en tant que spam', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'menu_home'), 'Accueil', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_own_commen_spam'), 'Vous ne pouvez pas signaler votre propre commentaire en tant que spam', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'playlist_owner'), 'Propriétaire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'spam_comment_ok'), 'Le commentaire a été marqué comme spam', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cant_pm_banned_user'), 'Vous ne pouvez pas envoyer de message privé à %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'upload_custom_thumbnail'), 'Téléverser une vignette personnalisée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'extracted_thumbs'), 'Vignettes extraites', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'custom_thumbs'), 'Vignettes personnalisées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm'), 'Confirmer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'uploaded'), 'Téléversés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photo_tags'), 'Mots clés photos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_is'), 'La collection est %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'not_found'), 'Introuvable', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'age_restriction'), 'Restriction d\'âge', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_age_restriction'), 'Laisser le champs vide pour aucune restriction. Sinon mettez l\'âge minimum pour accéder au contenu', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'access_forbidden_under_age'), 'Accès interdit aux moins de %s ans', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_age_restriction'), 'Activer la restriction d\'âge sur les médias', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_dob_edition'), 'Autoriser l\'édition de la date de naissance', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_dob_edition_disabled'), 'L\'édition de la date de naissance est désactivée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_blur_restricted_content'), 'Flouter les contenus restreints', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_enable_blur_restricted_content'), 'Si activé, les contenus restreints sont visible mais floutés ; sinon, les contenus restreints sont masqués', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_global_age_restriction'), 'Activer la pop-in de restriction d\'âge globale', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_age_restriction'), 'Vous n\'avez pas l\'âge nécessaire pour accéder à ce contenu', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_age_restriction_save'), 'L\'âge minimum requis doit être compris entre 1 et 99', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'age_verification'), 'Vérification d\'âge', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'age_verification_text'), 'Ce site web contient du matériel avec des restrictions d\'âge. En vous connectant, vous affiemer que vous avez au moins %s ans.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disclaimer_older'), 'J\'ai %s ans ou plus - Entrer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disclaimer_return'), 'J\'ai moins de %s ans - Sortir', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_enable_global_age_restriction'), 'Basé sur l\'âge minimum d\'inscription', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edition_min_age_request'), 'L\'âge ne peut être inférieur à %s ans', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_quicklist'), 'Activer la quicklist', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_hide_empty_collection'), 'Masquer les collections vides', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'comment_disabled_for'), 'Les commentaires sont désactivés pour cette %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'dev_mode'), 'Mode développement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'dev'), 'dev', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'discord_error_log'), 'Activer les logs d\'erreur Discord', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'discord_webhook_url'), 'URL du webhook Discord', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'discord_webhook_url_invalid'), 'L\'URL du webhook Discord n\'est pas valide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_sitemap'), 'Activer le sitemap', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'category_type_unknown'), 'Type de catégorie inconnue : %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_setting'), 'Administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'site_setting'), 'Paramétrage', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_username'), 'Identifiant administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_password'), 'Mot de passe administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_email'), 'Email administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'save_continue'), 'Enregistrer et continuer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'hint_admin_username'), 'L\'identifiant ne peut contenir que des caractères alphanumériques et des tirets bas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'hint_admin_email'), 'Vérifiez bien votre adresse e-mail avant de continuer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_install_info'), 'Toutes les étapes majeurs sont terminées, à présent saisissez un identifiant et un mot de passe pour votre administrateur, par défaut comme suit identifiant : <strong>admin</strong> | mot de passe : <strong>admin</strong>', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate'), 'Générer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'current'), 'Actuel', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_configuration'), 'Configuration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_configuration_info'), 'Vous pouvez paramétrer ici des éléments de base, vous pourrez les changer ultérieurement en allant dans l\'espace d\'administration > Configurations', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_title'), 'Titre du site web', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_title_hint'), 'C\'est le titre de votre site web, vous pouvez le changer depuis l\'espace administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_slogan'), 'Slogan du site web', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_slogan_hint'), 'C\'est le slogan de votre site web, vous pouvez le changer depuis l\'espace administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_url'), 'URL du site web', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_url_hint'), 'Sans le slash de fin', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'agreement'), 'Accord', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'pre_check'), 'Vérifications préalables', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'permission'), 'Autorisations', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'database'), 'Base de donnée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'data_import'), 'Import des données', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'finish'), 'Fin', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'continue_admin_area'), 'Continuer vers l\'espace d\'administration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'continue_to'), 'Continuer vers', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'successful_install'), 'a été installé avec succès !', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_language'), 'Langage par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_server_config'), 'Merci de mettre à jour votre configuration serveur. Cliquez ici <a href="%s">pour plus d\'informations.</a>', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'not_required_version'), 'La version actuelle de %s est <strong>%s</strong>, la version minimale requise est <strong>%s</strong>', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'dob_required'), 'La date de naissance doit être renseignée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'completed'), 'Terminé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_allow_photo_types'), 'Seuls les formats d\'image suivants sont autorisés : %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'mysql_client'), 'Client MySQL', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'mysql_server'), 'Serveur MySQL', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_git_path'), 'Chemin GIT', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'core_upgrade_avaible'), 'Une mise à jour est disponible, cliquez ici pour mettre à jour : ', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_core_label'), 'Mise à jour du coeur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_core_description'), 'Utilise GIT pour annuler tous les changements et mettre à jour à la dernière revision', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'core_up_to_date'), 'Votre coeur est à jour', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_session_table_label'), 'Nettoyage de la table des sessions', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_session_table_description'), 'Supprime les lignes de la table session datant de plus d\'un mois', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_recalcul_video_file_label'), 'Mise à jour de la liste des fichiers vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_recalcul_video_file_description'), 'Met à jour la liste des fichiers vidéos de toutes les vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'recreate_thumb_label'), 'Régénération des vignettes photos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'recreate_thumb_description'), 'Régénère toutes les vignettes photos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_logs'), 'Aucuns journaux à afficher', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'show_log'), 'Afficher les derniers journaux', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_started'), 'Outil lancé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_stopped'), 'Outil arrêté', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_ended'), 'Outil terminé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_tmdb'), 'Activer TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_token'), 'Token d\'authentification TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_token_check'), 'Vérifier le token TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'get_data_tmdb'), 'Récupérer les infos depuis The Movie DataBase', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'release_date'), 'Date de sortie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'import'), 'Importer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'actors'), 'Acteurs', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'producer'), 'Producteur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'crew'), 'Equipe', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'genre'), 'Genre', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'executive_producer'), 'Producteur exécutif', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'director'), 'Directeur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_genre'), 'Récupérer le genre depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_actors'), 'Récupérer les acteurs depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_producer'), 'Récupérer le producteur depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_executive_producer'), 'Récupérer le producteur exécutif depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_director'), 'Récupérer le directeur depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_crew'), 'Récupérer l\'équipe depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_poster'), 'Récupérer l\'affiche depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_release_date'), 'Récupérer la date de sortie depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_title'), 'Récupérer le titre depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_description'), 'Récupérer la description depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_search'), 'Recherche The Movie Database', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'movie_infos'), 'Informations sur le film', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_poster'), 'Activer les affiches', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_backdrop'), 'Activer les décors', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_age_restriction'), 'Récupérer la restriction d\'âge depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_backdrop'), 'Récupérer le décors depuis TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by'), 'Trier par %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'backdrop'), 'décor', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'poster'), 'affiche', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'thumbnail'), 'vignette', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_x'), '%s par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_require_x_enabled'), 'Cette option nécessite que \'%s\' soit activé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_as_default_x'), 'Sélectionner comme %s par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_x_field'), 'Activer le champ %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_category'), 'Mettre à jour la catégorie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'add_new_category'), 'Ajouter une nouvelle catégorie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edit_from_BO'), 'Depuis l\'administration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edit_from_FO'), 'Depuis mon compte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_edit_button'), 'Activer le bouton d\édition', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'only_keep_max_resolution'), 'Conserver uniquement la résolution maximale', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'thumbs'), 'Vignettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_tmdb_mature_content'), 'Activer le contenu mature', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_mature_content_age'), 'Âge minimum du contenu pour adulte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'access_forbidden_under_age_display'), '- %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_enable_on_front'), 'Activer TMDB sur le front office', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enabled'), 'activé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disabled'), 'désactivé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cloudflare_documentation'), 'Documentation Cloudflare', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'incorrect_configuration_413_error'), 'Une configuration incorrecte pourrait causer des erreurs 413.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'available'), 'Disponible', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unavailable'), 'Indisponible', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sse_error_features_disabled'), 'Des fonctionnalités tels que l\'actualisation automatique et les tâches de fond seront désactivées.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sse_error_please_use_php_fpm'), 'Veuillez utiliser PHP-FPM pour une expérience optimale de ClipBucketV5.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'storage'), 'Stockage', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_comments_censor'), 'Activer la censure des commentaires', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_censored_words'), 'Mots censurés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'separated_by_commas'), 'Séparé par des virgules', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_description_censor'), 'Activer la censure des descriptions', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_description_link'), 'Activer les liens dans la description', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_chunk_upload'), 'Activer le téléchargement morcelé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_enable_chunk_upload'), 'Lors de l\'upload, le fichier sera découpé en plus petits morceaux', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'mb'), 'Mo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'kb'), 'Ko', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'in_x'), 'En %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cloudflare_upload_limit'), 'Limite d\'upload Cloudflare', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_nginx_path'), 'Chemin Nginx', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'file_size_cant_exceeds_x_x'), 'Le poids du fichier ne peut dépasser %s%s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_video'), 'Êtes vous certains de vouloir supprimer cette vidéo ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cancel_uploading'), 'Annuler le téléversement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'upload_more_videos'), 'Téléverser plus de vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'pourcent_completed'), '% complété', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'submit_now'), 'Enregistrer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_profil_censor'), 'Activer la censure du profil utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_playlists'), 'Activer les playlists', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_comments_video'), 'Activer les commentaires de vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_comments_photo'), 'Activer les commentaires de photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_comments_collection'), 'Activer les commentaires de collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_comments_channel'), 'Activer les commentaires de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_most_items'), 'Plus d\'éléments', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'db_updating'), 'Mise à jour BDD en cours...', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'core_updating'), 'Mise à jour du coeur en cours...', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'launch_wip'), 'Lancer la migration WIP', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'correct_video_categorie_label'), 'Correction des vidéos sans catégorie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'correct_video_categorie_description'), 'Affecte la catégorie par défaut aux vidéos n\'ayant aucune catégorie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'delete_unused_resolution_files_label'), 'Suppression des résolutions désactivées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'delete_unused_resolution_files_description'), 'Supprime les fichiers vidéo des résolutions désactivées pour la conversion des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'on_error'), 'En erreur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'anonymous'), 'Anonyme', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'anonymous_locked'), 'L\'utilisateur anonyme est verrouillé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_doesnt_exist'), 'L\'utilisateur n\'existe pas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'orphan'), 'Orphelin', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'upload_poster'), 'Téléverser une affiche', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'upload_backdrop'), 'Téléverser un décor', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'poster_list'), 'Liste des affiches', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'backdrop_list'), 'Liste des décors', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'posters'), 'décors', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'backdrops'), 'backdrops', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'thumb_regen_end'), 'La génération des vignettes est terminée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'thumb_regen_start'), 'Regénération des vignettes en cours...', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_not_found'), 'L\'outil est introuvable', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_automate_launch_mode'), 'Avec l\'activité des utilisateurs, les automates sont lancés en tâche de fond au chargement des pages', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_automate_launch_mode'), 'Lancement des automates', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_automate_launch_mode_crontab'), 'Crontab', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_automate_launch_mode_user_activity'), 'Activité des utilisateurs', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_automate_launch_mode_disabled'), 'Désactivé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'frequence'), 'Fréquence', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'frequence_enabled'), 'Lancement automatique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cron_format_title'), 'Format crontab : * * * * *', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'bad_format_cron'), 'La fréquence doit être un format CRON valide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_already_launched'), 'Cet outils est déjà en cours', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'success_update_tools'), 'L\'outil a bien était mis à jour', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'automate_label'), 'Lancement automatique des outils', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'automate_description'), 'Lance automatiquement les outils en fonction de leur fréquence', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'datetime_synchro_error'), 'Il existe un écart entre la date issue de PHP et la date issue de la base de donnée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'datetime_synchro'), 'Correctement synchronisée avec base de donnée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'automate_launch_disabled_in_config'), 'Le lancement automatique des outils est désactivé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'crontab_link_label'), 'Ligne à copier dans Crontab', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'copy_clipboard'), 'Copier dans le presse-papier', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_timezone'), 'Timezone', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unknown_type'), 'Type inconnu', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'calc_user_storage_label'), 'Calcul utilisation disque utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'calc_user_storage_description'), 'Calcul pour un utilisateur le poids de tous ses fichiers uploadés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_storage_history'), 'Activer l\'historique de stockage', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_storage_history_fo'), 'Afficher l\'historique de stockage sur le front office', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_current_storage'), 'Espace utilisé actuellement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'storage_use'), 'Espace utilisé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'storage_history'), 'Historique de l\'espace utilisé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'thumbs_upload_successfully'), 'La vignette a été téléversée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'poster_upload_successfully'), 'L\'affiche a été téléversée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'backdrop_upload_successfully'), 'Le décor a été téléversé avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'thumbs_delete_successfully'), 'La vignette a été supprimée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'poster_delete_successfully'), 'L\'affiche a été supprimée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'backdrop_delete_successfully'), 'Le décor a été supprimé avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'manage_x'), 'Gestion des %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'remove_from_favorites'), 'Retirer des favoris', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'interfaces'), 'Interfaces', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'global'), 'Global', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_default_theme'), 'Thème par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_default_theme_light_original'), 'Clair (Original)', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_default_theme_light'), 'Clair', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_default_theme_dark'), 'Sombre', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_custom_css'), 'CSS personnalisé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'manage_items'), 'Gestion des objets', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_collection_found'), 'Aucune collection trouvée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cannot_be_own_parent'), 'Une collection ne peut pas être sa propre collection parente', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'templates'), 'Thèmes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'players'), 'Lecteurs', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'pages'), 'Pages', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'make_featured'), 'Mettre en vedette', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'make_unfeatured'), 'Retirer des vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_featured'), 'La collection a été ajoutée aux vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_unfeatured'), 'La collection a été retirée des vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'selected_collects_del'), 'Les collections sélectionnées ont été supprimées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'object'), 'objet', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'objects'), 'objets', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_channel_comments'), 'Voir les commentaires de chaine', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collect_added_msg'), 'La collection a été ajoutée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_social_networks_links_footer'), 'Activer les liens de réseaux sociaux dans le pied de page', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_social_networks_links_sidebar'), 'Activer les liens de réseaux sociaux dans la barre latérale', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'add_new_social_network_link'), 'Ajouter un nouveau lien de réseau social', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugins'), 'plugins', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'url'), 'url', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'order'), 'Ordre', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'icon'), 'Icône', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'validate'), 'Valider', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'title_cannot_be_empty'), 'Le titre ne peut être vide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'url_cannot_be_empty'), 'L\'URL ne peut être vide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'icon_is_required'), 'L\'icône est requise', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_social_network'), 'Êtes-vous sûr de vouloir supprimer ce lien de réseau social ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'missing_params'), 'Il manque des paramètres', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'manage_social_networks_links'), 'Gestion des liens des réseaux sociaux', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'text_confirm_comment'), 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_comments'), 'Aucun commentaire pour cette %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_not_found'), 'Une collection est nécessaire pour compléter la configuration de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edit_collection'), 'Editer la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edit_photo'), 'Editer la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photo_title'), 'Titre de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photo_caption'), 'Description de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photo_success_deleted'), 'La photo a été supprimée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_video_view_history'), 'Activer l\'historique de vue des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_viewed_recently'), 'Vue récemment', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_shorter'), 'Plus courte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_longer'), 'Plus longue', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_homepage_enable_popin_video'), 'Activer les vidéos dans une pop-in', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_homepage_recent_videos_display'), 'Mode d\'affichage des vidéos récentes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_paginate'), 'Pagination', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_slider'), 'Caroussel', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_homepage_recent_video_style'), 'Style des vidéos récentes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_modern'), 'Moderne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_classic'), 'Classique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_list_recent_videos'), 'Nombre de vidéos récentes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_list_featured_videos'), 'Nombre de vidéos vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_only_with_slider_option'), 'Ne s\'applique qu\'avec le mode d\'affichage caroussel', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_fullwidth'), 'Affichage pleine largeur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_disable_sidebar'), 'Désactiver la sidebar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_home_display_featured_collections'), 'Afficher les collections vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_homepage_collection_video_style'), 'Style des vidéos de collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_list_home_collection_videos'), 'Nombre de vidéos de collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_homepage_collection_video_ratio'), 'Ratio d\'affichage des vidéos de collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_homepage_recent_video_ratio'), 'Ratio d\'affichage des vidéos récentes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_home_display_recent_videos'), 'Afficher les vidéo récentes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_more'), 'En voir plus', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_access_view_video_history'), 'Activer l\'accès à l\'historique des vues', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_list_view_video_history'), 'Historique des vues', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_history'), 'Voir l\'historique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'history'), 'Historique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'usr_cmt_del_msg'), 'Le commentaire a été supprimé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'channel_settings'), 'Paramètre de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_channel_page'), 'Activer la page de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disable_channel'), 'Désactiver la chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_account'), 'Compte administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'timezone_not_corresponding'), 'Le fuseau horaire %s ne correspond pas à celui de la base de donnée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'will_be_upload_into_collection'), 'Les %s seront téléversées dans la collection <strong><i>%s</i></strong>', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'configurations'), 'Configurations', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'template_editor'), 'Editeur de thèmes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_logos'), 'Mise à jour des logos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'languages_settings'), 'Configuration des langues', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_template'), 'Modèle d\'email', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'watermark_settings'), 'Configuration des filigranes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'assign_default_thumb_label'), 'Assigner la vignette par défaut des collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'assign_default_thumb_description'), 'Assigne aux collection la vignette par défaut du premier élément de la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_thumb'), 'Vignette par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_levels'), 'Niveaux d\'utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'add_collection'), 'Ajouter la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'permissions'), 'Permissions', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'writeable'), 'Accessible en écriture', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'chmod_file'), 'Veuillez exécuter la commande chmod 755 sur ce fichier/dossier', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'force_to_error'), 'Forcer en erreur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_forced_to_error'), 'Outil forcé en erreur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_level'), 'Niveau d\'utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'administrator'), 'Administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'registered_user'), 'Utilisateur enregistré', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'inactive_user'), 'Utilisateur inactif', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'global_moderator'), 'Modérateur global', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'maintained_by'), 'maintenu par', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'channel_doesnt_exists'), 'La chaîne n\'existe pas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_has_been_set_as_featured'), 'L\'utilisateur est marqué en vedette', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_has_been_removed_from_featured_users'), 'L\'utilisateur a été retiré des vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cant_featured_deactivate_user'), 'Vous ne pouvez pas marquer une chaîne désactivée en vedette', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cannot_access_page'), 'Vous ne pouvez pas accéder à cette page', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_cant_receive_pm'), 'L\'utilisateur %s ne peut pas recevoir de message privés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_channel_page_desc'), 'L\'utilisateur peut avoir une page de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'missing_timezone'), 'Timezone manquante', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_format_date'), 'Format de date incorrect', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_visual_editor'), 'Activer l\'éditeur visuel', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_hide_uploader_name'), 'Masquer le nom du propriétaire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_enable_hide_uploader_name'), 'Si activé, les nom de propriétaires sont masqués', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'wip_done'), 'Migration WIP effectuée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'relaunch'), 'Relancer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'movie'), 'Film', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'series'), 'Série', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'limit_photo_related'), 'Quantité de photo similaires', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'related_photos'), 'Photos similaires', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_access_desc'), 'Permet l\'accès au panneau d\'administration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_video_upload_desc'), 'Permet de téléverser des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_photo_upload_desc'), 'Permet de téléverser des photos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_video_desc'), 'Permet de regarder des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_photos_desc'), 'Permet de regarder des photos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_collections_desc'), 'Permet de regarder des collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_channel_desc'), 'Permet de voir les chaînes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_videos_desc'), 'Permet de voir la liste des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'avatar_upload_desc'), 'Permet de changer son avatar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_moderation_desc'), 'Permet de gérer les vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'member_moderation_desc'), 'Permet de gérer les utilisateurs', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ad_manager_access_desc'), 'Permet de gérer les publicités', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'manage_template_access_desc'), 'Permet de modifier les thèmes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'group_moderation_desc'), 'Permet de gérer les groupes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'web_config_access_desc'), 'Permet de modifier les configurations du site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_channels_desc'), 'Peut voir la page chaînes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'playlist_access_desc'), 'Permet de voir les playlists', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_channel_bg_desc'), 'Permet à l\'utilisateur de changer l\'image de fond de sa chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'private_msg_access_desc'), 'Permet d\'utiliser le système de messagerie privée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edit_video_desc'), 'Permet d\'éditer les vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'download_video_desc'), 'Permet de télécharger les vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_del_access_desc'), 'Permet de supprimer des commentaires', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photos_moderation_desc'), 'Permet de gérer les photos depuis l\'administration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_moderation_desc'), 'Permet de gérer les collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugins_moderation_desc'), 'Permet de gérer les plugins', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_box_desc'), 'Permet de gérer les outils d\'administration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_manage_user_level_desc'), 'Permet de gérer les niveaux d\'utilisateurs', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_create_collection_desc'), 'Permet de créer des collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_create_playlist_desc'), 'Permet de créer des playlists', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_access'), 'Accès administrateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_video_upload'), 'Téléversement de vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_photo_upload'), 'Téléversement de vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_photos'), 'Regarder photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_collections'), 'Regarder la page des collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_channel'), 'Voir une chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'view_videos'), 'Liste des vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'avatar_upload'), 'Téléversement d\'avatar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_moderation'), 'Gestion de vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'member_moderation'), 'Gestion d\'utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ad_manager_access'), 'Gestion des publicités', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'manage_template_access'), 'Gestion des thèmes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'group_moderation'), 'Gestion des groupes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'web_config_access'), 'Configurations', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'playlist_access'), 'Accès playlist', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_channel_bg'), 'Changer l\'image de fond', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'private_msg_access'), 'Messagerie privée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edit_video'), 'Edition de vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'download_video'), 'Téléchargement de vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_del_access'), 'Suppression de commentaire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photos_moderation'), 'Gestion des photos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_moderation'), 'Gestion des collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugins_moderation'), 'Gestion des plugins', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_manage_user_level'), 'Gestion des niveaux d\'utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_create_collection'), 'Création de collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_create_playlist'), 'Création de playlist', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'display_featured_video'), 'Afficher les vidéos vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'featured_video_style'), 'Style des vidéos vedettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'classic'), 'Classique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'modern'), 'Moderne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'recommended_dimension'), 'Taille minimum recommandée : %s x %s px', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'favicon'), 'Icône du site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_logo'), 'Le logo est affiché en haut de chaque page', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_favicon'), 'L\'icône du site est ce que vous voyez dans les onglets du navigateur, les marques-pages et raccourcis', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'wrong_image_extension'), 'Seules les extensions suivantes sont prise en charge: %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_nsfw_check'), 'Activer la vérification de contenu mature', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_enable_nsfw_check'), 'Les contenus matures seront reportés et nécessiteront une activation manuelle', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_powered_by_ai'), 'Propulsé par l\'IA', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'warning_ai_requirements'), 'Les fonctionnalités IA nécessitent PHP 7.4+ et l\'extension FFI', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ai_features_disabled'), 'Les fonctionnalités IA seront désactivées.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ai_setup_config'), 'Veuillez utiliser PHP 7.4+ et activer l\'extension FFI ("preload" ne fonctionnera pas).', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_nsfw_check_model'), 'Modèle de vérification de contenu mature', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_nudity'), 'Nudité', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_nsfw'), 'Contenu mature', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_nudity_nsfw'), 'Nudité + contenu mature', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_vid_in_playlist'), 'Aucune vidéo trouvée dans cette playlist !', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'warning_php_version'), 'Cher administrateur,<br/> Il semble que vous utilisez une ancienne version de PHP (<b>%s</b>). Cette version ne sera plus prise en charge dans la prochaine version <b>%s</b>.<br/>Veuillez mettre à jour votre version de PHP vers %s ou une version supérieure.<br/><br/>Merci d\'utiliser ClipBucketV5 !', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_template_management'), 'Gestion des modèles d\'emails', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_template_management_desc'), 'Peut gérer les modèles d\'emails', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'empty_email_content'), 'Merci de renseigner la variable "email_content".', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'rendered'), 'Rendu', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'code_cannot_be_empty'), 'Le code ne peut pas être vide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'back_to_list'), 'Retour à la liste', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'code_already_exist'), 'Ce code existe déjà. Merci d\'en choisir un autre', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'template_set_default'), 'Le modèle %s a été enregistré par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_default_template'), 'Voulez-vous appliquer ce nouveau modèle d\'email par défaut à tous les emails existants ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_content'), 'Cette variable sera remplacée par le contenu de l\'email', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'success'), 'Opération réalisée avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sender'), 'Expéditeur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_sender'), 'Adresse email de l\'expéditeur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'recipient'), 'Destinataire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_recipient'), 'Adresse email du destinataire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_an_email'), 'Choisissez un email', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'content'), 'Contenu', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'invalid_email_recipient'), 'Merci de saisir une adresse de destination valide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'invalid_email_sender'), 'Merci de saisir une adresse d\'expédition valide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'missing_recipient'), 'Destinataire manquant', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unknown_email'), 'Email inconnu', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'template_dont_exist'), 'Ce modèle d\'email n\'existe pas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_sender_address'), 'Adresse d\'expédition des emails', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_sender_name'), 'Nom de l\'expéditeur des emails', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_mail'), 'Une erreur est survenue lors de l\'envoi du mail : %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_website_title'), 'Contient le titre du site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_user_username'), 'Nom d\'utilisateur du destinataire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_user_avatar'), 'URL de l\'avatar du destinataire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_date_year'), 'Année en cours', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_baseurl'), 'URL du site web', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_date_time'), 'Date et heure de la création du mail', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_login_link'), 'Lien vers la page de connexion', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_avcode'), 'Code de validation de compte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_video_link'), 'Lien vers la vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_video_title'), 'Titre de la vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_video_thumb'), 'URL de la vignette de la vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_video_description'), 'Description de la vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_sender_message'), 'Contenu du message', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_subject'), 'Sujet du message', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_profile_link'), 'Lien vers le profile de l\'utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_request_link'), 'Lien vers la demande d\'ami', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_photo_link'), 'Lien vers la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_photo_thumb'), 'URL vers la miniature de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_photo_description'), 'Description de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_photo_title'), 'Titre de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_collection_link'), 'Lien vers la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_collection_thumb'), 'URL de la vignette de la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_collection_description'), 'Description de la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_collection_title'), 'Titre de la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_total_items'), 'Nombre d\'éléments dans la collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_collection_type'), 'Type d\'objet de la collection (vidéo, photo, etc.)', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_private_message_link'), 'Lien vers le message dans la boite de reception', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_password'), 'Mot de passe généré', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_reset_password_link'), 'Lien pour la réinitialisation du mot de passe', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_comment_link'), 'Lien vers le commentaire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_object'), 'Type d\'object cité dans l\'email (vidéo, photo etc.)', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_sender_username'), 'Nom d\'utilisateur à l\'origine du message', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_sender_email'), 'Adresse email de l\'expéditeur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_user_email'), 'Adresse email du destinataire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_specific'), 'Spécifique à l\'email', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'title_email_variables'), 'Variables utilisables dans l\'email', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_email_variables'), 'Les variables doivent être placées entre doubles accolades, par exemple : {{website_title}}', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_logo_url'), 'Lien vers le logo du site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'email_variable_favicon_url'), 'Lien vers l\'icone du site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cannot_remove_default_have_to_add_one'), 'Impossible de retirer le modèle par défaut, merci d\'en choisir un nouveau', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'this_user_blocked_you'), 'Cet utilisateur vous a bloqué : %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_is_banned'), 'Cet utilisateur est banni : %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'you_cant_share_to_yourself'), 'Vous ne pouvez pas faire de partage à vous même', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'link_this_photo'), 'Lien de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'link_this_collection'), 'Lien de la collection', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'share'), 'Partager', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_link_sharing'), 'Activer le partage par lien', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_internal_sharing'), 'Activer le partage en interne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'element'), 'Élément', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'motif'), 'Motif', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reporter'), 'Rapporteur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unflag'), 'Annuler le signalement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'delete_element'), 'Supprimer l\'élément', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unflag_and_activate'), 'Annuler le signalement et activer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_flagged'), 'Vidéos signalées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_flagged'), 'Utilisateurs signalés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_flagged'), 'Collections signalées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'playlist_flagged'), 'Playlists signalées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photo_flagged'), 'Photos signalées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'report_successful'), 'Le signalement a été effectué avec succès', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unflag_successful'), 'Le signalement a été annulé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'element_deleted'), 'L\'élément a été supprimé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nb_flag'), 'Nombre de signalement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'flagged_obj'), 'Éléments signalés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'flagged'), 'Signalé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'must_update_version'), 'Votre base de donnée nécessite d\'être mise à jour', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'missing_email_recipient'), 'Missing recipient\'s email', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'missing_category_report'), 'Veuillez choisir un motif de signalement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'viewing_permission'), 'Permissions de visionnage', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'uploading_permission'), 'Permissions de téléchargement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'administration_permission'), 'Permissions d\'administration', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'general_permission'), 'Permissions générales', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_base_url'), 'URL de base', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_base_url_hint'), 'Indiquez l\'adresse de votre domaine', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_thumb_background_color'), 'Couleur de fond des vignettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_country_video_field'), 'Activer le champs Pays', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_location_video_field'), 'Activer le champs Localisation', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_recorded_date_video_field'), 'Activer le champs Date', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_tag_space'), 'Autoriser les espaces dans les tags', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'use_tab_tag'), 'Utilisez la touche "Tab" pour passer au mot clé suivant', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'orphan_file_has_been_deleted'), 'Suppression du fichier orphelin : %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'processing_x_files'), 'Traitement de %s fichiers ...', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'x_orphan_files_have_been_deleted'), '%s fichiers orphelins ont été supprimés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'loading_file_list'), 'Chargement de la liste des fichiers...', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_360_video'), 'Activer le support des vidéos 360°', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'x_fov'), '%s°', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_fov'), 'Champ de vision', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'basic_settings'), 'Configurations simples', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'advanced_settings'), 'Configurations avancées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'basic_settings_desc'), 'Permet de modifier les configurations simples du site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'advanced_settings_desc'), 'Permet de modifier les configurations avancées', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_thumbs_preview'), 'Activer la prévisualisation vidéo dans la vignette', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_video_thumbs_preview_count'), 'Nombre de vignettes de prévisualisation vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'uploaded_by_x'), 'Téléversé par by %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ongoing_conversion'), 'Conversion en cours', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'mass_category_selection'), 'Sélection des categories en masse', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'mass_broadcast_selection'), 'Sélection de diffusion en masse', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'vdo_br_opt1'), 'Publique - Partagez votre vidéo avec tout le monde! (Recommandé)', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'vdo_br_opt2'), 'Privé - Visible uniquement par vous et vos amis', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'vdo_broadcast_unlisted'), 'Non listé (visible par quiconque avec le lien et/ou le mot de passe)', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'logged_users_only'), 'Connecté seulement (visible uniquement par les utilisateurs connectés)', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cannot_delete_not_empty_category'), 'Vous ne pouvez pas supprimer une catégorie associée à des éléments', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_show_collapsed_checkboxes'), 'Catégories repliables', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'changelog'), 'Changelog', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'older_versions'), 'Anciennes versions', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'page_name_about_us'), 'À propos de nous', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'page_name_privacy_policy'), 'Politique de confidentialité', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'page_name_terms_of_service'), 'Condition d\'utilisation', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'page_name_help'), 'Aide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'translation_already_exist_choose_other_name'), 'Le code de traduction "%s" existe déjà. Merci de choisir un autre nom de page.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'page_name_cant_have_space'), 'Le nom de la page ne peut pas contenir d\'espace', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'page_display_changed'), 'L\'affichage de la page a été modifié', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_most_old'), 'Plus Ancien', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_most_viewed'), 'Plus visionnés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_most_commented'), 'Plus commentés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_sort'), 'Tri par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_featured'), 'Vedette', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_categories'), 'Activer les catégories', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'launch_tool'), 'Lancement de l\'outil "%s"', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_theme_change'), 'Activer le changement de thème', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_theme_change_tips'), 'Disponible uniquement pour les nouveaux thèmes sombre et clair', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_theme_auto'), 'Auto', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'title_theme_auto'), 'Suivre le thème du système', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'title_theme_x'), 'Utiliser le thème %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'max_video_categories'), 'Catégories maximum', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'max_video_categories_hint'), 'Nombre maximum de catégories par vidéo ; 0 pour aucune limite', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_aspect_ratio_label'), 'Mise à jour des ratios de vidéo manquants', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_aspect_ratio_description'), 'Met à jour les ratios manquants des vidéos, en se basant sur les fichiers vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'approve_x'), '%s à valider', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'approve'), 'Approve', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'see_all_notifications'), 'Voir toutes les notifications', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'invalid_date_format'), 'Format de date invalide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'directory_x_is_forbidden'), 'Le sous-dossier utilisé "%s" est réservé par le système et ne peut pas être utilisé pour héberger le site. Veuillez en choisir un autre pour assurer le bon fonctionnement de la plateforme.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nginx_vhost'), 'VirtualHost Nginx', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nginx_vhost_desc'), 'Voici la configuration de base du VirtualHost pour ClipBucketV5 sur Nginx :', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nginx_vhost_last_updated'), 'Le VirtualHost de base a été mis à jour pour la dernière fois dans la version %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nginx_vhost_first_update'), 'Il semble que ce soit votre premier contrôle du VirtualHost. Veuillez vous assurer qu\'il est à jour', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nginx_vhost_no_update'), 'Aucune nouvelle version du VirtualHost n\'a été publiée depuis votre dernière mise à jour %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nginx_vhost_update'), 'Il semble que vous ayez mis à jour votre VirtualHost pour la dernière fois en version %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nginx_vhost_updated'), 'Mon VirtualHost est à jour !', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'access_to_front_end'), 'Accéder au front office', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_alphabetical'), 'Alphabétique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by_reverse_alphabetical'), 'Alphabétique inversé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_channel_slogan'), 'Activer le slogan de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_channel_description'), 'Activer la description de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'channel_slogan'), 'Slogan de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_channels_slogan_display'), 'Activer l\'affichage des slogans de chaînes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_self_deletion'), 'Autoriser les utilisateur à supprimer leur compte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'drop_my_account'), 'Supprimer mon compte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'account_deletion'), 'Suppression du compte', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'account_deletion_confirmation'), 'Êtes-vous sûr de vouloir supprimer votre compte ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'account_deletion_confirmation_info'), 'Tous vos éléments et votre compte seront supprimés.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'account_deletion_yes'), 'Oui, supprimer !', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'account_deleted'), 'Votre compte a bien été supprimé.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reconversion_started_for_x'), 'La reconversion de %s a été lancée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'resume_conversion'), 'Reprendre la conversion', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'selected_conversion_resumed'), 'Les conversions sélectionnées ont été reprises', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'conversion_not_found_x'), 'Impossible de trouver la conversion %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_not_found_with_filename_x'), 'Impossible de trouver la vidéo du fichier %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'conversion_x_cannot_be_resumed'), 'La conversion de la vidéo "%s" ne peut reprendre à cause de son statut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'conversion_queue_warning'), 'Ceci est une page de configuration avancée. Veuillez vous assurer de bien comprendre les modifications que vous effectuez. Des actions incorrectes peuvent perturber ou casser les conversions vidéo en cours.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_cookie_banner'), 'Activer le bandeau de cookies', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookies'), 'Cookies', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'accept'), 'Accepter', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_uses_cookies'), 'Ce site utilise des cookies.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'necessary_cookies_only'), 'Pour vous offrir la meilleure expérience, ce site utilise des cookies strictement nécessaires.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookies_and_consent'), 'Cookies et Consentement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'undefined'), 'Non défini', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'close'), 'Fermer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_description_quicklist'), 'Permet la fonctionnalité quicklist', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_description_phpsessid'), 'Identifiant de session utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_description_lang'), 'Permet le changement de langue', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_description_theme'), 'Permet le changement de thème', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_description_theme_auto'), 'Permet le changement de thème automatique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_description_age_restrict'), 'Permet l\'accès au contenu restreint', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_description_consent'), 'Permet l\'enregistrement du consentement', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'save_preferences'), 'Sauvegarder les préférences', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cookie_cant_be_disabled'), 'Ce cookie est nécessaire au bon fonctionnement du site et ne peut donc pas être désactivé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'accept_all'), 'Accepter tout', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'refuse_all_optionnal'), 'Refuser tous les optionnels', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'lifetime'), 'Durée de vie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_comment'), 'Aucun commentaire', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'make_public'), 'Rendre publique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'make_private'), 'Rendre privée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'created_x'), 'Créée : %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_made_public'), 'La collection a été basculée en visibilité publique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collection_made_private'), 'La collection a été basculée en visibilité privée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'x_collections_made_public'), '%s collections ont été basculées en visibilité publique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'x_collections_made_private'), '%s collections ont été basculées en visibilité privée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'overall_statistics'), 'Statistiques globales', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_statistics'), 'Statistiques utilisateurs', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_statistics'), 'Statistiques vidéos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reported'), 'Signalés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total'), 'Total', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_photo_ratio'), 'Ratio de la photo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_photo_ratio_help'), 'Votre vignette de photo, et les vignettes de taille moyenne seront reformater en fonction de ces ratios', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_large_photo_width'), 'Largeur des grandes photos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_crop_image'), 'Recadrer les images', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_photo_thumb_size'), 'Taille des vignettes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'width'), 'Largueur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'height'), 'Longueur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_medium_photo_size'), 'Taille des photos moyennes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset'), 'Réinitialiser', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'logo_reset'), 'Le logo a été réinitialisé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'favicon_reset'), 'L\'icône du site a été réinitialisé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_max_photo_categories'), 'Catégories maximum', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_max_photo_categories_hint'), 'Nombre maximum de catégories par photo ; 0 pour aucune limite', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_max_collection_categories'), 'Catégories maximum', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_max_collection_categories_hint'), 'Nombre maximum de catégories par collection ; 0 pour aucune limite', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'request_has_been_canceled'), 'Votre demande d\'ami a été annulée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_unfriend'), 'Voulez-vous vraiment supprimer %s de votre liste des contacts ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'my_collections'), 'Mes collections', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'my_friends_collections'), 'Les collections de mes amis', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'public_collections'), 'Autres collections publiques', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_user_level'), 'Voulez-vous vraiment supprimer ce niveau d\'utilisateur ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'com_manage_subs'), 'Gestion des abonnements de chaîne', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_public_video_page'), 'Activer la page de vidéos publiques', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_public_video_page_tips'), 'Sépare les vidéos publiques dans une page dédiée', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'level_del_sucess'), 'Le niveau d\'utilisateur a bien été supprimé, tous les utilisateurs de ce niveau ont été transféré vers %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'public_videos'), 'Vidéos publiques', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_homepage'), 'Page d\'accueil par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'homepage'), 'Page d\'accueil', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_homepage_desc'), 'Défini la page sur laquelle est redirigé l\'utilisateur à la connexion et au clique sur le logo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_public_video_page'), 'Autoriser la page de vidéos publiques', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'allow_public_video_page_desc'), 'L\'utilisateur peut voir la page de vidéo publique', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'userlevel_cannot_be_default'), 'Ce niveau d\'utilisateur ne peut être mis par défaut', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_userlevel_cannot_be_disabled'), 'Le niveau d\'utilisateur par défaut ne peut être désactivé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'userlevel_cannot_be_disabled'), 'Ce niveau d\'utilisateur ne peut être désactivé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cannot_be_default_until_activated'), 'Le niveau d\'utilisateur ne pas être par défaut s\'il n\'est pas activé', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'file'), 'Fichier', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'submit'), 'Envoyer', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'invalid_subtitle_file'), 'Fichier de sous-titres invalide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'invalid_subtitle_extension'), 'Extension de fichier de sous-titres invalide', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'subtitle_uploaded_successfully'), 'Les sous-titres ont correctement été téléversés', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'file_size_exceeded'), 'La taille du fichier dépasse la limite autorisée de %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_maximum_allowed_subtitle_size'), 'Taille maximale des sous-titres', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_can_upload_subtitles'), 'Activer le téléversement de sous-titres sur le front office', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_upload_subtitle'), 'Le fichier doit être de type STR et peser au maximum %s %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'invalid_subtitle_timer'), 'Un sous-titre dépasse la durée de la vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'upload_subtitles'), 'Téléverser des sous-titres', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'subtitle_already_exists'), 'Ce nom existe déjà pour un autre sous-titre', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'alert_update_core_already_ongoing'), 'Une mise à jour du coeur est déjà en cours, doit-elle être marquée comme ayant échouée ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'alert_update_db_already_ongoing'), 'Une mise à jour de la base de donnée est en cours, doit-elle être marquée comme ayant échouée ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'alert_video_conversion_ongoing'), 'Une conversion vidéo est en cours, voulez-vous continuer la mise à jour ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'miscellaneous_options'), 'Options diverses', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_video_bloc_style'), 'Style du bloc vidéo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'add_member'), 'Créer un nouvel utilisateur', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'new_mem_added'), 'Le nouvel utilisateur a été correctement ajouté', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'max_option_display'), 'Entrer un nombre entre 1 et le maximum', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'display_option'), 'Option d\'affichage', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'inbox'), 'Messagerie', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'anonymous_stats'), 'Envoyer des statistiques d\'utilisation anonymes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'anonymous_stats_hint'), 'Avec votre autorisation, enverra régulièrement des statistiques anonymes, telles que la version de PHP utilisée, le nombre d\'éléments gérés et les configurations, à Oxygenz afin de nous aider à améliorer nos services. Aucune information personnelle, y compris les détails liés à vos comptes utilisateurs, ne sera transmise.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'unknown_task'), 'Tâche inconnue', @language_id);
