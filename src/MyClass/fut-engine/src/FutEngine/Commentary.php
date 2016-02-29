<?php

namespace FutEngine;

Class Commentary
{

	protected $_game;

	public function __construct($game)
	{
		$this->_game = $game;
	}

	public function shot($shot)
	{
		$quality = $this->_getMoveQuality($shot['atkDiceResult']);	

		$try = ($shot['atkDiceResult'] <= 5) ? 'executa ' : 'acerta';

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

			$commentary = $shot['atk']->name . ' ' . $try . ' um ' . self::strong($chute) . 'de ' . $this->_game->_fieldPlaces[$shot['zone']]['name'] . ' e '.$final.' para o '.$shot['atkTeam']->name.'.';
		} else {
			$but = ($shot['atkDiceResult'] <= 5) ? 'e' : 'mas';

			$commentary = $shot['atk']->name .' arrisca um ' . self::strong($chute) . 'de ' . $this->_game->_fieldPlaces[$shot['zone']]['name'] . ' ' . $but .' '. $shot['def']->name . ' defende.';
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
			$out = [
				[
					'before' => false,
					'word' => 'Ridículo'
				],
				[
					'before' => false,
					'word' => 'Terrível'
				],
				[
					'before' => true,
					'word' => 'Péssimo'
				],
				[
					'before' => false,
					'word' => 'Horroroso'
				],
				[
					'before' => false,
					'word' => 'Bizarro'
				],
			];
		} elseif ($value <= 5) {
			$out = [
				[
					'before' => false,
					'word' => 'Ruim'
				],
				[
					'before' => false,
					'word' => 'Fraquinho'
				],
				[
					'before' => false,
					'word' => 'Sem perigo'
				],
			];
		} elseif ($value <= 8) {
			$out = [
				[
					'before' => true,
					'word' => 'Bom'
				],
			];
		} elseif ($value <= 8) {
			$out = [
				[
					'before' => true,
					'word' => 'belo'
				],
				[
					'before' => true,
					'word' => 'ótimo'
				],
				[
					'before' => true,
					'word' => 'excelente'
				],
				[
					'before' => false,
					'word' => 'de muita categoria'
				]
			];
		} elseif ($value <= 9) {
			$out = [
				[
					'before' => false,
					'word' => 'magnífico'
				],
				[
					'before' => false,
					'word' => 'incrível'
				],
				[
					'before' => false,
					'word' => 'maravilhoso'
				],
				[
					'before' => false,
					'word' => 'formidável'
				],
			];
		}
		$word = $out[rand(0, count($out) - 1)];
		$word['word'] = ($lc) ? strtolower($word['word']) : $word['word'];
		return $word;
	}
	protected static function strong($value)
	{
		return '<strong>'.$value.'</strong>';
	}

}