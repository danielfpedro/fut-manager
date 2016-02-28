<?php

namespace FutEngine;

use Dice\Dice;

class Shot
{
	protected $_cols = ['a', 'b', 'c', 'd', 'e'];
	protected $_rows = [1, 2, 3, 4, 5];

	public $shootDistanceDifficulties = [
		'strong' => [
			[11, 7, 1, 7, 11],
			[6, 4, 2, 4, 6],
			[5, 3, 3, 3, 5],
			[8, 7, 8, 7, 8]
		],
		'finesse' => [
			[10, 5, 1, 5, 10],
			[7, 3, 2, 3, 7],
			[6, 5, 4, 5, 6],
			[6, 5, 4, 5, 6]
		]
	];

	public $goalDifficultiesToSave = [
		[7, 4, 3, 4, 7],
		[5, 4, 1, 4, 5],
		[6, 4, 2, 4, 6]
	];

	protected function _shot($atkTeam, $defTeam, $kicker, $gk, $zone, $shotStyle)
	{
		$out = [];
		
		$out['atkTeam'] = $atkTeam;
		$out['atkTeam']->scoreBeforeMove = $atkTeam->score;

		$out['defTeam'] = $defTeam;
		$out['defTeam']->scoreBeforeMove = $defTeam->score;

		$out['atk'] = $kicker;
		$out['def'] = $gk;
		$out['type'] = $shotStyle;
		$out['zone'] = $zone;
		$out['atkSkill'] = $kicker->skills->shotAcc;
		$out['defSkill'] = $gk->skills->gk;

		$distanceDifficultIndex = $this->_getValueByZone($zone);
		$distanceValue = $this->shootDistanceDifficulties[$shotStyle][$distanceDifficultIndex[1]][$distanceDifficultIndex[0]];

		$out['distanceDifficult'] = $distanceValue;

		$shootDistanceFactor = 4;
		$out['distanceFactor'] = '+' . $shootDistanceFactor;

		$kickerDice = new Dice($kicker->skills->shotAcc);

		$kickerDiceResult = $kickerDice->roll();
		$out['atkDiceResult'] = $kickerDiceResult;

		$kickerResult = ($kickerDiceResult + $shootDistanceFactor) - $distanceValue;
		$kickerResult = ($kickerResult < 1) ? 0 : $kickerResult;

		$out['atkResult'] = $kickerResult;

		$gkDice = new Dice($gk->skills->gk);
		$gkResult = $gkDice->roll();
		$out['gkDiceResult'] = $gkResult;

		if ($gkResult > $kickerResult) {
			$out['result'] = 'defendeu';
		} elseif ($gkResult == $kickerResult) {
			$out['result'] = 'rebateu';
		} else {
			$out['result'] = 'gol';
		}
		return $out;
	}

	public function dofinesse($atkTeam, $defTeam, $kicker, $gk, $zone)
	{
		return $this->_shot($atkTeam, $defTeam, $kicker, $gk, $zone, 'finesse');
	}
	public function doStrong($atkTeam, $defTeam, $kicker, $gk, $zone)
	{
		return $this->_shot($atkTeam, $defTeam, $kicker, $gk, $zone, 'strong');
	}
	protected function _getValueByZone($zoneString)
	{
		$zone = [];

		$zone[] = substr($zoneString, 0, 1);
		$zone[] = substr($zoneString, 1, 2);

		$row = null;
		$col = null;
		foreach ($this->_cols as $key => $rowItem) {
			if ($rowItem == $zone[0]) {
				$row = $key;
			}
		}
		foreach ($this->_rows as $key => $colItem) {
			if ($colItem == $zone[1]) {
				$col = $key;
			}
		}
		return [$row, $col];
	}
}