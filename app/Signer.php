<?php

namespace App;

use App\Mail\SignatureRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Mail;

class Signer extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authorizationCode(){
        return $this->hasOne(AuthorizationCode::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document(){
        return $this->belongsTo(Document::class);
    }

    /**
     *  Creates an authorization code
     */
    public function generateAuthCode(){
        if ($this->id === null) {
            $lastSigner = Signer::orderBy('id', 'desc')->first();
            if ($lastSigner === null){
                $signerId = 1;
            } else {
                $signerId = $lastSigner->id + 1;
            }
        } else {
            $signerId = $this->id;
        }

        // create auth code
        $authCode = AuthorizationCode::generateCode(6, date('YmdHis'));

        // delete previous auth codes
        AuthorizationCode::where('signer_id', $signerId)->delete();

        // generate a new auth code
        $newAuthorizationCode = new AuthorizationCode([
            'signer_id'     => $signerId,
            'password'      => bcrypt($authCode),
            'expiration'    => time() + (2 * 86400)
        ]);
        $newAuthorizationCode->save();
        $this->authorization_code_id = $newAuthorizationCode->id;

        if ($this->id != null) {
            $this->update();
        }

        // send out email
        Mail::to($this->email)->send(new SignatureRequest($this, $signerId, $authCode));
    }
}
