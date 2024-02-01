<?php

namespace App\Repository\Eloquent;

use App\Models\EmailVerificationToken;
use App\Repository\EmailVerificationTokenRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
        $token = $this->model->create([
            'email' => $attributes['email'],
            'token' => $attributes['token'],
            'expiration_date' => now()->addMinute(120)
        ]);

        return $token;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function findByToken(string $token)
    {
        return $this->model->where('token',$token)->first();
    }
}
