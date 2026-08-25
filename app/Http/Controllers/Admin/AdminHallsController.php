<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\HallRequest;
use App\Http\Requests\UpdateHallRequest;
use App\Models\Cinema;
use App\Models\Hall;
use App\Models\Seat;

class AdminHallsController extends Controller
{

    public function index(Request $request)
    {
        $cinemas = Cinema::all();
        $cinema = Cinema::findOrFail(
            $request->cinema_id ?? $cinemas->first()->id
        );
        $halls = Hall::where('cinema_id', $cinema->id)
            ->paginate(6)
            ->withQueryString();
        return view(
            'Admin.Halls.HallsMain',
            compact('cinemas', 'cinema', 'halls')
        );
    }

    public function show(Request $request){
        $cinema = Cinema::findOrFail($request->cinema_id);
        return view('Admin.Halls.AddHallForm', compact('cinema'));
    }

    public function edit(Hall $hall){
        $cinema = $hall->cinema;
        return view('Admin.Halls.EditHallForm', compact('hall', 'cinema'));
    }

    public function store(HallRequest $request){
        $hall = Hall::create([
            'cinema_id' => $request->cinema_id,
            'name' => $request->name,
            'type' => $request->type,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);
        $vipCount = (int) ceil($hall->capacity * 0.07);
        $seatNumber = 1;
        for ($i = 1; $i <= $hall->capacity; $i++) {
            $rowNumber = (int) ceil($i / 10);
            $row = chr(64 + $rowNumber);
            $number = $seatNumber;
            $type = $i > ($hall->capacity - $vipCount)
                ? 'vip'
                : 'regular';
            Seat::create([
                'hall_id' => $hall->id,
                'row' => $row,
                'number' => $number,
                'type' => $type,
                'status' => 'available',
            ]);
            $seatNumber++;
            if ($seatNumber > 10) {
                $seatNumber = 1;
            }
        }
        return redirect()
            ->route('AdminHalls');
    }

    public function update(UpdateHallRequest $request, Hall $hall){
        $oldCapacity = $hall->capacity;
        $hall->update([
            'name' => $request->name,
            'type' => $request->type,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);
        if ($oldCapacity != $hall->capacity) {
            $hall->seats()->delete();
            $vipCount = (int) ceil($hall->capacity * 0.07);
            $seatNumber = 1;
            for ($i = 1; $i <= $hall->capacity; $i++) {
                $rowNumber = (int) ceil($i / 10);
                $row = chr(64 + $rowNumber);
                $number = $seatNumber;
                $type = $i > ($hall->capacity - $vipCount)
                    ? 'vip'
                    : 'regular';
                Seat::create([
                    'hall_id' => $hall->id,
                    'row' => $row,
                    'number' => $number,
                    'type' => $type,
                    'status' => 'available',
                ]);
                $seatNumber++;
                if ($seatNumber > 10) {
                    $seatNumber = 1;
                }
            }
        }

        return redirect()
            ->route('AdminHalls');
    }

    public function destroy(Hall $hall)
    {
        $hall->delete();
        return redirect()->route('AdminHalls');
    }
}
