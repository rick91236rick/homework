<?php

namespace App\Http\Requests\Order;

use App\Http\Domains\Order\ValueObjects\Address;
use App\Http\Domains\Order\ValueObjects\OrderInfo;
use App\Models\Orders\Currency;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['string', 'required'],
            'name' => ['string', 'required'],
            'address' => ['array', 'required'],
            'address.city' => ['string', 'required'],
            'address.district' => ['string', 'required'],
            'address.street' => ['string', 'required'],
            'price' => ['integer', 'required'],
            'currency' => [new Enum(Currency::class), 'required'],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, new JsonResponse([
            'errors' => $validator->errors()->messages(),
        ], 422),);
    }

    public function getOrderInfo(): OrderInfo
    {
        return new OrderInfo(
            id: $this->input('id'),
            name: $this->input('name'),
            address: new Address(
                city: $this->input('address.city'),
                district: $this->input('address.district'),
                street: $this->input('address.street'),
            ),
            price: $this->input('price'),
            currency: $this->enum('currency', Currency::class),
        );
    }
}
