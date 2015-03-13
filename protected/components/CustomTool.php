<?php
class CustomTool{
	public $ARRAY_CATEGORY = array(
	        "Apparel & Jewelry"=> "Apparel & Jewelry",
	        "Arts & Antiques" => "Arts & Antiques",
	        "Automotive"=>"Automotive",
	        "Aviation & Marine"=>"Aviation & Marine",
	        "Books & Magazines"=>"Books & Magazines",
	        "Cellphones & Accessories"=>"Cellphones & Accessories",
	        "Computer Hardware & Software"=>"Computer Hardware & Software",
	        "Electronics"=>"Electronics",
	        "Education"=>"Education",
	        "Food & Dining"=>"Food & Dining",
	        "Gifts & Flowers"=>"Gifts & Flowers",
	        "Health, Fitness, Beauty"=>"Health, Fitness, Beauty",
	        "Home & Garden"=>"Home & Garden",
	        "Legal & Financial"=>"Legal & Financial",
	        "Music, Instruments, CDs"=>"Music, Instruments, CDs",
	        "Office Furniture"=>"Office Furniture",
	        "Machines & Supplies"=>"Machines & Supplies",
	        "Pets"=>"Pets",
	        "Real Estate"=>"Real Estate",
	        "Recreation"=>"Recreation",
	        "Services"=>"Services",
	        "Sports & Outdoors"=>"Sports & Outdoors",
	        "Tools & Machinery"=>"Tools & Machinery",
	        "Toys, Games, Hobbies"=>"Toys, Games, Hobbies",
	        "Travel & Lodging" => "Travel & Lodging"
	    );
		
	public function getCategoryList()
    {
        return $this->ARRAY_CATEGORY;
    }	
	public function getMonthsArray()
    {
        for($monthNum = 1; $monthNum <= 12; $monthNum++){
            $months[$monthNum] = date('F', mktime(0, 0, 0, $monthNum, 1));
        }

        return $months;
    }
	 
    public function getDaysArray()
    {
        for($dayNum = 1; $dayNum <= 31; $dayNum++){
            $days[$dayNum] = $dayNum;
        }

        return $days;
    }
    public static function isBusinessOwner($bid)
    {
    	if($bid==Yii::app()->user->id)
			return true;
		return false;
    }
	public static function generateFullname($id)
	{
		$user = User::model()->findByPk($id);
		return ucwords($user->profile['firstname']." ".$user->profile['lastname']); 
	}
    public function getYearsArray()
    {
        $thisYear = date('Y', time()) -18;

        for($yearNum = $thisYear; $yearNum >= 1960; $yearNum--){
            $years[$yearNum] = $yearNum;
        }

        return $years;
    }
	public static function filterSearchKeys($query)
	{
		
		
	    $query = trim(preg_replace("/(\s+)+/", " ", $query));
	    $words = array();
	    // expand this list with your words.
	    $list = array("in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then","&","and","for"
	    		,"each");
	    $c = 0;
	    foreach(explode(" ", $query) as $key){
	        if (in_array($key, $list)){
	            continue;
	        }
	        $words[] = $key;
	        if ($c >= 15){
	            break;
	        }
	        $c++;
	    }
	    return $words;
	}
	//limit words number of characters
	public static function limitChars($query, $limit = 200){
    return substr($query, 0,$limit);
}
}
