<?php

namespace App\Http\Controllers;

use App\Domain\Users\Actions\GetUserByBirthdayAction;
use App\Domain\Users\DataTransferObjects\UserFilterData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'year'  => 'numeric|nullable',
            'month' => 'numeric|min:1|max:12|nullable',
        ]);

        // Make the DTO
        $reqData = new UserFilterData([
            'month' => $request->get('month'),
            'year'  => $request->get('year'),
        ]);

        // Get result by applying the filters
        $data = (new GetUserByBirthdayAction())->execute($reqData, $request->get('page', 1));

        return view('dashboard', [
            'data' => $data,
        ]);
    }
}
