<?php

namespace App\Http\Requests\ProductLike;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductLikeRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Typically, likes are not "updated" but created/deleted.
        // If you were to allow updating, it might be for a status, but this schema doesn't support that.
        // Authorization would be crucial: only the liking user can update their own like.
        return true;
    }

    public function rules(): array
    {
        // No updatable fields in this schema for a "like" other than liked_at which is managed by DB.
        // This request class might be redundant unless you introduce more attributes.
        return [];
    }
}
