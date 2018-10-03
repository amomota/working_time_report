<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Users;
use Expenses;
use App\Via;
use App\Affiliation;
use App\Team;


class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {

        //ユーザをIDにて取得
        $year = date('Y');
        $month = date('n');	

	if(Auth::User()->isadmin){
		$userid = $request->userId;
	}else{
		$userid = Auth::User()->id;
	}
	
	$users = Users::where('id',$userid)->get();
	$vias = Via::all();
	$affiliations = Affiliation::all();
	$teams = Team::all();

        return view('/user/userprofile')->with(compact('users',$users,
						'vias',$vias,
						'affiliations',$affiliations,
						'teams',$teams,
						'year',$year,
						'month',$month
						));
    }

    public function profile_edit(Request $request){

        $users = Users::where('id', $request->userId)->firstOrFail();

        if(Auth::User()->isadmin){
            $userid = $users->user_id;
        }else{
            $userid = Auth::User()->id;
        }
        // ユーザ取得

        $vias = Via::all();
        $affiliations = Affiliation::all();
        $teams = Team::all();
        

        return view('/user/profile_edit')->with(compact('users',$users,
                                                  'vias',$vias,
                                                  'affiliations',$affiliations,
                                                  'teams',$teams));
    }

    public function profile_delete(Request $request){

        $users = Users::where('id', $request->userId)->firstOrFail();
        Users::destroy($request->userId);

        if(Auth::User()->isadmin){
            return redirect()->to('admin');
        }else{
            return redirect()->to('admin');
        }
    }


    public function profile_update(Request $request) {

        $users = Users::where('id', $request->userId)->firstOrFail();
        $vias = Via::all();
        $affiliations = Affiliation::all();
        $teams = Team::all();

        $users->name = $request->name;
        $users->aiueo_rder = $request->aiueo_rder;
        $users->username = $request->username;
        $users->email = $request->email;

        if($request->password != "") {
            $hashpassword = $request->password;
            $users->password = password_hash($hashpassword,PASSWORD_BCRYPT);
        }

        $users->via_id = $request->via_id;
        $users->affiliation_id = $request->affiliation_id;
        $users->team_id = $request->team_id;
        $users->nokia_in = $request->nokia_in;
        $users->nokia_out = $request->nokia_out;

        // データベースへ保存
        $users->save();


        // 経由会社 計上処理
        foreach($vias as $via){
            switch($via->id){
            case 1:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','1'] ])->count();   // 経由会社:ミナト
                break;
            case 2:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','2'] ])->count();   // 経由会社:OST
                break;
            case 3:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','3'] ])->count();   // 経由会社:NESIC
                break;
            case 4:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','4'] ])->count();   // 経由会社:インセクト
                break;
            case 5:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','5'] ])->count();   // 経由会社:リングス
                break;
            case 6:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','6'] ])->count();   // 経由会社:KCCS
                break;
            case 7:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','7'] ])->count();   // 経由会社:ミライト
                break;
            case 8:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','8'] ])->count();   // 経由会社:メタテック
                break;
            case 9:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','9'] ])->count();   // 経由会社:ディージースト
                break;
            case 10:
                $via->total = User::where([ ['isadmin','0'], ['isactive','1'],['via_id','10'] ])->count();  // 経由会社:都工組
                break;
            default:
                printf("via err");
            }

            $via->save();

        }

        // 所属会社 計上処理
        foreach($affiliations as $affiliation){
            switch($affiliation->id){
            case 1:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','1'] ])->count();   // 所属会社:ミナト
                break;
            case 2:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','2'] ])->count();   // 所属会社:POTECT
                break;
            case 3:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','3'] ])->count();   // 所属会社:BLパートナー
                break;
            case 4:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','4'] ])->count();   // 所属会社:スマートテック
                break;
            case 5:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','5'] ])->count();   // 所属会社:ディージースト
                break;
            case 6:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','6'] ])->count();   // 所属会社:エスアイイー
                break;
            case 7:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','7'] ])->count();   // 所属会社:ピークアドバンス
                break;
            case 8:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','8'] ])->count();   // 所属会社:C&I
                break;
            case 9:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','9'] ])->count();   // 所属会社:JICOO
                break;
            case 10:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','10'] ])->count();  // 所属会社:セレッテ
                break;
            case 11:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','11'] ])->count();  // 所属会社:SEI
                break;
            case 12:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','12'] ])->count();  // 所属会社:プラウドデータ
                break;
            case 13:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','13'] ])->count();  // 所属会社:GBR
                break;
            case 14:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','14'] ])->count();  // 所属会社:アイリス
                break;
            case 15:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','15'] ])->count();  // 所属会社:ソシアス
                break;
            case 16:
                $affiliation->total = User::where([ ['isadmin','0'], ['isactive','1'],['affiliation_id','16'] ])->count();  // 所属会社:KIS
                break;
            default:
                printf("affiliation err");
            }

            $affiliation->save();

        }

        // チーム 計上処理
        foreach($teams as $team){
            switch($team->id){
            case 1:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','1'] ])->count();    // チーム:KCOM CORE ALARM
                break;
            case 2:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','2'] ])->count();    // チーム:KCOM CORE TOOL
                break;
            case 3:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','3'] ])->count();    // チーム:WCP CORE
                break;
            case 4:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','4'] ])->count();    // チーム:KCOM NPO
                break;
            case 5:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','5'] ])->count();    // チーム:SCOM NPO
                break;
            case 6:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','6'] ])->count();    // チーム:KCOM CORE LABO
                break;
            case 7:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','7'] ])->count();    // チーム:KIC Veri
                break;
            case 8:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','8'] ])->count();    // チーム:SCOM NPO GSC
                break;
            case 9:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','9'] ])->count();    // チーム:KCOM RAN CARE L1
                break;
            case 10:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','10'] ])->count();   // チーム:KCOM CORE KPI
                break;
            case 11:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','11'] ])->count();   // チーム:KCOM OCS L2
                break;
            case 12:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','12'] ])->count();   // チーム:CARE RAN Veri
                break;
            case 13:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','13'] ])->count();   // チーム:SCOM OBS
                break;
            case 14:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','14'] ])->count();   // チーム:CARE RAN
                break;
            case 15:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','15'] ])->count();   // チーム:KCOM PCRF L2
                break;
            case 16:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','16'] ])->count();   // チーム:Falcon
                break;
            case 17:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','17'] ])->count();   // チーム:SCOM CARE RAN
                break;
            case 18:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','18'] ])->count();   // チーム:門前仲町
                break;
            case 9999:
                $team->total = User::where([ ['isadmin','0'], ['isactive','1'],['team_id','9999'] ])->count(); // チーム:無所属
                break;
            default:
                printf("team err");
            }

            $team->save();

        }

        if (Auth::User()->isadmin) {
                return redirect()->to('admin');
        } else{
                return redirect()->to('admin');
        }

    }
}
