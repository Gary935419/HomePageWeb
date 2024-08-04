<?php

namespace App\Http\Controllers\api\web;

use Illuminate\Support\Facades\Mail;

class SimulationsController extends Controller
{
    public function post_simulations_calculation()
    {
        try {
            $params = request()->all();

            //*** 計算開始 ***
            $real_alc = 0;
            // ビール
            if (!empty($params['SimulationBeer']) && is_numeric($params['SimulationBeer'])) {
                $real_alc = $params['SimulationBeer'] * 5 / 100;
            }
            // 日本酒
            if (!empty($params['SimulationSake']) && is_numeric($params['SimulationSake'])) {
                $real_alc += $params['SimulationSake'] * 16 / 100;
            }
            // ウイスキー
            if (!empty($params['SimulationWhiskey']) && is_numeric($params['SimulationWhiskey'])) {
                $real_alc += $params['SimulationWhiskey'] * 45 / 100;
            }
            // ブランデー
            if (!empty($params['SimulationBrandy']) && is_numeric($params['SimulationBrandy'])) {
                $real_alc += $params['SimulationBrandy'] * 43 / 100;
            }
            // 焼酎
            if (!empty($params['SimulationShochu']) && is_numeric($params['SimulationShochu'])) {
                $real_alc += $params['SimulationShochu'] * 35 / 100;
            }
            // ワイン
            if (!empty($params['SimulationWine']) && is_numeric($params['SimulationWine'])) {
                $real_alc += $params['SimulationWine'] * 14 / 100;
            }
            // 体重
            if (!empty($params['SimulationWeight']) && is_numeric($params['SimulationWeight'])) {
                $weight = $params['SimulationWeight'];
            } else {
                $weight = 0;
            }

            if (!empty($real_alc) && !empty($weight)) {
                $drink_amount = $real_alc * 0.792;	// 飲酒量
                $breath = 0.5 * $drink_amount / ($weight * 60 * 0.01);	// 最高呼気中濃度
                $resolving_time = $drink_amount / ($weight * 0.11);		// 分解最低時間
                $real_alc 		= round($real_alc,2);
                $drink_amount 	= round($drink_amount,2);
                $breath 		= round($breath,2);
                $resolving_time = round($resolving_time,2);
            } else {
                $real_alc = 0;
                $drink_amount = 0;
                $breath = 0;
                $resolving_time = 0;
            }
            // データセット
            $data['real_alc'] = $real_alc;				// アルコール容量合計
            $data['drink_amount'] = $drink_amount;		// 飲酒量
            $data['breath'] = $breath;					// 最高呼気中濃度
            $data['resolving_time'] = $resolving_time;	// 分解最低時間
            // 酔いの状態
            if ($breath > 0 && $breath < 0.25) {
                $data['status'] = 'ほろ酔い前期（爽快期）';
                $data['mg'] 	= '～0.25';
                $data['text']	= 'ふわっとして爽快な気分になり、快活になったり、陽気になったりする。この時期の特徴は、酔いの自覚がなく、「このくらいなら大丈夫」「運転に影響ない」と思いがちであること。でも、そう思ってるのは、アルコールによって「理性」をつかさどる大脳新皮質がマヒしはじめた脳である。微量でも、運転に欠かせない動体視力が落ち、反応が鈍くなる。集中力・判断力にも影響が及ぶ。・・・・これは飲んだ翌朝、アルコールが体内に残っている状態でも同じである。実際のところ、酒気帯び基準値以下の事故がかなり起きている。';
            } elseif ($breath >= 0.25 && $breath < 0.5) {
                $data['status'] = 'ほろ酔い後期';
                $data['mg'] 	= '0.25～0.5';
                $data['text']	= '大脳新皮質のマヒが進むため、気分が高揚し、気が大きくなる。緊張が減少し、スピード超過、信号無視など、危険な行動をとりやすくなる。人によっては軽い酩酊状態。集中力・判断力も低下し、不注意によるミスが起きる。距離感がわからなくなり、ブレーキやハンドル操作も遅れるため、運転は大変危険！';
            } elseif ($breath >= 0.5 && $breath < 1) {
                $data['status'] = '酩酊';
                $data['mg'] 	= '0.5～1';
                $data['text']	= 'いわゆる酔っぱらいの段階。大脳新皮質だけでなく、「感情」をつかさどる大脳辺縁系や、「運動」をつかさどる小脳にもマヒが広がる。感情の起伏が激しくなり、からんだり、ろれつが回らなくなるのはそのため。千鳥足はバランス感覚を失っている証拠。転落・転倒事故が多く、運転すれば蛇行運転になる。居眠りも起きやすく、運転などもってのほか。';
            } elseif ($breath >= 1 && $breath < 1.5) {
                $data['status'] = '泥酔';
                $data['mg'] 	= '1&～1.5';
                $data['text']	= '酔いつぶれ、自力で立てない。言語不明瞭で、吐き気や嘔吐が起きる。大脳・小脳がマヒし、「生命の中枢」脳幹にまでマヒが及びつつある。急性アルコール中毒の状態。吐物をのどに詰まらせたり、外で眠りこんで事故にあう危険性も高く、絶対一人にしてはいけない。様子がおかしいと感じたら病院へ。';
            } elseif ($breath >= 1.5 && $breath < 2) {
                $data['status'] = '昏睡';
                $data['mg'] 	= '1.5～2';
                $data['text']	= '「生命の中枢」である脳幹のマヒがすすみ、いわば「死と紙一重」の状態。意識を喪失しており、呼んでも揺すってもつねっても反応しない。あるいは意識がない状態で大いびきをかいている・・・・こんな場合は一刻をあらそう。すぐに救急車を呼ぶこと。';
            } else {
                $data['status'] = '計測できせん';
                $data['mg'] 	= '--';
                $data['text']	= '入力値が正しくないため計測できません。';
            }
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。', 'DATA' => $data));
        } catch (\Exception $e) {
            return $this->error(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
