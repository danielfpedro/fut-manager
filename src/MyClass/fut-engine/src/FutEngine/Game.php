<?php

namespace FutEngine;

Class Game
{
	protected $_teams;

	public $_fieldPlaces = [
		'a1' => [
			'name' => 'linha de fundo',
			'pos' => 'esquerda'
		],
		'b1' => [
			'name' => 'entrada lateral da grande área sem ângulo',
			'pos' => 'esquerda'
		],
		'c1' => [
			'name' => 'dentro da pequena área sem ângulo',
			'pos' => 'esquerda'
		],
		'd1' => [
			'name' => 'dentro da pequena área',
			'pos' => 'centro'
		],
		'e1' => [
			'name' => 'dentro da pequena área sem ângulo',
			'pos' => 'direita'
		],
		'f1' => [
			'name' => 'entrada lateral da grande área sem ângulo',
			'pos' => 'direita'
		],		
		'g1' => [
			'name' => 'linha de fundo',
			'pos' => 'direita'
		],


		'a2' => [
			'name' => 'lateral do campo',
			'pos' => 'esquerda'
		],
		'b2' => [
			'name' => 'entrada lateral da grande área',
			'pos' => 'esquerda'
		],
		'c2' => [
			'name' => 'dentro grande área',
			'pos' => 'esquerda'
		],
		'd2' => [
			'name' => 'dentro da grande área',
			'pos' => 'centro'
		],
		'e2' => [
			'name' => 'dentro grande área.',
			'pos' => 'direita'
		],
		'f2' => [
			'name' => 'entrada lateral grande área',
			'pos' => 'direita'
		],		
		'g2' => [
			'name' => 'lateral do campo',
			'pos' => 'direita'
		],
	];

	public function __construct($game)
	{
		$game['teamA']->score = 2;
		$game['teamB']->score = 0;
		$this->_teams['a'] = $game['teamA'];
		$this->_teams['b'] = $game['teamB'];
	}
	public function getPlayerByPos($team, $pos)
	{
		$team = $this->_teams[$team];
		foreach ($team->players as $player) {
			if ($player->pos == $pos) {
				return $player;
			}
		}

		return null;
	}
	public function getTeam($pos)
	{
		return $this->_teams[$pos];
	}
}