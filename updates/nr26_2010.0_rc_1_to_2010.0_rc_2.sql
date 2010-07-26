UPDATE {pre}_options SET options_value = '2010.0 RC 2' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2010-07-26' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 58 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_access ADD access_lightbox int(2) NOT NULL default '0';

UPDATE {pre}_access SET access_lightbox = access_gallery;