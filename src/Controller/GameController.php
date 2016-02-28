<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use FutEngine\Game;
use FutEngine\Shot;
use FutEngine\Commentary;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class GameController extends AppController
{
    public function dashboard()
    {
    }
    public function game()
    {
        $teamA = (object)[
            'name' => 'Real Madrid',
            'players' => (object)[
                (object)[
                    'pos' => 'gk',
                    'name' => 'Keylor Navas',
                    'shortName' => 'Navas',
                    'skills' => (object)[
                        'gk' => 9
                    ]
                ],
                (object)[
                    'pos' => 'str',
                    'name' => 'Cristiano Ronaldo',
                    'shortName' => 'Ronaldo',
                    'skills' => (object)[
                        'shotAcc' => 7
                    ]
                ]
            ]
        ];
        $teamB = (object)[
            'name' => 'Barcelona',
            'players' => (object)[
                (object)[
                    'pos' => 'gk',
                    'name' => 'Ter Stegen',
                    'skills' => (object)[
                        'gk' => 9
                    ]
                ],
                (object)[
                    'pos' => 'str',
                    'name' => 'Lionel Messi',
                    'shortName' => 'Messi',
                    'skills' => (object)[
                        'shotAcc' => 9
                    ]
                ]
            ]
        ];
    	$kicker = (object)[
    		'shootStrength' => 9
    	];
    	$goalKeeper = (object)[
    		'saveSkill' => 9
    	];
    	$results['defesas'] = 0;
    	$results['gols'] = 0;

        $game = [];
        $game['teamA'] = $teamA;
        $game['teamB'] = $teamB;

    	$game = new Game($game);
        $shot = new Shot($game);
        $commentary = new Commentary;

        $atk = $game->getPlayerByPos('a', 'str');
        $gk = $game->getPlayerByPos('b','gk');

    	$times = 1;

        for ($i=0; $i < $times; $i++) { 
            $shotResult = $shot->doFinesse($game->getTeam('a'), $game->getTeam('a'), $atk, $gk, 'c1');
            //debug($shotResult);
            echo $commentary->shot($shotResult);
            echo '<br>';
            echo '<br>';
        }

    	// for ($i=0; $i < $times; $i++) { 
    	// 	if ($this->Plays->shoot($kicker, $goalKeeper, 'a4', 'placed')['result'] == 'Gol') {
    	// 		$results['gols']++;
    	// 	} else {
    	// 		$results['defesas']++;
    	// 	}
    	// }
    	// $percent = ($results['gols']);
    	// debug(($results['gols'] / 10) . '%');
    	// debug($results);
    	
    }
}
