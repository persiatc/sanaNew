<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActiveCode extends Model
{
    use HasFactory;
    protected $guarded = [];
        
    /**
     # Date: 2022/6/25 , Developr: Asiye Yaghubi
     * user
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVerifyCode($query , $code,  $user)
    {
        return !! $user->activeCode()->whereCode($code)->where('expired_at' , '>' , now())->first();
    }

    public function scopeGenerateCode($query , $user)
    {
        //        if($code = $this->getAliveCodeForUser($user)) {
        //            $code = $code->code;
        //        } else {
        //
        //        }

        $user->activeCode()->delete();

        do {
            $code = mt_rand(100000, 999999);
        } while($this->checkCodeIsUnique($user , $code));

        // store the code
        $user->activeCode()->create([
            'code' => $code,
            'expired_at' => now()->addMinutes(10)
        ]);

        return $code;
    }

    private function checkCodeIsUnique($user, int $code)
    {
        return !! $user->activeCode()->whereCode($code)->first();
    }

    private function getAliveCodeForUser($user)
    {
        return $user->activeCode()->where('expired_at' , '>' , now())->first();
    }

}
