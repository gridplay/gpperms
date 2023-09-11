<?php
namespace GPPerms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class GPPerms extends Model {
	protected $table = 'gpperms_users';
    public $incrementing = false;
	public $timestamps = false;
	protected $guarded = [];
	public static $GPRANK_TABLE = 'gpperms_ranks';

	// GPPerms::CanDo('Rank name or ID');
	public static function CanDo($rank): bool
	{
		if (Auth::check()) {
			if (is_string($rank)) {
				$rank = self::GetRankID($rank);
			}
			if ($u = self::where('user_id', Auth::id())->first()) {
				if ($u->rank_id == $rank) {
					return true;
				}
			}
		}
		return false;
	}
	// GPPerms::AddorUpdateUser($user_id, 'Rank Name or ID');
	public static function AddorUpdateUser($user_id, $rank): string
	{
		if (is_string($rank)) {
			$rank = self::GetRankID($rank);
		}
		if ($ur = self::where('user_id', $user_id)->first()) {
			self::where('user_id', $user_id)->update(['rank_id' => $rank, 'changed' => time()]);
			return "User already added, updated rank instead";
		}else{
			self::insert(['user_id' => $user_id, 'rank_id' => $rank, 'added' => time()]);
			return "User added with rank ID ".$rank;
		}
		return "Adding/Updating derp";
	}
	// GPPerms::GetRankName($rank_id);
	public static function GetRankName($rid): string
	{
		if ($r = DB::table(self::$GPRANK_TABLE)->where('rank_id', $rid)->first()) {
			return $r->rank_name;
		}
		return "";
	}
	// converts rank name to id
	// GPPerms::GetRankID($rankname);
	public static function GetRankID($rankname): integer
	{
		if ($r = DB::table(self::$GPRANK_TABLE)->where('rank_name', $rankname)->first()) {
			return $r->rank_id;
		}
		return -1;
	}
	// GPPerms::AddorUpdateRankName($rank_name, $optional_id);
	// $optional_id is ONLY for updating $rank_name or if rank_id is NOT auto incremented
	public static function AddorUpdateRankName($rname, $rid = 0): integer
	{
		if ($r = DB::table(self::$GPRANK_TABLE)->where('rank_id', $rid)->first()) {
			DB::table(self::$GPRANK_TABLE)->where('rank_id', $rid)->update(['rank_name' => $rname]);
			return $rid;
		}else{
			if ($rid = 0) {
				return DB::table(self::$GPRANK_TABLE)->insertGetId(['rank_name' => $rname]);
			}else if ($rid > 0) {
				DB::table(self::$GPRANK_TABLE)->insert(['rank_id' => $rid, 'rank_name' => $rname]);
				return $rid;
			}
		}
	}
}