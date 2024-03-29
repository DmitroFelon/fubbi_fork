<?php

namespace Stripe;

class ChargeTest extends TestCase
{
    const TEST_RESOURCE_ID = 'ch_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/charges'
        );
        $resources = Charge::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Charge", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/charges/' . self::TEST_RESOURCE_ID
        );
        $resource = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/charges'
        );
        $resource = Charge::create(array(
            "amount" => 100,
            "currency" => "usd",
            "source" => "tok_123"
        ));
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource                  = Charge::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $resource->id
        );
        $resource->save();
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/charges/' . self::TEST_RESOURCE_ID
        );
        $resource = Charge::update(self::TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testCanRefund()
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id . '/refund'
        );
        $resource = $charge->refund();
        $this->assertSame("Stripe\\Charge", get_class($resource));
        $this->assertSame($resource, $charge);
    }

    public function testCanCapture()
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id . '/capture'
        );
        $resource = $charge->capture();
        $this->assertSame("Stripe\\Charge", get_class($resource));
        $this->assertSame($resource, $charge);
    }

    public function testCanUpdateDispute()
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id . '/dispute'
        );
        $resource = $charge->updateDispute();
        $this->assertSame("Stripe\\Dispute", get_class($resource));
    }

    public function testCanCloseDispute()
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id . '/dispute/close'
        );
        $resource = $charge->closeDispute();
        $this->assertSame("Stripe\\Charge", get_class($resource));
        $this->assertSame($resource, $charge);
    }

    public function testCanMarkAsFraudulent()
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id,
            array('fraud_details' => array('user_report' => 'fraudulent'))
        );
        $resource = $charge->markAsFraudulent();
        $this->assertSame("Stripe\\Charge", get_class($resource));
        $this->assertSame($resource, $charge);
    }

    public function testCanMarkAsSafe()
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id,
            array('fraud_details' => array('user_report' => 'safe'))
        );
        $resource = $charge->markAsSafe();
        $this->assertSame("Stripe\\Charge", get_class($resource));
        $this->assertSame($resource, $charge);
    }
}
