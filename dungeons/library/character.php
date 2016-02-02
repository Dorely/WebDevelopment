<?php

function create_character() {
    session_start();
    $user_id = $_SESSION['user_id'];

    $dbconn = dungeon_connection();
    $character_name = filter_input(INPUT_POST, 'character_name');
    $character_class = filter_input(INPUT_POST, 'character_class');
    $character_race = filter_input(INPUT_POST, 'character_race');


    if ($character_name == null || $character_name == false ||
            $character_class == null || $character_class == false ||
            $character_race == null || $character_race == false) {
        return $message = '<p>Invalid Data, try again</p>';
    } else {
        $insert = 'INSERT INTO characters 
              (character_id
              ,user_id
              ,character_name
              ,class
              ,level
              ,race)
              VALUES
              (NULL
              ,:user_id
              ,:character_name
              ,:character_class
              ,\'1\'
              ,:character_race)';
        $statement1 = $dbconn->prepare($insert);
        $statement1->bindValue(':user_id', $user_id);
        $statement1->bindValue(':character_name', $character_name);
        $statement1->bindValue(':character_class', $character_class);
        $statement1->bindValue(':character_race', $character_race);
        $statement1->execute();

        return $message = '<p>Character Created</p>';
    }
}

function delete_character() {
    $dbconn = dungeon_connection();
    $character_id = filter_input(INPUT_POST, 'character_id');

    if ($character_id == null || $character_id == false) {
        echo 'Something went wrong';
        header('location: .?action=loggedon');
    } else {
        $query = 'DELETE FROM characters WHERE character_id = :character_id';
        $statement = $dbconn->prepare($query);
        $statement->bindValue(':character_id', $character_id);
        $statement->execute();
    }
}

function save_character() {
    
}

function get_characters($user_id) {
    $dbconn = dungeon_connection();

    $query = 'SELECT * FROM characters WHERE user_id = :user_id';
    $statement = $dbconn->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $characters = $statement->fetchAll();
    $statement->closeCursor();

    return $characters;
}

function get_character($character_id) {
    $dbconn = dungeon_connection();

    $query = 'SELECT * FROM characters WHERE character_id = :character_id';
    $statement = $dbconn->prepare($query);
    $statement->bindValue(':character_id', $character_id);
    $statement->execute();
    $character = $statement->fetch();
    $statement->closeCursor();

    return $character;
}

