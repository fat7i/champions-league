<?php

namespace App\Http\Controllers;

use App\Services\WeekService;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    /**
     * @var WeekService
     */
    private $weekService;

    /**
     * WeekController constructor.
     * @param WeekService $weekService
     */
    public function __construct(WeekService $weekService)
    {
        $this->weekService = $weekService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function play(Request $request)
    {
        $id = $request->get('id');

        $result = $this->weekService->play($id);

        return response()->json($result);
    }
}
