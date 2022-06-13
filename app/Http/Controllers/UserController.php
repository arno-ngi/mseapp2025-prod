<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        if (is_null(auth()->user()->tenant_id)) {
            $users = User::all();
        } else {
            $users = auth()->user()->tenant->users()->whereIsClientvisible(true)->whereIsActive(true)->get();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit(User $user)
    {
        if (auth()->user()->is_superadmin || $user->tenant_id === auth()->user()->tenant_id) {
            $permissions = Permission::orderBy('name')->get();

            return view('users.edit', compact('user', 'permissions'));
        }

        flash()->error(__('law.not_allowed'));

        return back();
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->is_superadmin || $user->tenant_id === auth()->user()->tenant_id) {
            if ($request->has('name')) {
                $validated = $request->validate([
                    'name' => 'required',
                    'firstname' => 'required',
                    'email' => 'email:rfc,dns'
                ]);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->firstname = $request->firstname;
                $user->initials = $request->initials;
                $user->notifier_position = $request->notifier_position;
                $user->is_active = $request->has('is_active') ? true : false;

                if ($request->has('password') && !is_null($request->password)) {
                    $this->validate($request, [
                        'password' => ['required', 'string', 'min:8'],
                    ]);

                    $user->password = Hash::make($request->password);
                }

                $user->save();
            }

            if ($request->has('permissions')) {
                $permissions = $request['permissions'];

                if (!is_null($permissions)) {
                    $user->permissions()->sync(array_values($permissions));
                } else {
                    $user->permissions()->detach();
                }
            }
            flash()->success(__('law.updated_succesfully'));

            return to_route('users.index');
        }

        flash()->error(__('law.not_allowed'));

        return to_route('users.index');

    }

    public function update_profile(Request $request, User $user)
    {
        if (auth()->user()->is_superadmin || $user->tenant_id === auth()->user()->tenant_id) {



                $user->birthplace = $request->birthplace;
                $user->birthdate = $request->birthdate;
                $user->birth_country = $request->birth_country;
                $user->national_register_no = $request->national_register_no;
                $user->nationality = $request->nationality;
                $user->bankaccountno = $request->bankaccountno;
                $user->street = $request->street;
                $user->number = $request->number;
                $user->zip = $request->zip;
                $user->city = $request->city;
                $user->hospital_previous_eployer = $request->hospital_previous_eployer;
                $user->contract_no = $request->contract_no;
                $user->hospital_previous_eployer = $request->hospital_previous_eployer;

                $user->save();


            flash()->success(__('law.updated_succesfully'));

            return to_route('users.index');
        }

        flash()->error(__('law.not_allowed'));

        return to_route('users.index');

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'firstname' => 'required',
            'email' => 'email:rfc,dns'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->firstname = $request->firstname;
        $user->initials = $request->initials;
        $user->tenant_id = auth()->user()->tenant_id;
        $user->is_active = true;

        if ($request->has('password') && !is_null($request->password)) {
            $this->validate($request, [
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user->password = Hash::make($request->password);
        } else {
            $user->password = Hash::make(Str::random(10));
        }

        $user->save();

        flash()->success(__('law.created_succesfully'));

        return to_route('users.edit', $user);

    }

    public function store_files(User $user, Request $request)
    {
        $file = $request->file('rfafile');
        $fileprefix = Str::slug('upload-' . Str::random(10));
        $savepath = 'uploads/' . $fileprefix . '_' . $file->getClientOriginalName();
        $originalname = $file->getClientOriginalName();
        Storage::put('public/' . $savepath, $file->get());
        $user->extrafiles()->create(['filepath' => $savepath, 'filename' => $originalname]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
