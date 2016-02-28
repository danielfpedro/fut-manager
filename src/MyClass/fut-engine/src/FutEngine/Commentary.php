<?php

namespace FutEngine;

Class Commentary
{
	public function shot($shot)
	{
		$quality = $this->_getMoveQuality($shot['atkDiceResult']);

		if ($quality['before']) {
			$chute = $quality['word'] . ' chute ';
		} else {
			$chute = 'chute ' . $quality['word'] . ' ';
		}

		if ($shot['result'] == 'gol') {
			if ($shot['atkTeam']->scoreBeforeMove == 0) {
				$final = 'abre o placar ';
			} else {
				$final = 'faz mais um ';
			}
			$commentary = $shot['atk']->name .' acerta um ' . self::strong($chute) . 'de ' . $shot['zone'] . ' e '.$final.' para o '.$shot['atkTeam']->name.'.';
		} else {
			$commentary = $shot['atk']->name .' arrisca um ' . self::strong($chute) . 'de ' . $shot['zone'] . ' mas ' . $shot['def']->name . ' defende.';
		}
		//debug($shot);
		return $commentary;
	}

	/**
	 * Qualidade do movimento
	 */
	protected function _getMoveQuality($value, $lc = true)
	{
		$out = null;
		if ($value <= 2) {
			$out['before'] = true;
			$out['word'] = 'Péssimo';
		} elseif ($value <= 5) {
			$out['before'] = false;
			$out['word'] = 'Ruim';
		} elseif ($value <= 8) {
			$out['before'] = true;
			$out['word'] = 'Bom';
		} elseif ($value <= 8) {
			$out['before'] = true;
			$out['word'] = 'Belo';
		} elseif ($value <= 10) {
			$out['before'] = false;
			$out['word'] = 'Incrível';
		}
		$out['word'] = ($lc) ? strtolower($out['word']) : $out['word'];
		return $out;
	}
	protected static function strong($value)
	{
		return '<strong>'.$value.'</strong>';
	}

}