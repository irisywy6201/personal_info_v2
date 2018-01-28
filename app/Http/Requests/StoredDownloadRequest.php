<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoredDownloadRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		

     
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		
		 $rules = [
        'name' => 'required',
        'describe' => 'required',
        'category' => 'required',
       
      ];

      foreach($this->request->get('brandAndStorage') as $key => $val)
      {
        $rules['brandAndStorage.'.$key] = 'required';
      }

      foreach($this->request->get('propertyId') as $key => $val)
      {
        $rules['propertyId.'.$key] = 'required';
      }
        return [
            //
        ];
    }
}
