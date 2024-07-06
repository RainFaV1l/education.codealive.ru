<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true || auth()->user->role_id === 3;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'author' => ['required', 'numeric'],
            'course_category_id' => ['required', 'numeric'],
            'course_level_id' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'course_icon_path' => ['required', 'image', 'max:5120'],
        ];
    }
}
