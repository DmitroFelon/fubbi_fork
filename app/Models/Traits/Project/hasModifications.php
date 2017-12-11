<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 11/12/17
 * Time: 12:37
 */

namespace App\Models\Traits\Project;

/**
 * Used to modify projects services related
 * to selected Stripe plan.
 * Stored in project_meta
 *
 * @trait hasModifications
 *
 * @package App\Models\Traits\Project
 */
trait hasModifications
{
	/**
	 * @var array
	 */
	protected $modificator_fields = [
		'service',
		'value',
		'default',
	];

	/**
	 * @var string
	 */
	protected $modificator_slug = 'modificator_';

	/**
	 * @param $service
	 * @param $value
	 * @param null $default
	 */
	public function modify($service, $value, $default = null)
	{
		$this->setMeta(
			$this->modificator_slug.$service,
			$this->payload([$service, $value, $default])
		);
		$this->save();
	}

	/**
	 * @param $data
	 * @return array
	 */
	private function payload($data)
	{
		return array_combine($this->modificator_fields, $data);
	}

	/**
	 * @param $service
	 */
	public function unmodify($service)
	{
		$this->unsetMeta($this->modificator_slug.$service);
		$this->save();
	}

	/**
	 * @param $service
	 * @return bool
	 */
	public function getModified($service)
	{
		$key = $this->modificator_slug.$service;

		return ($this->isModified($service)) ? $this->$key : false;
	}

	/**
	 * @param $service
	 * @return bool
	 */
	public function isModified($service)
	{
		$key = $this->modificator_slug.$service;

		return (isset($this->$key) and ! is_null($this->$key));
	}

	/**
	 * @return mixed
	 */
	public function getModifications()
	{
		return $this->metas()->where('key', 'like', $this->modificator_slug.'%')->get();
	}
}