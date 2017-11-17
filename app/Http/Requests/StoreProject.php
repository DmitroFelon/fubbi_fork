<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'themes'    => 'required',
			'questions' => 'required',
			'relevance' => 'required',
			'audience'  => 'required',
			'homepage'  => 'required',
		];
	}
}