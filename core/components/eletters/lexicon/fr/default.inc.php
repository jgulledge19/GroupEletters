<?php
/**
 * Default French Lexicon Entries for ELetters
 *
 * @package ELetters
 * @subpackage lexicon
 */

//general
$_lang['eletters'] = 'ELetters';
$_lang['eletters.desc'] = 'Gestionnaire de Newsletters pour Modx';
$_lang['eletters.menu'] = 'Menu';
$_lang['eletters.search...'] = 'Rechercher...';

//newsletters
$_lang['eletters.newsletters'] = 'Newsletters';
$_lang['eletters.newsletters.subject'] = 'Objet';
$_lang['eletters.newsletters.date'] = 'Date de Début - Date de Fin';
$_lang['eletters.newsletters.document'] = 'Document';
$_lang['eletters.newsletters.sent'] = 'Envoyé';
$_lang['eletters.newsletters.delivered'] = 'Remis';
$_lang['eletters.newsletters.bounced'] = 'Refoulé';
$_lang['eletters.newsletters.opened'] = 'Ouvert/lu';
$_lang['eletters.newsletters.clicks'] = 'Clicks';

$_lang['eletters.newsletters.new'] = 'Créer newsletter';
$_lang['eletters.newsletters.groups'] = 'Groupes';
$_lang['eletters.newsletters.remove'] = 'Supprimer newsletter';
$_lang['eletters.newsletters.remove.title'] = 'Supprimer newsletter?';
$_lang['eletters.newsletters.remove.confirm'] = 'Êtes-vous sur de vouloir supprimer cette Newsletter et les données associées ?';
$_lang['eletters.newsletters.saved'] = 'Newsletter sauvée (programmée)';
$_lang['eletters.newsletters.err.save'] = 'Impossible de sauver/programmer la newsletter';
$_lang['eletters.newsletters.err.nf'] = 'Impossible d\'ouvrir le document';
$_lang['eletters.newsletters.err.remove'] = 'Impossible de supprimer la newsletter';
// Queue
$_lang['eletters.queue.ran'] = 'Queue d\envoi des Newsletters exécutée avec succès';
$_lang['eletters.queue.ran.err'] = 'La queue d\'envoi des Newsletters n\'a pu envoyer d\'emails';

//groups
$_lang['eletters.groups'] = 'Groupes';
$_lang['eletters.groups.name'] = 'Nom';
$_lang['eletters.groups.public'] = 'Public';
$_lang['eletters.groups.public.desc'] = 'Public (Inscription autorisée via un formulaire)';
$_lang['eletters.groups.active'] = 'Actif';
$_lang['eletters.groups.description'] = 'Description';
$_lang['eletters.groups.department'] = 'Département';
$_lang['eletters.groups.allow_signup'] = 'Autoriser l\'inscription';

$_lang['eletters.groups.members'] = 'Membres';
$_lang['eletters.groups.new'] = 'Nouveau groupe';
$_lang['eletters.groups.edit'] = 'Modifier groupe';
$_lang['eletters.groups.remove'] = 'Supprimer groupe';
$_lang['eletters.groups.remove.title'] = 'Supprimer le groupe ?';
$_lang['eletters.groups.remove.confirm'] = 'Êtes-vous sur de vouloir supprimer ce groupe ? Les abonnés ne seront pas supprimés';
$_lang['eletters.groups.update'] = 'Mettre à jour groupe';
$_lang['eletters.groups.saved'] = 'Groupe sauvé';
$_lang['eletters.groups.err.nf'] = 'Groupe non trouvé';
$_lang['eletters.groups.err.save'] = 'Impossible de sauver ce groupe';

