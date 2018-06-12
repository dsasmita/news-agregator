<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    protected $table = 'news_post';

    public function portal()
    {
        return $this->belongsTo(
                        'App\Models\Portal',
                        'id_portal',
                        'id'
                    );
    }
}
