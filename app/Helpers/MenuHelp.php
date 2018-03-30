<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class MenuHelp
{
 
    public static function getSideMenu($parent_id=0)
    {

    	$menu = DB::table('sidemenu')->where('parent_id',$parent_id)->orderBy('order','asc')->get();

    	for ($i=0; $i<count($menu); $i++)
    	{
    		$menu[$i]->url = $menu[$i]->redirect ? $menu[$i]->redirect : $menu[$i]->url;

            if ( $menu[$i]->parent_id == 0 )
                $menu[$i]->children = self::getSideMenu($menu[$i]->id);
    	}
    	
        return $menu;
    }

    public static function getCurrentSection()
    {
        /*
    	if (\Request::path() == '/')
    		$arr = ['news'];
    	else
			$arr = explode('/',\Request::path());

        $current_path = array_shift($arr);
        */

        $current_path = \Request::path();
        $cur = DB::table('sidemenu')->where('url','/'.$current_path)->first();

        if ($cur)
            return $cur;
        else
        {
            $arr = explode('/',$current_path);
            if (count($arr)>1)
            {
                $current_path = $arr[0];
                $cur = DB::table('sidemenu')->where('url','/'.$current_path)->first();

                if ($cur)
                    return $cur;                    
            }
        }

        return DB::table('sidemenu')->where('url','/profile')->first();
    }
 
    public static function isSubSectionActive($check_id)
    {
        $cur = self::getCurrentSection();
        if (!$cur)
            return false;

        return ($cur->parent_id === $check_id);
    }

}