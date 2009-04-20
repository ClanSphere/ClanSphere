UPDATE {pre}_options SET options_value = '2009.0_svn' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-04-23' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '39' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

DELETE FROM {pre}_options WHERE options_mod = 'fckeditor' AND options_name = 'mode';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_html', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_more', '');