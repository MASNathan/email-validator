<?php

namespace Masnathan\EmailValidator\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Masnathan\EmailValidator\EmailValidator;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    public function test_check_email()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'email'      => getenv('EMAIL'),
                'valid'      => true,
                'disposable' => false,
                'mx_records' => true,
                'exists'     => null,
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $emailValidator = new EmailValidator(
            'email-validator8.p.rapidapi.com',
            'super-secret-api-key',
            $client
        );

        $details = $emailValidator->check(getenv('EMAIL'));

        $this->assertTrue($details['valid']);
    }

    public function test_check_batch()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'id'     => '00000000-0000-0000-0000-000000000000',
                'status' => 'pending',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $emailValidator = new EmailValidator(
            'email-validator8.p.rapidapi.com',
            'super-secret-api-key',
            $client
        );

        $details = $emailValidator->checkBatch([getenv('EMAIL'), 'this.is@email.com']);

        $this->assertArrayHasKey('id', $details);
        $this->assertArrayHasKey('status', $details);

    }

    public function test_report_details()
    {
        $reportId = '00000000-0000-0000-0000-000000000000';

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'id'      => $reportId,
                'status'  => 'success',
                'payload' => [
                    getenv('EMAIL')     => [
                        'email'      => getenv('EMAIL'),
                        'valid'      => true,
                        'disposable' => false,
                        'mx_records' => true,
                        'exists'     => true,
                    ],
                    'this.is@email.com' => [
                        'email'      => 'this.is@email.com',
                        'valid'      => true,
                        'disposable' => false,
                        'mx_records' => false,
                        'exists'     => false,
                    ],
                ],
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $emailValidator = new EmailValidator(
            'email-validator8.p.rapidapi.com',
            'super-secret-api-key',
            $client
        );

        $details = $emailValidator->report($reportId);

        $this->assertArrayHasKey('id', $details);
        $this->assertEquals($reportId, $details['id']);
        $this->assertArrayHasKey('status', $details);
        $this->assertArrayHasKey('payload', $details);
        $this->assertArrayHasKey(getenv('EMAIL'), $details['payload']);
    }
}
