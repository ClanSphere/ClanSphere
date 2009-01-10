ALTER TABLE {pre}_access ADD access_converter INT( 2 ) NOT NULL default '0';
UPDATE {pre}_access SET access_converter = '0' WHERE access_id = '1';
UPDATE {pre}_access SET access_converter = '0' WHERE access_id = '2';
UPDATE {pre}_access SET access_converter = '0' WHERE access_id = '3';
UPDATE {pre}_access SET access_converter = '0' WHERE access_id = '4';
UPDATE {pre}_access SET access_converter = '5' WHERE access_id = '5';