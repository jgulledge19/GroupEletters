<?php
/**
 * Default Czech Lexicon Entries for Eletters
 *
 * @package ELetters
 * @subpackage lexicon
 */

//general
$_lang['eletters'] = 'Eletters';
$_lang['eletters.desc'] = 'Správce e-mailových newsletterů pro MODX';
$_lang['eletters.menu'] = 'Menu';
$_lang['eletters.search...'] = 'Hledat...';

//newsletters
$_lang['eletters.newsletters'] = 'Newslettery';
$_lang['eletters.newsletters.subject'] = 'předmět';
$_lang['eletters.newsletters.date'] = 'Datum Od - Do';
$_lang['eletters.newsletters.document'] = 'Dokument';
$_lang['eletters.newsletters.sent'] = 'Odesláno';
$_lang['eletters.newsletters.delivered'] = 'Doručeno';
$_lang['eletters.newsletters.bounced'] = 'Zahozeno';
$_lang['eletters.newsletters.opened'] = 'Otevřeno/Přečteno';
$_lang['eletters.newsletters.clicks'] = 'Odkliknutí';

$_lang['eletters.newsletters.new'] = 'Nový newsletter';
$_lang['eletters.newsletters.groups'] = 'Skupiny';
$_lang['eletters.newsletters.remove'] = 'Odstranit newsletter';
$_lang['eletters.newsletters.remove.title'] = 'Odstranit newsletter?';
$_lang['eletters.newsletters.remove.confirm'] = 'Opravdu chcete odstranit tento newsletter a všechna jeho data?';
$_lang['eletters.newsletters.saved'] = 'Newsletter uložen (naplánován)';
$_lang['eletters.newsletters.err.save'] = 'Nemohu uložit/naplánovat newsletter';
$_lang['eletters.newsletters.err.nf'] = 'Nemohu otevřít/najít dokument';
$_lang['eletters.newsletters.err.remove'] = 'Nemohu odstranit newsletter';
// Queue
$_lang['eletters.queue.ran'] = 'Fronta newsletterů proběhla v pořádku';
$_lang['eletters.queue.ran.err'] = 'Fronta newsletterů nemůže odeslat e-maily';

//groups
$_lang['eletters.groups'] = 'Skupiny';
$_lang['eletters.groups.name'] = 'Jméno';
$_lang['eletters.groups.public'] = 'Veřejná';
$_lang['eletters.groups.public.desc'] = 'Veřejná (odběratelé se mohou přihlásit formulářem)';
$_lang['eletters.groups.active'] = 'Aktivní';
$_lang['eletters.groups.description'] = 'Popis';
$_lang['eletters.groups.department'] = 'Oddělení';
$_lang['eletters.groups.allow_signup'] = 'Přihlášení možné';

$_lang['eletters.groups.members'] = 'Odběratelé';
$_lang['eletters.groups.new'] = 'Nová skupina';
$_lang['eletters.groups.edit'] = 'Upravit skupinu';
$_lang['eletters.groups.remove'] = 'Odstranit skupinu';
$_lang['eletters.groups.remove.title'] = 'Odstranit skupinu?';
$_lang['eletters.groups.remove.confirm'] = 'Opravdu chcete odstranit tuto skupinu? Odběratelé nebudou smazáni.';
$_lang['eletters.groups.update'] = 'Upravit skupinu';
$_lang['eletters.groups.saved'] = 'Skupina uložena';
$_lang['eletters.groups.err.nf'] = 'Skupina nenalezena';
$_lang['eletters.groups.err.save'] = 'Nemohu uložit skupinu';

//subscribers
$_lang['eletters.subscribers.basic_info'] = 'Záklaní informace';
$_lang['eletters.subscribers.groups_info'] = 'Skupiny';
$_lang['eletters.subscribers.address_info'] = 'Telefon a adresa';
$_lang['eletters.subscribers'] = 'Odběratalé';
$_lang['eletters.subscribers.first_name'] = 'Jméno';
$_lang['eletters.subscribers.m_name'] = 'Další jméno';
$_lang['eletters.subscribers.last_name'] = 'Příjmení';
$_lang['eletters.subscribers.company'] = 'Společnost';
$_lang['eletters.subscribers.email'] = 'E-mail';
$_lang['eletters.subscribers.crm_id'] = 'CRM ID';
$_lang['eletters.subscribers.address'] = 'Ulice';
$_lang['eletters.subscribers.city'] = 'Město/obec';
$_lang['eletters.subscribers.state'] = 'Kraj';
$_lang['eletters.subscribers.zip'] = 'PSČ';
$_lang['eletters.subscribers.country'] = 'Stát';
$_lang['eletters.subscribers.phone'] = 'Telefon';
$_lang['eletters.subscribers.cell'] = 'Mobilní telefon';
$_lang['eletters.subscribers.active'] = 'Aktivní';
$_lang['eletters.subscribers.date_created'] = 'Datum vytvoření';
$_lang['eletters.subscribers.code'] = 'Vygenerovaný kód';


