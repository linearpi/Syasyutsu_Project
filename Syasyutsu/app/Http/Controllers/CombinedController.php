<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Param;

class CombinedController extends Controller
{

    // 共通のバリデーションメソッド
    private function validateFields(Request $request, array $rules, array $messages = [])
    {
        return $request->validate($rules, $messages);
    }


    /**
     * 統合検索：全件
     */
    public function search_all(Request $request)
    {
        $logs = Log::orderBy('id','desc')->paginate(10);
        $params = Param::paginate(10);

        return view('app/result_combined', [
            'method' => 'all',
            'q' => 'all',
            'logs' => $logs,
            'params' => $params
        ]);
    }

    /**
     * 統合検索：パラメータ名 / ログ paraName
     */
    public function search_paraName(Request $request)
    {
        $this->validateFields($request, 
		['q' => 'required'],
		['q.required' => '検索ワードを入力してください。']
	);

        $logs = Log::where('paraName','like','%'.$request->q.'%')
                   ->orderBy('id','desc')
                   ->paginate(10);

        $params = Param::where('name','like','%'.$request->q.'%')
                              ->paginate(10);

        return view('app/result_combined', [
            'method' => 'paraName',
            'q' => $request->q,
            'logs' => $logs,
            'params' => $params
        ]);
    }

    /**
     * 統合検索：日付検索
     */
    public function search_date(Request $request)
    {
        $this->validateFields($request, 
		['q' => 'required'],
		['q.required' => '日付を指定してください。']
	);

        $logs = Log::whereDate('created_at',$request->q)
                   ->orderBy('id','desc')
                   ->paginate(10);

        $params = Param::whereDate('created_at',$request->q)
                              ->paginate(10);

        return view('app/result_combined', [
            'method' => 'date',
            'q' => $request->q,
            'logs' => $logs,
            'params' => $params
        ]);
    }

    /**
     * 統合検索：期間検索（ログのみ）
     * Parameta は日付範囲を持たない場合は logs だけ検索
     */
    public function search_range(Request $request)
    {
        $this->validateFields($request, 
		[
	            	'q1' => 'required',
    	        	'q2' => 'required',
			'q2' => 'after_or_equal:q1'
  		],
		[
			'q1.required' => '開始日を指定してください。',
			'q2.required' => '終了日を指定してください。',
			'q2.after_or_equal' => '終了日は開始日以降の日付を指定してください。'
		]
	);

        $old_period = $request->q1 . " 00:00:00";
        $new_period = $request->q2 . " 23:59:59";

        $logs = Log::whereBetween('created_at', [$old_period, $new_period])
                   ->orderBy('id','desc')
                   ->paginate(10);

        // パラメータは日付範囲を考慮しない場合は全件
        $params = Param::paginate(10);

        return view('app/result_combined', [
            'method' => 'range',
            'q1' => $request->q1,
            'q2' => $request->q2,
            'logs' => $logs,
            'params' => $params
        ]);
    }

    /**
     * 統合検索：良品・不良品検索（ログのみ）
     * Parameta は ACTIVE 検索として対応可能
     */
    public function search_judgment(Request $request)
    {
        $this->validateFields($request, 
		['q' => 'required'],
		['q.required' => '良否を選択してください。']
	);

        $param = $request->q === "1" ? 1 : 0;

        $label = $param === 1 ? "良品" : "不良品";

        $logs = Log::where('judgment', $param)
                   ->orderBy('id','desc')
                   ->paginate(10);

        // Parameta は ACTIVE 状態を表示
        $params = Param::paginate(10);

        return view('app/result_combined', [
            'method' => 'judgment',
            'q' => $label,
            'logs' => $logs,
            'params' => $params
        ]);
    }

    /**
     * 統合検索：ACTIVE検索（Parametaのみ）
     */
    public function search_active(Request $request)
    {
        $this->validateFields($request,
        	['q' => 'required'],
		['q.required' => '可否を選択してください。']
	);

        $isActive = $request->q === "1" ? 1 : 0;

        $params = Param::where('is_active', $request->q)
                              ->paginate(10);

        $label = $isActive === 1 ? "有効" : "無効";

        // logs は全件表示
        $logs = Log::orderBy('id','desc')->paginate(10);

        return view('app/result_combined', [
            'method' => 'active',
            'q' => $label,
            'logs' => $logs,
            'params' => $params
        ]);
    }
}

