<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Spatie\Translatable\HasTranslations;
class Notification extends Model
{
    use HasTranslations, HasFactory;
    protected $table = 'notifications';
    protected $fillable = ['title', 'description', 'notification_type', 'user_id', 'object_id', 'object_type', 'is_seen'];
    public $translatable = ['title', 'description', 'notification_type'];
    protected $appends = ['image'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getImageAttribute(){
        $image = null;
        if($this->object_type == 'company'){
            $image = Company::where('id', $this->object_id)->value('image');
        }
        if($this->object_type == 'user'){
            $image = UserProfile::where('user_id', $this->object_id)->value('avatar');
        }
        return $image;
    }
    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, App::getLocale());
        }
        return $attributes;
    }

}
