'use strict';

/**
 * Returns an object providing several APIs for index sub-page events and actions.
 */
define(function () {
	/**
	 * Add action to target DOM, realizing that when mouse roll into
	 * target DOM, the target marquee will stop animating, until the
	 * mouse leave the target marquee.
	 * @param target The target marquee DOM.
	 */
	function marquee(target) {

		var tid = null,pause = false;
		var stf = "div";
		var delay = 3500;
		var speed = 25;
		var h = 20;
		var delay = delay||1000,speed = speed||20,h = h||20;
		var slideBox = document.getElementById('announcement-div');
		//預設值 delay:幾毫秒滾動一次(1000毫秒=1秒)
		//       speed:數字越小越快，h:高度
		if(slideBox !== null) {
			var s = function() {
				tid=setInterval(slide, speed);
			}
			//主要動作的地方
			var slide = function() {
				if(pause) return;
				//滾動條往下滾動 數字越大會越快但是看起來越不連貫，所以這邊用1
				slideBox.scrollTop += 1;
				//滾動到一個高度(h)的時候就停止
				if(slideBox.scrollTop%h == 0){
					//跟setInterval搭配使用的
					clearInterval(tid);
					//將剛剛滾動上去的前一項加回到整列的最後一項
					slideBox.appendChild(slideBox.getElementsByTagName(stf)[0]);
					//再重設滾動條到最上面
					slideBox.scrollTop = 0;
					//延遲多久再執行一次
					setTimeout(s, delay);
				}
			}
			//滑鼠移上去會暫停 移走會繼續動
			
			slideBox.onmouseover=function() { pause = true; }
			slideBox.onmouseout=function() { pause = false; }
			

			//起始的地方，沒有這個就不會動囉
			setTimeout(s, delay);
		}
		
	}
	return {
		/**
		 * Initialization routings of index sub-page.
		 */
		addMarqueeAction: function (target) {
			marquee(target);
		}
	};
});