<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demo_user;

class OutputdbController extends Controller
{
	public function index()
	{
		$db_data = Demo_user::select('name', 'furigana', 'email'
							,'age', 'birthday', 'blood')
					->selectRaw(<<< EOM
							(CASE sex
							WHEN 0 THEN "男性"
							WHEN 1 THEN "女性"
							END) AS sex_name
							EOM)
					->orderBy('age', 'asc')
					->get();

		return view('outputdb.view', ['records'=>$db_data]);
	}
}
