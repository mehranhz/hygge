<?php

namespace App\Repository\Eloquent;

use App\Models\FAQ as FAQModel;
use App\Repository\FAQRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Entity\FAQ;

class FAQRepository extends BaseRepository implements FAQRepositoryInterface
{
    public function __construct(FAQModel $model)
    {
        parent::__construct($model);
    }

    public function convert(Model $source): mixed
    {
        return new FAQ(
            $source->title,
            $source->description,
            $source->visibility,
        );
    }
}
