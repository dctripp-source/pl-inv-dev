<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'owner_first_name' => 'required|string|max:255',
            'owner_last_name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255|unique:businesses',
            'description' => 'required|string|min:50|max:2000',
            'services' => 'nullable|string|max:1000',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'website' => 'nullable|url|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',

        ];
    }

    public function messages()
    {
        return [
            'owner_first_name.required' => 'Ime vlasnika je obavezno.',
            'owner_last_name.required' => 'Prezime vlasnika je obavezno.',
            'business_name.required' => 'Naziv biznisa je obavezan.',
            'business_name.unique' => 'Biznis sa ovim nazivom već postoji.',
            'description.required' => 'Opis biznisa je obavezan.',
            'description.min' => 'Opis mora imati najmanje 50 karaktera.',
            'description.max' => 'Opis može imati maksimalno 2000 karaktera.',
            'phone.required' => 'Broj telefona je obavezan.',
            'address.required' => 'Adresa je obavezna.',
            'city.required' => 'Grad je obavezan.',
            'categories.required' => 'Morate odabrati najmanje jednu kategoriju.',
            'categories.min' => 'Morate odabrati najmanje jednu kategoriju.',
        ];
    }


    protected function prepareForValidation()
    {

        $uploadedImages = session('uploaded_images', []);
        

        if (empty($uploadedImages)) {
            $this->session()->flash('image_error', 'Morate uploadovati najmanje jednu sliku.');
        }
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $uploadedImages = session('uploaded_images', []);
            
            if (empty($uploadedImages)) {
                $validator->errors()->add('images', 'Morate uploadovati najmanje jednu sliku.');
            }
            
            if (count($uploadedImages) > 10) {
                $validator->errors()->add('images', 'Možete uploadovati maksimalno 10 slika.');
            }
        });
    }
}