<?php

namespace App\Providers;

use App\Models\Invite;
use App\Models\Project;
use App\Observers\InviteObserver;
use App\Observers\MessageObserver;
use App\Observers\ProjectObserver;
use App\Observers\UserObserver;
use App\Services\Api\Keywords\KeywordsFactoryInterface;
use App\Services\Api\Keywords\LocalKeywords;
use App\Services\Api\KeywordTool;
use App\Services\CustomFileSystem;
use App\User;
use Form;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Musonza\Chat\Messages\Message;
use Spatie\MediaLibrary\Filesystem\Filesystem;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
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

    /**
     * init veiw observers
     */
    private function observers()
    {
        Project::observe(ProjectObserver::class);
        Invite::observe(InviteObserver::class);
        User::observe(UserObserver::class);
        Message::observe(MessageObserver::class);
    }

    /**
     * init custom collective forms components
     */
    private function formComponents()
    {
        Form::component(
            'bsText',
            'components.form.text',
            [
                'name',
                'value'       => null,
                'label'       => null,
                'description' => null,
                'attributes'  => [],
                'type'        => 'text',
            ]
        );
        Form::component(
            'bsSelect',
            'components.form.select',
            [
                'name',
                'list',
                'selected'           => null,
                'label'              => null,
                'description'        => null,
                'select_attributes'  => [],
                'options_attributes' => [],
            ]
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(KeywordsFactoryInterface::class, LocalKeywords::class);
    }
}
