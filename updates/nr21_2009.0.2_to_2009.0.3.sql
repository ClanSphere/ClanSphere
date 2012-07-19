UPDATE {pre}_options SET options_value = '2009.0.3' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-12-06' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 48 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_wars ADD wars_topmatch int(2) NOT NULL default 0;