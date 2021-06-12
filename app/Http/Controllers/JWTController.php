<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class JWTController extends Controller
{
    /**
     * Create a new JWTController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.refresh')->only('update');
        $this->middleware('jwt.auth')->only('destroy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $user = User::where([
                        'identity_number' => $request->identity_number,
                        'password' => $request->password,
                    ])->firstOrFail();
        
        $responseArray = $this->generateToken($user)
                        ->put('user_role', $user->role->name);

        return response()->json($responseArray);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        return response()->json($this->generateToken($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Auth::logout($user);

        return $this->successMessage();
    }

    /**
     * Generate JWT token for given user with validation and refresh
     * date information.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Support\Collection
     */
    public function generateToken(User $user)
    {
        return collect([
            'token' => JWTAuth::fromUser($user),
            'validation_expire_date' => Carbon::now()
                                        ->add(env('JWT_TTL'), 'minute')
                                        ->format('Y-m-d\TH:i'),
            'refresh_expire_date' => Carbon::now()
                                        ->add(env('JWT_REFRESH_TTL'), 'minute')
                                        ->format('Y-m-d\TH:i'),
        ]);
    }
}
