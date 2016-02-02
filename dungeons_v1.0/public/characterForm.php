<?php
if (!isset($_SESSION)) {
    session_start();
}
$name = $_SESSION['name'];
$user_id = $_SESSION['user_id'];
$user_data = get_user_data($user_id);
$character_id = filter_input(INPUT_POST, 'character_id');
//echo 'character_id = ' .$character_id;
$character_data = get_character($character_id);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/head_character.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>
<div>
    <?php
    if (ISSET($updated)) {
        echo '<p class="message">Changes saved</p>';
    }
    ?>
</div>
<main role="main">
    <img src="/css/characterSheet.png" >
    <form method="post" action=".">
        <input type="hidden" name="action" value="savecharacter">
        <input class="submit" type="submit" value="Save Changes">
        <input type="hidden" value="<?php echo $character_data['character_id']; ?>" name="character_id">

        <div class="character_sheet">
            <input class="character_name" type="text" name="character_name" value="<?php echo $character_data['character_name']; ?>">
            <input class="character_class" type="text" name="class" value="<?php echo $character_data['class']; ?>">
            <input class="level" type="text" name="level" value="<?php echo $character_data['level']; ?>">
            <input class="background" type="text" name="background" value="<?php echo $character_data['background']; ?>">
            <input class="player_name" type="text" name="player_name" value="<?php echo $character_data['player_name']; ?>">
            <input class="race" type="text" name="race" value="<?php echo $character_data['race']; ?>">
            <input class="alignment" type="text" name="alignment" value="<?php echo $character_data['alignment']; ?>">
            <input class="experience" type="text" name="experience_points" value="<?php echo $character_data['experience_points']; ?>">

            <div class="attributes">
                <input class="attribute strength" type="text" name="strength" value="<?php echo $character_data['strength']; ?>">
                <input class="attribute dexterity" type="text" name="dexterity" value="<?php echo $character_data['dexterity']; ?>">
                <input class="attribute constitution" type="text" name="constitution"value="<?php echo $character_data['constitution']; ?>">
                <input class="attribute intelligence" type="text" name="intelligence" value="<?php echo $character_data['intelligence']; ?>">
                <input class="attribute wisdom" type="text" name="wisdom" value="<?php echo $character_data['wisdom']; ?>">
                <input class="attribute charisma" type="text" name="charisma" value="<?php echo $character_data['charisma']; ?>">
            </div> 

            <div class="modifiers">
                <input class="strength_modifier modifier" type="text" name="strength_modifier" value="<?php echo $character_data['strength_modifier']; ?>">
                <input class="dexterity_modifier modifier" type="text" name="dexterity_modifier" value="<?php echo $character_data['dexterity_modifier']; ?>">
                <input class="constitution_modifier modifier" type="text" name="constitution_modifier" value="<?php echo $character_data['constitution_modifier']; ?>">
                <input class="intelligence_modifier modifier" type="text" name="intelligence_modifier" value="<?php echo $character_data['intelligence_modifier']; ?>">
                <input class="wisdom_modifier modifier" type="text" name="wisdom_modifier" value="<?php echo $character_data['wisdom_modifier']; ?>">
                <input class="charisma_modifier modifier" type="text" name="charisma_modifier" value="<?php echo $character_data['charisma_modifier']; ?>">
            </div>

            <div class="inspiration_and_proficiency">
                <input class="inspiration" type="text" name="inspiration" value="<?php echo $character_data['inspiration']; ?>">
                <input class="proficiency_bonus" type="text" name="proficiency_bonus"value="<?php echo $character_data['proficiency_bonus']; ?>">
            </div>



            <div class="has_boxes_div" >
                <input class="has_strength_throw has_boxes" type="checkbox" value="1" name="has_strength_throw"<?php
                if ($character_data['has_strength_throw'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_dexterity_throw has_boxes" type="checkbox" value="1" name="has_dexterity_throw"<?php
                if ($character_data['has_dexterity_throw'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_constitution_throw has_boxes" type="checkbox" value="1" name="has_constitution_throw"<?php
                if ($character_data['has_constitution_throw'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_intelligence_throw has_boxes" type="checkbox" value="1" name="has_intelligence_throw"<?php
                if ($character_data['has_intelligence_throw'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_wisdom_throw has_boxes" type="checkbox" value="1" name="has_wisdom_throw"<?php
                if ($character_data['has_wisdom_throw'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_charisma_throw has_boxes" type="checkbox" value="1" name="has_charisma_throw"<?php
                if ($character_data['has_charisma_throw'] == 1) {
                    echo 'checked';
                }
                ?>>  

                <input class="has_acrobatics has_boxes" type="checkbox" value="1" name="has_acrobatics"<?php
                if ($character_data['has_acrobatics'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_animal_handling has_boxes" type="checkbox" value="1" name="has_animal_handling"<?php
                if ($character_data['has_animal_handling'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_arcana has_boxes" type="checkbox" value="1" name="has_arcana"<?php
                if ($character_data['has_arcana'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_athletics has_boxes" type="checkbox" value="1" name="has_athletics"<?php
                if ($character_data['has_athletics'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_deception has_boxes" type="checkbox" value="1" name="has_deception"<?php
                if ($character_data['has_deception'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_history has_boxes" type="checkbox" value="1" name="has_history"<?php
                if ($character_data['has_history'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_insight has_boxes" type="checkbox" value="1" name="has_insight"<?php
                if ($character_data['has_insight'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_intimidation has_boxes" type="checkbox" value="1" name="has_intimidation"<?php
                if ($character_data['has_intimidation'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_investigation has_boxes" type="checkbox" value="1" name="has_investigation"<?php
                if ($character_data['has_investigation'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_medicine has_boxes" type="checkbox" value="1" name="has_medicine"<?php
                if ($character_data['has_medicine'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_nature has_boxes" type="checkbox" value="1" name="has_nature"<?php
                if ($character_data['has_nature'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_perception has_boxes" type="checkbox" value="1" name="has_perception"<?php
                if ($character_data['has_perception'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_performance has_boxes" type="checkbox" value="1" name="has_performance"<?php
                if ($character_data['has_performance'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_persuasion has_boxes" type="checkbox" value="1" name="has_persuasion"<?php
                if ($character_data['has_persuasion'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_religion has_boxes" type="checkbox" value="1" name="has_religion"<?php
                if ($character_data['has_religion'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_sleight_of_hand has_boxes" type="checkbox" value="1" name="has_sleight_of_hand"<?php
                if ($character_data['has_sleight_of_hand'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_stealth has_boxes" type="checkbox" value="1" name="has_stealth"<?php
                if ($character_data['has_stealth'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="has_survival has_boxes" type="checkbox" value="1" name="has_survival"<?php
                if ($character_data['has_survival'] == 1) {
                    echo 'checked';
                }
                ?>>

            </div>

            <div class="throws_and_skills_div">

                <input class="strength_throw_value throws_and_skills" type="text" name="strength_throw_value"value="<?php echo $character_data['strength_throw_value']; ?>">
                <input class="dexterity_throw_value throws_and_skills" type="text" name="dexterity_throw_value" value="<?php echo $character_data['dexterity_throw_value']; ?>">
                <input class="constitution_throw_value throws_and_skills" type="text" name="constitution_throw_value" value="<?php echo $character_data['constitution_throw_value']; ?>">
                <input class="intelligence_throw_value throws_and_skills" type="text" name="intelligence_throw_value" value="<?php echo $character_data['intelligence_throw_value']; ?>">
                <input class="wisdom_throw_value throws_and_skills" type="text" name="wisdom_throw_value"  value="<?php echo $character_data['wisdom_throw_value']; ?>">
                <input class="charisma_throw_value throws_and_skills" type="text" name="charisma_throw_value" value="<?php echo $character_data['charisma_throw_value']; ?>">
                
                <input class="acrobatics_value throws_and_skills" type="text" name="acrobatics_value" value="<?php echo $character_data['acrobatics_value']; ?>">
                <input class="animal_handling_value throws_and_skills" type="text" name="animal_handling_value" value="<?php echo $character_data['animal_handling_value']; ?>">
                <input class="arcana_value throws_and_skills" type="text" name="arcana_value" value="<?php echo $character_data['arcana_value']; ?>">
                <input class="athletics_value throws_and_skills" type="text" name="athletics_value" value="<?php echo $character_data['athletics_value']; ?>">
                <input class="deception_value throws_and_skills" type="text" name="deception_value" value="<?php echo $character_data['deception_value']; ?>">
                <input class="history_value throws_and_skills" type="text" name="history_value" value="<?php echo $character_data['history_value']; ?>">
                <input class="insight_value throws_and_skills" type="text" name="insight_value" value="<?php echo $character_data['insight_value']; ?>">
                <input class="intimidation_value throws_and_skills" type="text" name="intimidation_value" value="<?php echo $character_data['intimidation_value']; ?>">
                <input class="investigation_value throws_and_skills" type="text" name="investigation_value" value="<?php echo $character_data['investigation_value']; ?>">
                <input class="medicine_value throws_and_skills" type="text" name="medicine_value" value="<?php echo $character_data['medicine_value']; ?>">
                <input class="nature_value throws_and_skills" type="text" name="nature_value" value="<?php echo $character_data['nature_value']; ?>">
                <input class="perception_value throws_and_skills" type="text" name="perception_value" value="<?php echo $character_data['perception_value']; ?>">
                <input class="performance_value throws_and_skills" type="text" name="performance_value" value="<?php echo $character_data['performance_value']; ?>">
                <input class="persuasion_value throws_and_skills" type="text" name="persuasion_value" value="<?php echo $character_data['persuasion_value']; ?>">
                <input class="religion_value throws_and_skills" type="text" name="religion_value" value="<?php echo $character_data['religion_value']; ?>">
                <input class="sleight_of_hand_value throws_and_skills" type="text" name="sleight_of_hand_value" value="<?php echo $character_data['sleight_of_hand_value']; ?>">
                <input class="stealth_value throws_and_skills" type="text" name="stealth_value" value="<?php echo $character_data['stealth_value']; ?>">
                <input class="survival_value throws_and_skills" type="text" name="survival_value" value="<?php echo $character_data['survival_value']; ?>">
            </div>

            <input class="passive_wisdom" type="text" name="passive_wisdom" value="<?php echo $character_data['passive_wisdom']; ?>">


            <div class="proficiencies_div">
                <input class="proficiencies1 proficiencies" type="text" name="proficiencies1" value="<?php echo $character_data['proficiencies1']; ?>">
                <input class="proficiencies2 proficiencies" type="text" name="proficiencies2"value="<?php echo $character_data['proficiencies2']; ?>">
                <input class="proficiencies3 proficiencies" type="text" name="proficiencies3"value="<?php echo $character_data['proficiencies3']; ?>">
                <input class="proficiencies4 proficiencies" type="text" name="proficiencies4"value="<?php echo $character_data['proficiencies4']; ?>">
                <input class="proficiencies5 proficiencies" type="text" name="proficiencies5"value="<?php echo $character_data['proficiencies5']; ?>">
                <input class="proficiencies6 proficiencies" type="text" name="proficiencies6"value="<?php echo $character_data['proficiencies6']; ?>">
                <input class="proficiencies7 proficiencies" type="text" name="proficiencies7"value="<?php echo $character_data['proficiencies7']; ?>">
                <input class="proficiencies8 proficiencies" type="text" name="proficiencies8"value="<?php echo $character_data['proficiencies8']; ?>">
                <input class="proficiencies9 proficiencies" type="text" name="proficiencies9"value="<?php echo $character_data['proficiencies9']; ?>">
                <input class="proficiencies10 proficiencies" type="text" name="proficiencies10"value="<?php echo $character_data['proficiencies10']; ?>">
                <input class="proficiencies11 proficiencies" type="text" name="proficiencies11"value="<?php echo $character_data['proficiencies11']; ?>">
                <input class="proficiencies12 proficiencies" type="text" name="proficiencies12"value="<?php echo $character_data['proficiencies12']; ?>">
            </div>

            <div class="top_middle_div">
                <input class="armor_class" type="text" name="armor_class" value="<?php echo $character_data['armor_class']; ?>">
                <input class="initiative" type="text" name="initiative" value="<?php echo $character_data['initiative']; ?>">
                <input class="speed" type="text" name="speed" value="<?php echo $character_data['speed']; ?>">

                <input class="hit_points_maximum" type="text" name="hit_points_maximum" value="<?php echo $character_data['hit_points_maximum']; ?>">
                <input class="hit_points_current" type="text" name="hit_points_current" value="<?php echo $character_data['hit_points_current']; ?>">
                <input class="hit_points_temporary" type="text" name="hit_points_temporary" value="<?php echo $character_data['hit_points_temporary']; ?>">
                <input class="hit_dice_total" type="text" name="hit_dice_total" value="<?php echo $character_data['hit_dice_total']; ?>">
                <input class="hit_dice" type="text" name="hit_dice" value="<?php echo $character_data['hit_dice']; ?>">

                <input class="death_save_success1" type="checkbox" value="1" name="death_save_success1"<?php
                if ($character_data['death_save_success1'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="death_save_success2" type="checkbox" value="1" name="death_save_success2"<?php
                if ($character_data['death_save_success2'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="death_save_success3" type="checkbox" value="1" name="death_save_success3"<?php
                if ($character_data['death_save_success3'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="death_save_failure1" type="checkbox" value="1" name="death_save_failure1"<?php
                if ($character_data['death_save_failure1'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="death_save_failure2" type="checkbox" value="1" name="death_save_failure2"<?php
                if ($character_data['death_save_failure2'] == 1) {
                    echo 'checked';
                }
                ?>>
                <input class="death_save_failure3" type="checkbox" value="1" name="death_save_failure3"<?php
                if ($character_data['death_save_failure3'] == 1) {
                    echo 'checked';
                }
                ?>>
            </div>

            <div class="attack_div">
                <input class="attack_name_1" type="text" name="attacks_name_1" value="<?php echo $character_data['attacks_name_1']; ?>">
                <input class="attack_bonus_1" type="text" name="attacks_bonus_1" value="<?php echo $character_data['attacks_bonus_1']; ?>">
                <input class="attack_type_1" type="text" name="attacks_type_1" value="<?php echo $character_data['attacks_type_1']; ?>">
                <input class="attack_name_2" type="text" name="attacks_name_2" value="<?php echo $character_data['attacks_name_2']; ?>">
                <input class="attack_bonus_2" type="text" name="attacks_bonus_2" value="<?php echo $character_data['attacks_bonus_2']; ?>">
                <input class="attack_type_2" type="text" name="attacks_type_2" value="<?php echo $character_data['attacks_type_2']; ?>">
                <input class="attack_name_3" type="text" name="attacks_name_3" value="<?php echo $character_data['attacks_name_3']; ?>">
                <input class="attack_bonus_3" type="text" name="attacks_bonus_3" value="<?php echo $character_data['attacks_bonus_3']; ?>">
                <input class="attack_type_3" type="text" name="attacks_type_3" value="<?php echo $character_data['attacks_type_3']; ?>">

                <input class="attack_other1" type="text" name="attacks_other1" value="<?php echo $character_data['attacks_other1']; ?>">
                <input class="attack_other2" type="text" name="attacks_other2" value="<?php echo $character_data['attacks_other2']; ?>">
                <input class="attack_other3" type="text" name="attacks_other3" value="<?php echo $character_data['attacks_other3']; ?>">
                <input class="attack_other4" type="text" name="attacks_other4" value="<?php echo $character_data['attacks_other4']; ?>">
                <input class="attack_other5" type="text" name="attacks_other5" value="<?php echo $character_data['attacks_other5']; ?>">
                <input class="attack_other6" type="text" name="attacks_other6" value="<?php echo $character_data['attacks_other6']; ?>">
                <input class="attack_other7" type="text" name="attacks_other7" value="<?php echo $character_data['attacks_other7']; ?>">
                <input class="attack_other8" type="text" name="attacks_other8" value="<?php echo $character_data['attacks_other8']; ?>">
                <input class="attack_other9" type="text" name="attacks_other9" value="<?php echo $character_data['attacks_other9']; ?>">
                <input class="attack_other10" type="text" name="attacks_other10" value="<?php echo $character_data['attacks_other10']; ?>">
            </div>
            <div class="equipment_div">
                <input class="equipment_cp" type="text" name="equipment_cp" value="<?php echo $character_data['equipment_cp']; ?>">
                <input class="equipment_sp" type="text" name="equipment_sp" value="<?php echo $character_data['equipment_sp']; ?>">
                <input class="equipment_ep" type="text" name="equipment_ep" value="<?php echo $character_data['equipment_ep']; ?>">
                <input class="equipment_gp" type="text" name="equipment_gp" value="<?php echo $character_data['equipment_gp']; ?>">
                <input class="equipment_pp" type="text" name="equipment_pp" value="<?php echo $character_data['equipment_pp']; ?>">

                <input class="equipment_other1" type="text" name="equipment_other1" value="<?php echo $character_data['equipment_other1']; ?>">
                <input class="equipment_other2" type="text" name="equipment_other2" value="<?php echo $character_data['equipment_other2']; ?>">
                <input class="equipment_other3" type="text" name="equipment_other3" value="<?php echo $character_data['equipment_other3']; ?>">
                <input class="equipment_other4" type="text" name="equipment_other4" value="<?php echo $character_data['equipment_other4']; ?>">
                <input class="equipment_other5" type="text" name="equipment_other5" value="<?php echo $character_data['equipment_other5']; ?>">
                <input class="equipment_other6" type="text" name="equipment_other6" value="<?php echo $character_data['equipment_other6']; ?>">
                <input class="equipment_other7" type="text" name="equipment_other7" value="<?php echo $character_data['equipment_other7']; ?>">
                <input class="equipment_other8" type="text" name="equipment_other8" value="<?php echo $character_data['equipment_other8']; ?>">
                <input class="equipment_other9" type="text" name="equipment_other9" value="<?php echo $character_data['equipment_other9']; ?>">
                <input class="equipment_other10" type="text" name="equipment_other10" value="<?php echo $character_data['equipment_other10']; ?>">
                <input class="equipment_other11" type="text" name="equipment_other11" value="<?php echo $character_data['equipment_other11']; ?>">
                <input class="equipment_other12" type="text" name="equipment_other12" value="<?php echo $character_data['equipment_other12']; ?>">
                <input class="equipment_other13" type="text" name="equipment_other13" value="<?php echo $character_data['equipment_other13']; ?>">
                <input class="equipment_other14" type="text" name="equipment_other14" value="<?php echo $character_data['equipment_other14']; ?>">
            </div>

            <div class="top_right_div">
                <input class="personality_traits1 top_right" type="text" name="personality_traits1" value="<?php echo $character_data['personality_traits1']; ?>">
                <input class="personality_traits2 top_right" type="text" name="personality_traits2" value="<?php echo $character_data['personality_traits2']; ?>">
                <input class="personality_traits3 top_right" type="text" name="personality_traits3" value="<?php echo $character_data['personality_traits3']; ?>">
                <input class="personality_traits4 top_right" type="text" name="personality_traits4" value="<?php echo $character_data['personality_traits4']; ?>">

                <input class="ideals1 top_right" type="text" name="ideals1" value="<?php echo $character_data['ideals1']; ?>">
                <input class="ideals2 top_right" type="text" name="ideals2" value="<?php echo $character_data['ideals2']; ?>">
                <input class="ideals3 top_right" type="text" name="ideals3" value="<?php echo $character_data['ideals3']; ?>">

                <input class="bonds1 top_right" type="text" name="bonds1" value="<?php echo $character_data['bonds1']; ?>">
                <input class="bonds2 top_right" type="text" name="bonds2" value="<?php echo $character_data['bonds2']; ?>">
                <input class="bonds3 top_right" type="text" name="bonds3" value="<?php echo $character_data['bonds3']; ?>">

                <input class="flaws1 top_right" type="text" name="flaws1" value="<?php echo $character_data['flaws1']; ?>">
                <input class="flaws2 top_right" type="text" name="flaws2" value="<?php echo $character_data['flaws2']; ?>">
                <input class="flaws3 top_right" type="text" name="flaws3" value="<?php echo $character_data['flaws3']; ?>">
            </div>
            <div class="features_div">
                <input class="features1  features" type="text" name="features1" value="<?php echo $character_data['features1']; ?>">
                <input class="features2  features" type="text" name="features2" value="<?php echo $character_data['features2']; ?>">
                <input class="features3  features" type="text" name="features3" value="<?php echo $character_data['features3']; ?>">
                <input class="features4  features" type="text" name="features4" value="<?php echo $character_data['features4']; ?>">
                <input class="features5  features" type="text" name="features5" value="<?php echo $character_data['features5']; ?>">
                <input class="features6  features" type="text" name="features6" value="<?php echo $character_data['features6']; ?>">
                <input class="features7  features" type="text" name="features7" value="<?php echo $character_data['features7']; ?>">
                <input class="features8  features" type="text" name="features8" value="<?php echo $character_data['features8']; ?>">
                <input class="features9  features" type="text" name="features9" value="<?php echo $character_data['features9']; ?>">
                <input class="features10 features" type="text" name="features10" value="<?php echo $character_data['features10']; ?>">
                <input class="features11 features" type="text" name="features11" value="<?php echo $character_data['features11']; ?>">
                <input class="features12 features" type="text" name="features12" value="<?php echo $character_data['features12']; ?>">
                <input class="features13 features" type="text" name="features13" value="<?php echo $character_data['features13']; ?>">
                <input class="features14 features" type="text" name="features14" value="<?php echo $character_data['features14']; ?>">
                <input class="features15 features" type="text" name="features15" value="<?php echo $character_data['features15']; ?>">
                <input class="features16 features" type="text" name="features16" value="<?php echo $character_data['features16']; ?>">
                <input class="features17 features" type="text" name="features17" value="<?php echo $character_data['features17']; ?>">
                <input class="features18 features" type="text" name="features18" value="<?php echo $character_data['features18']; ?>">
                <input class="features19 features" type="text" name="features19" value="<?php echo $character_data['features19']; ?>">
                <input class="features20 features" type="text" name="features20" value="<?php echo $character_data['features20']; ?>">
                <input class="features21 features" type="text" name="features21" value="<?php echo $character_data['features21']; ?>">
                <input class="features22 features" type="text" name="features22" value="<?php echo $character_data['features22']; ?>">
                <input class="features23 features" type="text" name="features23" value="<?php echo $character_data['features23']; ?>">
                <input class="features24 features" type="text" name="features24" value="<?php echo $character_data['features24']; ?>">
                <input class="features25 features" type="text" name="features25" value="<?php echo $character_data['features25']; ?>">
                <input class="features26 features" type="text" name="features26" value="<?php echo $character_data['features26']; ?>">
                <input class="features27 features" type="text" name="features27" value="<?php echo $character_data['features27']; ?>">
                <input class="features28 features" type="text" name="features28" value="<?php echo $character_data['features28']; ?>">
                <input class="features29 features" type="text" name="features29" value="<?php echo $character_data['features29']; ?>">
                <input class="features30 features" type="text" name="features30" value="<?php echo $character_data['features30']; ?>">
                <input class="features31 features" type="text" name="features31" value="<?php echo $character_data['features31']; ?>">
                <input class="features32 features" type="text" name="features32" value="<?php echo $character_data['features32']; ?>">
                <input class="features33 features" type="text" name="features33" value="<?php echo $character_data['features33']; ?>">
                <input class="features34 features" type="text" name="features34" value="<?php echo $character_data['features34']; ?>">
            </div>
        </div>

        </tr>
        </table>
    </form>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>