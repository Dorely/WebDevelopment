drop table characters;
drop table feedback;
drop table users;


create table users
(user_id		INT UNSIGNED	AUTO_INCREMENT
,first_name		VARCHAR(100)
,last_name		VARCHAR(100)
,email			VARCHAR(150)
,password		VARCHAR(100)
,number_of_logins	INT
,user_type		VARCHAR(100)
,UNIQUE(email)
,constraint pk_users_1 primary key (user_id));

create table feedback
(feedback_id	INT UNSIGNED	AUTO_INCREMENT
,user_id		INT UNSIGNED	NOT NULL
,feedback_text	TEXT
,new			BOOLEAN			NOT NULL
,constraint pk_feedback primary key (feedback_id)
,constraint fk_feedback_1 foreign key(user_id) references users(user_id));

create table characters
(character_id	INT UNSIGNED	AUTO_INCREMENT
,user_id		INT UNSIGNED	NOT NULL
,character_name				TEXT
,class 						TEXT
,level 						TEXT
,background 				TEXT
,player_name 				TEXT
,race 						TEXT
,alignment 					TEXT
,experience_points 			TEXT
,strength 					TEXT
,strength_modifier 			TEXT
,dexterity 					TEXT
,dexterity_modifier 		TEXT
,constitution 				TEXT
,constitution_modifier 		TEXT
,intelligence 				TEXT
,intelligence_modifier 		TEXT
,wisdom 					TEXT
,wisdom_modifier 			TEXT
,charisma 					TEXT
,charisma_modifier 			TEXT
,passive_wisdom 			TEXT
,proficiencies1				TEXT
,proficiencies2  			TEXT
,proficiencies3  			TEXT
,proficiencies4  			TEXT
,proficiencies5  			TEXT
,proficiencies6  			TEXT
,proficiencies7  			TEXT
,proficiencies8  			TEXT
,proficiencies9  			TEXT
,proficiencies10 			TEXT
,proficiencies11 			TEXT
,proficiencies12 			TEXT
,inspiration 				TEXT
,proficiency_bonus 			TEXT
,has_strength_throw 		BOOLEAN
,strength_throw_value 		TEXT
,has_dexterity_throw 		BOOLEAN
,dexterity_throw_value 		TEXT
,has_constitution_throw 	BOOLEAN
,constitution_throw_value 	TEXT
,has_intelligence_throw 	BOOLEAN
,intelligence_throw_value 	TEXT
,has_wisdom_throw 			BOOLEAN
,wisdom_throw_value 		TEXT
,has_charisma_throw 		BOOLEAN
,charisma_throw_value 		TEXT
,has_acrobatics 			BOOLEAN
,acrobatics_value 			TEXT
,has_animal_handling 		BOOLEAN
,animal_handling_value 		TEXT
,has_arcana 				BOOLEAN
,arcana_value 				TEXT
,has_athletics 				BOOLEAN
,athletics_value 			TEXT
,has_deception 				BOOLEAN
,deception_value 			TEXT
,has_history 				BOOLEAN
,history_value 				TEXT
,has_insight 				BOOLEAN
,insight_value 				TEXT
,has_intimidation 			BOOLEAN
,intimidation_value			TEXT
,has_investigation 			BOOLEAN
,investigation_value 		TEXT
,has_medicine 				BOOLEAN
,medicine_value 			TEXT
,has_nature 				BOOLEAN
,nature_value 				TEXT
,has_perception 			BOOLEAN
,perception_value 			TEXT
,has_performance 			BOOLEAN
,performance_value 			TEXT
,has_persuasion 			BOOLEAN
,persuasion_value 			TEXT
,has_religion 				BOOLEAN
,religion_value 			TEXT
,has_sleight_of_hand 		BOOLEAN
,sleight_of_hand_value 		TEXT
,has_stealth 				BOOLEAN
,stealth_value 				TEXT
,has_survival 				BOOLEAN
,survival_value 			TEXT
,armor_class 				TEXT
,initiative 				TEXT
,speed 						TEXT
,hit_points_maximum 		TEXT
,hit_points_current 		TEXT
,hit_points_temporary 		TEXT
,hit_dice 					TEXT
,hit_dice_total 			TEXT
,death_save_success1 		BOOLEAN
,death_save_success2 		BOOLEAN
,death_save_success3 		BOOLEAN
,death_save_failure1 		BOOLEAN
,death_save_failure2 		BOOLEAN
,death_save_failure3 		BOOLEAN
,attacks_name_1 			TEXT
,attacks_bonus_1 			TEXT
,attacks_type_1 			TEXT
,attacks_name_2 			TEXT
,attacks_bonus_2 			TEXT
,attacks_type_2 			TEXT
,attacks_name_3 			TEXT
,attacks_bonus_3 			TEXT
,attacks_type_3 			TEXT
,attacks_other1				TEXT
,attacks_other2				TEXT
,attacks_other3				TEXT
,attacks_other4				TEXT
,attacks_other5				TEXT
,attacks_other6				TEXT
,attacks_other7				TEXT
,attacks_other8				TEXT
,attacks_other9				TEXT
,attacks_other10			TEXT
,equipment_cp 				TEXT
,equipment_sp 				TEXT
,equipment_ep 				TEXT
,equipment_gp 				TEXT
,equipment_pp 				TEXT
,equipment_other1 			TEXT
,equipment_other2			TEXT
,equipment_other3			TEXT
,equipment_other4			TEXT
,equipment_other5			TEXT
,equipment_other6			TEXT
,equipment_other7			TEXT
,equipment_other8			TEXT
,equipment_other9			TEXT
,equipment_other10			TEXT
,equipment_other11			TEXT
,equipment_other12			TEXT
,equipment_other13			TEXT
,equipment_other14			TEXT
,personality_traits1 		TEXT
,personality_traits2		TEXT
,personality_traits3		TEXT
,personality_traits4		TEXT
,ideals1 					TEXT
,ideals2					TEXT
,ideals3					TEXT
,bonds1 					TEXT
,bonds2						TEXT
,bonds3						TEXT
,flaws1 					TEXT
,flaws2						TEXT
,flaws3						TEXT
,features1 					TEXT
,features2					TEXT
,features3					TEXT
,features4					TEXT
,features5					TEXT
,features6					TEXT
,features7					TEXT
,features8					TEXT
,features9					TEXT
,features10					TEXT
,features11					TEXT
,features12					TEXT
,features13					TEXT
,features14					TEXT
,features15					TEXT
,features16					TEXT
,features17					TEXT
,features18					TEXT
,features19					TEXT
,features20					TEXT
,features21					TEXT
,features22					TEXT
,features23					TEXT
,features24					TEXT
,features25					TEXT
,features26					TEXT
,features27					TEXT
,features28					TEXT
,features29					TEXT
,features30					TEXT
,features31					TEXT
,features32					TEXT
,features33					TEXT
,features34					TEXT
,constraint pk_characters_1 primary key(character_id)
,constraint fk_characters_1 foreign key(user_id) 
						references users(user_id)
);