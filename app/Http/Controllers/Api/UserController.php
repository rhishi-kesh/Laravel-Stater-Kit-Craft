<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    use ApiResponse;

    /**
     * Fetch User data based on user_id
     *
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

    public function userData() {

        $user = User::find(auth()->user()->id);
        if (!$user) {
            return $this->error([], 'User Not Found', 404);
        }
        return $this->success($user, 'User data fetched successfully', '200');
    }

    /**
     * Update User Information
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request with the register query.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

    public function userUpdate(Request $request, int $id) {

        $validator = Validator::make($request->all(), [
            'avatar'  => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
            'name'    => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error([], $validator->errors()->first(), 422);
        }

        try {
            // Find the user by ID
            $user = User::find($id);

            // If user is not found, return an error response
            if (!$user) {
                return $this->error([], "User Not Found", 404);
            }

            if ($request->hasFile('avatar')) {

                if ($user->avatar) {
                    $previousImagePath = public_path($user->avatar);
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }

                $image     = $request->file('avatar');
                $imageName = uploadImage($image, 'User/Avatar');
            } else {
                $imageName = $user->avatar;
            }

            $user->name    = $request->name;
            $user->avatar  = $imageName;

            $user->save();

            return $this->success($user, 'User updated successfully', '200');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }
    }

    /**
     * Logout the authenticated user's account
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse JSON response with success or error.
     */
    public function logoutUser() {

        try {
            auth()->guard('api')->logout();

            return $this->success([], 'Successfully logged out', '200');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }

    }

    /**
     * Delete the authenticated user's account
     *
     * @return \Illuminate\Http\JsonResponse JSON response with success or error.
     */
    public function deleteUser() {
        try {
            // Get the authenticated user
            $user = auth()->user();

            // Delete the user's avatar if it exists
            if ($user->avatar) {
                $previousImagePath = public_path($user->avatar);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

            // Delete the user
            $user->delete();

            return $this->success([], 'User deleted successfully', '200');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }
    }
}
