<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 16/12/17
 * Time: 14:35
 */

namespace App\Services\Api\Keywords;

use Illuminate\Support\Collection;

/**
 * Interface KeywordsFactoryInterface
 *
 * @package App\Services\Api
 */
interface KeywordsFactoryInterface
{
	/**
	 * @param $keyword
	 * @param string $country
	 * @param string $language
	 * @return \Illuminate\Support\Collection
	 * @throws \Exception
	 */
	public function suggestions($keyword, $country = 'au', $language = 'en'):Collection;

	/**
	 * @param $keyword
	 * @param string $country
	 * @param string $language
	 * @return \Illuminate\Support\Collection
	 */
	public function questions($keyword, $country = 'au', $language = 'en'):Collection;
}