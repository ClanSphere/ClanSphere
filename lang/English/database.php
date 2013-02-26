<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang['mod_name']  = 'Database';
$cs_lang['modtext']  = 'Database actions take place here';

// roots.php
$cs_lang['db_infos'] = 'Database information';
$cs_lang['type'] = 'Database Type';
$cs_lang['subtype'] = 'Storage Engine';
$cs_lang['encoding'] = 'Encoding';
$cs_lang['client'] = 'Client Version';
$cs_lang['host'] = 'Database host';
$cs_lang['server'] = 'Server Version';
$cs_lang['tables']  = 'Tables';
$cs_lang['usage'] = 'Usage';
$cs_lang['data'] = 'Data';
$cs_lang['indexe'] = 'Indexes';
$cs_lang['overhead'] = 'Overhead';
$cs_lang['db_integrity'] = 'Database integrity';
$cs_lang['table_double_owned'] = 'SQL-Table "%s" is owned by more than one module: "%s" and "%s"';
$cs_lang['table_not_owned'] = 'SQL-Table "%s" is not owned by any module';
$cs_lang['table_not_found'] = 'SQL-Table "%s" required by module "%s" not found';
$cs_lang['db_check_passed'] = 'All checks passed';
$cs_lang['access_not_found'] = 'SQL-Table "access" has no column for module "%s"';

$cs_lang['roots'] = 'Roots';
$cs_lang['body_roots']  = 'Please select from the following options.';
$cs_lang['import'] = 'Import';
$cs_lang['body_import']  = 'SQL-Imports are applied here';
$cs_lang['export'] = 'Export';
$cs_lang['body_export']  = 'Generate backups for data safety';
$cs_lang['optimize']  = 'Optimize';
$cs_lang['body_optimize']  = 'Removes unused space from database tables';
$cs_lang['statistic']  = 'Statistic';
$cs_lang['body_statistic']  = 'Show installed modules with their database usage';

$cs_lang['optimize_tables'] = 'Optimize tables';
$cs_lang['sql_datasets']    = 'SQL datasets';
$cs_lang['sql_tables']      = 'SQL tables';
$cs_lang['sql_text']        = 'SQL text';
$cs_lang['sql_options']      = 'SQL options';
$cs_lang['sql_file']        = 'SQL file';
$cs_lang['modul']           = 'Modul';
$cs_lang['run']              = 'Run';

$cs_lang['update_done']      = 'Update successfully applied';
$cs_lang['update_error']    = 'Errors occured inside the update';
$cs_lang['actions_done']    = 'Finished actions';

$cs_lang['all']           = 'All';
$cs_lang['none']          = 'None';
$cs_lang['reverse']       = 'Reverse';
$cs_lang['prefix']        = 'Prefix';
$cs_lang['datasets']      = 'Datasets';
$cs_lang['send_truncate'] = 'Truncate tables before actions are done';
$cs_lang['output']        = 'Output';
$cs_lang['text']          = 'Text';
$cs_lang['file']          = 'File';
$cs_lang['no_tables']     = 'You must select one or more tables';
$cs_lang['tables']        = 'Tables';
$cs_lang['sql_data_for']  = 'SQL data for table "%s"';

$cs_lang['error_inst_sql'] = "The <b>install.sql</b> file can not be imported, <br />because it is only needed for the' ";
$cs_lang['error_inst_sql'] .= "<b>Installation</b>.<br />";
$cs_lang['error_inst_sql'] .= "If you wish an update, please use the SQL update files from the directory <br /><b>\"updates/clansphere\"</b>";