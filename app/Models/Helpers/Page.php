<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/10/18
 * Time: 9:58 PM
 */

namespace App\Models\Helpers;


/**
 * Class Page
 * @package App\Models\Helpers
 */
use Illuminate\Support\Collection;

/**
 * Class Page
 * @package App\Models\Helpers
 */
class Page
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $route;
    /**
     * @var array
     */
    public $params;

    /**
     * Page constructor.
     * @param string $route
     * @param string|null $name
     * @param array|null $params
     */
    public function __construct(string $route, array $params = null, string $name = null)
    {
        $this->name   = $name;
        $this->route  = $route;
        $this->params = $params;
    }

    /**
     * @return Collection
     */
    public static function getAvailablePages()
    {
        return collect([
            new self('*', null, 'All Pages'),
            new self('projects.index', null, _('All Projects')),
            new self('projects.show', null, _('Specific Project')),
            new self('projects.create', null, _('Create Project')),
            new self('projects.edit', null, _i('Edit Project')),
            new self('projects.edit', ['k' => ProjectStates::PLAN_SELECTION], ProjectStates::PLAN_SELECTION),
            new self('projects.edit', ['k' => ProjectStates::QUIZ_FILLING], ProjectStates::QUIZ_FILLING),
            new self('projects.edit', ['k' => ProjectStates::KEYWORDS_FILLING], ProjectStates::KEYWORDS_FILLING),
            new self('projects.edit', ['k' => ProjectStates::MANAGER_REVIEW], ProjectStates::MANAGER_REVIEW),
            new self('projects.edit', ['k' => ProjectStates::CLIENT_REVIEW], ProjectStates::CLIENT_REVIEW),
            new self('project.articles.index', null, _('All Articles')),
            new self('project.articles.show', null, _('Specific Article')),
            new self('project.articles.create', null, _('Create Article')),
        ]);
    }

    /**
     * Prepare for select input
     *
     * @return $this
     */
    public static function toView()
    {
        return self::getAvailablePages()->transform(function (Page $item, $key) {
            return $item->getName().'test';
        });
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}