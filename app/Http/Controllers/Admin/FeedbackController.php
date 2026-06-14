<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        return view('Admin.feedbacks.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        if (!$feedback->is_read) {
            $feedback->update(['is_read' => true]);
        }

        return view('Admin.feedbacks.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')->with('success', 'Kritik dan saran berhasil dihapus.');
    }
}