//subscribers
$_lang['eletters.subscribers.basic_info'] = 'Basic';
$_lang['eletters.subscribers.groups_info'] = 'Groupes';
$_lang['eletters.subscribers.address_info'] = 'Téléphone &amp; Addresse';
$_lang['eletters.subscribers'] = 'Abonnés';
$_lang['eletters.subscribers.first_name'] = 'Prénom';
$_lang['eletters.subscribers.m_name'] = 'Surnom';
$_lang['eletters.subscribers.last_name'] = 'Nom';
$_lang['eletters.subscribers.company'] = 'Société';
$_lang['eletters.subscribers.email'] = 'Email';
$_lang['eletters.subscribers.crm_id'] = 'CRM ID';
$_lang['eletters.subscribers.address'] = 'Rue';
$_lang['eletters.subscribers.city'] = 'Ville';
$_lang['eletters.subscribers.state'] = 'Etat';
$_lang['eletters.subscribers.zip'] = 'Code postal';
$_lang['eletters.subscribers.country'] = 'Pays';
$_lang['eletters.subscribers.phone'] = 'Téléphone';
$_lang['eletters.subscribers.cell'] = 'Mobile';
$_lang['eletters.subscribers.active'] = 'Actif';
$_lang['eletters.subscribers.date_created'] = 'Date de création';
$_lang['eletters.subscribers.code'] = 'Code généré';


$_lang['eletters.subscribers.signupdate'] = 'Date d\'inscription';
$_lang['eletters.subscribers.new'] = 'Nouvel abonné';
$_lang['eletters.subscribers.exportcsv'] = 'Export CSV';
$_lang['eletters.subscribers.importcsv'] = 'Import CSV';
$_lang['eletters.subscribers.importcsv.example'] = 'Exemple CSV simple';
$_lang['eletters.subscribers.importcsv.completeExample'] = 'Exemple CSV complet';
$_lang['eletters.subscribers.importcsv.start'] = 'Démarrer import';
$_lang['eletters.subscribers.importcsv.file'] = 'Fichier';
$_lang['eletters.subscribers.importcsv.results'] = 'Resultats';
$_lang['eletters.subscribers.importcsv.err.uploadfile'] = 'Téléchargez préalablement un fichier';
$_lang['eletters.subscribers.importcsv.err.cantopenfile'] = 'Fichier impossible à ouvrir';
$_lang['eletters.subscribers.importcsv.err.firstrow'] = 'La première ligne doit contenir les noms des colonnes (la première colonne doit être l\'email)';
$_lang['eletters.subscribers.importcsv.err.cantsaverow'] = 'Impossible de sauver la ligne [[+rownum]]';
$_lang['eletters.subscribers.importcsv.err.skippedrow'] = 'Ligne sautée [[+rownum]]';
// Updated in 1.0RC2
$_lang['eletters.subscribers.importcsv.msg.complete'] = 'Nombre de nouveaux enregistrements : [[+newCount]] <br>Enregistrements existants non modifiés : [[+existCount]] '.
        '<br>Enregistrements CSV invalides : [[+invalidCount]] <br>Total des enregistrements dans le fichier CSV : [[+csvCount]]';
// 'Import complete. Imported [[+importCount]] records ([[+newCount]] new)';
$_lang['eletters.subscribers.confirm.subject'] = 'Confirmez votre abonnement à la newsletter';
$_lang['eletters.subscribers.confirm.success'] = 'Vous êtes maintenant inscrit à notre newsletter.';
$_lang['eletters.subscribers.confirm.err'] = 'Combinaison Abonné / code incorrect.';
$_lang['eletters.subscribers.signup.err.emailunique'] = 'Adresse Email déjà utilisé';
$_lang['eletters.subscribers.unsubscribe.success'] = 'Vous êtes retiré de notre mailing list.';
$_lang['eletters.subscribers.unsubscribe.err'] = 'Abonné introuvable.';
$_lang['eletters.subscribers.active'] = 'Actif';
$_lang['eletters.subscribers.groups'] = 'Groupes';
$_lang['eletters.subscribers.remove'] = 'Supprimer abonné';
$_lang['eletters.subscribers.remove.title'] = 'Supprimer l\'abonné ?';
$_lang['eletters.subscribers.remove.confirm'] = 'Êtes-vous sur de vouloir supprimer cet abonné ?';
$_lang['eletters.subscribers.update'] = 'Mise à jour abonné';
$_lang['eletters.subscribers.saved'] = 'Abonné sauvé';
$_lang['eletters.subscribers.err.save'] = 'Erreur pendant la sauvegarde de l\'abonné';
$_lang['eletters.subscribers.err.ae'] = 'Un abonné avec la même adresse email existe déjà';


