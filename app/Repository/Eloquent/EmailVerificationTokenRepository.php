<?php

namespace App\Repository\Eloquent;

use App\Models\EmailVerificationToken;
use App\Repository\EmailVerificationTokenRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EmailVerificationTokenRepository extends BaseRepository implements EmailVerificationTokenRepositoryInterface
{
    /**
     * @param EmailVerificationToken $model
     */
    public function __construct(EmailVerificationToken $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create([
            'email' => $attributes['email'],
            'token' => $attributes['token'],
            'expiration_date' => now()->addMinute(120)
        ]);

    }

    /**
     * @param string $token
     * @return Model
     */
    public function findByToken(string $token): Model
    {
        return $this->model->where('token',$token)->first();
    }
}
