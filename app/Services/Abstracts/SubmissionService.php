<?php

namespace App\Services\Abstracts;

use App\Models\AbstractAuthor;
use App\Models\Abstrakt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubmissionService
{
    public function create(array $data, ?int $submitterUserId = null): Abstrakt
    {
        return DB::transaction(function () use ($data, $submitterUserId) {
            $wordCount = $this->countWords($data);
            $contentHash = $this->hashContent($data);

            $reference = sprintf('ABS-%s-%05d', now()->format('Y'), Abstrakt::count() + 1);

            $abstract = Abstrakt::create([
                'reference' => $reference,
                'submitter_user_id' => $submitterUserId,
                'thematic_area_id' => $data['thematic_area_id'],
                'submission_type' => $data['submission_type'],
                'title' => $data['title'],
                'short_title' => Str::limit($data['title'], 80, ''),
                'language' => $data['language'] ?? 'fr',
                'keywords' => $data['keywords'],
                'introduction' => $data['introduction'] ?? null,
                'methods' => $data['methods'] ?? null,
                'results' => $data['results'] ?? null,
                'discussion' => $data['discussion'] ?? null,
                'conclusion' => $data['conclusion'] ?? null,
                'case_description' => $data['case_description'] ?? null,
                'is_case_report' => $data['submission_type'] === 'case_report',
                'word_count' => $wordCount,
                'content_hash' => $contentHash,
                'has_conflict_of_interest' => $data['has_conflict_of_interest'] ?? false,
                'conflict_disclosure' => $data['conflict_disclosure'] ?? null,
                'funding_disclosed' => $data['funding_disclosed'] ?? false,
                'funding_sources' => $data['funding_sources'] ?? null,
                'ethical_approval' => $data['ethical_approval'] ?? false,
                'ethical_approval_number' => $data['ethical_approval_number'] ?? null,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            foreach (($data['authors'] ?? []) as $index => $author) {
                AbstractAuthor::create([
                    'abstract_id' => $abstract->id,
                    'salutation' => $author['salutation'] ?? null,
                    'first_name' => $author['first_name'],
                    'last_name' => $author['last_name'],
                    'email' => $author['email'],
                    'affiliation' => $author['affiliation'],
                    'country' => $author['country'] ?? null,
                    'orcid' => $author['orcid'] ?? null,
                    'is_corresponding' => (bool) ($author['is_corresponding'] ?? ($index === 0)),
                    'is_presenter' => (bool) ($author['is_presenter'] ?? ($index === 0)),
                    'display_order' => $index,
                    'consent_given' => true,
                ]);
            }

            return $abstract;
        });
    }

    public function countWords(array $data): int
    {
        $text = trim(implode(' ', array_filter([
            $data['title'] ?? '',
            $data['introduction'] ?? '',
            $data['methods'] ?? '',
            $data['results'] ?? '',
            $data['discussion'] ?? '',
            $data['conclusion'] ?? '',
            $data['case_description'] ?? '',
        ])));

        return $text === '' ? 0 : str_word_count(strip_tags($text));
    }

    public function hashContent(array $data): string
    {
        $body = strtolower(preg_replace('/\s+/', ' ', implode('|', [
            $data['title'] ?? '',
            $data['introduction'] ?? '',
            $data['methods'] ?? '',
            $data['results'] ?? '',
            $data['discussion'] ?? '',
            $data['conclusion'] ?? '',
            $data['case_description'] ?? '',
        ])));

        return hash('sha256', $body);
    }
}
