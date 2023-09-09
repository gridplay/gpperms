<?php
namespace GPPerms;
use Illuminate\Database\Eloquent\Model;
class GPRanks extends Model {
	protected $table = 'gpperms_ranks';
    public $incrementing = true;
	public $timestamps = false;
	protected $guarded = [];
	// converts rank name to id
	public static function GetRankID($rankname): integer
	{
		if ($r = self::where('rank_name', $rankname)->first()) {
			return $r->rank_id;
		}
		return -1;
	}
}