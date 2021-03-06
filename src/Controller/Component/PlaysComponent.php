<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

use Dice\Dice;

class PlaysComponent extends Component
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
		'placed' => [
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

	/**
	 * Qualidade do movimento
	 */
	protected function $_getMoveQuality($value)
	{
		$out = '';
		if ($value <= 2) {
			$out = 'Péssimo';
		} elseif ($value <= 5) {
			$out = 'Ruim';
		} elseif ($value <= 7) {
			$out = 'Normal';
		} elseif ($value <= 9) {
			$out = 'Bom';
		} elseif ($value == 10) {
			$out = 'Incrível';
		}
		return $out;
	}

	public function shoot($kicker, $goalKeeper, $zone, $shootStyle)
	{
		$out = [];
		$out['zone'] = $zone;
		$out['atkSkill'] = $kicker->shootStrength;
		$out['defSkill'] = $goalKeeper->saveSkill;

		$distanceDifficultIndex = $this->_getValueByZone($zone);
		$distanceValue = $this->shootDistanceDifficulties[$shootStyle][$distanceDifficultIndex[1]][$distanceDifficultIndex[0]];

		$out['distanceDifficult'] = $distanceValue;

		$shootDistanceFactor = 4;
		$out['distanceFactor'] = '+' . $shootDistanceFactor;

		$kickerDice = new Dice($kicker->shootStrength);

		$kickerDiceResult = $kickerDice->roll();
		$out['atkDiceResult'] = $kickerDiceResult;

		$kickerResult = ($kickerDiceResult + $shootDistanceFactor) - $distanceValue;
		$kickerResult = ($kickerResult < 1) ? 0 : $kickerResult;

		$out['atkResult'] = $kickerResult;

		$gkDice = new Dice($goalKeeper->saveSkill);
		$gkResult = $gkDice->roll();
		$out['gkDiceResult'] = $gkResult;

		if ($gkResult > $kickerResult) {
			$out['result'] = 'Defendeu';
		} elseif ($gkResult == $kickerResult) {
			$out['result'] = 'Rebateu';
		} else {
			$out['result'] = 'Gol';
		}
		return $out;
	}

	protected function _getShootDistanceDifficult($kicker, $zone, $shootStyle)
	{
		$distanceDifficult = $this->_getValueByZone($zone);
		$distanceValue = $this->shootDistanceDifficulties[$shootStyle][$distanceDifficult[1]][$distanceDifficult[0]];

		$shootDistanceFactor = 3;

		$kickerDice = new Dice($kicker->shootStrength);
		$kickerResult = $kickerDice->roll();
		$kickerResult = ($kickerResult + $shootDistanceFactor) - $distanceValue;
		$kickerResult = ($kickerResult < 1) ? 0 : $kickerResult;

		$gkDice = new Dice($goalKeeper->saveSkill);
		$gkResult = $gkDice->roll();

		if ($gkResult >= $kickerResult) {
			return 'Defendeu';
		} else {
			return 'Gol';
		}
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
	protected function _getGoalDifficultToSaveByZone($zoneString)
	{
		$zone = [];

		$zone[] = substr($zoneString, 0, 1);
		$zone[] = substr($zoneString, 1, 2);

		$row = null;
		$col = null;
		foreach ($this->_rows as $key => $rowItem) {
			if ($rowItem == $zone[0]) {
				$row = $key;
			}
		}
		foreach ($this->_cols as $key => $colItem) {
			if ($colItem == $zone[1]) {
				$col = $key;
			}
		}
		return [$row, $col];
	}
}