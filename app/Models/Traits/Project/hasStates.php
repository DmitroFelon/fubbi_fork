<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 09/11/17
 * Time: 12:33
 */

namespace App\Models\Traits\Project;

use App\Exceptions\Project\ImpossibleProjectState;
use App\Models\Helpers\ProjectStates;
use App\Models\Keyword;
use App\Services\Api\KeywordTool;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class hasStates
 *
 * @package App\Models\Traits\Project
 */
trait hasStates
{
    /**
     * @return bool
     */
    public function isOnReview()
    {
        $reviewable_states = [
            ProjectStates::MANAGER_REVIEW,
        ];

        return in_array($this->state, $reviewable_states);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return $this
     */
    public function filling(Request $request)
    {
        switch ($request->input('_step')) {
            case \App\Models\Helpers\ProjectStates::QUIZ_FILLING:
                $this->fillQuiz($request);
                break;
            case \App\Models\Helpers\ProjectStates::KEYWORDS_FILLING:
                $this->fillKeywords($request);
                break;
            default:
                abort(404);
                break;
        }

        $this->save();

        return $this;
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function fillQuiz(Request $request)
    {
        $this->setMeta(
            $request->except(
                [
                    '_token',
                    '_project_id',
                    '_step',
                    '_method',
                    'compliance_guideline',
                    'logo',
                    'article_images',
                    'ready_content',
                ]
            )
        );
        $this->addFiles($request);
        $this->setState(\App\Models\Helpers\ProjectStates::KEYWORDS_FILLING);
    }


    /**
     * @param string $state
     * @return \App\Models\Project
     * @throws \Exception
     */
    public function setState($state)
    {
        throw_unless(
            $this->validateState($state),
            ImpossibleProjectState::class,
            _i('Impossible state of project')
        );

        $this->state = $state;

        if ($this->isDirty()) {
            $this->save();
            $this->fireModelEvent('setState', false);
        }

        return $this;
    }

    /**
     * @param $state
     * @return bool
     */
    public function validateState($state)
    {
        return in_array($state, ProjectStates::$states);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function fillKeywords(Request $request)
    {
        $this->setState(\App\Models\Helpers\ProjectStates::MANAGER_REVIEW);
        $this->filled();
    }

    /**
     * Fires model event "filled"
     * Called after client fill all necessary data
     * and project ready for manager review
     */
    public function filled()
    {
        //TODO check project state if project filled, send events to workers
        $this->fireModelEvent('filled', false);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function prefill(Request $request)
    {
        if ($request->input('keywords')) {
            return $this->prefillKeywords($request);
        }

        if ($request->input('themes')) {
            return $this->prefillQuiz($request);
        }

        return false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function prefillKeywords(Request $request)
    {
        $keywords_input = collect($request->input('keywords'));

        $keywords_input->transform(
            function ($item, $key) {
                return array_keys($item);
            }
        );

        $keywords_old = ($this->getMeta('keywords')) ? collect($this->getMeta('keywords')) : collect();

        //fill by new keywords if necessary
        $keywords_input->each(
            function ($item, $k) use ($keywords_old) {
                if (!$keywords_old->has($k)) {
                    $keywords_old->put($k, []);
                }
            }
        );

        $keywords_old->transform(
            function ($item, $k) use ($keywords_input, &$keywords_old) {
                if ($keywords_input->has($k)) {
                    //set all to false
                    foreach ($item as $keyword => $state) {
                        $item->$keyword = false;
                    }
                    //set true at existed
                    foreach ($keywords_input->get($k) as $i => $keyword) {
                        $item->$keyword = true;
                    }
                }

                return $item;
            }
        );

        $this->setMeta('keywords', $keywords_old);

        $this->setMeta('keywords_meta', $request->input('meta'));

        $this->save();

        return true;

    }

    /**
     * @param Request $request
     * @return bool
     */
    private function prefillQuiz(Request $request)
    {
        return true;
    }
}