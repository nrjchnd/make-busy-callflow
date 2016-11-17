<?php

namespace KazooTests\Applications\Callflow;

use \KazooTests\TestCase;
use \MakeBusy\Kazoo\Applications\Crossbar\TestAccount;

class RingGroupTestCase extends TestCase {
    public static $user = array();
    public static $device = array();

    public static $ring_group_1;
    public static $ring_group_2;
    public static $ring_group_3;
    public static $ring_group_4;

    const RG_EXT_1 = '8001';
    const RG_EXT_2 = '8002';
    const RG_EXT_3 = '8003';
    const RG_EXT_4 = '8004';
    const DURATION = '30';

    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        $acc = new TestAccount("RingGroupTestCase");

        foreach (range('a','g') as $letter) {
            self::$user[$letter] = $acc->createUser();
        }

        foreach (range('a','g') as $letter) {
            self::$device[$letter] = $acc->createDevice("auth", true, ["owner_id" => self::$user[$letter]->getID()]);
        }

        self::$ring_group_1 = $acc->createRingGroup([self::RG_EXT_1],
            [
                ["id" => self::$device['b']->getId(), "type" => "device", "timeout" => "30", "delay" => "0"],
                ["id" => self::$device['c']->getId(), "type" => "device", "timeout" => "25", "delay" => "5"],
                ["id" => self::$device['d']->getId(), "type" => "device", "timeout" => "20", "delay" => "10"],
                ["id" => self::$user['e']->getId(), "type" => "user", "timeout" => "15", "delay" => "15"],
                ["id" => self::$user['f']->getId(), "type" => "user", "timeout" => "10", "delay" => "20"],
                ["id" => self::$user['g']->getId(), "type" => "user", "timeout" => "5", "delay" => "25"]
            ]
        );

        self::$ring_group_2 = $acc->createRingGroup([self::RG_EXT_2],
            [
                ["id" => self::$device['b']->getId(), "type" => "device", "timeout" => "10"],
                ["id" => self::$device['c']->getId(), "type" => "device", "timeout" => "10"]
            ]
        );

        self::$ring_group_3 = $acc->createRingGroup([self::RG_EXT_3],
            [
                ["id" => self::$device['d']->getId(), "type" => "device", "timeout" => "10"],
                ["id" => self::$device['e']->getId(), "type" => "device", "timeout" => "10"]
            ],
            "simultaneous"
        );

        self::$ring_group_4 = $acc->createRingGroup([self::RG_EXT_4],
            [
                ["id" => self::$device['f']->getId(), "type" => "device", "timeout" => "10"],
                ["id" => self::$device['g']->getId(), "type" => "device", "timeout" => "10"]
            ],
            "single"
        );

        self::sync_sofia_profile("auth", self::$device["a"]->isLoaded(), 6);
    }

}