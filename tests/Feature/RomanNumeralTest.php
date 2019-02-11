<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RomanNumeralTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function test_convert_number_to_roman_numeral()
	{
		$given = [
			'number_requested' => 10,
		];

		$data = [
			'message' => 'Your number has been converted',
			'NumberToConvert' => 10,
			'RomanNumber' => 'X',
		];

		$this->post(route('store'), $given)
			->assertStatus(201)
			->assertJson($data);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function test_recently_converted()
	{
		$given = [
			[
				'roman_numeral' => 'L',
				"number_requested" => 50,
				"total_number_requested" => 2,
				"created_at" => "2019-02-11"
			],
			[
				"roman_numeral" => "D",
				"number_requested" => 500,
				"total_number_requested" => 1,
				"created_at" => "2019-02-11"
			]
		];

		$this->post(route('recentlyConverted'), $given)
			->assertStatus(200)
			->assertJson($given);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function test_top_ten()
	{
		$given = [
			[
				'roman_numeral' => 'L',
				"number_requested" => 50,
				"total_number_requested" => 2,
				"created_at" => "2019-02-11"
			],
			[
				"roman_numeral" => "D",
				"number_requested" => 500,
				"total_number_requested" => 1,
				"created_at" => "2019-02-11"
			]
		];

		$this->post(route('recentlyConverted'), $given)
			->assertStatus(200)
			->assertJson($given);
	}
}
