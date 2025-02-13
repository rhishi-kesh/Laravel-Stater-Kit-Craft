<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class FaqController extends Controller
{
    use ApiResponse;

    /**
     * Fetch FAQs
     *
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */
    public function FaqAll()
    {
        $faq = Faq::where('status', 'active')->get();

        if ($faq->isEmpty()) {
            return $this->error([], 'Faq not found', 200);
        }

        return $this->success($faq, 'Faq fetch Successful!', 200);
    }
}
