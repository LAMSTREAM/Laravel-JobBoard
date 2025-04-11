<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        // Sort by created_at, default is desc
        $sort = $request->query('sort', 'desc');

        $jobPosts = JobPost::with(['user'])
            ->where('created_at', '>=', now()->subMonths(2)) // Only show posts from the last 2 months
            ->orderBy('created_at', $sort)
            ->paginate(10)
            ->appends(['sort' => $sort]);

        return view('job_posts.index', compact('jobPosts', 'sort'));
    }


    public function create()
    {
        if (auth()->user()->role !== 'poster') {
            abort(403);
        }

        return view('job_posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'summary' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        JobPost::create([
            'summary' => $request->summary,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('job-posts.index')->with('success', 'Job posted!');
    }

    public function show(JobPost $jobPost)
    {
        $jobPost->load(['user', 'interestedUsers']);
        return view('job_posts.show', compact('jobPost'));
    }

    public function edit(JobPost $jobPost)
    {
        if ($jobPost->user_id !== Auth::id()) {
            abort(403);
        }

        return view('job_posts.edit', compact('jobPost'));
    }

    public function update(Request $request, JobPost $jobPost)
    {
        if ($jobPost->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'summary' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $jobPost->update($request->only('summary', 'body'));

        return redirect()->route('job-posts.index')->with('success', 'Job updated!');
    }

    public function destroy(JobPost $jobPost)
    {
        if ($jobPost->user_id !== Auth::id()) {
            abort(403);
        }

        $jobPost->delete();

        return redirect()->route('job-posts.index')->with('success', 'Job deleted!');
    }

    /**
     * Toggle interest in a job post.
     *
     * @param JobPost $jobPost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleInterest(JobPost $jobPost)
    {
        $user = auth()->user();

        if ($jobPost->interestedUsers->contains($user)) {
            $jobPost->interestedUsers()->detach($user->id);
        } else {
            $jobPost->interestedUsers()->attach($user->id);
        }

        return redirect()->back();
    }


}
