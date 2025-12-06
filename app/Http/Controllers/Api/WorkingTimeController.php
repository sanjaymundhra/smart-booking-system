<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkingTime;
use App\Http\Requests\WorkingTimeRequest;

class WorkingTimeController extends Controller
{
    public function index()
    {
        $workingHours = WorkingTime::with('service')->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $workingHours
        ]);
    }

    public function store(WorkingTimeRequest $request)
    {
        $data = $request->validated();

        $exists = WorkingTime::where('service_id', $data['service_id'])
            ->where('day_of_week', $data['day_of_week'])
            ->where('date', $data['date'])
            ->where('start_time', $data['start_time'])
            ->where('end_time', $data['end_time'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'This working time already exists.'
            ], 422);
        }

        $workingTime = WorkingTime::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Working time added successfully',
            'data' => $workingTime
        ], 201);
    }

    public function destroy($id)
    {
        WorkingTime::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Working time deleted successfully',
        ], 200);
    }
}