//system settings
$_lang['setting_eletters.batchSize'] = 'Taille du Batch';
$_lang['setting_eletters.batchSize_desc'] = 'Le nombre d\'emails à envoyer par batch d\'envois.  20 par défaut.';
$_lang['setting_eletters.delay'] = 'Délai';
$_lang['setting_eletters.delay_desc'] = 'Le délai en secondes entre chaque batch d\'envois.  10 par défaut.';
$_lang['setting_eletters.debug'] = 'Debug';
$_lang['setting_eletters.debug_desc'] = 'Si configuré à "oui", alors le log des erreurs contiendra des messages de débug pour vérifier les erreurs.';
$_lang['setting_eletters.confirmPageID'] = 'Page de confirmation';
$_lang['setting_eletters.confirmPageID_desc'] = 'L\'ID de la ressource correspondant à la page de confirmation';
$_lang['setting_eletters.manageSubscriptionsPageID'] = 'La page de gestion des abonnements';
$_lang['setting_eletters.manageSubscriptionsPageID_desc'] = 'L\'ID de la ressource qui est la page de gestion des abonnements';
$_lang['setting_eletters.unsubscribePageID'] = 'Page de résiliation';
$_lang['setting_eletters.unsubscribePageID_desc'] = 'L\'ID de la ressource correspondant à la page de résiliation d\'abonnement';
$_lang['setting_eletters.trackingPageID'] = 'Page de suivi des traces (tracking)';
$_lang['setting_eletters.trackingPageID_desc'] = 'L\'ID de la ressource correspondant à la page de redirection de Tracking';
$_lang['setting_eletters.deniedPageID'] = 'Page de refus d\'accès';
$_lang['setting_eletters.deniedPageID_desc'] = 'L\'ID de la ressource à afficher si vous avez configurer la newsletter à "privée" et qu\'un internaute tente d\'accéder sans code unique.';
$_lang['setting_eletters.useUrlTracking'] = 'URL de Tracking';
$_lang['setting_eletters.useUrlTracking_desc'] = 'Configurez à "vrai" pour utiliser le suivi des clicks sur les URLs';

// replyEmail, fromEmail, fromName
$_lang['setting_eletters.replyEmail'] = 'Adresse email "Reply"';
$_lang['setting_eletters.replyEmail_desc'] = 'L\'adresse email de réponse par défaut';
$_lang['setting_eletters.fromEmail'] = 'addresse email "From Email"';
$_lang['setting_eletters.fromEmail_desc'] = 'L\'adresse email d\'envoi par défaut';
$_lang['setting_eletters.fromName'] = '"From Name"';
$_lang['setting_eletters.fromName_desc'] = 'Le nom affiché par défaut';
$_lang['setting_eletters.testPrefix'] = 'Préfixe de l\'objet du mail de Test';
$_lang['setting_eletters.testPrefix_desc'] = 'Indiquez une valeur au préfixe de l\'objet des mails de tests envoyés.';



/** Settings - remove these..
$_lang['eletters.settings'] = 'Settings';
$_lang['eletters.settings.name'] = 'Name';
$_lang['eletters.settings.email'] = 'Email';
$_lang['eletters.settings.bounceemail'] = 'Bounce email address';
$_lang['eletters.settings.template'] = 'Template';
$_lang['eletters.settings.saved'] = 'Settings saved';
$_lang['eletters.settings.error'] = 'Error while saving settings';
*/
