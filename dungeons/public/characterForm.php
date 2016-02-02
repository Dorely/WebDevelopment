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
    <div class="character_sheet">
        <img src="/css/characterSheet.png" >
        <form method="post" action=".">
            <input type="hidden" name="action" value="savecharacter">
            <input class="submit" type="submit" value="Save Changes">
            <input type="hidden" value="<?php echo $character_data['character_id']; ?>" name="character_id">

            <div class="top_div">
                <input class="character_name" type="text" name="character_name" value="<?php echo $character_data['character_name']; ?>">
                <input class="character_class" type="text" name="class" value="<?php echo $character_data['class']; ?>">
                <input class="level" type="text" name="level" value="<?php echo $character_data['level']; ?>">
                <input class="background" type="text" name="background" value="<?php echo $character_data['background']; ?>">
                <input class="player_name" type="text" name="player_name" value="<?php echo $character_data['player_name']; ?>">
                <input class="race" type="text" name="race" value="<?php echo $character_data['race']; ?>">
                <input class="alignment" type="text" name="alignment" value="<?php echo $character_data['alignment']; ?>">
                <input class="experience" type="text" name="experience_points" value="<?php echo $character_data['experience_points']; ?>">
            </div>
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

            <div class="passive_wisdom_div">
                <input class="passive_wisdom" type="text" name="passive_wisdom" value="<?php echo $character_data['passive_wisdom']; ?>">
            </div>

            <div class="proficiencies_div">
                <textarea class="proficiencies" name="proficiencies1"><?php echo $character_data['proficiencies1']; ?></textarea>
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

                <textarea class="attack_other1" name="attacks_other1"><?php echo $character_data['attacks_other1']; ?></textarea>
            </div>
            <div class="equipment_div">
                <input class="equipment_cp" type="text" name="equipment_cp" value="<?php echo $character_data['equipment_cp']; ?>">
                <input class="equipment_sp" type="text" name="equipment_sp" value="<?php echo $character_data['equipment_sp']; ?>">
                <input class="equipment_ep" type="text" name="equipment_ep" value="<?php echo $character_data['equipment_ep']; ?>">
                <input class="equipment_gp" type="text" name="equipment_gp" value="<?php echo $character_data['equipment_gp']; ?>">
                <input class="equipment_pp" type="text" name="equipment_pp" value="<?php echo $character_data['equipment_pp']; ?>">

                <textarea class="equipment_other1" name="equipment_other1"><?php echo $character_data['equipment_other1']; ?></textarea>
                <textarea class="equipment_other2" name="equipment_other2"><?php echo $character_data['equipment_other2']; ?></textarea>

            </div>

            <div class="top_right_div">
                <textarea class="personality_traits1" name="personality_traits1"><?php echo $character_data['personality_traits1']; ?></textarea>

                <textarea class="ideals1 top_right" name="ideals1"><?php echo $character_data['ideals1']; ?></textarea>

                <textarea class="bonds1 top_right" name="bonds1"><?php echo $character_data['bonds1']; ?></textarea>

                <textarea class="flaws1 top_right" name="flaws1"><?php echo $character_data['flaws1']; ?></textarea>
            </div>
            <div class="features_div">
                <textarea class="features" name="features1"><?php echo $character_data['features1']; ?></textarea>
            </div>

            </tr>
            </table>
        </form>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>