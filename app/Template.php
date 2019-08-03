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
        if ($variables !== null && is_array($variables) === true) {
            foreach ($variables as $k => $v) {
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
    }

    public function thumbnail(){
        if(false && config('app.env') === 'production'){
            // Cannot use this method as imagick might not be compiled right.
            $pdfThumb = new \imagick();
            $pdfThumb->setResolution(10, 10);
            $pdfThumb->readImage(url("/pdf/preview-template/{$this->id}[0]"));
            $pdfThumb->setImageFormat('jpg');
            return $pdfThumb;
        }
        return 'https://via.placeholder.com/150x200/';
    }
}
