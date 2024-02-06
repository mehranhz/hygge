<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Collection;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param string $email
     * @return \App\Entity\User
     */
    public function findByEmail(string $email): \App\Entity\User
    {
        $user = $this->model->where('email', $email)->first();

        if ($user) {
            return new \App\Entity\User($user->name, $user->email, $user->phone, $user->email_verified_at, $user->password);
        }
        throw new \Exception('user not found', 404);
    }


    /**
     * @param string $email
     * @param string $timestamp
     * @return void
     */
    public function updateVerificationDateByUserEmail(string $email, string $timestamp): void
    {
        $user = $this->model->where('email', $email)->first();
        if ($user) {
            $user->update([
                'email_verified_at' => $timestamp
            ]);

        }
    }

    /**
     * @param string $email
     * @return User
     */
    public function getModelInstanceByEmail(string $email): User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * @param int $userID
     * @param string $roleName
     * @return void
     */

    public function assignRoleToUser(int $userID, string $roleName): void
    {
        $user = $this->find($userID);
        if ($user !== null) {
            $user->assignRole($roleName);
        } else {
            throw new ResourceNotFoundException("user not found with id:$userID");
        }
    }
}
