<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

// MKBUSY-36
// Ensurue direct calls get forwarded and group calls do not
class DirectCallsOnly extends UserTestCase {

    public function setUp() {
        self::$b_user->resetCfParams(self::C_NUMBER);
        self::$b_user->setCfParam("direct_calls_only", TRUE);
    }

    public function tearDown() {
        self::$b_user->resetCfParams();
    }

    public function main($sip_uri) {
        $target = self::B_NUMBER .'@'. $sip_uri;
        $ch_a = self::ensureChannel( self::$a_device_1->originate($target) );
        $ch_b = self::ensureChannel( self::$b_device_1->waitForInbound() );
        $ch_c = self::ensureChannel( self::$c_device_1->waitForInbound() );

        self::hangupChannels($ch_b, $ch_c);

        $target  = self::RINGGROUP_NUMBER .'@'. $sip_uri;

        $ch_a = self::ensureChannel( self::$a_device_1->originate($target) );
        $ch_b = self::ensureChannel( self::$b_device_1->waitForInbound() );
        self::assertNull( self::$c_device_1->waitForInbound() );
        self::hangupChannels($ch_b);
    }

}