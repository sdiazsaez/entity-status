<?php
/**
 * Copyright (c) 2022. Simon Diaz <sdiaz@sdshost.ml>
 */

namespace Larangular\EntityStatus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityStatusRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'key'    => 'required|string',
            'status' => 'required|number',
            'message' => 'nullable|string'
        ];
    }
}
