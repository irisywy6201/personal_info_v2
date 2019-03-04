<?php

namespace App\Http\Controllers;

use \App;
use \Auth;
use \Crypt;
use \Input;
use \Lang;
use \Mail;
use \Redirect;
use \URL;
use \Validator;
use \View;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\DynamicLink;
use App\Entities\Email;
use App\Entities\NcuccOffduty;
use App\Entities\User;
use App\Entities\UserLogs;

use App\Jobs\SendMail;

class EmailController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }

    private $rules = [
        'email' => 'required|email|regex:/.+(?<!@cc.ncu.edu.tw)$/',
        'acct' => 'required',
        'name' => 'required',
        'g-recaptcha-response' => 'required|recaptcha'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {       
        return App::abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($acct)
    {
        $acct = Crypt::decrypt($acct);
        $altEmail = null;
        $altEmail = NcuccOffduty::where('sid', $acct)->get()->toArray();
        $userID = User::where('acct', $acct)->pluck('id');
        $userName = User::find($userID)->getPresentName();

        if ($altEmail && count($altEmail) === 1) {
            $altEmail = $altEmail[0];

            $verificationLink = $this->storeUnverifiedEmail($acct, $altEmail['email']);
            $this->sendVerificationMail($altEmail['email'], $verificationLink);

            UserLogs::writeEmailLog(Carbon::now(), $acct);

            return View::make('admin.CheckEmail.verificationEmailSentReminder')->with([
                'user' => $userName,
                'acct' => Crypt::encrypt($acct),
                'email' => Crypt::encrypt($altEmail['email']),
                'feedback' => [
                    'type' => 'success',
                    'message' => Lang::get('backupMail.mailSent')
                ],
                'showPortalEmailMessage' => true
            ]);
        }
        else {
            $userId = User::where('acct', $acct)->pluck('id');
            $username = User::where('acct', $acct)->pluck('username');
            $presentName = User::find($userId)->getPresentName();
            
            // if count is greater than 1, send error e-mail.
            return View::make('admin.CheckEmail.newAlternateEmailAddress')->with([
                'acct' => $acct,
                'name' => $username,
                'presentName' => $presentName
            ]);
        }
    }

    /**
     * Store a newly created backup e-mail for a specific user.
     *
     * @return Response
     */
    public function store($internalCall = false)
    {
        $validation = Validator::make(Input::all(), $this->rules);
        
        if ($validation->passes()) {
            $acct = Input::get('acct');
            $email = Input::get('email');
            $userRealName = Input::get('name');

            if (!$internalCall) {
                $acct = Crypt::decrypt($acct);
            }

            $userId = User::where('acct', $acct)->pluck('id');
            $user = User::find($userId);
            
            User::where('acct', $acct)->update([
                'username' => $userRealName
            ]);

            // Check if user is already registered
            if ($user->registered) {
                return View::make('admin.CheckEmail.alreadyRegistered')->with([
                    'user' => $user->getPresentName(),
                    'email' => $email
                ]);
            }
            else {
                $verificationLink = $this->storeUnverifiedEmail($acct, $email);
                $this->sendVerificationMail($email, $verificationLink);

                UserLogs::writeEmailLog(Carbon::now(), $acct);

                return View::make('admin.CheckEmail.verificationEmailSentReminder')->with([
                    'user' => $user->getPresentName(),
                    'acct' => Crypt::encrypt($acct),
                    'email' => Crypt::encrypt($email),
                    'feedback' => [
                        'type' => 'success',
                        'message' => Lang::get('backupMail.mailSent')
                    ],
                    'showPortalEmailMessage' => false
                ]);
            }
        }
        else {
            return Redirect::back()->withInput()->withErrors($validation->messages())->with([
                'feedback' => [
                    'type' => 'danger',
                    'message' => Lang::get('backupMail.sendFailure')
                ]
            ]);
        }
    }

    /**
     * Redo the store() function.
     *
     * @return Response.
     */
    public function redoStoreEmailVerification()
    {
        if ($this->__validate(Input::all(), ['email', 'acct'])) {
            $email = Crypt::decrypt(Input::get('email'));
            $encryptedAcct = Input::get('acct');
            $acct = Crypt::decrypt($encryptedAcct);
            $userID = User::where('acct', $acct)->pluck('id');
            $user = User::find($userID);

            if (Email::where('address', $email)->where('user_id', $userID)->pluck('verified')) {
                return View::make('admin.CheckEmail.emailAddressUsed')->with([
                    'user' => $user->getPresentName(),
                    'email' => $email,
                    'feedback' => [
                        'type' => 'warning',
                        'message' => Lang::get('backupMail.resendVeriEmailFailure')
                    ]
                ]);
            }
            else {
                $verificationLink = $this->storeUnverifiedEmail($acct, $email);
                $this->sendVerificationMail($email, $verificationLink);

                return View::make('admin.CheckEmail.verificationEmailSentReminder')->with([
                    'user' => $user->getPresentName(),
                    'acct' => $encryptedAcct,
                    'email' => Crypt::encrypt($email),
                    'feedback' => [
                        'type' => 'success',
                        'message' => Lang::get('backupMail.mailSent')
                    ],
                    'showPortalEmailMessage' => false
                ]);
            }
        }
        else {
            return Redirect::back()->withErrors()->withInput()->with([
                'user' => $user->getPresentName(),
                'acct' => $encryptedAcct,
                'email' => Crypt::encrypt($inputEmail),
                'feedback' => [
                    'type' => 'danger',
                    'message' => Lang::get('backupMail.resendVeriEmailFailure')
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return App::abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if (Auth::check())
        {
            if (Email::find($id)) {
                return View::make('admin.CheckEmail.editEmail')
                    ->with([
                        'id' => $id,
                        'user' => Auth::user()->getPresentName(),
                        'email' => Email::find($id)->address
                ]);
            }
            else {
                return App::abort(404, Lang::get('alerts.updateFailure', ['item' => Lang::get('backupMail.email')]));
            }
        }
        else {
            return Redirect::guest('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if (Auth::check()) {
            $acct = Auth::user()->acct;
            $email = Input::get('email');
            $userID = Auth::user()->id;
            $user = User::find($userID);
            $validation = $this->__validate(Input::all(), ['email']);

            if ($validation->passes()) {
                if (Email::where('address', $email)->where('user_id', $userID)->pluck('verified')) {
                    return View::make('admin.CheckEmail.emailAddressUsed')->with([
                        'user' => $user->getPresentName(),
                        'email' => $email,
                        'feedback' => [
                            'type' => 'warning',
                            'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('backupMail.email')])
                        ]
                    ]);
                }
                else {
                    $verificationLink = $this->storeUnverifiedEmail($acct, $email);
                    $this->sendVerificationMail($email, $verificationLink);

                    return View::make('admin.CheckEmail.verificationEmailSentReminder')->with([
                        'user' => $user->getPresentName(),
                        'acct' => Crypt::encrypt($acct),
                        'email' => Crypt::encrypt($email),
                        'feedback' => [
                            'type' => 'success',
                            'message' => Lang::get('backupMail.mailSent')
                        ],
                        'showPortalEmailMessage' => false
                    ]);
                }
            }
            else {
                return Redirect::back()->withErrors($validation->messages())->withInput()->with([
                    'feedback' => [
                        'type' => 'danger',
                        'message' => Lang::get('backupMail.sendFailure')
                    ]
                ]);
            }
        }
        else {
            return Redirect::guest('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $emailQuery = null;

        if (Auth::check()) {
            $emailHash = Email::find($id)->hash;

            if (!is_null($emailHash) && count($emailHash) > 0) {
                DynamicLink::where('hash', $emailHash)->delete();
                Email::find($id)->delete();

                return Redirect::back()->with([
                    'feedback' => [
                        'type' => 'success',
                        'message' => Lang::get('alerts.deleteSuccess', ['item' => 'backupMail.email'])
                    ]
                ]);
            }
            else {
                return View::make('errors.errorMessage')->with([
                    'title' => Lang::get('alerts.deleteFailure', ['item' => 'backupMail.email']),
                    'content' => Lang::get('backupMail.emailNotFound'),
                    'feedback' => [
                        'type' => 'danger',
                        'message' => Lang::get('alerts.deleteFailure', ['item' => 'backupMail.email'])
                    ]
                ]);
            }
        }
        else {
            return Redirect::guest('login');
        }
    }

    /**
     * Verifying the E-mail and set the user's E-mail address.
     * If verification failed, give a page to inform user about
     * what kink of error he/she encountered.
     *
     * @param {String} hashCode The hash code which corresponds
     * to the E-mail address to be verified.
     * @return Response.
     */
    public function verify($hashCode)
    {
        if (!$this->isEmailDuplicated($hashCode) && !$this->isEmailOutOfDate($hashCode)) {
            $emailID = Email::where('hash', $hashCode)->pluck('id');
            $email = Email::find($emailID);
            $userID = $email->user()->pluck('id');
            $userAcct = User::find($userID)->pluck('acct');

            // Delete user's verified e-mail.
            Email::where('user_id', $userID)->where('verified', true)->delete();
            DynamicLink::where('hash', $hashCode)->delete();

            // Verify user's new E-mail.
            $email->update(['verified' => true]);
            $email->user()->update(['registered' => true]);
            $email->user()->update(['status' => 'active']);

            // Update NCU Computer Center database.
            $studentID = NcuccOffduty::where('sid', $userAcct)->pluck('sid');
            if ($studentID) {
                NcuccOffduty::where('sid', $userAcct)->update([
                    'trans_flag' => true
                ]);
            }

            return View::make('admin.CheckEmail.verifySucceeded')->with([
                'email' => $email['email'],
                'feedback' => [
                    'type' => 'success',
                    'message' => Lang::get('backupMail.verifySuccess')
                ]
            ]);
        }
        else {
            return View::make('admin.CheckEmail.errorMessage')->with([
                'title' => Lang::get('backupMail.verifyFailure'),
                'content' => Lang::get('backupMail.linkExpired'),
                'feedback' => [
                    'type' => 'danger',
                    'message' => Lang::get('backupMail.verifyFailure')
                ]
            ]);
        }
    }

    /**
     * Delete the dued e-mail which is not verified yet.
     *
     * @param {Object} job The IronIO job object.
     * @param {Integer} id The ID number of the e-mail.
     * @return {Boolean} True if deleted, False if deletion
     * failed.
     */
    public function deleteDueEmail($job, $id)
    {
        $email = Email::find($id[0]);

        if (!is_null($id) && !is_null($email) && !$email->verified) {
            DynamicLink::where('hash', $email['hash'])->delete();
            $email->delete();
        }
        
    }
    
    /**
     * Send verification E-mail to user who registered it.
     *
     * @param {String} receiver The receiver of this E-mail (Current user).
     * @param {String} link The link to the verification page.
     */
    public function sendVerificationMail($receiver, $verificationLink)
    {
        $data['receivers'] = $receiver;
        $data['subject'] = Lang::get('email.verificationMail.subject');
        $data['mailView'] = 'emails.verificationMail';
        $data['mailViewData'] = [
            'link' => $verificationLink
        ];

        $this->dispatch(new SendMail($data));
    }

    /**
     * Generate a dynamic link for e-mail verification.
     *
     * @return {String} a dynamic link.
     */
    public function generateDynamicLink()
    {
        $datetime = Carbon::now()->addDays(2);
        $randomNumber = rand(1, 1000);
        
        return md5($datetime . $randomNumber);
    }

    /**
     * Validate the input is valid or not. For Ajax real time validation.
     *
     * @return {JSON} an object containing the result of validation.
     */
    public function ajaxValidate()
    {
        $myRules = [];

        foreach (Input::all() as $inputName => $value) {
            $myRules[$inputName] = $this->rules[$inputName];
        }

        $validation = Validator::make(Input::all(), $myRules);
        $result = [];

        if ($validation->passes()) {
            $result['status'] = true;
            $result['message'] = null;
        }
        else {
            $result['status'] = false;
            $result['message'] = $validation->messages()->getMessages();
        }

        return json_encode($result);
    }

    /**
     * Store a newly created e-mail address whose status
     * is unverified into database.
     *
     * @param string $acct The ID number of current user.
     * @param string $email The e-mail address to be stored.
     * @return string Returns the verification link.
     */
    public function storeUnverifiedEmail($acct, $email)
    {
        $this->discardUnverifiedEmail($acct);
        
        $due = Carbon::now()->addDays(1);
        $link = new DynamicLink();
        $link = $link->newDynamicLink(URL::to('/email/verify/'), $due);
        $hashCode = explode('/', $link);
        $hashCode = $hashCode[count($hashCode) - 1];

        $newEmail = new Email();
        $newEmail->user_id = User::where('acct', $acct)->pluck('id');
        $newEmail->address = $email;
        $newEmail->hash = $hashCode;
        $newEmail->due = $due;
        $newEmail->save();

        return $link;
    }

    /**
     * Discard the unverified e-mail and the corresponding
     * dynamic link record in database for a given user.
     *
     * @param {String} acct The user account.
     * @return {Boolean} True if there exists unverifeid e-mail
     * and deleted it, False if no unverified e-mail in database.
     */
    public function discardUnverifiedEmail($acct)
    {
        $userID = User::where('acct', $acct)->pluck('id');
        $unverifiedEmailQuery = User::find($userID)->email()->where('verified', false);
        $hashCodes = $unverifiedEmailQuery->lists('hash')->all();

        if ($hashCodes) {
            DynamicLink::whereIn('hash', $hashCodes)->delete();
        }
        
        $unverifiedEmailQuery->delete();
    }

    /**
     * Performs a full validation to decide the input is valid or not.
     *
     * @param data {Array} the inputs.
     * @return {MessageBag} an object containing the result of validation. (See Laravel API document)
     */
    private function __fullValidate($data)
    {
        return Validator::make($data, $this->rules);
    }

    /**
     * Validate the input is valid or not.
     *
     * @param data {Array} the inputs.
     * @param option {Array} decide which input(s) needs to be validated.
     * @return {MessageBag} an object containing the result of validation. (See Laravel API document)
     */
    private function __validate($data, $option)
    {
        $myRules = [];

        if ($option && count($option) > 0) {
            foreach ($option as $key => $inputName) {
                $myRules[$inputName] = $this->rules[$inputName];
            }

            return Validator::make($data, $myRules);
        }
        else {
            return $this->__fullValidate($data);
        }
    }

    /**
     * Check if there is any duplicated e-mail in database.
     *
     * @param {String} email The e-mail to be checked.
     * @return {Boolean} True if no duplicated e-mail in database,
     * False if there exists any duplicated e-mail.
     */
    private function isEmailDuplicated($hash)
    {
        if (is_null(Email::where('hash', $hash)->where('verified', true)->first()))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Check if e-mail is out of date or not.
     *
     * @param {String} hash The hash code of e-mail.
     * @return {Boolean} True if given e-mail is out of date,
     * False if given e-mail is not out of date.
     */
    private function isEmailOutOfDate($hash)
    {
        if (Email::where('hash', $hash)->pluck('due') > Carbon::now()) {
            return false;
        }
        else {
            return true;
        }
    }
}
