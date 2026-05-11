<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Étape 1 : Catégorie
            'category_id' => ['required', 'exists:registration_categories,id'],

            // Étape 2 : Identité
            'salutation' => ['nullable', 'string', 'max:16'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:32'],
            'whatsapp' => ['nullable', 'string', 'max:32'],

            // Profil professionnel
            'profession' => ['nullable', 'string', 'max:120'],
            'organization' => ['nullable', 'string', 'max:200'],
            'job_title' => ['nullable', 'string', 'max:200'],
            'specialty' => ['nullable', 'string', 'max:120'],

            // Adresse
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'size:2'],
            'country_of_origin' => ['nullable', 'string', 'size:2'],

            // Étape 3 : Options
            'promo_code' => ['nullable', 'string', 'max:64'],
            'visa_letter_requested' => ['boolean'],
            'accompanying_persons' => ['nullable', 'integer', 'min:0', 'max:10'],
            'dietary_restrictions' => ['nullable', 'array'],
            'dietary_restrictions.*' => ['string', 'in:halal,vegetarian,vegan,gluten_free,lactose_free,kosher'],

            // Consentements
            'newsletter_optin' => ['boolean'],
            'directory_optin' => ['boolean'],
            'terms_accepted' => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'catégorie tarifaire',
            'first_name' => 'prénom',
            'last_name' => 'nom',
            'email' => 'e-mail',
            'phone' => 'téléphone',
            'profession' => 'profession',
            'organization' => 'organisation',
            'specialty' => 'spécialité',
            'country' => 'pays',
            'terms_accepted' => 'conditions générales',
        ];
    }
}
