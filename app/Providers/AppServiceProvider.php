<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Invite;
use App\Models\Project;
use App\Observers\ArticleObserver;
use App\Observers\InviteObserver;
use App\Observers\MessageObserver;
use App\Observers\ProjectObserver;
use App\Observers\UserObserver;
use App\Services\Api\Keywords\KeywordsFactoryInterface;
use App\Services\Api\KeywordTool;
use App\User;
use Form;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Musonza\Chat\Messages\Message;

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
        Article::observe(ArticleObserver::class);
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
        
        if (!App::environment('production')) {
            //$this->app['url']->forceScheme('https');
            $this->app->configureMonologUsing(function (Logger $monolog) {
                $processUser = posix_getpwuid(posix_geteuid());
                $processName = $processUser['name'];

                $filename = storage_path('logs/laravel-' . php_sapi_name() . '-' . $processName . '.log');
                $handler  = new RotatingFileHandler($filename);
                $monolog->pushHandler($handler);
            });
        }
        $this->app->bind(KeywordsFactoryInterface::class, KeywordTool::class);
        //$this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        //$this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);
    }
}
