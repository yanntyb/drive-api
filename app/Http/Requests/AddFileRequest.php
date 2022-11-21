<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class AddFileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "files" => "required|array|min:1",
            "files.*" => "required|file",
            "path" => "required|regex:#^(?:[/]\w+)+$#",
            "storage_id" => Rule::exists("storages","id")->where(static function(Builder $query){
                return $query->whereIn("id",auth()->user()->storages->pluck("id"));
            }),
        ];
    }

    public function messages()
    {
        return [
            "files.required" => "Files are required",
            "files.*.required" => "Files are required",
            "files.*.file" => "Files should be files !",
            "storage_id.exists" => "This storage isn't yours"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_FORBIDDEN));
    }

}
