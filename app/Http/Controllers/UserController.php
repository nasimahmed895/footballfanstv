<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AppModel;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('subscription')->where('user_type', 'user')->orderBy('id', 'DESC')->get();

        if ($request->ajax()) {
            return DataTables::of($users)
                ->addColumn('image', function ($user) {
                    return '<img class="img-sm img-thumbnail" src="' . asset($user->image) . '">';
                })
                ->editColumn('email', function ($user) {
                    return $user->email;
                })
                ->editColumn('subscription', function ($user) {
                    return Str::ucfirst($user->subscription->name);
                })
                ->addColumn('status', function ($user) {
                    return $user->status == 1 ? status(_lang('Active'), 'success') : status(_lang('In-Active'), 'danger');
                })
                ->addColumn('action', function($user){

                    $action = '<div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        ' . _lang('Action') . '
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                    $action .= '<a href="' . route('users.show', $user->id) . '" class="dropdown-item ajax-modal" data-title="' . _lang('Details') . '">
                                        <i class="fas fa-eye"></i>
                                        ' . _lang('Details') . '
                                    </a>';
                    $action .= '<a href="' . route('users.edit', $user->id) . '" class="dropdown-item ajax-modal" data-title="' . _lang('Edit') . '">
                                        <i class="fas fa-edit"></i>
                                        ' . _lang('Edit') . '
                                    </a>';
                    $action .= '<form action="' . route('users.destroy', $user->id) . '" method="post" class="ajax-delete">'
                                . csrf_field() 
                                . method_field('DELETE') 
                                . '<button type="button" class="btn-remove dropdown-item">
                                        <i class="fas fa-trash-alt"></i>
                                        ' . _lang('Delete') . '
                                    </button>
                                </form>';
                    $action .= '</div>
                            </div>';
                    return $action;
                })
                ->rawColumns(['action', 'status', 'image', 'subscription'])
                ->make(true);
        }

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $subscriptions = Subscription::orderBy('id', 'ASC')->get();

        if (!$request->ajax()) {
            return view('backend.users.create', compact('subscriptions'));
        } else {
            return view('backend.users.modal.create', compact('subscriptions'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [

            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'subscription_id' => 'required',
            'status' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $subscription = Subscription::find($request->subscription_id);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->subscription_id = $request->subscription_id;
        if($request->subscription_id != 0){
            $user->expired_at = date("Y-m-d H:i:s", strtotime("+{$subscription->duration} {$subscription->duration_type}", now()->timestamp));
        }
        $user->provider = 'email';
        $user->user_type = 'user';
        $user->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            \Image::make($image)->resize(300, 300)->save(base_path('public/uploads/images/users/') . $ImageName);
            $user->image = 'public/uploads/images/users/' . $ImageName;
        }

        $user->save();

        if (!$request->ajax()) {
            return redirect('users')->with('success', _lang('Information has been added.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => 'users', 'message' => _lang('Information has been added sucessfully.')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);

        if (!$request->ajax()) {
            return view('backend.users.show', compact('user'));
        } else {
            return view('backend.users.modal.show', compact('user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $subscriptions = Subscription::orderBy('id', 'ASC')->get();

        if (!$request->ajax()) {
            return view('backend.users.edit', compact('user', 'subscriptions'));
        } else {
            return view('backend.users.modal.edit', compact('user', 'subscriptions'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [

            'name' => 'required|string|max:191',
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'subscription_id' => 'required',
            'status' => 'required',
            'image' => 'nullable|image',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        
        $subscription = Subscription::find($request->subscription_id);

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = 'user';
        $user->app_id = $request->app_id;
        $user->subscription_id = $request->subscription_id;
        if($request->subscription_id != 0){
            $user->expired_at = date("Y-m-d H:i:s", strtotime("+{$subscription->duration} {$subscription->duration_type}", now()->timestamp));
        }
        $user->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            \Image::make($image)->resize(300, 300)->save(base_path('public/uploads/images/users/') . $ImageName);
            $user->image = 'public/uploads/images/users/' . $ImageName;
        }

        $user->save();

        if (!$request->ajax()) {
            return redirect('users')->with('success', _lang('Information has been updated.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => 'users', 'message' => _lang('Information has been updated sucessfully.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();

        if (!$request->ajax()) {
            return back()->with('success', _lang('Information has been deleted'));
        } else {
            return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully')]);
        }
    }
}
