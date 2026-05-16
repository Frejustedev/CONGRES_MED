<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\CmeCredit;
use App\Models\ProgramSession;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CmeQuizController extends Controller
{
    public function show(Request $request, int $sessionId): Response|RedirectResponse
    {
        $session = ProgramSession::findOrFail($sessionId);

        if (! $session->quiz_questions || ! count($session->quiz_questions)) {
            abort(404, 'Aucun quiz disponible pour cette session.');
        }

        // Auth simple via email + reference
        $registration = $this->authenticate($request);
        if (! $registration) {
            return Inertia::render('Public/CmeQuiz/Auth', [
                'session' => ['id' => $session->id, 'title' => $session->title],
            ]);
        }

        // Doit avoir scanné la session
        $hasAttended = Attendance::where('registration_id', $registration->id)
            ->where('session_id', $session->id)
            ->exists();

        if (! $hasAttended) {
            return Inertia::render('Public/CmeQuiz/NotAttended', [
                'session' => ['title' => $session->title],
            ]);
        }

        $existing = CmeCredit::where('registration_id', $registration->id)
            ->where('session_id', $session->id)
            ->first();

        if ($existing && $existing->quiz_passed) {
            return Inertia::render('Public/CmeQuiz/AlreadyPassed', [
                'session' => ['title' => $session->title],
                'credits' => (float) $existing->credits,
            ]);
        }

        return Inertia::render('Public/CmeQuiz/Quiz', [
            'session' => [
                'id' => $session->id,
                'title' => $session->title,
                'cme_credits' => $session->cme_credits,
                'pass_threshold' => $session->quiz_pass_threshold,
                'questions' => collect($session->quiz_questions)->map(fn ($q, $i) => [
                    'index' => $i,
                    'question' => $q['question'],
                    'options' => $q['options'],
                ])->values(),
            ],
            'registration_reference' => $registration->reference,
            'registration_email' => $registration->participant->email,
        ]);
    }

    public function submit(Request $request, int $sessionId): RedirectResponse
    {
        $session = ProgramSession::findOrFail($sessionId);
        $registration = $this->authenticate($request);
        abort_unless($registration, 403);

        $validated = $request->validate([
            'answers' => ['required', 'array'],
            'answers.*' => ['integer', 'min:0'],
        ]);

        $questions = $session->quiz_questions;
        $correctCount = 0;
        foreach ($questions as $i => $q) {
            if (($validated['answers'][$i] ?? null) === ($q['correct_answer'] ?? null)) {
                $correctCount++;
            }
        }

        $score = (int) round(($correctCount / count($questions)) * 100);
        $passed = $score >= $session->quiz_pass_threshold;

        CmeCredit::updateOrCreate(
            ['registration_id' => $registration->id, 'session_id' => $session->id],
            [
                'category' => 'cme',
                'credits' => $passed ? $session->cme_credits : 0,
                'quiz_required' => true,
                'quiz_passed' => $passed,
                'quiz_score' => $score,
                'quiz_attempted_at' => now(),
                'quiz_answers' => $validated['answers'],
                'earned_at' => $passed ? now() : null,
                'validated' => $passed,
            ],
        );

        return redirect()->route('cme.quiz.show', $session->id)
            ->with($passed ? 'success' : 'warning', $passed
                ? "Bravo ! Vous avez obtenu {$score} %, vos crédits CME sont attribués."
                : "Score {$score} %. Le seuil de validation est de {$session->quiz_pass_threshold} %. Réessayez."
            );
    }

    protected function authenticate(Request $request): ?Registration
    {
        $ref = $request->input('reference', $request->query('reference', $request->cookie('reg_ref')));
        $email = $request->input('email', $request->query('email', $request->cookie('reg_email')));

        if (! $ref || ! $email) return null;

        return Registration::with('participant')
            ->where('reference', $ref)
            ->whereHas('participant', fn ($q) => $q->where('email', $email))
            ->first();
    }
}
