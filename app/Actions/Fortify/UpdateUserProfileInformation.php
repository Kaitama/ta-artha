<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'alpha_num', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'phone' => ['nullable', 'string', Rule::unique('users', 'phone')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'birthdate' => ['required', 'date'],
            'birthplace' => ['required'],
            'education' => ['required'],
            'university'    => ['required']
        ], [], [
            'name'  => 'nama lengkap',
            'phone' => 'nomor telepon',
            'birthdate' => 'tanggal lahir',
            'birthplace' => 'tempat lahir',
            'education' => 'pendidikan terakhir',
            'university' => 'perguruan tinggi',
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'username' => $input['username'],
                'phone' => $input['phone'],
                'birthdate' => $input['birthdate'],
                'birthplace' => $input['birthplace'],
                'education' => $input['education'],
                'university' => $input['university'],
                'major' => $input['major']
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'username' => $input['username'],
            'phone' => $input['phone'],
            'email_verified_at' => null,
            'birthdate' => $input['birthdate'],
            'birthplace' => $input['birthplace'],
            'education' => $input['education'],
            'university' => $input['university'],
            'major' => $input['major']
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
