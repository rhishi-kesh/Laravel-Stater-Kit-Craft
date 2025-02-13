<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class SitesettingController extends Controller
{
    use ApiResponse;

    /**
     * Fetch Site Settings
     *
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */
    public function siteSettings() {

        $data = SystemSetting::where('id', 1)->first();

        if ($data == null) {
            return $this->error([], 'System Settings not found', 200);
        }

        return $this->success($data, 'System Settings fetch Successful!', 200);
    }
}
