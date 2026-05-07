<?php

namespace App\Http\Controllers\Organisateur;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Event $event)
    {
        $this->authorizeEvent($event);
        $staff = $event->staff()->get();
        $availableAgents = User::where('role', 'agent')
            ->where('organisateur_id', auth()->id())
            ->whereNotIn('id', $staff->pluck('id'))
            ->get();
        return view('organisateur.staff.index', compact('event', 'staff', 'availableAgents'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $request->validate([
            'action' => 'required|in:existing,new',
            'user_id' => 'nullable|required_if:action,existing|exists:users,id',
            'name' => 'required_if:action,new|string|max:255',
            'email' => 'required_if:action,new|email|unique:users',
            'password' => 'required_if:action,new|min:6',
        ]);

        if ($request->action === 'new') {
            $agent = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'agent',
                'organisateur_id' => auth()->id(),
            ]);
            $userId = $agent->id;
        } else {
            $userId = $request->user_id;
        }

        $event->staff()->syncWithoutDetaching([$userId => ['role' => 'agent']]);
        return back()->with('success', 'Agent ajouté à l\'événement.');
    }

    public function destroy(Event $event, User $user)
    {
        $this->authorizeEvent($event);
        $event->staff()->detach($user->id);
        return back()->with('success', 'Agent retiré de l\'événement.');
    }

    private function authorizeEvent(Event $event): void
    {
        if ($event->organisateur_id !== auth()->id()) abort(403);
    }
}
