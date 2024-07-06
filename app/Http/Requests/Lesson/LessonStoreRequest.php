<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class LessonStoreRequest extends FormRequest
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
            'course_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:250'],
            'description' => ['required', 'string', 'max:1000'],
            'task' => ['required', 'string', 'max:1000'],
            'lesson_number' => ['required', 'numeric'],
            'file_path' => ['nullable', 'max:5120'],
            'inputs.*.video_path' => ['nullable', 'string', 'max:255'],
        ];
    }
}
