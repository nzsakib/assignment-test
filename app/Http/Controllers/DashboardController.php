<?php

namespace App\Http\Controllers;

use App\Domain\Users\Actions\GetUserByBirthdayAction;
use App\Domain\Users\DataTransferObjects\UserFilterData;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        request()->validate([
            'year'  => 'numeric',
            'month' => 'numeric|min:1|max:12',
        ]);

        $reqData = new UserFilterData([
            'month' => request()->get('month'),
            'year'  => request()->get('year'),
        ]);

        $data = (new GetUserByBirthdayAction())->execute($reqData, 1);
// dd($data);
        return view('dashboard', [
            'data' => $data,
        ]);
    }
}
