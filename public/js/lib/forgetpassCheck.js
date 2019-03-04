
	var year = document.getElementById("year");
	var month = document.getElementById("month");
	var day = document.getElementById("day");

	var inputAreaId = new Array("username", "studentID", "identifyNumber");
	var birthdayMenu = new Array("year", "month", "day");
	

	function finalCheck()
	{
		var checkBlank = 1;

		for(var i = 0; i < inputAreaId.length; i++)
		{
			var inp = document.getElementById(inputAreaId[i]).value;
			if(inp == "")
			{
				checkBlank = 0;
			}
		}
		for(var i = 0; i < birthdayMenu.length; i++)
		{
			var bir = document.getElementById(birthdayMenu[i]).value;
			console.log(bir);
			if(bir == "--")
			{
				checkBlank = 0;
			}
		}

		if(checkBlank == 0)
		{
			console.log("something blank");
		}
		else
		{
			console.log("all done");
		}
	}


	var date = new Date();
	var now_year = date.getFullYear();
	var lowest_year = "1900";
	

	function create_option(create_value, id)
	{
		var year_select = document.getElementById(id);
		var option_html = document.createElement("option");
		option_html.appendChild(document.createTextNode(create_value));
		year_select.appendChild(option_html);
	}

	create_option("--", "year");
	create_option("--", "month");
	create_option("--", "day");

	for(var i = now_year; i >= lowest_year; i--)
	{
		create_option(i, "year");
	}/* create the year elements in menu */


	year.onchange = changeYearMount;
	function changeYearMount()
	{
		if (year.value == "--")
		{
			cleanMonth();
			cleanDay();
			
		}else
		{
			for(var i = 1; i <= 12; i++)
			{
				create_option(i, "month");
			}/* create the month element in menu*/
			
			for(var i = 0; i < month.children.length; i++)
			{
				month.children[i].className += "month_class";
			}

			if(month.value == "2")
			{
				day.value = "--";
				cleanDay();
				cleanMonth();
				for(var i = 1; i <= 12; i++)
				{
					create_option(i, "month");
				}/* create the month element in menu*/

				changeDayMount();
				LeapYear();
			}
		}
	}

	month.onchange = changeDayMount;
	function changeDayMount()
	{
		if (year.value == "--")
		{
			cleanDay();
			cleanMonth();
		}
		else
		{
			var bigMonth = new Array("1", "3", "5", "7", "8", "10", "12");
			var flag = bigMonth.some(function(value, index, array)
			{
				return value == month.value? true: false;
			});


			cleanDay();

			if(flag == true)
			{
				for(var i = 1; i <= 31; i++)
				{
					create_option(i, "day");
				}
			}else if(flag == false && month.value != "2")
			{
				for(var i = 1; i <= 30; i++)
				{
					
					create_option(i, "day");
				}
			}else
			{
				LeapYear();
			}
		}	
	}


	function LeapYear()
	{
		if(year.value % 4 == 0)/* 29 day in February*/
		{
			for(var i = 1; i <= 29; i++)
			{
				
				create_option(i, "day");
			}
		}else/* 28 day in February*/
		{
			for(var i = 1; i <= 28; i++)
			{
				
				create_option(i, "day");
			}
		}
	}

	function cleanDay()
	{
		while(day.lastChild.value != "--")
		{
			day.removeChild(day.lastChild);
		}
	}

	function cleanMonth()
	{
		while(month.lastChild.value != "--")
		{
			month.removeChild(month.lastChild);
		}
	}
