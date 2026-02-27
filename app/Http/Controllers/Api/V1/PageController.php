<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class PageController extends BaseController
{
    /**
     * Get All Active Pages
     */
    public function index(): JsonResponse
    {
        try {

            $pages = Page::where('status', 1)
                ->select('id', 'title', 'subtitle', 'short_description')
                ->get();

            return $this->successResponse(
                'Pages fetched successfully.',
                $pages
            );
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Get Single Page By Slug
     */
    public function showBySlug($slug): JsonResponse
    {
        try {

            $page = Page::where('slug', $slug)
                ->where('status', 1)
                ->first();

            if (!$page) {
                return $this->errorResponse('Page not found.', [], 404);
            }

            return $this->successResponse(
                'Page details fetched successfully.',
                $page
            );
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }
}
