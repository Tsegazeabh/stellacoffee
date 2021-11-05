<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isEmpty;

class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'created_at' => 'datetime:Y-m-d h:i:s A'
        // Note: Please do not add 'auditable_id' in here, as it will break non-integer PK models
    ];

    protected $appends = ['auditable_type_model_name'];

    public function getAuditableTypeModelNameAttribute()
    {
        if ($this->auditable_type == Content::class) {
            if (!isEmpty($this->auditable_id)) {
                $content = Content::find($this->auditable_id);
                if(!isEmpty($content)) {
                    return Content::find($this->auditable_id)->contentable_type;
                }
            }
        }

        return getModelShortName($this->auditable_type);
    }
}
