<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\LoginUserRequest;
    use App\Http\Requests\StoreUserRequest;
    use App\Models\User;
    use App\Traits\HttpResponses;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class AuthController extends Controller
    {
        use HttpResponses;

        public function login(LoginUserRequest $request): \Illuminate\Http\JsonResponse
        {
            $request->validated($request->all());

            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error('Invalid credentials', 401);
            }

            $user = User::where('email', $request->email)->first();

            return $this->success(
                [
                'message' => 'Login successful',
                'user' => $user,
                'token' => $user->createToken('API Token of '. $user->name)->plainTextToken
            ],"Login successful",200);
        }

        public function register(StoreUserRequest $request): \Illuminate\Http\JsonResponse
        {

            $request->validated($request->all());

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return $this->success([
                'message' => 'User registered successfully',
            ],'User registered successfully');
        }

        public function logout(): \Illuminate\Http\JsonResponse
        {
            return response()->json(['message' => 'logout route hit']);
        }

        public function getCurrentUser(Request $request): \Illuminate\Http\JsonResponse
        {
            return response()->json([
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'role' => auth()->user()->role,
            ]);
        }
    }
