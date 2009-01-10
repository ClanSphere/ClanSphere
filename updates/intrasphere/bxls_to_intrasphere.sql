ALTER TABLE {pre}_lanpartys DROP lanpartys_postalcode;

ALTER TABLE {pre}_lanpartys ADD lanpartys_postalcode varchar(8) NOT NULL default '';