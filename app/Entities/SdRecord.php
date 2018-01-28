<?php
  namespace App\Entities;

  class SdRecord extends BaseEntity{
      /**
       * The database table used by the model
       */
      protected $table = 'sdRecord';
      protected $primaryKey = 'id';
      protected $fillable = ['category','user_category','sdRecCont','solution','recorder','user_id','user_contact'];

      public function scopeGetFromId($query,$id){
        return $query->where('id', '=', $id );
      }

      public function scopeOutputData($query) {
        $result = $query->get();
        $finalResult = [];
        foreach ($result as $key => $value) {
          $final = ['id' => null, 'department' => null, 'category' => null, 'sdRecCont' => null, 'solution' => null, 'recorder' => null, 'user_category' => null, 'user_id' => null, 'user_contact' => null, 'created_at' => null, 'editTime' => null];
    			if ($value->category) {
    				$value->category = SdRecCategory::getSubCategory(1)->where('id' ,$value->category)->value('name');
    			}
          if ($value->user_category) {
    				$value->user_category = SdRecUserCategory::where('id' ,$value->user_category)->value('user');
    			}
    			if ($value->solution) {
    				$value->solution = SolutionCategory::where('id' ,$value->solution)->value('method');
    			}
          $value['department'] = SdRecCategory::getSubCategory(0)->first()->value('name');

          $final['id'] = $key+1;
          $final['department'] = $value['department'];
          $final['category'] = $value['category'];
          $final['sdRecCont'] = $value['sdRecCont'];
          $final['solution'] = $value['solution'];
          $final['recorder'] = $value['recorder'];
          $final['user_category'] = $value['user_category'];
          $final['user_id'] = $value['user_id'];
          $final['user_contact'] = $value['user_contact'];
          $final['created_at'] = $value['created_at'];
          $final['editTime'] = $value['editTime'];

          array_push($finalResult,$final);
    		}
        return $finalResult;
      }

      /**
    	 * This fumction will return the sdRecord after this time
    	 * @var string $from : start from this time
    	 * @return $query
    	 */
    	public function scopeAfterTime($query, $after)
    	{
    		return $query->where('created_at', '>=', $after);
    	}

    	/**
    	 * This function will return the sdRecord before this time
    	 * @var string $before :  before this time
    	 * @return $query
    	 */
    	public function scopeBeforeTime($query, $before)
    	{
    		return $query->where('created_at', '<=', $before);
    	}
  }

?>
