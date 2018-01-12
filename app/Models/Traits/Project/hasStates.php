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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;

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

        try {
            if ($request->input('_step') == ProjectStates::QUIZ_FILLING) {
                return $this->prefillQuiz($request);
            }

            if ($request->input('_step') == ProjectStates::KEYWORDS_FILLING) {
                return $this->prefillKeywords($request);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        throw new Exception('Undefined project step: ' . $request->input('_step'));
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function prefillKeywords(Request $request)
    {
        if ($request->has('keywords')) {
            $this->saveKeywords($request->input('keywords'), 'keywords');
        }

        if ($request->has('keywords_questions')) {
            $this->saveKeywords($request->input('keywords_questions'), 'keywords_questions');
        }

        if ($request->has('meta') and is_array($request->get('meta'))) {

            $old_keywords_meta = ($this->keywords_meta) ? $this->keywords_meta : [];

            foreach ($request->get('meta') as $theme => $metas) {
                $old_keywords_meta[$theme] = $metas;
            }

            $this->setMeta('keywords_meta', $old_keywords_meta);
        }

        $this->save();

        return true;
    }

    /**
     * @param $input
     * @param $name
     * @return bool
     */
    private function saveKeywords($input, $name)
    {
        $input = collect($input);

        //set input value to true insted of "1"
        $input->transform(function ($item) {
            return array_fill_keys(array_keys($item), true);
        });

        //load keywords from database
        $keywords = collect($this->getMeta($name));

        $input_array = $input->toArray();
        //cast to array from std
        $old_array = json_decode(json_encode($keywords->toArray()), true);

        $keywords = array_replace_recursive($old_array, $input_array);

        $this->setMeta($name, $keywords);

        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function prefillQuiz(Request $request)
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
        $this->save();
        return true;
    }

}