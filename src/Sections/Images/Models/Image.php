<?php

namespace NetLinker\WideStore\Sections\Images\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Image extends Model
{

    use SoftDeletes;


    /**
     * Get connection name
     *
     * @return string|null
     */
    public function getConnectionName()
    {
        if (config('wide-store.connection')){
            $this->setConnection(config('wide-store.connection'));
        }
        return parent::getConnectionName();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wide_store_images';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
        'main' => 'boolean',
        'active' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['uuid', 'product_uuid', 'identifier', 'deliverer', 'url_source', 'path', 'disk', 'url_target', 'order', 'main', 'active', 'lang', 'type'];

    public $orderable = [];

    protected $encryptable = [];

    /**
     * Binds creating/saving events to create UUIDs (and also prevent them from being overwritten).
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
            static::urlTargetSafe($model);
        });

        static::saving(function ($model) {
            $original_uuid = $model->getOriginal('uuid');
            if ($original_uuid !== $model->uuid) {
                $model->uuid = $original_uuid;
            }
            static::urlTargetSafe($model);
        });

        static::updating(function ($model) {
            static::urlTargetSafe($model);
        });
    }

    public static function urlTargetSafe($model)
    {
        $model->url_target = str_replace('https://storage.waw.cloud.ovh.net', env('APP_URL'), $model->url_target);
    }

    /**
     * If the attribute is in the encryptable array
     * then decrypt it.
     *
     * @param  $key
     *
     * @return $value
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encryptable) && $value !== '') {
            $value = decrypt($value);
        }
        return $value;
    }

    /**
     * If the attribute is in the encryptable array
     * then encrypt it.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = encrypt($value);
        }
        return parent::setAttribute($key, $value);
    }

    /**
     * When need to make sure that we iterate through
     * all the keys.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->encryptable as $key) {
            if (isset($attributes[$key])) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }
        return $attributes;
    }
}

