<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Support\Arr;

interface UserRepositoryInterface
{
  public function create(array $userData): User;
  public function update(array $userData = []): void;
  public function getById(int $id): User | null;
  public function getByEmail(string $email): User | null;
  public function deleteById(int $id): void;
}

class UserRepository implements UserRepositoryInterface
{
  /**
   * Create new user.
   *
   * @param array User data
   */
  public function create(array $userData): User
  {
    $user = new User();
    $data = Arr::only($userData, $user->getFillable());
    $data = [...$data, 'password' => Hash::make($data['password']), 'is_active' => true];
    return $user->create($data);
  }

  public function update(array $userData = []): void
  {
    //
  }

  public function getById(int $id): User | null
  {
    return User::findById($id);
  }

  /**
   * Get User by Email
   *
   * @param string $email
   * @return User
   */
  public function getByEmail(string $email): User | null
  {
    return User::where(['email' => $email])->first();
  }

  public function deleteById(int $id): void
  {
    //
  }
}
