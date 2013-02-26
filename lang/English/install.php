<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang['mod_name']  = 'Installation';
$cs_lang['modtext']  = 'Installs ClanSphere';

$cs_lang['head_list']  = 'List';
$cs_lang['body_list']  = 'Welcome to the installation of ClanSphere!' . cs_html_br(2) . 'Please choose a language:';

$cs_lang['lang'] = 'Language';

$cs_lang['language_choose'] = 'Language Selection';
$cs_lang['install_check'] = 'Installation Check';
$cs_lang['license'] = 'License';
$cs_lang['configuration'] = 'Configuration';
$cs_lang['database'] = 'Database';
$cs_lang['login'] = 'Login';

$cs_lang['this_is_compatible_check'] = 'Here we check whether this webserver suits ClanSphere.';
$cs_lang['enough'] = 'Enough';
$cs_lang['compatible_database'] = 'Compatible database';
$cs_lang['change'] = 'Change';
$cs_lang['create_admin_head'] = 'Create Webmaster';
$cs_lang['last_check'] = 'Last Check';

$cs_lang['check'] = 'Check';
$cs_lang['found'] = 'Found';
$cs_lang['required'] = 'Required';
$cs_lang['any']  = 'Any';
$cs_lang['recommend'] = 'Recommended';
$cs_lang['php_mod']  = 'PHP Module';
$cs_lang['db_support']  = 'Supported databases';
$cs_lang['short_open_tag'] = 'Open PHP like XML';
$cs_lang['file_uploads'] = 'Upload files';
$cs_lang['reg_global'] = 'Register Globals';
$cs_lang['magic_quotes'] = 'Magic Quotes';
$cs_lang['safe_mode'] = 'Safe Mode';
$cs_lang['trans_sid'] = 'Transparent SessionID';
$cs_lang['basedir_restriction'] = 'Basedir restriction';
$cs_lang['allow_url_fopen'] = 'Allow remote files';
$cs_lang['allow_url_include'] = 'Allow remote include';
$cs_lang['gd_extension'] = 'GD Extension';
$cs_lang['off']  = 'off';
$cs_lang['on'] = 'on';

$cs_lang['check_perfect'] = 'All checked settings are perfectly set up to start your ClanSphere experience!';
$cs_lang['check_ok'] = 'ClanSphere is going to run in this environment, but some settings are not very comfortable.';
$cs_lang['check_failed'] = 'Caused by the upper issues it is not possible to install ClanSphere here!';

$cs_lang['head_complete']  = 'End';
$cs_lang['rem_install']  = '- Remove installation files';
$cs_lang['set_chmod']  = '- New rights for directories (CHMOD)';
$cs_lang['remove_file'] = 'Please remove file manually:';
$cs_lang['err_chmod']  = 'Error: Please set rights for directory "uploads",';
$cs_lang['err_chmod']  .= ' as well as all sub-directories manually on CHMOD 777';

$cs_lang['login']  = 'Login';

$cs_lang['head_license']  = 'License';
$cs_lang['body_license']  = 'Required condition for usage';

$cs_lang['accept_done'] = 'Conditions successfully accepted';
$cs_lang['accept_license'] = 'Read and accepted';
$cs_lang['not_accepted'] = '- You have to accept the conditions';
$cs_lang['send'] = 'Send';

$cs_lang['head_settings']  = 'Configuration';
$cs_lang['body_settings']  = 'Creating a setup file for the portal';

$cs_lang['hash'] = 'Encryption type';
$cs_lang['hash_info'] = 'Sha1 is recommended';
$cs_lang['type'] = 'Database Type';
$cs_lang['type_info'] = 'In most cases this will be MySQL (mysql)';
$cs_lang['subtype'] = 'Database Storage Engine';
$cs_lang['subtype_info'] = 'MySQL only! Defaults to myisam if empty';
$cs_lang['place'] = 'Location of Database';
$cs_lang['place_info'] = 'Insert an IP, DNS, or nothing for UNIX Domain Socket';
$cs_lang['sqlite_info'] = 'If SQLite please enter the total path to the database file.';
$cs_lang['user'] = 'User (Database)';
$cs_lang['pwd'] = 'Password (Database)';
$cs_lang['db_name'] = 'Name of Database';
$cs_lang['prefix'] = 'Table Prefix';
$cs_lang['more'] = 'More';
$cs_lang['save_actions'] = ' Log database querys.';
$cs_lang['save_errors'] = ' Log common portal errors.';
$cs_lang['charset'] = 'Charset';

$cs_lang['no_hash'] = '-  An encryption type must be selected!';
$cs_lang['no_type'] = '- A database type must be selected';
$cs_lang['no_name'] = '- Name may not be empty';
$cs_lang['prefix_err'] = '- Empty or invalid prefix. Special chars are not allowed!';
$cs_lang['db_err'] = '- DB Error:';
$cs_lang['file_err'] = '- Setup file couldn\'t be written, check chmod!';

$cs_lang['save_file'] = 'Please copy and paste the contents to a file called "setup.php" and place it in the clansphere base directory. Then restart the installation!';

$cs_lang['setup_exists'] = 'Found existing setup file.';
$cs_lang['inst_create_done'] = 'Database found and setup file created.';

