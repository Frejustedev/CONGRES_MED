<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAbstractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'thematic_area_id' => ['required', 'exists:thematic_areas,id'],
            'submission_type' => ['required', 'in:oral,poster,eposter,case_report'],
            'title' => ['required', 'string', 'max:300'],
            'language' => ['required', 'in:fr,en'],
            'keywords' => ['required', 'array', 'min:3', 'max:6'],
            'keywords.*' => ['string', 'max:64'],

            // IMRAD (optionnel selon type)
            'introduction' => ['nullable', 'string', 'max:5000'],
            'methods' => ['nullable', 'string', 'max:5000'],
            'results' => ['nullable', 'string', 'max:5000'],
            'discussion' => ['nullable', 'string', 'max:5000'],
            'conclusion' => ['nullable', 'string', 'max:5000'],
            'case_description' => ['nullable', 'string', 'max:6000'],

            // COI / éthique
            'has_conflict_of_interest' => ['boolean'],
            'conflict_disclosure' => ['nullable', 'string', 'max:2000'],
            'funding_disclosed' => ['boolean'],
            'funding_sources' => ['nullable', 'string', 'max:2000'],
            'ethical_approval' => ['boolean'],
            'ethical_approval_number' => ['nullable', 'string', 'max:120'],

            // Auteurs
            'authors' => ['required', 'array', 'min:1', 'max:15'],
            'authors.*.salutation' => ['nullable', 'string', 'max:16'],
            'authors.*.first_name' => ['required', 'string', 'max:120'],
            'authors.*.last_name' => ['required', 'string', 'max:120'],
            'authors.*.email' => ['required', 'email', 'max:160'],
            'authors.*.affiliation' => ['required', 'string', 'max:300'],
            'authors.*.country' => ['nullable', 'string', 'size:2'],
            'authors.*.orcid' => ['nullable', 'string', 'max:32'],
            'authors.*.is_corresponding' => ['boolean'],
            'authors.*.is_presenter' => ['boolean'],

            'terms_accepted' => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'thematic_area_id' => 'thématique',
            'submission_type' => 'type de soumission',
            'title' => 'titre',
            'keywords' => 'mots-clés',
            'authors' => 'auteurs',
        ];
    }
}
