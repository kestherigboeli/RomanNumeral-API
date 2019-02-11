<?php

namespace App\Http\Controllers;

use App\Http\Resources\NumeralResource;
use Symfony\Component\HttpFoundation\Response;
use App\Numeral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NumeralController extends Controller
{

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'number_requested' => 'required|numeric|between:1,3999'
		]);

		if ($validator->fails()) {

			return response([
				'success' => false,
				'message' => 'Number requested must be a numeric value between 1 to 3999'
			]);
		}

		$checkNumber 	= Numeral::where('number_requested', $request->number_requested)->first();

		$result 		= null;

		if ($checkNumber) {

			$result = $checkNumber->roman_numeral;

			$checkNumber->total_number_requested = $checkNumber->total_number_requested + 1;

			$checkNumber->save();

		} else {

			$checkNumber = Numeral::create([
				'roman_numeral' 			=> $this->numberToRomanRepresentation($request->number_requested),
				'number_requested' 			=> $request->number_requested,
				'total_number_requested' 	=> 1
			]);

			$result = $checkNumber->roman_numeral;
		}

		return response([
			'success' 			=> true,
			'message' 			=> 'Your number has been converted',
			'NumberToConvert' 	=> $request->number_requested,
			'RomanNumber' 		=> $result
		], Response::HTTP_CREATED);
	}

	/**
	 * @param int $number
	 *
	 * check the number that has been converted the last hour
	 *
	 * @return string
	 */
	public function recentlyConverted()
	{
		$today = date('Y-m-d');

		$date = Carbon::parse($today)->subHour(1);

		$recent = Numeral::whereDate('updated_at', '>=', $date)
			->orderBy('created_at', 'DESC')
			->get();

		return response([
			'success' 	=> true,
			'message' 	=> 'Here is the recently converted number',
			'data' 		=> NumeralResource::collection($recent)
		], Response::HTTP_OK);


	}

	/**
	 * @param int $number
	 *
	 * check the number that has been converted the last hour
	 *
	 * @return string
	 */
	public function topTen()
	{

		$recent = Numeral::orderBy('total_number_requested', 'DESC')
			->take(10)
			->get();

		return response([
			'success' 	=> true,
			'message' 	=> 'Here are the list of top ten converted number',
			'data' 		=> NumeralResource::collection($recent)
		], Response::HTTP_OK);

	}

	/**
	 * @param int $number
	 *
	 * @return string
	 */
	private function numberToRomanRepresentation($number)
	{

		$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

		$returnValue = '';

		while ($number > 0) {
			foreach ($map as $roman => $int) {
				if ($number >= $int) {
					$number -= $int;
					$returnValue .= $roman;
					break;
				}
			}
		}

		return $returnValue;
	}
}
