-- Create Magic Database Structures
DROP TABLE collection_likes;
DROP TABLE collection_items;
DROP TABLE collections;
DROP TABLE users;
DROP TABLE cards;
DROP TABLE sets;
DROP TABLE Ncards;
DROP TABLE Nsets;


CREATE TABLE Nsets(
Nname text,
Ncode text,
Ncode_magiccards text,
Ndate text,
Nis_promo text,
Nboosterpack_nM text,
Nboosterpack_nR text,
Nboosterpack_nU text,
Nboosterpack_nC text,
Nboosterpack_nE text,
Nboosterpack_pM text,
Nboosterpack_pR text,
Nboosterpack_typeExtra1 text,
Nboosterpack_typeExtra2 text,
Nboosterpack_listExtra1 text,
Nboosterpack_listExtra2 text,
Nboosterpack_has_foil text,
Nboosterpack_pF text
);

CREATE TABLE Ncards(
Nid text,
Nname text,
Nset text,
Ntype text,
Nrarity text,
Nmanacost text,
Nconverted_manacost text,
Npower text,
Ntoughness text,
Nloyalty text,
Nability text,
Nflavor text,
Nvariation text,
Nartist text,
Nnumber text,
Nrating text,
Nruling text,
Ncolor text,
Ngenerated_mana text,
Npricing_low text,
Npricing_mid text,
Npricing_high text,
Nback_id text,
Nwatermark text,
Nprint_number text,
Nis_original text,
Nname_CN text,
Nname_TW text,
Nname_FR text,
Nname_DE text,
Nname_IT text,
Nname_JP text,
Nname_PT text,
Nname_RU text,
Nname_ES text,
Nname_KO text,
Ntype_CN text,
Ntype_TW text,
Ntype_FR text,
Ntype_DE text,
Ntype_IT text,
Ntype_JP text,
Ntype_PT text,
Ntype_RU text,
Ntype_ES text,
Ntype_KO text,
Nability_CN text,
Nability_TW text,
Nability_FR text,
Nability_DE text,
Nability_IT text,
Nability_JP text,
Nability_PT text,
Nability_RU text,
Nability_ES text,
Nability_KO text,
Nflavor_CN text,
Nflavor_TW text,
Nflavor_FR text,
Nflavor_DE text,
Nflavor_IT text,
Nflavor_JP text,
Nflavor_PT text,
Nflavor_RU text,
Nflavor_ES text,
Nflavor_KO text,
Nlegality_Block text,
Nlegality_Standard text,
Nlegality_Modern text,
Nlegality_Legacy text,
Nlegality_Vintage text,
Nlegality_Highlander text,
Nlegality_French_Commander text,
Nlegality_Tiny_Leaders_Commander text,
Nlegality_Modern_Duel_Commander text,
Nlegality_Commander text,
Nlegality_Peasant text,
Nlegality_Pauper text
);

create table sets
(set_id			INT UNSIGNED	AUTO_INCREMENT
,set_name		VARCHAR(200)
,official_code	VARCHAR(5)
,variant_code	VARCHAR(5)
,release_date	DATE
,constraint pk_set_1 primary key (set_id));

create table cards
(card_id				INT UNSIGNED	AUTO_INCREMENT
,set_id					INT UNSIGNED
,card_name				VARCHAR(255)
,card_type				text
,rarity					text
,mana_cost				text
,converted_mana_cost	text
,power					text
,toughness				text
,loyalty				text
,ability_text			text
,flavor_text			text
,variation_number		text
,artist					text
,collector_number		text
,ruling_text			text
,color 					text
,constraint pk_cards_1 primary key (card_id)
,FOREIGN KEY(set_id) REFERENCES sets(set_id));

Create Table users
(user_id	INT UNSIGNED	AUTO_INCREMENT
,user_type	VARCHAR(30)
,first_name	VARCHAR(100)
,last_name	VARCHAR(100)
,email		VARCHAR(100)
,user_name	VARCHAR(100)
,password	VARCHAR(100)
,number_of_logins	INT
,constraint user_pk	Primary Key(user_id)
,UNIQUE(email)
,UNIQUE(user_name));

Create Table collections
(collection_id	INT UNSIGNED	AUTO_INCREMENT
,user_id	INT UNSIGNED	NOT NULL
,collection_name	VARCHAR(300)
,collection_description	TEXT
,is_public	BOOLEAN
,constraint collections_pk Primary Key(collection_id)
,constraint collections_fk_1 Foreign Key(user_id) 
							 References users(user_id));
							 
Create Table collection_items
(collection_item_id	INT UNSIGNED	AUTO_INCREMENT
,collection_id 		INT UNSIGNED
,card_id			INT UNSIGNED	
,amount				INT 
,constraint	collection_item_pk	Primary Key(collection_item_id)
,constraint collection_item_fk_1 Foreign Key(collection_id)
								 References collections(collection_id)
,constraint collection_item_fk_2 Foreign Key(card_id)
								 References cards(card_id)
);

create table collection_likes
(collection_likes_id 	INT UNSIGNED	AUTO_INCREMENT
,collection_id 			INT UNSIGNED
,user_id				INT UNSIGNED
,constraint cl_pk_1	PRIMARY KEY(collection_likes_id)
,constraint cl_fk_1 FOREIGN KEY(collection_id) references collections(collection_id)
,constraint cl_fk_2 FOREIGN KEY(user_id) references users(user_id)
);

alter table collections add priority INT UNSIGNED;
alter table cards add price FLOAT DEFAULT 0.0;
alter table cards add price_foil FLOAT DEFAULT 0.0;
alter table cards add price_date DATE;

CREATE INDEX card_name_index
ON cards (card_name);