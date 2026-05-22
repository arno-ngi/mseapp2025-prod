<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserProfileChangeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        if (is_null(auth()->user()->tenant)) {
            $users = User::all();
        } else {
            $users = auth()->user()->whereIsClientvisible(true)->whereIsActive(true)->get();
        }

        return view('users.index', compact('users'));
    }

    public function getbank(Request $request)
    {
    $user = User::whereId($request->userid)->first();

        return response()->json([
            'banknumber' => $user->bankaccountno,
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit(User $user)
    {
        if (auth()->user()->is_superadmin || $user->tenant_id === auth()->user()->tenant_id) {
            $permissions = Permission::orderBy('name')->get();

            $activitylogs = Activity::whereSubjectId($user->id)->whereSubjectType(get_class($user))->with('causer')->orderBy('id', 'desc')->get();


            return view('users.edit', compact('user', 'permissions', 'activitylogs'));
        }

        flash()->error(__('law.not_allowed'));

        return back();
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->is_superadmin || $user->tenant_id === auth()->user()->tenant_id || auth()->user()->id === $user->id) {
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
                $user->is_onserver = $request->has('is_onserver') ? true : false;

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

            return back();
        }

        flash()->error(__('law.not_allowed'));

        return back();

    }

    public function update2(Request $request, User $user)
    {
        if (auth()->user()->is_superadmin || $user->tenant_id === auth()->user()->tenant_id || auth()->user()->id === $user->id) {
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

                $user->save();
            }


            flash()->success(__('law.updated_succesfully'));

            return back();
        }

        flash()->error(__('law.not_allowed'));

        return back();

    }

    public function update_profile(Request $request, User $user)
    {
        if (auth()->user()->is_superadmin || $user->tenant_id === auth()->user()->tenant_id) {

            if ($user->birthplace !== $request->birthplace) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed birthplace from ' . $user->birthplace . ' to ' . $request->birthplace);
            }
            $user->birthplace = $request->birthplace;

            $user->birthdate = $request->birthdate;

            if ($user->birth_country !== $request->birth_country) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed birth_country from ' . $user->birth_country . ' to ' . $request->birth_country);
            }
            $user->birth_country = $request->birth_country;

            if ($user->national_register_no !== $request->national_register_no) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed national_register_no from ' . $user->national_register_no . ' to ' . $request->national_register_no);
            }
            $user->national_register_no = $request->national_register_no;

            if ($user->nationality !== $request->nationality) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed nationality from ' . $user->nationality . ' to ' . $request->nationality);
            }
            $user->nationality = $request->nationality;

            if ($user->bankaccountno !== $request->bankaccountno) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed bankaccountno from ' . $user->bankaccountno . ' to ' . $request->bankaccountno);
            }
            $user->bankaccountno = $request->bankaccountno;

            if ($user->street !== $request->street) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed street from ' . $user->street . ' to ' . $request->street);
            }
            $user->street = $request->street;

            if ($user->number !== $request->number) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed number from ' . $user->number . ' to ' . $request->number);
            }
            $user->number = $request->number;

            if ($user->zip !== $request->zip) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed zip from ' . $user->zip . ' to ' . $request->zip);
            }
            $user->zip = $request->zip;

            if ($user->city !== $request->city) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed city from ' . $user->city . ' to ' . $request->city);
            }
            $user->city = $request->city;
            if ($user->contract_no !== $request->contract_no) {
                activity()
                    ->performedOn($user)
                    ->log('Item updated ' . $user->name . ': Changed contract_no from ' . $user->contract_no . ' to ' . $request->contract_no);
            }

            $user->contract_no = $request->contract_no;
            $user->hospital_previous_eployer = $request->hospital_previous_eployer;
            $user->date_identitycard = $request->date_identitycard;
            $user->date_goedgedragenzeden = $request->date_goedgedragenzeden;
            $user->partner_name = $request->partner_name;
            $user->partner_firstname = $request->partner_firstname;
            $user->partner_birthdate = $request->partner_birthdate;
            $user->partner_tenlaste = $request->has('partner_tenlaste') ? true : false;
            $user->partner_mindervalide = $request->has('partner_mindervalide') ? true : false;

            $user->beroepsinkomsten = $request->beroepsinkomsten;
            $user->personentenlaste_kind_valide = $request->personentenlaste_kind_valide;
            $user->personentenlaste_kind_invalide = $request->personentenlaste_kind_invalide;
            $user->personentenlaste_65mantel_valide = $request->personentenlaste_65mantel_valide;
            $user->personentenlaste_65mantel_invalide = $request->personentenlaste_65mantel_invalide;
            $user->personentenlaste_65overgang_valide = $request->personentenlaste_65overgang_valide;
            $user->personentenlaste_65overgang_invalide = $request->personentenlaste_65overgang_invalide;
            $user->personentenlaste_andere_valide = $request->personentenlaste_andere_valide;
            $user->personentenlaste_andere_invalide = $request->personentenlaste_andere_invalide;
            $user->prive_email = $request->prive_email;
            $user->telefoon = $request->telefoon;
            $user->ice_name = $request->ice_name;
            $user->ice_number = $request->ice_number;
            $user->clothing_shirt = $request->clothing_shirt;
            $user->clothing_shoes = $request->clothing_shoes;
            $user->clothing_pants = $request->clothing_pants;
            $user->burgerlijke_staat = $request->burgerlijke_staat;
            $user->opleidingsniveau = $request->opleidingsniveau;

            $user->save();


            flash()->success(__('law.updated_succesfully'));

            $useradmin = User::find(9);
            $useradmin->notify(new UserProfileChangeNotification($user->email));

            return redirect('/users/' . $user->uuid . '?tab=profile');
        }

        flash()->error(__('law.not_allowed'));

        return redirect('/users/' . $user->uuid . '?tab=profile');

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
