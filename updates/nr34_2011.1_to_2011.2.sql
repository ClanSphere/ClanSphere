UPDATE {pre}_options SET options_value = '2011.2' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2011-07-06' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '74' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_boardvotes ADD boardvotes_several int(2) NOT NULL default '0';