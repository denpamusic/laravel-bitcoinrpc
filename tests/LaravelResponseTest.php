<?php

use Denpa\Bitcoin\Responses\LaravelResponse;
use Illuminate\Support\Collection;

class LaravelResponseTest extends TestCase
{
    /**
     * Set up environment.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $data = [
            'result' => [
                'foo' => [
                    'bar' => 'baz',
                ],
            ],
        ];

        $this->response = $this
            ->getMockBuilder('Psr\Http\Message\ResponseInterface')
            ->getMock();

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode($data));
    }

    /**
     * Test getting laravel collection from response data.
     *
     * @return void
     */
    public function testCollection()
    {
        $response = new LaravelResponse($this->response);

        $foo = $response->collect('foo');
        $this->assertInstanceOf(Collection::class, $foo);
        $this->assertEquals('baz', $foo->get('bar'));
    }
}