$_lang['eletters.subscribers.signupdate'] = 'Datum přihlášení';
$_lang['eletters.subscribers.new'] = 'Nový odběratel';
$_lang['eletters.subscribers.exportcsv'] = 'Export CSV';
$_lang['eletters.subscribers.importcsv'] = 'Import CSV';
$_lang['eletters.subscribers.importcsv.start'] = 'Spustit import';
$_lang['eletters.subscribers.importcsv.file'] = 'Soubor';
$_lang['eletters.subscribers.importcsv.results'] = 'Výsledky';
$_lang['eletters.subscribers.importcsv.err.uploadfile'] = 'Prosím, nahrajte soubor';
$_lang['eletters.subscribers.importcsv.err.cantopenfile'] = 'Nemohu otevřít soubor';
$_lang['eletters.subscribers.importcsv.err.firstrow'] = 'První řádek musí obsahovat názvy sloupců (první sloupec musí obsahovat e-mail)';
$_lang['eletters.subscribers.importcsv.err.cantsaverow'] = 'Nemohu uložit řádek [[+rownum]]';
$_lang['eletters.subscribers.importcsv.err.skippedrow'] = 'Řádek [[+rownum]] přeskočen';
$_lang['eletters.subscribers.importcsv.msg.complete'] = 'Import dokončen. Importováno [[+importCount]] záznamů ([[+newCount]] nových)';
$_lang['eletters.subscribers.confirm.subject'] = 'Potvrďte vaše přihlášení k odběru e-mail newsletteru';
$_lang['eletters.subscribers.confirm.success'] = 'Nyní jste přihlášeni k odběru newsletteru.';
$_lang['eletters.subscribers.confirm.err'] = 'Chybná kombinace odběratel/kód.';
$_lang['eletters.subscribers.signup.err.emailunique'] = 'E-mailová adresa je již přihlášena';
$_lang['eletters.subscribers.unsubscribe.success'] = 'Byli jste odhlášeni z odběru newsletteru.';
$_lang['eletters.subscribers.unsubscribe.err'] = 'Odběratel nenalezen.';
$_lang['eletters.subscribers.active'] = 'Aktivní';
$_lang['eletters.subscribers.groups'] = 'Skupiny';
$_lang['eletters.subscribers.remove'] = 'Odstranit odběratele';
$_lang['eletters.subscribers.remove.title'] = 'Odstranit odběratele?';
$_lang['eletters.subscribers.remove.confirm'] = 'Opravdu chcete odstranit odběratele?';
$_lang['eletters.subscribers.update'] = 'Upravit odběratele';
$_lang['eletters.subscribers.saved'] = 'Odběratel uložen';
$_lang['eletters.subscribers.err.save'] = 'Došlo k chybě při ukládání odběratele';
$_lang['eletters.subscribers.err.ae'] = 'Odběratel se stejnou e-mailovou adresou již existuje';


//system settings
$_lang['setting_eletters.batchSize'] = 'Velikost dávky';
$_lang['setting_eletters.batchSize_desc'] = 'Počet e-mailů odeslaných v jedné dávce. Výchozí je 20.';
$_lang['setting_eletters.delay'] = 'Prodleva';
$_lang['setting_eletters.delay_desc'] = 'Prodleva v sekundách mezi e-maily odeslanými v dávce. Výchozí je 10.';
$_lang['setting_eletters.debug'] = 'Ladění';
$_lang['setting_eletters.debug_desc'] = 'Pokud je zapnuto, chybový log bude obsahovat ladící informace pro kontrolu chyb.';
$_lang['setting_eletters.confirmPageID'] = 'Potvrzovací stránka';
$_lang['setting_eletters.confirmPageID_desc'] = 'ID dokumentu pro potvrzení odběrů.';
$_lang['setting_eletters.manageSubscriptionsPageID'] = 'Stránka správy odběratelů';
$_lang['setting_eletters.manageSubscriptionsPageID_desc'] = 'ID dokumentu pro správu odběratelů';
$_lang['setting_eletters.unsubscribePageID'] = 'Odhlašovací stránka';
$_lang['setting_eletters.unsubscribePageID_desc'] = 'ID dokumentu stránky pro odhlášení';
$_lang['setting_eletters.trackingPageID'] = 'Přesměrovací stránka';
$_lang['setting_eletters.trackingPageID_desc'] = 'ID dokumentu s přesměrováním pro sledování odkliků newsletteru';
$_lang['setting_eletters.useUrlTracking'] = 'Používat sledování odkliků';
$_lang['setting_eletters.useUrlTracking_desc'] = 'Zapněte na true pro aktivaci sledování odkliků newsletteru';

// replyEmail, fromEmail, fromName
$_lang['setting_eletters.replyEmail'] = 'E-mail pro odpovědi';
$_lang['setting_eletters.replyEmail_desc'] = 'Výchozí e-mail pro odpovědi';
$_lang['setting_eletters.fromEmail'] = 'E-mail odesílatel';
$_lang['setting_eletters.fromEmail_desc'] = 'Výchozí e-mailová adresa odesílatele';
$_lang['setting_eletters.fromName'] = 'Jméno odesílatek';
$_lang['setting_eletters.fromName_desc'] = 'Výchozí jméno odesílatele';



/** Settings - remove these..
$_lang['eletters.settings'] = 'Settings';
$_lang['eletters.settings.name'] = 'Name';
$_lang['eletters.settings.email'] = 'Email';
$_lang['eletters.settings.bounceemail'] = 'Bounce email address';
$_lang['eletters.settings.template'] = 'Template';
$_lang['eletters.settings.saved'] = 'Settings saved';
$_lang['eletters.settings.error'] = 'Error while saving settings';
*/