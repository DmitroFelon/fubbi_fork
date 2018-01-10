<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HelpVideo
 * @package App\Models
 */
class HelpVideo extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'page'
    ];

    /**
     * @param $value
     * @return mixed|string
     */
    public function getYoutubeIdAttribute($value)
    {
        if (filter_var($this->url, FILTER_VALIDATE_URL)) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->url, $match)) {
                return $match[1];
            }
        }

        return $this->url;
    }

    /**
     * @param $value
     * @return string
     */
    public function getThumbnailAttribute($value)
    {
        return 'http://img.youtube.com/vi/' . $this->youtube_id . '/default.jpg';
    }

    public function setPageAttribute($value)
    {
        $this->attributes['page'] = is_array($value)
            ? json_encode($value)
            : json_encode([$value]);
    }

}
