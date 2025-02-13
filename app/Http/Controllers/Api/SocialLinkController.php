<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class SocialLinkController extends Controller
{
    use ApiResponse;

    /**
     * Fetch Social Links
     *
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */
    public function socialLinks() {

        $data = SocialMedia::latest()->get();

        if ($data->isEmpty()) {
            return $this->error([], 'Social Link not found', 200);
        }

        return $this->success($data, 'Social Link fetch Successful!', 200);
    }
}
