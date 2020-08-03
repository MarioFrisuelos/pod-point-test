<?php

namespace App\Tests\Helper;

use PHPUnit\Framework\TestCase;
use App\Helper\UnitHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class PodpointapiTest
 */
class PodpointapiTest extends TestCase
{
	private $unitHelper;

	public function setUp()
	{
		$this->client = new Client([
			'base_uri' => 'http://localhost:8000',
		]);
	}

	public function testSetUnit()
	{
		$endPoint = [
			"endpoint" => "/units/{unitId}",
			"method" => "POST",
			"statusCode" => 200,
			"headers" => null,
		];
        $params = [
        	"name" => "This is a test",
            "start" => "2019-11-02 15:35:20"
        ];
		$endPoint["endpoint"] = str_replace("{unitId}", "999", $endPoint["endpoint"]);
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);

        $this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testSetUnitFail()
	{
		$endPoint = [
			"endpoint" => "/units/{unitId}",
			"method" => "POST",
			"statusCode" => 400,
			"headers" => null,
		];
        $params = [
        	"name" => "This is a test",
            "start" => "2019-11-02 15:35:20"
        ];
		$endPoint["endpoint"] = str_replace("{unitId}", "1", $endPoint["endpoint"]);
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);

        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testPutUnit()
	{
		$endPoint = [
			"endpoint" => "/units/{unitId}/charges/{chargeId}",
			"method" => "PUT",
			"statusCode" => 200,
			"headers" => null,
		];
        $params = [
            "end" => "2019-11-02 15:35:20"
        ];
        $endPoint["endpoint"] = str_replace("{unitId}", "1", $endPoint["endpoint"]);
        $endPoint["endpoint"] = str_replace("{chargeId}", "1", $endPoint["endpoint"]);
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);

        $this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testPutUnitFailUnitId()
	{
		$endPoint = [
			"endpoint" => "/units/{unitId}/charges/{chargeId}",
			"method" => "PUT",
			"statusCode" => 400,
			"headers" => null,
		];
        $params = [
            "end" => "2019-11-02 15:35:20"
        ];
        $endPoint["endpoint"] = str_replace("{unitId}", "999", $endPoint["endpoint"]);
        $endPoint["endpoint"] = str_replace("{chargeId}", "1", $endPoint["endpoint"]);
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);

        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testPutUnitFailChargeId()
	{
		$endPoint = [
			"endpoint" => "/units/{unitId}/charges/{chargeId}",
			"method" => "PUT",
			"statusCode" => 404,
			"headers" => null,
		];
        $params = [
            "end" => "2019-11-02 15:35:20"
        ];
        $endPoint["endpoint"] = str_replace("{unitId}", "1", $endPoint["endpoint"]);
        $endPoint["endpoint"] = str_replace("{chargeId}", "999", $endPoint["endpoint"]);
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);

        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testListUnits()
	{
		$endPoint = [
			"endpoint" => "/units",
			"method" => "GET",
			"statusCode" => 200,
			"headers" => null,
		];

		$this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testGetSingleUnit()
	{
		$endPoint = [
			"endpoint" => "/units/{unitId}",
			"method" => "GET",
			"statusCode" => 200,
			"headers" => null,
		];
		$endPoint["endpoint"] = str_replace("{unitId}", "1", $endPoint["endpoint"]);

		$this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testGetSingleUnitDoesntExist()
	{
		$endPoint = [
			"endpoint" => "/units/{unitId}",
			"method" => "GET",
			"statusCode" => 400,
			"headers" => null,
		];
		$endPoint["endpoint"] = str_replace("{unitId}", "999", $endPoint["endpoint"]);

		$this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

    private function endpointSuccess(string $path, string $method, int $statusCode, array $headers = null)
    {
        $response = $this->client->{strtolower($method)}($path, [
            'headers' => $headers,
        ]);

        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    private function endpointFail(string $path, string $method, int $statusCode, array $headers = null)
    {
        try {
            $this->client->{strtolower($method)}($path, [
                'headers' => $headers,
            ]);
        } catch (ClientException $e) {
            $this->assertEquals($statusCode, $e->getCode());
        }
    }
}