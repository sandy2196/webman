<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("READ_AUTH_LOG");
        $flashData = collect([]);
        $query = AuthLog::query();
        // SEARCH
        if ($request->has('search') && $request->search !== null) {
            $query->where(
                'ip_address',
                'LIKE',
                '%' . $request->search . '%',
            )->orWhere(
                    'email',
                    'LIKE',
                    '%' . $request->search . '%',
                )->orWhere(
                    'username',
                    'LIKE',
                    '%' . $request->search . '%',
                );
            $flashData->push('search');
        }
        // SORT
        if ($request->has('sortBy') && $request->sortBy !== null) {
            $query->orderBy($request->sortBy);
            $flashData->push('sortBy');
        }
        $authLogList = $query->latest()->paginate($request->numberOfRecords ? $request->numberOfRecords : 10)->withQueryString();
        $request->flashOnly($flashData->toArray());
        return view("auth-logs.index", ["authLogList" => $authLogList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthLog $authLog)
    {
        Gate::authorize("READ_AUTH_LOG");
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "authLog" => $authLog,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuthLog $authLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AuthLog $authLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthLog $authLog)
    {
        //
    }
}
