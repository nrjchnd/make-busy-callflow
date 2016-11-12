<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class BasicCallTest extends DeviceTestCase {

    public function testMain() {
        foreach (self::getSipTargets() as $sip_uri) {
            $target = self::MILLIWATT_NUMBER . '@' . $sip_uri;
            $channel = self::$no_device->originate($target);
            $this->hangupChannels($channel);
        }
   }

}