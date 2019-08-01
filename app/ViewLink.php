<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewLink extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document(){
        return $this->belongsTo(Document::class);
    }

    /**
     * @param $length
     * @param $seed
     * @return string
     */
    public static function generateToken($length, $dateSeed){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";

        mt_srand($dateSeed);

        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }
        return $token;
    }
}
