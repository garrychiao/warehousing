<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PurchaseRecordRequest extends Request
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
      return [
        //'order_id' => 'required|unique:purchase_records',//unique value in the "datatable"
        //'delivery_date' => 'required',
        //'quantity.*' => 'required|numeric|min:0',
        //'unit_price.*' => 'required|numeric|min:0',
        //'total.*' => 'required|numeric|min:0',
        //'purchase_date' => 'required',
      ];
    }
}
