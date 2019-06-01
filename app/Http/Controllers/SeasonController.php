<?php

namespace App\Http\Controllers;

use App\Services\PredictionsServices;
use App\Services\SeasonService;
use Illuminate\Http\Request;

class SeasonController extends Controller
{

    /**
     * @var SeasonService
     */
    private $seasonService;

    /**
     * @var PredictionsServices
     */
    private $predictionsServices;

    /**
     * SeasonController constructor.
     * @param SeasonService $seasonService
     * @param PredictionsServices $predictionsServices
     */
    public function __construct(SeasonService $seasonService, PredictionsServices $predictionsServices)
    {
        $this->seasonService = $seasonService;
        $this->predictionsServices = $predictionsServices;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('season.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\CreateSeasonFailedException
     * @throws \App\Exceptions\NoTeamsFoundException
     */
    public function store(Request $request)
    {
        $name = $request->get('name');

        $season = $this->seasonService->create($name);

        return redirect()->route('show_season', ['id' => $season->id]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $season = $this->seasonService->find($id);

        $predictions = $this->predictionsServices->get($id);

        return view('season.show', ['season' => $season, 'predictions' => $predictions]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTable($id)
    {
        $season = $this->seasonService->find($id);

        return view('season.partials.league-table', ['season' => $season]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPredictions($id)
    {
        $predictions = $this->predictionsServices->get($id);

        return view('season.partials.predictions-box', ['predictions' => $predictions]);
    }
}