function update_character($character_id){

$dbconn = dungeon_connection();

$character_name           = filter_input(INPUT_POST, 'character_name');
$class                    = filter_input(INPUT_POST, 'class');
$level                    = filter_input(INPUT_POST, 'level');
//echo $character_name . ' ' . $class . ' ' . $level; 
$background               = filter_input(INPUT_POST, 'background');
$player_name              = filter_input(INPUT_POST, 'player_name');
$race                     = filter_input(INPUT_POST, 'race');
$alignment                = filter_input(INPUT_POST, 'alignment');
$experience_points        = filter_input(INPUT_POST, 'experience_points');
$strength                 = filter_input(INPUT_POST, 'strength');
$strength_modifier        = filter_input(INPUT_POST, 'strength_modifier');
$dexterity                = filter_input(INPUT_POST, 'dexterity');
$dexterity_modifier       = filter_input(INPUT_POST, 'dexterity_modifier');
$constitution             = filter_input(INPUT_POST, 'constitution');
$constitution_modifier    = filter_input(INPUT_POST, 'constitution_modifier');
$intelligence             = filter_input(INPUT_POST, 'intelligence');
$intelligence_modifier    = filter_input(INPUT_POST, 'intelligence_modifier');
$wisdom                   = filter_input(INPUT_POST, 'wisdom');
$wisdom_modifier          = filter_input(INPUT_POST, 'wisdom_modifier');
$charisma                 = filter_input(INPUT_POST, 'charisma');
$charisma_modifier        = filter_input(INPUT_POST, 'charisma_modifier');
$passive_wisdom           = filter_input(INPUT_POST, 'passive_wisdom');
$proficiencies1           = filter_input(INPUT_POST, 'proficiencies1');
$proficiencies2           = filter_input(INPUT_POST, 'proficiencies2');
$proficiencies3           = filter_input(INPUT_POST, 'proficiencies3');
$proficiencies4           = filter_input(INPUT_POST, 'proficiencies4');
$proficiencies5           = filter_input(INPUT_POST, 'proficiencies5');
$proficiencies6           = filter_input(INPUT_POST, 'proficiencies6');
$proficiencies7           = filter_input(INPUT_POST, 'proficiencies7');
$proficiencies8           = filter_input(INPUT_POST, 'proficiencies8');
$proficiencies9           = filter_input(INPUT_POST, 'proficiencies9');
$proficiencies10          = filter_input(INPUT_POST, 'proficiencies10');
$proficiencies11          = filter_input(INPUT_POST, 'proficiencies11');
$proficiencies12          = filter_input(INPUT_POST, 'proficiencies12');
$inspiration              = filter_input(INPUT_POST, 'inspiration');
$proficiency_bonus        = filter_input(INPUT_POST, 'proficiency_bonus');
$has_strength_throw       = filter_input(INPUT_POST, 'has_strength_throw');
$strength_throw_value     = filter_input(INPUT_POST, 'strength_throw_value');
$has_dexterity_throw      = filter_input(INPUT_POST, 'has_dexterity_throw');
$dexterity_throw_value    = filter_input(INPUT_POST, 'dexterity_throw_value');
$has_constitution_throw     = filter_input(INPUT_POST, 'has_constitution_throw');
$constitution_throw_value = filter_input(INPUT_POST, 'constitution_throw_value');
$has_intelligence_throw   = filter_input(INPUT_POST, 'has_intelligence_throw');
$intelligence_throw_value = filter_input(INPUT_POST, 'intelligence_throw_value');
$has_wisdom_throw         = filter_input(INPUT_POST, 'has_wisdom_throw');
$wisdom_throw_value       = filter_input(INPUT_POST, 'wisdom_throw_value');
$has_charisma_throw       = filter_input(INPUT_POST, 'has_charisma_throw');
$charisma_throw_value     = filter_input(INPUT_POST, 'charisma_throw_value');
$has_acrobatics           = filter_input(INPUT_POST, 'has_acrobatics');
$acrobatics_value         = filter_input(INPUT_POST, 'acrobatics_value');
$has_animal_handling      = filter_input(INPUT_POST, 'has_animal_handling');
$animal_handling_value    = filter_input(INPUT_POST, 'animal_handling_value');
$has_arcana               = filter_input(INPUT_POST, 'has_arcana');
$arcana_value             = filter_input(INPUT_POST, 'arcana_value');
$has_athletics            = filter_input(INPUT_POST, 'has_athletics');
$athletics_value          = filter_input(INPUT_POST, 'athletics_value');
$has_deception            = filter_input(INPUT_POST, 'has_deception');
$deception_value          = filter_input(INPUT_POST, 'deception_value');
$has_history              = filter_input(INPUT_POST, 'has_history');
$history_value            = filter_input(INPUT_POST, 'history_value');
$has_insight              = filter_input(INPUT_POST, 'has_insight');
$insight_value            = filter_input(INPUT_POST, 'insight_value');
$has_intimidation         = filter_input(INPUT_POST, 'has_intimidation');
$intimidation_value       = filter_input(INPUT_POST, 'intimidation_value');
$has_investigation        = filter_input(INPUT_POST, 'has_investigation');
$investigation_value      = filter_input(INPUT_POST, 'investigation_value');
$has_medicine             = filter_input(INPUT_POST, 'has_medicine');
$medicine_value           = filter_input(INPUT_POST, 'medicine_value');
$has_nature               = filter_input(INPUT_POST, 'has_nature');
$nature_value             = filter_input(INPUT_POST, 'nature_value');
$has_perception           = filter_input(INPUT_POST, 'has_perception');
$perception_value         = filter_input(INPUT_POST, 'perception_value');
$has_performance          = filter_input(INPUT_POST, 'has_performance');
$performance_value        = filter_input(INPUT_POST, 'performance_value');
$has_persuasion           = filter_input(INPUT_POST, 'has_persuasion');
$persuasion_value         = filter_input(INPUT_POST, 'persuasion_value');
$has_religion             = filter_input(INPUT_POST, 'has_religion');
$religion_value           = filter_input(INPUT_POST, 'religion_value');
$has_sleight_of_hand      = filter_input(INPUT_POST, 'has_sleight_of_hand');
$sleight_of_hand_value    = filter_input(INPUT_POST, 'sleight_of_hand_value');
$has_stealth              = filter_input(INPUT_POST, 'has_stealth');
$stealth_value            = filter_input(INPUT_POST, 'stealth_value');
$has_survival             = filter_input(INPUT_POST, 'has_survival');
$survival_value           = filter_input(INPUT_POST, 'survival_value');
$armor_class              = filter_input(INPUT_POST, 'armor_class');
$initiative               = filter_input(INPUT_POST, 'initiative');
$speed                    = filter_input(INPUT_POST, 'speed');
$hit_points_maximum       = filter_input(INPUT_POST, 'hit_points_maximum');
$hit_points_current       = filter_input(INPUT_POST, 'hit_points_current');
$hit_points_temporary     = filter_input(INPUT_POST, 'hit_points_temporary');
$hit_dice                 = filter_input(INPUT_POST, 'hit_dice');
$hit_dice_total           = filter_input(INPUT_POST, 'hit_dice_total');
$death_save_success1      = filter_input(INPUT_POST, 'death_save_success1');
$death_save_success2      = filter_input(INPUT_POST, 'death_save_success2');
$death_save_success3      = filter_input(INPUT_POST, 'death_save_success3');
$death_save_failure1      = filter_input(INPUT_POST, 'death_save_failure1');
$death_save_failure2      = filter_input(INPUT_POST, 'death_save_failure2');
$death_save_failure3      = filter_input(INPUT_POST, 'death_save_failure3');
$attacks_name_1           = filter_input(INPUT_POST, 'attacks_name_1');
$attacks_bonus_1          = filter_input(INPUT_POST, 'attacks_bonus_1');
$attacks_type_1           = filter_input(INPUT_POST, 'attacks_type_1');
$attacks_name_2           = filter_input(INPUT_POST, 'attacks_name_2');
$attacks_bonus_2          = filter_input(INPUT_POST, 'attacks_bonus_2');
$attacks_type_2           = filter_input(INPUT_POST, 'attacks_type_2');
$attacks_name_3           = filter_input(INPUT_POST, 'attacks_name_3');
$attacks_bonus_3          = filter_input(INPUT_POST, 'attacks_bonus_3');
$attacks_type_3           = filter_input(INPUT_POST, 'attacks_type_3');
$attacks_other1           = filter_input(INPUT_POST, 'attacks_other1');
$attacks_other2           = filter_input(INPUT_POST, 'attacks_other2');
$attacks_other3           = filter_input(INPUT_POST, 'attacks_other3');
$attacks_other4           = filter_input(INPUT_POST, 'attacks_other4');
$attacks_other5           = filter_input(INPUT_POST, 'attacks_other5');
$attacks_other6           = filter_input(INPUT_POST, 'attacks_other6');
$attacks_other7           = filter_input(INPUT_POST, 'attacks_other7');
$attacks_other8           = filter_input(INPUT_POST, 'attacks_other8');
$attacks_other9           = filter_input(INPUT_POST, 'attacks_other9');
$attacks_other10          = filter_input(INPUT_POST, 'attacks_other10');
$equipment_cp             = filter_input(INPUT_POST, 'equipment_cp');
$equipment_sp             = filter_input(INPUT_POST, 'equipment_sp');
$equipment_ep             = filter_input(INPUT_POST, 'equipment_ep');
$equipment_gp             = filter_input(INPUT_POST, 'equipment_gp');
$equipment_pp             = filter_input(INPUT_POST, 'equipment_pp');
$equipment_other1         = filter_input(INPUT_POST, 'equipment_other1');
$equipment_other2         = filter_input(INPUT_POST, 'equipment_other2');
$equipment_other3         = filter_input(INPUT_POST, 'equipment_other3');
$equipment_other4         = filter_input(INPUT_POST, 'equipment_other4');
$equipment_other5         = filter_input(INPUT_POST, 'equipment_other5');
$equipment_other6         = filter_input(INPUT_POST, 'equipment_other6');
$equipment_other7         = filter_input(INPUT_POST, 'equipment_other7');
$equipment_other8         = filter_input(INPUT_POST, 'equipment_other8');
$equipment_other9         = filter_input(INPUT_POST, 'equipment_other9');
$equipment_other10        = filter_input(INPUT_POST, 'equipment_other10');
$equipment_other11        = filter_input(INPUT_POST, 'equipment_other11');
$equipment_other12        = filter_input(INPUT_POST, 'equipment_other12');
$equipment_other13        = filter_input(INPUT_POST, 'equipment_other13');
$equipment_other14        = filter_input(INPUT_POST, 'equipment_other14');
$personality_traits1      = filter_input(INPUT_POST, 'personality_traits1');
$personality_traits2      = filter_input(INPUT_POST, 'personality_traits2');
$personality_traits3      = filter_input(INPUT_POST, 'personality_traits3');
$personality_traits4      = filter_input(INPUT_POST, 'personality_traits4');
$ideals1                  = filter_input(INPUT_POST, 'ideals1');
$ideals2                  = filter_input(INPUT_POST, 'ideals2');
$ideals3                  = filter_input(INPUT_POST, 'ideals3');
$bonds1                   = filter_input(INPUT_POST, 'bonds1');
$bonds2                   = filter_input(INPUT_POST, 'bonds2');
$bonds3                   = filter_input(INPUT_POST, 'bonds3');
$flaws1                   = filter_input(INPUT_POST, 'flaws1');
$flaws2                   = filter_input(INPUT_POST, 'flaws2');
$flaws3                   = filter_input(INPUT_POST, 'flaws3');
$features1                = filter_input(INPUT_POST, 'features1');
$features2                = filter_input(INPUT_POST, 'features2');
$features3                = filter_input(INPUT_POST, 'features3');
$features4                = filter_input(INPUT_POST, 'features4');
$features5                = filter_input(INPUT_POST, 'features5');
$features6                = filter_input(INPUT_POST, 'features6');
$features7                = filter_input(INPUT_POST, 'features7');
$features8                = filter_input(INPUT_POST, 'features8');
$features9                = filter_input(INPUT_POST, 'features9');
$features10               = filter_input(INPUT_POST, 'features10');
$features11               = filter_input(INPUT_POST, 'features11');
$features12               = filter_input(INPUT_POST, 'features12');
$features13               = filter_input(INPUT_POST, 'features13');
$features14               = filter_input(INPUT_POST, 'features14');
$features15               = filter_input(INPUT_POST, 'features15');
$features16               = filter_input(INPUT_POST, 'features16');
$features17               = filter_input(INPUT_POST, 'features17');
$features18               = filter_input(INPUT_POST, 'features18');
$features19               = filter_input(INPUT_POST, 'features19');
$features20               = filter_input(INPUT_POST, 'features20');
$features21               = filter_input(INPUT_POST, 'features21');
$features22               = filter_input(INPUT_POST, 'features22');
$features23               = filter_input(INPUT_POST, 'features23');
$features24               = filter_input(INPUT_POST, 'features24');
$features25               = filter_input(INPUT_POST, 'features25');
$features26               = filter_input(INPUT_POST, 'features26');
$features27               = filter_input(INPUT_POST, 'features27');
$features28               = filter_input(INPUT_POST, 'features28');
$features29               = filter_input(INPUT_POST, 'features29');
$features30               = filter_input(INPUT_POST, 'features30');
$features31               = filter_input(INPUT_POST, 'features31');
$features32               = filter_input(INPUT_POST, 'features32');
$features33               = filter_input(INPUT_POST, 'features33');
$features34               = filter_input(INPUT_POST, 'features34');


$query = 'UPDATE characters SET
          character_name           = :character_name
         ,class                    = :class
         ,level                    = :level
         ,background               = :background
         ,player_name              = :player_name
         ,race                     = :race
         ,alignment                = :alignment
         ,experience_points        = :experience_points
         ,strength                 = :strength
         ,strength_modifier        = :strength_modifier
         ,dexterity                = :dexterity
         ,dexterity_modifier       = :dexterity_modifier
         ,constitution             = :constitution
         ,constitution_modifier    = :constitution_modifier
         ,intelligence             = :intelligence
         ,intelligence_modifier    = :intelligence_modifier
         ,wisdom                   = :wisdom
         ,wisdom_modifier          = :wisdom_modifier
         ,charisma                 = :charisma
         ,charisma_modifier        = :charisma_modifier
         ,passive_wisdom           = :passive_wisdom
         ,proficiencies1           = :proficiencies1
         ,proficiencies2           = :proficiencies2
         ,proficiencies3           = :proficiencies3
         ,proficiencies4           = :proficiencies4
         ,proficiencies5           = :proficiencies5
         ,proficiencies6           = :proficiencies6
         ,proficiencies7           = :proficiencies7
         ,proficiencies8           = :proficiencies8
         ,proficiencies9           = :proficiencies9
         ,proficiencies10          = :proficiencies10
         ,proficiencies11          = :proficiencies11
         ,proficiencies12          = :proficiencies12
         ,inspiration              = :inspiration
         ,proficiency_bonus        = :proficiency_bonus
         ,has_strength_throw       = :has_strength_throw
         ,strength_throw_value     = :strength_throw_value
         ,has_dexterity_throw      = :has_dexterity_throw
         ,dexterity_throw_value    = :dexterity_throw_value
         ,has_constitution_throw   = :has_constitution_throw
         ,constitution_throw_value = :constitution_throw_value
         ,has_intelligence_throw   = :has_intelligence_throw
         ,intelligence_throw_value = :intelligence_throw_value
         ,has_wisdom_throw         = :has_wisdom_throw
         ,wisdom_throw_value       = :wisdom_throw_value
         ,has_charisma_throw       = :has_charisma_throw
         ,charisma_throw_value     = :charisma_throw_value
         ,has_acrobatics           = :has_acrobatics
         ,acrobatics_value         = :acrobatics_value
         ,has_animal_handling      = :has_animal_handling
         ,animal_handling_value    = :animal_handling_value
         ,has_arcana               = :has_arcana
         ,arcana_value             = :arcana_value
         ,has_athletics            = :has_athletics
         ,athletics_value          = :athletics_value
         ,has_deception            = :has_deception
         ,deception_value          = :deception_value
         ,has_history              = :has_history
         ,history_value            = :history_value
         ,has_insight              = :has_insight
         ,insight_value            = :insight_value
         ,has_intimidation         = :has_intimidation
         ,intimidation_value       = :intimidation_value
         ,has_investigation        = :has_investigation
         ,investigation_value      = :investigation_value
         ,has_medicine             = :has_medicine
         ,medicine_value           = :medicine_value
         ,has_nature               = :has_nature
         ,nature_value             = :nature_value
         ,has_perception           = :has_perception
         ,perception_value         = :perception_value
         ,has_performance          = :has_performance
         ,performance_value        = :performance_value
         ,has_persuasion           = :has_persuasion
         ,persuasion_value         = :persuasion_value
         ,has_religion             = :has_religion
         ,religion_value           = :religion_value
         ,has_sleight_of_hand      = :has_sleight_of_hand
         ,sleight_of_hand_value    = :sleight_of_hand_value
         ,has_stealth              = :has_stealth
         ,stealth_value            = :stealth_value
         ,has_survival             = :has_survival
         ,survival_value           = :survival_value
         ,armor_class              = :armor_class
         ,initiative               = :initiative
         ,speed                    = :speed
         ,hit_points_maximum       = :hit_points_maximum
         ,hit_points_current       = :hit_points_current
         ,hit_points_temporary     = :hit_points_temporary
         ,hit_dice                 = :hit_dice
         ,hit_dice_total           = :hit_dice_total
         ,death_save_success1      = :death_save_success1
         ,death_save_success2      = :death_save_success2
         ,death_save_success3      = :death_save_success3
         ,death_save_failure1      = :death_save_failure1
         ,death_save_failure2      = :death_save_failure2
         ,death_save_failure3      = :death_save_failure3
         ,attacks_name_1           = :attacks_name_1
         ,attacks_bonus_1          = :attacks_bonus_1
         ,attacks_type_1           = :attacks_type_1
         ,attacks_name_2           = :attacks_name_2
         ,attacks_bonus_2          = :attacks_bonus_2
         ,attacks_type_2           = :attacks_type_2
         ,attacks_name_3           = :attacks_name_3
         ,attacks_bonus_3          = :attacks_bonus_3
         ,attacks_type_3           = :attacks_type_3
         ,attacks_other1           = :attacks_other1
         ,attacks_other2           = :attacks_other2
         ,attacks_other3           = :attacks_other3
         ,attacks_other4           = :attacks_other4
         ,attacks_other5           = :attacks_other5
         ,attacks_other6           = :attacks_other6
         ,attacks_other7           = :attacks_other7
         ,attacks_other8           = :attacks_other8
         ,attacks_other9           = :attacks_other9
         ,attacks_other10          = :attacks_other10
         ,equipment_cp             = :equipment_cp
         ,equipment_sp             = :equipment_sp
         ,equipment_ep             = :equipment_ep
         ,equipment_gp             = :equipment_gp
         ,equipment_pp             = :equipment_pp
         ,equipment_other1         = :equipment_other1
         ,equipment_other2         = :equipment_other2
         ,equipment_other3         = :equipment_other3
         ,equipment_other4         = :equipment_other4
         ,equipment_other5         = :equipment_other5
         ,equipment_other6         = :equipment_other6
         ,equipment_other7         = :equipment_other7
         ,equipment_other8         = :equipment_other8
         ,equipment_other9         = :equipment_other9
         ,equipment_other10        = :equipment_other10
         ,equipment_other11        = :equipment_other11
         ,equipment_other12        = :equipment_other12
         ,equipment_other13        = :equipment_other13
         ,equipment_other14        = :equipment_other14
         ,personality_traits1      = :personality_traits1
         ,personality_traits2      = :personality_traits2
         ,personality_traits3      = :personality_traits3
         ,personality_traits4      = :personality_traits4
         ,ideals1                  = :ideals1
         ,ideals2                  = :ideals2
         ,ideals3                  = :ideals3
         ,bonds1                   = :bonds1
         ,bonds2                   = :bonds2
         ,bonds3                   = :bonds3
         ,flaws1                   = :flaws1
         ,flaws2                   = :flaws2
         ,flaws3                   = :flaws3
         ,features1                = :features1
         ,features2                = :features2
         ,features3                = :features3
         ,features4                = :features4
         ,features5                = :features5
         ,features6                = :features6
         ,features7                = :features7
         ,features8                = :features8
         ,features9                = :features9
         ,features10               = :features10
         ,features11               = :features11
         ,features12               = :features12
         ,features13               = :features13
         ,features14               = :features14
         ,features15               = :features15
         ,features16               = :features16
         ,features17               = :features17
         ,features18               = :features18
         ,features19               = :features19
         ,features20               = :features20
         ,features21               = :features21
         ,features22               = :features22
         ,features23               = :features23
         ,features24               = :features24
         ,features25               = :features25
         ,features26               = :features26
         ,features27               = :features27
         ,features28               = :features28
         ,features29               = :features29
         ,features30               = :features30
         ,features31               = :features31
         ,features32               = :features32
         ,features33               = :features33
         ,features34               = :features34 
         WHERE character_id = :character_id';
$statement = $dbconn->prepare($query);
$statement->bindValue(':character_id', $character_id);
$statement->bindValue(':character_name',$character_name);
$statement->bindValue(':class',$class);
$statement->bindValue(':level',$level);
$statement->bindValue(':background',$background);
$statement->bindValue(':player_name',$player_name);
$statement->bindValue(':race',$race);
$statement->bindValue(':alignment',$alignment);
$statement->bindValue(':experience_points',$experience_points);
$statement->bindValue(':strength',$strength);
$statement->bindValue(':strength_modifier',$strength_modifier);
$statement->bindValue(':dexterity',$dexterity);
$statement->bindValue(':dexterity_modifier',$dexterity_modifier);
$statement->bindValue(':constitution',$constitution);
$statement->bindValue(':constitution_modifier',$constitution_modifier);
$statement->bindValue(':intelligence',$intelligence);
$statement->bindValue(':intelligence_modifier',$intelligence_modifier);
$statement->bindValue(':wisdom',$wisdom);
$statement->bindValue(':wisdom_modifier',$wisdom_modifier);
$statement->bindValue(':charisma',$charisma);
$statement->bindValue(':charisma_modifier',$charisma_modifier);
$statement->bindValue(':passive_wisdom',$passive_wisdom);
$statement->bindValue(':proficiencies1',$proficiencies1);
$statement->bindValue(':proficiencies2',$proficiencies2);
$statement->bindValue(':proficiencies3',$proficiencies3);
$statement->bindValue(':proficiencies4',$proficiencies4);
$statement->bindValue(':proficiencies5',$proficiencies5);
$statement->bindValue(':proficiencies6',$proficiencies6);
$statement->bindValue(':proficiencies7',$proficiencies7);
$statement->bindValue(':proficiencies8',$proficiencies8);
$statement->bindValue(':proficiencies9',$proficiencies9);
$statement->bindValue(':proficiencies10',$proficiencies10);
$statement->bindValue(':proficiencies11',$proficiencies11);
$statement->bindValue(':proficiencies12',$proficiencies12);
$statement->bindValue(':inspiration',$inspiration);
$statement->bindValue(':proficiency_bonus',$proficiency_bonus);
$statement->bindValue(':has_strength_throw',$has_strength_throw);
$statement->bindValue(':strength_throw_value',$strength_throw_value);
$statement->bindValue(':has_dexterity_throw',$has_dexterity_throw);
$statement->bindValue(':dexterity_throw_value',$dexterity_throw_value);
$statement->bindValue(':has_constitution_throw',$has_constitution_throw);
$statement->bindValue(':constitution_throw_value',$constitution_throw_value);
$statement->bindValue(':has_intelligence_throw',$has_intelligence_throw);
$statement->bindValue(':intelligence_throw_value',$intelligence_throw_value);
$statement->bindValue(':has_wisdom_throw',$has_wisdom_throw);
$statement->bindValue(':wisdom_throw_value',$wisdom_throw_value);
$statement->bindValue(':has_charisma_throw',$has_charisma_throw);
$statement->bindValue(':charisma_throw_value',$charisma_throw_value);
$statement->bindValue(':has_acrobatics',$has_acrobatics);
$statement->bindValue(':acrobatics_value',$acrobatics_value);
$statement->bindValue(':has_animal_handling',$has_animal_handling);
$statement->bindValue(':animal_handling_value',$animal_handling_value);
$statement->bindValue(':has_arcana',$has_arcana);
$statement->bindValue(':arcana_value',$arcana_value);
$statement->bindValue(':has_athletics',$has_athletics);
$statement->bindValue(':athletics_value',$athletics_value);
$statement->bindValue(':has_deception',$has_deception);
$statement->bindValue(':deception_value',$deception_value);
$statement->bindValue(':has_history',$has_history);
$statement->bindValue(':history_value',$history_value);
$statement->bindValue(':has_insight',$has_insight);
$statement->bindValue(':insight_value',$insight_value);
$statement->bindValue(':has_intimidation',$has_intimidation);
$statement->bindValue(':intimidation_value',$intimidation_value);
$statement->bindValue(':has_investigation',$has_investigation);
$statement->bindValue(':investigation_value',$investigation_value);
$statement->bindValue(':has_medicine',$has_medicine);
$statement->bindValue(':medicine_value',$medicine_value);
$statement->bindValue(':has_nature',$has_nature);
$statement->bindValue(':nature_value',$nature_value);
$statement->bindValue(':has_perception',$has_perception);
$statement->bindValue(':perception_value',$perception_value);
$statement->bindValue(':has_performance',$has_performance);
$statement->bindValue(':performance_value',$performance_value);
$statement->bindValue(':has_persuasion',$has_persuasion);
$statement->bindValue(':persuasion_value',$persuasion_value);
$statement->bindValue(':has_religion',$has_religion);
$statement->bindValue(':religion_value',$religion_value);
$statement->bindValue(':has_sleight_of_hand',$has_sleight_of_hand);
$statement->bindValue(':sleight_of_hand_value',$sleight_of_hand_value);
$statement->bindValue(':has_stealth',$has_stealth);
$statement->bindValue(':stealth_value',$stealth_value);
$statement->bindValue(':has_survival',$has_survival);
$statement->bindValue(':survival_value',$survival_value);
$statement->bindValue(':armor_class',$armor_class);
$statement->bindValue(':initiative',$initiative);
$statement->bindValue(':speed',$speed);
$statement->bindValue(':hit_points_maximum',$hit_points_maximum);
$statement->bindValue(':hit_points_current',$hit_points_current);
$statement->bindValue(':hit_points_temporary',$hit_points_temporary);
$statement->bindValue(':hit_dice',$hit_dice);
$statement->bindValue(':hit_dice_total',$hit_dice_total);
$statement->bindValue(':death_save_success1',$death_save_success1);
$statement->bindValue(':death_save_success2',$death_save_success2);
$statement->bindValue(':death_save_success3',$death_save_success3);
$statement->bindValue(':death_save_failure1',$death_save_failure1);
$statement->bindValue(':death_save_failure2',$death_save_failure2);
$statement->bindValue(':death_save_failure3',$death_save_failure3);
$statement->bindValue(':attacks_name_1',$attacks_name_1);
$statement->bindValue(':attacks_bonus_1',$attacks_bonus_1);
$statement->bindValue(':attacks_type_1',$attacks_type_1);
$statement->bindValue(':attacks_name_2',$attacks_name_2);
$statement->bindValue(':attacks_bonus_2',$attacks_bonus_2);
$statement->bindValue(':attacks_type_2',$attacks_type_2);
$statement->bindValue(':attacks_name_3',$attacks_name_3);
$statement->bindValue(':attacks_bonus_3',$attacks_bonus_3);
$statement->bindValue(':attacks_type_3',$attacks_type_3);
$statement->bindValue(':attacks_other1',$attacks_other1);
$statement->bindValue(':attacks_other2',$attacks_other2);
$statement->bindValue(':attacks_other3',$attacks_other3);
$statement->bindValue(':attacks_other4',$attacks_other4);
$statement->bindValue(':attacks_other5',$attacks_other5);
$statement->bindValue(':attacks_other6',$attacks_other6);
$statement->bindValue(':attacks_other7',$attacks_other7);
$statement->bindValue(':attacks_other8',$attacks_other8);
$statement->bindValue(':attacks_other9',$attacks_other9);
$statement->bindValue(':attacks_other10',$attacks_other10);
$statement->bindValue(':equipment_cp',$equipment_cp);
$statement->bindValue(':equipment_sp',$equipment_sp);
$statement->bindValue(':equipment_ep',$equipment_ep);
$statement->bindValue(':equipment_gp',$equipment_gp);
$statement->bindValue(':equipment_pp',$equipment_pp);
$statement->bindValue(':equipment_other1',$equipment_other1);
$statement->bindValue(':equipment_other2',$equipment_other2);
$statement->bindValue(':equipment_other3',$equipment_other3);
$statement->bindValue(':equipment_other4',$equipment_other4);
$statement->bindValue(':equipment_other5',$equipment_other5);
$statement->bindValue(':equipment_other6',$equipment_other6);
$statement->bindValue(':equipment_other7',$equipment_other7);
$statement->bindValue(':equipment_other8',$equipment_other8);
$statement->bindValue(':equipment_other9',$equipment_other9);
$statement->bindValue(':equipment_other10',$equipment_other10);
$statement->bindValue(':equipment_other11',$equipment_other11);
$statement->bindValue(':equipment_other12',$equipment_other12);
$statement->bindValue(':equipment_other13',$equipment_other13);
$statement->bindValue(':equipment_other14',$equipment_other14);
$statement->bindValue(':personality_traits1',$personality_traits1);
$statement->bindValue(':personality_traits2',$personality_traits2);
$statement->bindValue(':personality_traits3',$personality_traits3);
$statement->bindValue(':personality_traits4',$personality_traits4);
$statement->bindValue(':ideals1',$ideals1);
$statement->bindValue(':ideals2',$ideals2);
$statement->bindValue(':ideals3',$ideals3);
$statement->bindValue(':bonds1',$bonds1);
$statement->bindValue(':bonds2',$bonds2);
$statement->bindValue(':bonds3',$bonds3);
$statement->bindValue(':flaws1',$flaws1);
$statement->bindValue(':flaws2',$flaws2);
$statement->bindValue(':flaws3',$flaws3);
$statement->bindValue(':features1',$features1);
$statement->bindValue(':features2',$features2);
$statement->bindValue(':features3',$features3);
$statement->bindValue(':features4',$features4);
$statement->bindValue(':features5',$features5);
$statement->bindValue(':features6',$features6);
$statement->bindValue(':features7',$features7);
$statement->bindValue(':features8',$features8);
$statement->bindValue(':features9',$features9);
$statement->bindValue(':features10',$features10);
$statement->bindValue(':features11',$features11);
$statement->bindValue(':features12',$features12);
$statement->bindValue(':features13',$features13);
$statement->bindValue(':features14',$features14);
$statement->bindValue(':features15',$features15);
$statement->bindValue(':features16',$features16);
$statement->bindValue(':features17',$features17);
$statement->bindValue(':features18',$features18);
$statement->bindValue(':features19',$features19);
$statement->bindValue(':features20',$features20);
$statement->bindValue(':features21',$features21);
$statement->bindValue(':features22',$features22);
$statement->bindValue(':features23',$features23);
$statement->bindValue(':features24',$features24);
$statement->bindValue(':features25',$features25);
$statement->bindValue(':features26',$features26);
$statement->bindValue(':features27',$features27);
$statement->bindValue(':features28',$features28);
$statement->bindValue(':features29',$features29);
$statement->bindValue(':features30',$features30);
$statement->bindValue(':features31',$features31);
$statement->bindValue(':features32',$features32);
$statement->bindValue(':features33',$features33);
$statement->bindValue(':features34',$features34);
$statement->execute();

return true;
}