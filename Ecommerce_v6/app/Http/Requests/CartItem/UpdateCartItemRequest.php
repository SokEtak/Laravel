<?php

namespace App\Http\Requests\CartItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Example: User can only update items in their own cart session
        // return $this->route('cart_item')->cartSession->user_id === $this->user()->id;
        return true;
    }

    public function rules(): array
    {
        // When updating a specific cart item identified by its composite key,
        // you generally don't change the cart_session_id or product_id.
        // The unique rule is complex with composite keys for updates without a package.
        // It's often handled by finding the existing record first.

        return [
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
