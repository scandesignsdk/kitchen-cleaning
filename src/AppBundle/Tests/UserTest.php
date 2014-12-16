<?php
namespace AppBundle\Tests;

class UserTest extends AbstractTest
{

    public function test_find_team_1()
    {
        $users = [
            ['name' => 'Zero', 'cleaningnumbers' => 0],
            ['name' => 'One', 'cleaningnumbers' => 1],
            ['name' => 'Two', 'cleaningnumbers' => 2],
        ];

        usort($users, function($a, $b) {
            if ($a['cleaningnumbers'] === $b['cleaningnumbers']) {
                return 0;
            }
            return ($a['cleaningnumbers'] > $b['cleaningnumbers'] ? 1 : -1);
        });

        $user1 = $users[0];
        $user2 = $users[1];

        $this->assertEquals('Zero', $user1['name']);
        $this->assertEquals('One', $user2['name']);

    }

    public function test_find_team_2()
    {
        $users = [
            ['name' => 'Zero1', 'cleaningnumbers' => 0],
            ['name' => 'Zero2', 'cleaningnumbers' => 0],
            ['name' => 'Two', 'cleaningnumbers' => 2],
        ];

        usort($users, function($a, $b) {
            if ($a['cleaningnumbers'] === $b['cleaningnumbers']) {
                return 0;
            }
            return ($a['cleaningnumbers'] > $b['cleaningnumbers'] ? 1 : -1);
        });

        $user1 = $users[0];
        $user2 = $users[1];

        $this->assertEquals('Zero1', $user1['name']);
        $this->assertEquals('Zero2', $user2['name']);

    }

    public function test_find_team_3()
    {
        $users = [
            ['name' => 'Zero', 'cleaningnumbers' => 0],
            ['name' => 'Two1', 'cleaningnumbers' => 2],
            ['name' => 'Two2', 'cleaningnumbers' => 2],
        ];

        usort($users, function($a, $b) {
            if ($a['cleaningnumbers'] === $b['cleaningnumbers']) {
                return 0;
            }
            return ($a['cleaningnumbers'] > $b['cleaningnumbers'] ? 1 : -1);
        });

        $user1 = $users[0];
        $user2 = $users[1];

        $this->assertEquals('Zero', $user1['name']);
        $this->assertEquals('Two2', $user2['name']);

    }

}
