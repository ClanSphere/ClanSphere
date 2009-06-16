UPDATE {pre}_options SET options_value = '2009.0.1 SVN' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-06-14' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 43 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

UPDATE {pre}_users SET users_view = '' WHERE users_view NOT IN ('float', 'list');