<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exhibitor;
use App\Models\ProgramSession;
use App\Models\Room;
use App\Models\Speaker;
use App\Models\Sponsor;
use App\Models\Symposium;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Contrôleur consolidé pour le contenu éditorial du congrès :
 * sponsors, exposants, intervenants, sessions, symposiums.
 * Une seule classe pour éviter la multiplication de controllers CRUD très similaires.
 */
class ContentController extends Controller
{
    public function index(string $type): Response
    {
        abort_unless(in_array($type, ['sponsors', 'exhibitors', 'speakers', 'sessions', 'symposiums', 'rooms'], true), 404);

        $items = $this->modelClass($type)::query()
            ->when($type === 'sessions' || $type === 'symposiums', fn ($q) => $q->orderBy('starts_at'))
            ->when($type === 'sponsors' || $type === 'exhibitors' || $type === 'speakers' || $type === 'rooms', fn ($q) => $q->orderBy('display_order')->orderBy('name'))
            ->get();

        return Inertia::render('Admin/Content/Index', [
            'type' => $type,
            'items' => $items,
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $modelClass = $this->modelClass($type);

        $data = $request->validate($this->validationRules($type));

        if (empty($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(4));
        } elseif (empty($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']).'-'.Str::lower(Str::random(4));
        }

        $modelClass::create($data);

        return back()->with('success', ucfirst($type).' créé(e).');
    }

    public function update(Request $request, string $type, int $id): RedirectResponse
    {
        $item = $this->modelClass($type)::findOrFail($id);
        $data = $request->validate($this->validationRules($type, $id));
        $item->update($data);

        return back()->with('success', ucfirst($type).' mis(e) à jour.');
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $this->modelClass($type)::findOrFail($id)->delete();

        return back()->with('success', ucfirst($type).' supprimé(e).');
    }

    protected function modelClass(string $type): string
    {
        return match ($type) {
            'sponsors' => Sponsor::class,
            'exhibitors' => Exhibitor::class,
            'speakers' => Speaker::class,
            'sessions' => ProgramSession::class,
            'symposiums' => Symposium::class,
            'rooms' => Room::class,
        };
    }

    protected function validationRules(string $type, ?int $id = null): array
    {
        return match ($type) {
            'sponsors' => [
                'name' => ['required', 'string', 'max:200'],
                'tier' => ['required', 'in:platinum,gold,silver,bronze,partner,institutional,media'],
                'website' => ['nullable', 'url'],
                'description' => ['nullable', 'string', 'max:2000'],
                'logo_path' => ['nullable', 'string'],
                'is_published' => ['boolean'],
                'display_order' => ['integer', 'min:0'],
            ],
            'exhibitors' => [
                'name' => ['required', 'string', 'max:200'],
                'booth_number' => ['nullable', 'string', 'max:32'],
                'website' => ['nullable', 'url'],
                'description' => ['nullable', 'string', 'max:2000'],
                'is_published' => ['boolean'],
                'display_order' => ['integer', 'min:0'],
            ],
            'speakers' => [
                'first_name' => ['required', 'string', 'max:120'],
                'last_name' => ['required', 'string', 'max:120'],
                'salutation' => ['nullable', 'string', 'max:16'],
                'job_title' => ['nullable', 'string', 'max:200'],
                'affiliation' => ['nullable', 'string', 'max:200'],
                'country' => ['nullable', 'string', 'size:2'],
                'biography' => ['nullable', 'string', 'max:5000'],
                'is_keynote' => ['boolean'],
                'is_featured' => ['boolean'],
                'is_published' => ['boolean'],
                'name' => ['nullable', 'string'], // pour générer slug si fournit séparément
            ],
            'sessions' => [
                'title' => ['required', 'string', 'max:300'],
                'type' => ['required', 'in:plenary,workshop,oral,poster,symposium,keynote,break,ceremony'],
                'starts_at' => ['required', 'date'],
                'ends_at' => ['required', 'date', 'after:starts_at'],
                'room_id' => ['nullable', 'exists:rooms,id'],
                'description' => ['nullable', 'string', 'max:5000'],
                'language' => ['nullable', 'in:fr,en'],
                'cme_credits' => ['integer', 'min:0', 'max:20'],
                'is_published' => ['boolean'],
                'is_featured' => ['boolean'],
            ],
            'symposiums' => [
                'title' => ['required', 'string', 'max:300'],
                'sponsor_id' => ['nullable', 'exists:sponsors,id'],
                'room_id' => ['nullable', 'exists:rooms,id'],
                'starts_at' => ['required', 'date'],
                'ends_at' => ['required', 'date', 'after:starts_at'],
                'price' => ['numeric', 'min:0'],
                'currency' => ['nullable', 'string', 'size:3'],
                'capacity' => ['nullable', 'integer', 'min:1'],
                'is_published' => ['boolean'],
            ],
            'rooms' => [
                'name' => ['required', 'string', 'max:120'],
                'capacity' => ['nullable', 'integer', 'min:1'],
                'color' => ['nullable', 'string', 'max:16'],
                'is_active' => ['boolean'],
                'display_order' => ['integer', 'min:0'],
            ],
        };
    }
}
