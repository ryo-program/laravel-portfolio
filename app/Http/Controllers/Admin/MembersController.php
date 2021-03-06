<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Storage;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('created_at', 'desc')->get();
        return view('admin.members.members', ['members' => $members]);
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, Member::$rules);

        $member = new Member;
        if ($file = $request->profile_img) {
            $image = $request->file('profile_img');
            $path = Storage::disk('s3')->putFile('tennisclub-app', $image, 'public');
            $member->profile_img = Storage::disk('s3')->url($path);
        } else {
            $path = "";
        }

        $member->name = $request->name;
        $member->year = $request->year;
        $member->shot = $request->shot;
        $member->comment = $request->comment;
        $member->save();
        
        return redirect()->route('admin.members');
    }

    public function first()
    {
        $members = Member::orderBy('created_at', 'desc')->where('year', '1')->get();
        return view('admin.members.first', ['members' => $members]);
    }

    public function second()
    {
        $members = Member::orderBy('created_at', 'desc')->where('year', '2')->get();
        return view('admin.members.second', ['members' => $members]);
    }

    public function third()
    {
        $members = Member::orderBy('created_at', 'desc')->where('year', '3')->get();
        return view('admin.members.third', ['members' => $members]);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        \DB::transaction(function() use ($member) {
            $member->delete();
        });

        return redirect()->route('admin.members');
    }
}
