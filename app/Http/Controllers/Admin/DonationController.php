<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Donatur;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return view('admin.donation.index');
    }
    /**
     * filter
     *
     * @param mixed $request
     * @return void
     */
    public function filter(Request $request)
    {
        $this->validate($request, ['date_from' => 'required', 'date_to' => 'required',]);
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        //get data donation by range date
        $donations = Donatur::where('status', 'success')->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->get();

        //get total donation by range date
        $total = Donation::where('status', 'success')->whereDate('created_at', '>=', $request->date_from)->whereDate(
            'created_at',
            '<=',
            $request->date_to
        )->sum('amount');

        return view('admin.donation.index', compact('donations', 'total'));
    }
}
