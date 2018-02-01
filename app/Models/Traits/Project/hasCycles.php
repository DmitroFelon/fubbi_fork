<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/31/18
 * Time: 12:23 PM
 */

namespace App\Models\Traits\Project;

use App\Models\Project\Cycle;
use Carbon\Carbon;

/**
 * Class hasCycles
 * @package App\Models\Traits\Project
 */
trait hasCycles
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getCycleAttribute()
    {
        return $this->cycles()->latest()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cycles()
    {
        return $this->hasMany(Cycle::class);
    }

    /**
     * @param string $stripe_plan
     */
    public function setCycle(string $stripe_plan)
    {
        $this->cycles()->create([
            'stripe_plan' => $stripe_plan,
            'start_date'  => Carbon::now(),
            'end_date'    => Carbon::now()->addMonth(),
        ]);
    }

}