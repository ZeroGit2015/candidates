<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\CanResetPassword;

// Замена моим нотификатором класса нотификации сброса паролей
// - Класс MyOwnResetPassword создан командой 
//  php artisan make:notification MyOwnResetPassword
// - Сам шаблон письма находится в /resources/views/vendor/notifications, вынесен командой 
//  php artisan vendor:publish
// - Также в модели User должна присутствовать процедура
//  sendPasswordResetNotification($token)


use App\Notifications\MyOwnResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	// Список 
    public function getAll() 
    {
		return $this->select('*')->orderBy('name');
    }	


    // Установка поля пассворд
	public function setPasswordAttribute($value) {
		$this->attributes['password'] = empty($value)
            ? $this->password
            : Hash::make($value);	
	}

	

	// Получение параметров юзера
	public static function getParams() {

		$result = array();

	    $user = User::find(Auth::user()->id);
		if (isset($user->params)) {
			$result = unserialize($user->params);
		}

		return $result;
	}

	// Сохранение параметров юзера
	public static function setParams($params) {

	    $user = User::find(Auth::user()->id);
		$user->params = serialize($params);
		$user->save();
	}


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
