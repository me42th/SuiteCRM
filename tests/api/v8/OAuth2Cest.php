<?php

/**
 * Class JwtCest
 * Tests Jwt Token Authentication
 * @see https://tools.ietf.org/html/rfc7519
 */
class OAuth2Cest
{
    /**
     * As a Rest API Client, I want to ensure that I get the correct response when I send incorrect details
     * @param apiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioInvalidLogin(apiTester $I, \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
        $I->sendPOST(
            $browserDriverHelper->getInstanceURL().'/api/oauth/access_token',
            array(
                'username' => '',
                'password' => ''
            )
        );
        $I->seeResponseCodeIs(400);
    }

    /**
     * I want to ensure that I get the correct response when I send incorrect client details
     * @param apiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioInvalidClient(apiTester $I, \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
        $I->sendPOST(
            $I->getInstanceURL().'/api/oauth/access_token',
            array(
                'username' => $I->getAdminUser(),
                'password' => $I->getAdminPassword(),
                'grant_type' => 'password',
                'scope' => '',
                'client_id' => '',
                'client_secret' => ''
            )
        );
        $I->seeResponseCodeIs(401);

        $I->sendPOST(
            $I->getInstanceURL().'/api/oauth/access_token',
            array(
                'grant_type' => 'client_credentials',
                'client_id' => '0',
                'client_secret' => 'invalid secret'
            )
        );
        $I->seeResponseCodeIs(401);
    }

    /**
     * As a Rest API Client, I want to login so that I can get a JWT token
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioLoginWithPassword(apiTester $I)
    {
       $I->loginAsAdmin();
    }

    /**
     * I want to be able to login with Client Credentials grant type
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     * @throws \Codeception\Exception\ModuleException
     */
    public function TestScenarioLoginWithClientCredentials(apiTester $I)
    {
       $I->loginWithClientCredentials();
    }
}
