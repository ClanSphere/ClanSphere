UPDATE {pre}_options SET options_value = '2011.4.5' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2014-12-09' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '97' WHERE options_mod = 'clansphere' AND options_name = 'version_id';


ALTER TABLE {pre}_access ADD access_captcha int(2) NOT NULL default '0';
UPDATE {pre}_access SET access_captcha = '5' WHERE access_id = '5';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('captcha','method','standard');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('captcha','recaptcha_private_key','');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('captcha','recaptcha_public_key','');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('captcha','areyouahuman_scoring_key','');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('captcha','areyouahuman_publisher_key','');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('captcha','areyouahuman_lightbox','0');

ALTER TABLE {pre}_account CHANGE account_iban account_iban VARCHAR( 43 ) NULL default NULL;