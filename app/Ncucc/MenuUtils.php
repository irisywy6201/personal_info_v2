<?php

namespace App\Ncucc;

use \Auth as Auth;

class MenuUtils {
	public static function showable(array $nav) {
		if (! array_key_exists('role', $nav)) {
		} else if (! Auth::check()) {
			return false;
		} else if (((Auth::user()->role + Auth::user()->addrole) & $nav['role']) !== 0) {
		} else {
			return false;
		}

		// roleInclude is new statement aside from role and !role
		// dedicated to filter both addrole, role or addrole and role combined identity
		if(! array_key_exists('roleInclude', $nav)){
		}
		else if(! Auth::check()){
			return false;
		}
		else if(is_array($nav['roleInclude'])){
			$isAllow = false;
			foreach ($nav['roleInclude'] as $key => $value) {
				if((Auth::user()->role + Auth::user()->addrole) == $value){
					$isAllow = true;
				}
				else if((Auth::user()->role == $value) || (Auth::user()->addrole == $value)){
					$isAllow = true;
				}
			}
			if(!$isAllow){
				return false;
			}
		}
		else {
			$isAllow = false;
			if((Auth::user()->role + Auth::user()->addrole) == $nav['roleInclude']){
				$isAllow = true;
			}
			else if((Auth::user()->role == $nav['roleInclude']) || (Auth::user()->addrole == $nav['roleInclude'])){
				$isAllow = true;
			}
			if(!$isAllow){
				return false;
			}
		}

		// roleExclude is new statement aside from role and !role
		// dedicated to filter both addrole, role or addrole and role combined identity
		if(! array_key_exists('roleExclude', $nav)){
		}
		else if(! Auth::check()){
			return false;
		}
		else if(is_array($nav['roleExclude'])){
			foreach ($nav['roleExclude'] as $key => $value) {
				if((Auth::user()->role + Auth::user()->addrole) == $value){
					return false;
				}
				else if((Auth::user()->role == $value) || (Auth::user()->addrole == $value)){
					return false;
				}
			}
		}
		else{
			if((Auth::user()->role + Auth::user()->addrole) == $nav['roleExclude']){
				return false;
			}
			else if((Auth::user()->role == $nav['roleExclude']) || (Auth::user()->addrole == $nav['roleExclude'])){
				return false;
			}
		}

		if (! array_key_exists('!role', $nav)) {
			return true;
		} else if (! Auth::check()) {
			return true;
		} else if (((Auth::user()->role + Auth::user()->addrole) & $nav['!role']) !== 0) {
			return false;
		} else {
			return true;
		}
	}
}

?>
