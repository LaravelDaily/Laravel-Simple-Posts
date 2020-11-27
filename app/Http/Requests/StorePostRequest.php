<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_create');
    }

    public function rules()
    {
        return [
            'title'        => [
                'string',
                'required',
            ],
            'categories.*' => [
                'integer',
            ],
            'categories'   => [
                'array',
            ],
            'start_date'   => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date'     => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'ip_address'   => [
                'string',
                'nullable',
            ],
        ];
    }
}
