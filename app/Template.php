<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function variables()
    {
        return $this->hasMany(Variable::class);
    }

    /**
     * @param $variables
     * @param $signatures
     */
    public function saveVariables($variables, $signatures){
        foreach($variables as $k => $v){
            $variable = Variable::where([
                'template_id'   => $this->id,
                'variable'      => $k
            ])->first();

            if($variable != null){
                // update
                $variable->name = $v;
                $variable->signature_field = (count($signatures) && isset($signatures[$k]) &&  (int)$signatures[$k] == 1) ? 1 : 0;

                $variable->update();
            } else {
                $variable = new Variable([
                    'template_id'       => $this->id,
                    'name'              => $v,
                    'variable'          => $k,
                    'signature_field'   => (count($signatures) && isset($signatures[$k]) &&  (int)$signatures[$k] == 1) ? 1 : 0
                ]);

                $variable->save();
            }
        }
    }

    public function thumbnail(){
        if(config('APP_ENV') == 'production'){
            $pdfThumb = new \imagick();
            $pdfThumb->setResolution(10, 10);
            $pdfThumb->readImage("/pdf/preview-template/{$this->id}[0]");
            $pdfThumb->setImageFormat('jpg');
            return $pdfThumb;
        }
        return 'https://via.placeholder.com/150x200/';
    }
}
