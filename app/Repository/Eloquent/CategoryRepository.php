<?php

namespace App\Repository\Eloquent;

use App\Entity\Category;
use App\Models\Category as CategoryModel;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected array $updateable = ['title', 'description', 'thumbnail'];

    public function __construct(CategoryModel $categoryModel)
    {
        $this->model = $categoryModel;
        parent::__construct($categoryModel);
    }

    public function convert(Model $source): mixed
    {
        return new Category($source->title, $source->description);
    }
}
