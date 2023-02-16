<?php

namespace Spt\ExceptionHandling\Http;

use Illuminate\Routing\Controller;
use Spt\ExceptionHandling\Services\ExceptionHandlingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use File;

class ExceptionController extends Controller
{
    protected $exceptionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ExceptionHandlingService $exceptionService)
    {
        $this->exceptionService = $exceptionService;
    }

    /**
     * Returns dashboard view
     *
     */
    public function index(Request $request)
    {
        $data = $this->exceptionService->getLogs($request);
        $data['chart'] = $this->exceptionService->prepareChartData($data['logs']);
        if ($request->ajax()) {
            $dashboard = view('exceptions::dashboard', compact('data'))->render();

            return response()->json(['dashboard' => $dashboard, 'success' => true], 200);
        }

        return view('exceptions::dashboard', compact('data'));
    }

    /**
     * Delete an error Log file
     *
     */
    public function delete(Request $request)
    {
        if ($request->has('filename')) {
            $file = 'logs/' . $request->get('filename');
            if (File::exists(storage_path($file))) {
                File::delete(storage_path($file));
                return response()->json(['success' => true], 200);
            }
        }
    }
}
