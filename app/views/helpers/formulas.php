<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class FormulasHelper extends AppHelper {
	// Military System.
	// (1): Hits points for a Defense System. Two variables: DefenseSystemLevel, Population
	function military_defenseSystemHitPoints($DefenseSystemLevel = 0, $Population = 0) {
		// DFHitPoints = (DefSysLvl*700) + ceil(Pop*0.85) + 200
		// Revision 1, 2010-08-08
		return $DefenseSystemLevel * 700 + ceil($Population * 0.85) + 200;
	}

	// (2): Returns the maximum skill point in a skill level
	// Accepts the SkillLevel number
	function military_maxSkillPoint($SkillLevel = 0) {
		if($SkillLevel < 1000) return 1000;
		if($SkillLevel < 5000) return 5000;
		if($SkillLevel < 10000) return 10000;
		if($SkillLevel < 20000) return 20000;
		if($SkillLevel < 40000) return 40000;
		if($SkillLevel < 80000) return 80000;
		if($SkillLevel < 160000) return 160000;
		if($SkillLevel < 320000) return 320000;
		if($SkillLevel < 640000) return 640000;

		return 8000000;
	}

	// (3): Not necessarily a formula (again), but fits here. Returns the human interpretation of a skill level.
	function military_skillLevelRating($SkillLevel = 0) {
		if($SkillLevel < 1000) return __("Private", true);
		if($SkillLevel < 5000) return __("Specialist", true);
		if($SkillLevel < 10000) return __("Corporal", true);
		if($SkillLevel < 20000) return __("Sergeant", true);
		if($SkillLevel < 40000) return __("Lieutenant", true);
		if($SkillLevel < 80000) return __("Captain", true);
		if($SkillLevel < 160000) return __("Major", true);
		if($SkillLevel < 320000) return __("Colonel", true);
		if($SkillLevel < 640000) return __("General", true);

		return __("General+", true);
	}

	// (4): Returns the skill level value
	// Accepts the SkillLevel number
	function military_skillLevelValue($SkillLevel = 0) {
		if($SkillLevel < 1000) return 1;
		if($SkillLevel < 5000) return 2;
		if($SkillLevel < 10000) return 3;
		if($SkillLevel < 20000) return 4;
		if($SkillLevel < 40000) return 5;
		if($SkillLevel < 80000) return 6;
		if($SkillLevel < 160000) return 7;
		if($SkillLevel < 320000) return 8;
		if($SkillLevel < 640000) return 9;

		return 10;
	}

	
	// Economy System.
	// (1): Not necessarily a formula, but fits here. Returns the human interpretation of a resource level.
	function economy_resourceLevelRating($Num = 0) {
		switch($Num) {
			case 0: return __("None", true); break;
			case 1: return __("Low", true); break;
			case 2: return __("Medium", true); break;
			case 3: return __("High", true); break;
			case 4: return __("Very High", true); break;
			default: return "Unknown";
		}
	}

	// (2): Not necessarily a formula (again), but fits here. Returns the human interpretation of a skill level.
	function economy_skillLevelRating($SkillLevel = 0) {
		if($SkillLevel < 100) return __("Starter", true);
		if($SkillLevel < 500) return __("Assistant", true);
		if($SkillLevel < 1000) return __("Junior", true);
		if($SkillLevel < 2000) return __("Senior", true);
		if($SkillLevel < 4000) return __("Manager", true);
		if($SkillLevel < 8000) return __("Specialist", true);
		if($SkillLevel < 16000) return __("Expert", true);
		if($SkillLevel < 32000) return __("Master", true);

		return __("Master+", true);
	}

	// (3): Calculates the boost (in percentage) of each skill level.
	function economy_skillLevelBoost($SkillLevel = 0) {
		if($SkillLevel < 100) return 1;
		if($SkillLevel < 500) return 5;
		if($SkillLevel < 1000) return 14;
		if($SkillLevel < 2000) return 28;
		if($SkillLevel < 4000) return 60;
		if($SkillLevel < 8000) return 128;
		if($SkillLevel < 16000) return 135;
		if($SkillLevel < 32000) return 137;

		return 260;
	}

	// (14): Returns the maximum skill point in a skill level (e.g. for Starter, 100, for Expert, 16000, etc.).
	// Accepts the SkillLevel number
	function economy_maxSkillPoint($SkillLevel = 0) {
		if($SkillLevel < 100) return 100;
		if($SkillLevel < 500) return 500;
		if($SkillLevel < 1000) return 1000;
		if($SkillLevel < 2000) return 2000;
		if($SkillLevel < 4000) return 4000;
		if($SkillLevel < 8000) return 8000;
		if($SkillLevel < 16000) return 16000;
		if($SkillLevel < 32000) return 32000;

		return 9999999;
	}

	// (6): Calculates the Work Skill Value (not productivity related)
	function economy_skillLevelValue($SkillLevel = 0) {
		if($SkillLevel < 100) return 1;
		if($SkillLevel < 500) return 2;
		if($SkillLevel < 1000) return 3;
		if($SkillLevel < 2000) return 4;
		if($SkillLevel < 4000) return 5;
		if($SkillLevel < 8000) return 6;
		if($SkillLevel < 16000) return 7;
		if($SkillLevel < 32000) return 8;

		return 16;
	}

	// (4): Calculates the Experience (in this skill) gained in this skill after working.
	function economy_expGainAfterWork($Productivity, $Quality) {
		// OLD: EXPGainAfterWork = Productivity + Quality
		// return $Productivity + $Quality;

		// NEW: EXPGainAfterWork = Productivity * 0.18
		return $Productivity * 0.18;
	}

	// (5): Calculates the Productivity of this person.
	function economy_productivityCalc($Quality, $Health, $WorkSkillLevel, $BoosterName, $Hours, $industry, $woodLevel, $titaniumLevel, $grainLevel, $oilLevel) {
		// Productivity = Quality * ceil(Health/100) * WorkSkillBoost * BoosterName * Hours * IndustryMultiplier
		return $Quality * ceil($Health/100) * (1 + $this->economy_skillLevelBoost($WorkSkillLevel)/100) * $this->economy_boosterEffectValue($BoosterName) * $Hours * $this->economy_getIndustryMultiplier($industry, $woodLevel, $titaniumLevel, $grainLevel, $oilLevel);
	}

	// (7): Calculates the Booster Effect Value which is taken into Productivity
	function economy_boosterEffectValue($BoosterName) {
		switch($BoosterName) {
			case 'morningcoffee': return 1.1; break;
			case 'todolist': return 1.5; break;
			case 'cookiepack': return 2; break;
			case 'music': return 3; break;

			// study
			case 'stickynotes': return 1.1; break;
			case 'doityourself': return 1.5; break;
			case 'successlog': return 2.2; break;
			case 'qasess': return 3.4; break;
			
			// train
			case 'trainpack': return 1.1; break;
			case 'hardhat': return 1.5; break;
			case 'mildiary': return 2.2; break;
			case 'finalparty': return 4; break;
		}

		return 1;
	}

	// (14): Calculates the price of the booster, in Platinum
	function economy_getBoosterPrice($BoosterName) {
		switch($BoosterName) {
			case 'morningcoffee': return 0; break;
			case 'todolist': return 0.2; break;
			case 'cookiepack': return 0.7; break;
			case 'music': return 1; break;

			// study
			case 'stickynotes': return 0; break;
			case 'doityourself': return 0.4; break;
			case 'successlog': return 0.7; break;
			case 'qasess': return 1; break;
			
			// train
			case 'trainpack': return 0; break;
			case 'hardhat': return 0.4; break;
			case 'mildiary': return 0.9; break;
			case 'finalparty': return 2; break;
		}

		return 1;
	}

	// Not necessary a formula (again), but fits.
	// (8): Returns the Skill Set required for each industry
	function economy_getWorkType($industry) {
		switch($industry) {
			case 'food': return 'producer'; break;
			case 'house': return 'architect'; break;
			case 'gift': return 'producer'; break;

			case 'wood': return 'harvester'; break;
			case 'titanium': return 'harvester'; break;
			case 'grain': return 'harvester'; break;
			case 'oil': return 'harvester'; break;

			case 'defense': return 'architect'; break;
			case 'hospital': return 'architect'; break;
		}
	}

	// (9): Returns Industry Multiplier Which takes part in productivity calculation. Productivity=Units Approach
	function economy_getIndustryMultiplier($industry, $woodLevel, $titaniumLevel, $grainLevel, $oilLevel) {
		switch($industry) {
			case 'food': return 1; break;
			case 'house': return 0.01; break;
			case 'gift': return 1; break;

			case 'wood': 
				return 1 * $this->economy_getRawMaterialMultiplier($woodLevel);
			break;
			case 'titanium': 
				return 1 * $this->economy_getRawMaterialMultiplier($titaniumLevel);
			break;
			case 'grain': 
				return 1 * $this->economy_getRawMaterialMultiplier($grainLevel); 
			break;
			case 'oil': 
				return 1 * $this->economy_getRawMaterialMultiplier($oilLevel);
			break;

			case 'defense': return 0.001; break;
			case 'hospital': return 0.001; break;
		}
	}

	// (10): Returns RM multiplier, needed for Raw Material Industry Multiplier Situations
	function economy_getRawMaterialMultiplier($level) {
		switch($level) {
			case 0: return 0.02; break;
			case 1: return 1.27; break;
			case 2: return 3.29; break;
			case 3: return 6.49; break;
			case 4: return 9.66; break;
			default: return 0.02;
		}
	}

	// (11): Returns number of RM needed per unit. This is a full-formula-dependent value.
	function economy_numberOfRawNeededPerUnit($Industry, $Level) {
		// RMPerUnit = IndustryMultiplier * Level * AdjustableEconomyValue
		// Note: AdjustableEconomyValue is fetched from economy_getEconomyValueRMMultiplier. This number is adjusted to a very low level (min 0.83) when the economy is weak, and increased up to 7.26 when needed.
		return $this->economy_getIndustryRawMaterialMultiplier($Industry) * $Level * $this->economy_getEconomyValueRMMultiplier();
	}

	// (12): Returns industry raw material multiplier, used to calculate RM/unit situations
	function economy_getIndustryRawMaterialMultiplier($Industry) {
		switch($Industry) {
			case 'food': return 1.55; break;
			case 'house': return 500; break;
			case 'gift': return 1.88; break;

			case 'defense': return 1500; break;
			case 'hospital': return 1250; break;
		}

		return 99999;
	}

	// (13): Returns Economy Adjusting Multiplier, used for RM/unit calculation.
	// This is adjusted when the economy is weak/powerful, etc.
	function economy_getEconomyValueRMMultiplier() {
		return 0.83; // .83 is beta value, will be .99 on RTM and 1.25 in SP1, 1.73 in SP2, and up to 2.85 in SP3.
	}

	// (15): Skill Gain when Studying.
	function economy_studyExpGain($CurrSkill, $Hours, $BoosterName, $Health) {
		return ceil($Health/100) * $this->economy_skillLevelValue($CurrSkill) * 4 * $Hours * $this->economy_boosterEffectValue($BoosterName);
	}

	// (17): Skill Gain when Training.
	function economy_trainExpGain($CurrSkill, $Hours, $BoosterName, $Health) {
		return ceil($Health/100) * $this->military_skillLevelValue($CurrSkill) * 8 * $Hours * $this->economy_boosterEffectValue($BoosterName);
	}

	// (16): Food Consumption Health Gain.
	function economy_foodHealthGain($FoodQuality, $Health) {
		if($Health < 30) $HealthFactor = 6;
		elseif($Health < 50) $HealthFactor = 4;
		elseif($Health < 70) $HealthFactor = 3;
		elseif($Health < 85) $HealthFactor = 2;
		else $HealthFactor = 1.25;

		return ceil($FoodQuality * 1.28 * $HealthFactor);
	}
}