$cs_lang['head_sql']  = 'Database';
$cs_lang['body_sql']  = 'Tables and Entries are made';

$cs_lang['create_admin']  = 'Creation of an administrator account.';
$cs_lang['nick']  = 'Nick';
$cs_lang['email']  = 'Email';
$cs_lang['password'] = 'Password';
$cs_lang['admin_done'] = 'Administrator successfully created';

$cs_lang['short_nick'] = '- Entered nick is too short (min. 4)';
$cs_lang['short_pwd'] = '- Entered password is too short (min. 4)';
$cs_lang['email_false'] = '- Entered email-address is not valid';

$cs_lang['db_error'] = 'Database Error';
$cs_lang['remove_and_again'] = 'Remove installed part and try again';

$cs_lang['guest']  = 'Guest';
$cs_lang['community']  = 'User';
$cs_lang['member']  = 'Member';
$cs_lang['orga']  = 'Organisator';
$cs_lang['admin']  = 'Webmaster';

// Labels
$cs_lang['show_groups_as'] = 'Show groups as';

$cs_lang['clan'] = 'Clan';
$cs_lang['association'] = 'Association';
$cs_lang['club'] = 'Club';
$cs_lang['guild'] = 'Guild';
$cs_lang['enterprise'] = 'Enterprise';
$cs_lang['school'] = 'School';

$cs_lang['show_subgroups_as'] = 'Show subgroups as';

$cs_lang['squads'] = 'Squads';
$cs_lang['groups'] = 'Groups';
$cs_lang['sections'] = 'Sections';
$cs_lang['teams'] = 'Teams';
$cs_lang['class'] = 'Class';

$cs_lang['show_members_as'] = 'Show members as';

$cs_lang['members'] = 'Members';
$cs_lang['employees'] = 'Employees';
$cs_lang['teammates'] = 'Teammates';
$cs_lang['classmates'] = 'Classmates';

$cs_lang['full_install'] = 'Complete Installation';
$cs_lang['module_select'] = 'Select Modules';

$cs_lang['mark_all'] = 'Mark all';
$cs_lang['unmark_all'] = 'Unmark all';

$cs_lang['database_modselect'] = 'Please select database &raquo; modules';
$cs_lang['select_module'] = 'Please select the modules to be installed';
$cs_lang['sys_module'] = 'System Modules';
$cs_lang['opt_module'] = 'Optional Modules';
$cs_lang['install'] = 'Install';
$cs_lang['abcode'] = 'Abcode';
$cs_lang['access'] = 'Access';
$cs_lang['article'] = 'Articles';
$cs_lang['awards'] = 'Awards';
$cs_lang['banner'] = 'Banners';
$cs_lang['board'] = 'Board';
$cs_lang['boardmods'] = 'Boardmods';
$cs_lang['boardranks'] = 'Boardranks';
$cs_lang['buddys'] = 'Buddys';
$cs_lang['captcha'] = 'Captcha';
$cs_lang['cash'] = 'Cash';
$cs_lang['categories'] = 'Categories';
$cs_lang['clans'] = 'Clans';
$cs_lang['clansphere'] = 'ClanSphere';
$cs_lang['comments'] = 'Comments';
$cs_lang['computers'] = 'Computers';
$cs_lang['contact'] = 'Contact';
$cs_lang['count'] = 'Counter';
$cs_lang['errors'] = 'Errors';
$cs_lang['events'] = 'Events';
$cs_lang['explorer'] = 'Explorer';
$cs_lang['faq'] = 'F.A.Q.';
$cs_lang['ckeditor'] = 'WYSIWYG CKeditor';
$cs_lang['fightus'] = 'Fightus';
$cs_lang['files'] = 'Files';
$cs_lang['gallery'] = 'Gallery';
$cs_lang['games'] = 'Games';
$cs_lang['gbook'] = 'Guestbook';
$cs_lang['history'] = 'History';
$cs_lang['joinus'] = 'Joinus';
$cs_lang['links'] = 'Links';
$cs_lang['linkus'] = 'Link us';
$cs_lang['logs'] = 'Logs';
$cs_lang['maps'] = 'Maps';
$cs_lang['members'] = 'Members';
$cs_lang['messages'] = 'Messages';
$cs_lang['modules'] = 'Modules';
$cs_lang['news'] = 'News';
$cs_lang['newsletter'] = 'Newsletter';
$cs_lang['options'] = 'Options';
$cs_lang['partner'] = 'Partners';
$cs_lang['quotes'] = 'Quotes';
$cs_lang['ranks'] = 'Ranks';
$cs_lang['replays'] = 'Replays';
$cs_lang['rules'] = 'Rules';
$cs_lang['search'] = 'Search';
$cs_lang['servers'] = 'Servers';
$cs_lang['shoutbox'] = 'Shoutbox';
$cs_lang['squads'] = 'Squads';
$cs_lang['static'] = 'Statc Sites';
$cs_lang['updates'] = 'Updates';
$cs_lang['users'] = 'Users';
$cs_lang['usersgallery'] = 'Usersgallery';
$cs_lang['votes'] = 'Votes';
$cs_lang['wars'] = 'Clanwars';
$cs_lang['wizard'] = 'Installation Wizard';
$cs_lang['clansphere_core'] = 'ClanSphere Base';
$cs_lang['metatags'] = 'Metatags';