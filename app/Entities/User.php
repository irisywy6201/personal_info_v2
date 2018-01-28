<?php

namespace App\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use \AppConfig;

class User extends BaseEntity implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['registered', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * User __has_one___ Email.
     */
    public function email()
    {
        return $this->hasOne('Email');
    }

    /**
     * User __has_many__ Question.
     */
    public function questions()
    {
        return $this->hasMany('Question');
    }

    /**
     * User __has_many__ Reply.
     */
    public function replies()
    {
        return $this->hasMany('Reply');
    }

    /**
     * User __has_many__ ContactPersonPosition.
     */
    public function contactPersonPositions()
    {
        return $this->hasMany('ContactPersonPosition');
    }

    public function notReadQuesCount() {
        return $this->questions()->where('status', '0')->where('isRead', false);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Gets the present name of user. The possible return value
     * will be real name and account.
     * @return string Returns the choiced name of this user for
     * resentation. Order: real name then account name (portal ID).
     */
    public function getPresentName()
    {
        if ($this->username) {
            return $this->username;
        }

        return $this->acct;
    }

    /**
     * Check if user is administrator or not.
     *
     * @return Boolean Return True if the user
     * is an administrator, return False otherwise.
     */
    public function isAdmin()
    {
        return (($this->addrole + $this->role) & AppConfig::$roleMap['ROLE_ADMIN']);
    }

    /**
     * Check if user is a system user or not.
     *
     * @return Boolean Return True if the user
     * is a system user, return False otherwise.
     */
    public function isSystemUser()
    {
        return (($this->addrole + $this->role) & AppConfig::$roleMap['ROLE_SYSUSER']);
    }

    /**
     * Check if user is a staff person or not.
     *
     * @return Boolean Return True if the user
     * is a staff person, return False if the
     * user is not a staff person.
     */
    public function isStaff()
    {
        return ($this->isAdmin() || $this->isSystemUser());
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function isFaculty()
    {
        return (($this->addrole + $this->role) & AppConfig::$roleMap['ROLE_FACULTY']);
    }

    public function isStudent()
    {
        return (($this->addrole + $this->role) & AppConfig::$roleMap['ROLE_STUDENT']);
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Collection
     *
     *
     * @return $user query
     */
    public function scopeGetUserMaxRole($query,$user)
    {
        $roleType = array_reverse(AppConfig::$roleMap);
        foreach ($roleType as $key ) {
                if($user->role & $key) {
                    $user->role = $key;
                break;
                }
            }
        return $user;
    }

}

?>
