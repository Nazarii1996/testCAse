<?php

namespace App\Http\Requests;

use App\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title'       => [
                'required'],
            'description' => [
                'max:2000',
                'required'],
            'start'       => [
                'date_format:' . config('panel.date_format'),
                'nullable'],
            'end'         => [
                'date_format:' . config('panel.date_format'),
                'nullable'],
            'type'        => [
                'required'],
        ];

    }
}
