<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class HDDestroyFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

      $rules = [
        'brandAndStorage' => 'required',
        'propertyId' => 'required',
        'identifyExtensionNumber' => 'required',
        'datetimepicker' => 'required',
      ];

      foreach($this->request->get('brandAndStorage') as $key => $val)
      {
        $rules['brandAndStorage.'.$key] = 'required';
      }

      foreach($this->request->get('propertyId') as $key => $val)
      {
        $rules['propertyId.'.$key] = 'required';
      }

      return $rules;
    }

    public function messages()
    {

      $messages = [
        'brandAndStorage.required' => '品牌容量欄位不能為空!',
        'propertyId.required' => '財產編號欄位不能為空!',
        'identifyExtensionNumber.required' => '分機號碼欄位不能為空!',
        'datetimepicker.required' => '時間欄位不能為空!',
      ];

      foreach($this->request->get('brandAndStorage') as $key => $val)
      {
        $messages['brandAndStorage.'.$key] = '品牌容量欄位 '.$key.'" 不能為空！';
      }

      foreach($this->request->get('propertyId') as $key => $val)
      {
        $messages['propertyId.'.$key] = '財產編號欄位 '.$key.'" 不能為空！';
      }

      return $messages;
  }





}
