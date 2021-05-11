<?php

declare(strict_types=1);

namespace Tests\Email;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailTest extends WebTestCase
{
    public function testPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(1, $crawler->filter('#sendFormEmail'));
    }

    public function testSendMail(): void
    {
        $clientGet = static::createClient();
        $crawlerGet = $clientGet->request('GET', '/');
        $form = $crawlerGet->filter('#sendFormEmail');
        $url = $form->attr('action');
        $clientPost = new \GuzzleHttp\Client();
        $post = $clientPost->request('POST', 'http://webserver'.$url, [
            'multipart' => [
                [
                    'name'    => 'file_attach',
                    'contents' => fopen(__DIR__.'/fixture/email.jpg', 'rb')
                ],
                [
                    'name'     => 'name',
                    'contents' => 'Example name'
                ],
                [
                    'name'     => 'email',
                    'contents' => 'email@'.rand(0,100).'.com'
                ],
                [
                    'name'     => 'phone',
                    'contents' => '1213123'
                ],
                [
                    'name'     => 'message',
                    'contents' => 'Test message'
                ]
            ]
        ]);

        $statusCode = $post->getStatusCode();

        $this->assertEquals(201, $statusCode);
    }
}
