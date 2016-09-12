<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProformaInvoiceRequest extends Request
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
        'order_id' => 'required|unique:proforma_invoices',//unique value in the "datatable"
        //'create_date' => 'required',
        //'bill_to' => 'required',
        //'quantity.*' => 'required|numeric|min:0',
        //'unit_price.*' => 'required|numeric|min:0',
        //'total.*' => 'required|numeric|min:0',
      ];

    }

}
