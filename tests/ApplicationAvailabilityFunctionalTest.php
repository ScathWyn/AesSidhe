<?php
// tests/ApplicationAvailabilityFunctionalTest.php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient(array(), array(
		'HTTP_HOST' => 'aesSidhe.fr',
		));
				
        $client->request('GET', $url);
	   
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
		yield ['/'];
		yield ['/signIn'];
		yield ['/register'];
		yield ['/character'];
		yield ['/story'];
	}
	
	/**
     * @dataProvider urlRedirectProvider
     */
    public function testRedirectionPageIsSuccessful($url)
    {
        $client = self::createClient(array(), array(
		'HTTP_HOST' => 'aesSidhe.fr',
		));
				
        $client->request('GET', $url);

        // $this->assertTrue($client->getResponse()->isSuccessful());
	    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
	
	public function urlRedirectProvider()
	{
		yield ['/signOut'];
		//redirected to authentification entry point
		yield ['/admin'];
		yield ['/admin/characters'];
	}
}