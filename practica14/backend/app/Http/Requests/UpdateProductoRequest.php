<?php

namespace App\Http\Requests;

class UpdateProductoRequest extends StoreProductoRequest
{
    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'Debes indicar un precio.',
            'stock.required' => 'Debes indicar el stock.',
        ]);
    }
}
