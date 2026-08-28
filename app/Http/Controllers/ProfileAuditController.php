<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeProfileAudit;
use App\Models\ProfileAudit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProfileAuditController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->remainingAnalyses() <= 0) {
            $message = 'You\'ve used all '.User::FREE_ANALYSIS_LIMIT.' of your free analyses.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['pdf' => $message]);
        }

        $request->validate([
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $file = $request->file('pdf');
        $path = $file->store('profile-audits', 'local');

        $audit = $user->profileAudits()->create([
            'original_filename' => $file->getClientOriginalName(),
            'pdf_path' => $path,
        ]);

        AnalyzeProfileAudit::dispatch($audit);

        if ($request->wantsJson()) {
            return response()->json([
                'status_url' => route('profile-audits.status', $audit),
                'processing_url' => route('profile-audits.processing', $audit),
            ]);
        }

        return Redirect::route('profile-audits.processing', $audit);
    }

    public function processing(Request $request, ProfileAudit $profileAudit)
    {
        abort_unless($profileAudit->user_id === $request->user()->id, 403);

        if ($profileAudit->isCompleted()) {
            return Redirect::route('profile-audits.show', $profileAudit);
        }

        return view('audits.processing', ['audit' => $profileAudit]);
    }

    public function status(Request $request, ProfileAudit $profileAudit)
    {
        abort_unless($profileAudit->user_id === $request->user()->id, 403);

        return response()->json([
            'status' => $profileAudit->status,
            'error' => $profileAudit->error,
            'redirect' => $profileAudit->isCompleted()
                ? route('profile-audits.show', $profileAudit)
                : null,
        ]);
    }

    public function show(Request $request, ProfileAudit $profileAudit)
    {
        abort_unless($profileAudit->user_id === $request->user()->id, 403);

        if (! $profileAudit->isCompleted()) {
            return Redirect::route('profile-audits.processing', $profileAudit);
        }

        return view('audits.show', ['audit' => $profileAudit]);
    }

    public function history(Request $request)
    {
        $audits = $request->user()->profileAudits()->latest()->get();

        return view('audits.history', ['audits' => $audits]);
    }
}
