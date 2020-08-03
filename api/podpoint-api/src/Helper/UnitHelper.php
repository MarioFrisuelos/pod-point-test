<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Unit;
use App\Entity\Charge;
use App\Repository\UnitRepository;
use App\Repository\ChargeRepository;

/**
 * Class UnitHelper
 */
final class UnitHelper
{
	/** @var UnitRepository */
	private $unitRepository;

	/** @var ChargeRepository */
	private $chargeRepository;

	/**
     * @param UnitRepository 	$unitRepository
     * @param ChargeRepository 	$chargeRepository
     */
    public function __construct(UnitRepository $unitRepository, ChargeRepository $chargeRepository)
    {
        $this->unitRepository = $unitRepository;
        $this->chargeRepository = $chargeRepository;
    }

	/**
     * @param string   $unitId
     * @param Request  $request
     *
     * @return array
     */
	public function setUnit(string $unitId, Request $request): array
	{
		$unitResult = $this->unitRepository->findOneBy([
			'id' => intval($unitId)
		]);
		if (!is_null($unitResult)) {
			return [
				"response" => 400,
				"return" => "Invalid request (invalid unit ID or body)",
				"header" => []
			];
		}
		$newUnitArray = $this->formatData($request);		
		$newUnitArray['unitId'] = intval($unitId);
		$newUnitId = $this->unitRepository->createnewUnit($newUnitArray);

		return [
			"response" => 200,
			"return" => "Successful operation",
			"header" => ["X-Entity-ID" => $newUnitId]
		];
	}

	/**
     * @param string   $unitId
     * @param string   $chargeId
     * @param Request  $request
     *
     * @return array
     */
	public function patchUnit(string $unitId, string $chargeId, Request $request): array
	{
		$unitResult = $this->unitRepository->findOneBy([
			'id' => intval($unitId)
		]);
		if (is_null($unitResult)) {
			return [
				"response" => 400,
				"return" => "Invalid request (invalid ID or body)",
				"header" => []
			];
		} 
		$chargeResult = $this->chargeRepository->findOneBy([
			'id' => intval($chargeId)
		]);
		if (is_null($chargeResult)) {
			return [
				"response" => 404,
				"return" => "Charge not found",
				"header" => []
			];
		}
		$patchArray = array_filter($this->formatData($request));		
		$patchArray['unitId'] = intval($unitId);
		$patchArray['chargeId'] = intval($chargeId);
		$patchArray['status'] = "Charging";
		$resultUnit = $this->unitRepository->patchUnit($patchArray);
		$resultCharge = $this->chargeRepository->patchCharge($patchArray);

		return [
			"response" => 200,
			"return" => "Successful operation",
			"header" => []
		];
	}	

	/**
     * @param  none
     *
     * @return string
     */
	public function getListUnits()
	{
		$allUnitsResult = $this->unitRepository->findAll();
		$responseListUnits = [];
		foreach ($allUnitsResult as $keyUnit => $valueUnit) {
			$responseListUnits[] = $this->formatResponse($valueUnit);	
		}

		return [
			"response" => 200,
			"return" => $responseListUnits,
			"header" => []
		];
	}

	/**
     * @param string $unitId
     *
     * @return array
     */
	public function getUnit(string $unitId): array
	{
		$unitResult = $this->unitRepository->findOneBy([
			'id' => intval($unitId)
		]);
		if (is_null($unitResult)) {
			return [
				"response" => 400,
				"return" => "Invalid request (invalid ID or body)",
				"header" => []
			];
		}
		if (!count($unitResult->getCharges())) {
			return [
				"response" => 404,
				"return" => "No charges found for given unit",
				"header" => []
			];
		}

		return [
			"response" => 200,
			"return" => $this->formatResponse($unitResult),
			"header" => []
		];
	}


	/**
     * @param object $request
     *
     * @return array
     */
	private function formatData($request): array
	{
		$unitData = [
			"address" => !is_null($request->get("address")) ? $request->get("address") : "unknown",
			"postcode" => !is_null($request->get("postcode")) ? $request->get("postcode") : "unknown",
			"name" => !is_null($request->get("name")) ? $request->get("name") : "unknown",
			"status" => !is_null($request->get("status")) ? "Charging" : "Available",
		];
		$chargeData = [
			"start" => !is_null($request->get("start")) ? new \DateTime($request->get("start")) : null,
			"end" => !is_null($request->get("end")) ? new \DateTime($request->get("end")) : null,
		];

		return array_merge($unitData, $chargeData);
	}

	/**
     * @param object $rawData
     *
     * @return array
     */
	private function formatResponse($rawData): array
	{
		$resultArray = [];
		$resultArray["id"] = $rawData->getId();
		$resultArray["address"] = $rawData->getAddress();
		$resultArray["postcode"] = $rawData->getPostcode();
		$resultArray["name"] = $rawData->getName();
		$resultArray["status"] = $rawData->getStatus();
		foreach ($rawData->getCharges() as $keyCharges => $valueCharges) {
			$auxCharges['id'] = $valueCharges->getId();
			$auxCharges['start'] = $valueCharges->getStart();
			$auxCharges['end'] = $valueCharges->getEnd();
			$resultArray["charges"][$keyCharges] = $auxCharges;
		}
		
		return $resultArray;
	}
}
