<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->route('post')?->id;
        return [
            'title' => 'required|min:3|unique:posts,title,'.$postId,
            'description' => 'required|min:10',
            'image' => 'required|mimes:jpeg,PNG,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.min' => 'Title must be at least 3 characters',
            'title.unique' => 'Title must be unique',
            'description.required' => 'Description is required',
            'description.min' => 'Description must be at least 10 characters',
            'image.mimes' => 'Image must be jpeg, png, jpg or gif',
            'image.max' => 'Image size must not exceed 2MB'
        ];
    }
}
