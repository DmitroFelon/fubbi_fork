<?php

namespace App\Providers;

use App\Models\Invite;
use App\Models\Project;
use App\Observers\InviteObserver;
use App\Observers\ProjectObserver;
use App\Observers\UserObserver;
use App\User;
use Form;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Schema::defaultStringLength(191);

		\Stripe\Stripe::setApiKey(config('services.stripe.secret'));

		$this->observers();

		$this->formComponents();
	}

	private function observers()
	{
		Project::observe(ProjectObserver::class);
		Invite::observe(InviteObserver::class);
		User::observe(UserObserver::class);
	}

	private function formComponents()
	{
		Form::component('bsText', 'components.form.text', [
			'name',
			'value',
			'label',
			'description',
			'attributes' => [],
			'type'       => '',
		]);

		Form::component('bsSelect', 'components.form.select', [
			'name',
			'list',
			'selected',
			'label',
			'description',
			'select_attributes'  => [],
			'options_attributes' => [],
		]);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
