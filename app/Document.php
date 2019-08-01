<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viewLinks(){
        return $this->hasMany(ViewLink::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function signers(){
        return $this->hasMany(Signer::class);
    }

    /**
     * @param $variablesArr
     * @param $signatureArr
     * @return false|mixed|string
     */
    public function setVariables($variablesArr, $signatureArr){
        foreach($variablesArr as $variable => $value){
            $variablesArr[$variable] = [
                'value' => $value,
                'signature_field' => $signatureArr[$variable]
            ];
        }
        $this->variable_values = json_encode($variablesArr);
        return $this->variable_values;
    }

    /**
     * @return mixed
     */
    public function getVariables(){
        return json_decode($this->variable_values);
    }

    /**
     * @return mixed
     */
    public function processedDocument(){
        $variables = json_decode($this->variable_values);

        preg_match_all('/{(\w+)}/', $this->content, $matches);
        $processedContent = $this->content;
        foreach ($matches[0] as $index => $var_name) {
            $variableName = str_replace(['{','}'], '', $var_name);

            if (isset($variables->$variableName)) {
                if($variables->$variableName->signature_field == 1){
                    // get signature data if has signed
                    $signer = Signer::where('document_id', $this->id)->where('email', $variables->$variableName->value)->first();
                    if (empty($signer->signature_data) === false) {
                        // place img onto line
                        $processedContent = str_replace($var_name, "<img src='{$signer->signature_data}' style='height:120px;border-bottom:1px solid black;' />", $processedContent);
                    } else {
                        // place a line for manual signing
                        $processedContent = str_replace($var_name, "_______________________________________________________", $processedContent);
                    }
                } else {
                    $processedContent = str_replace($var_name, "{$variables->$variableName->value}", $processedContent);
                }
            }
        }

        return $processedContent;
    }
}
