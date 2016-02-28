<?php

namespace FutEngine;

Class Game
{
	protected $_teams;

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