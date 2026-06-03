<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'precio' => ['required', 'numeric', 'min:0.01', 'max:99999'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['nullable', 'exists:categorias,id'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no puede superar :max caracteres.',
            'descripcion.max' => 'La descripcion no puede superar :max caracteres.',
            'precio.required' => 'Debes indicar un precio.',
            'precio.min' => 'El precio debe ser mayor a cero.',
            'precio.max' => 'El precio no puede superar :max.',
            'stock.required' => 'Debes indicar el stock.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'categoria_id.exists' => 'La categoria seleccionada no existe.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser JPG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede superar 2 MB.',
        ];
    }
}
