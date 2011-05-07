Drag = {
 
    obj : null,
 
    init : function(o, oRoot, minX, maxX, minY, maxY, bSwapHorzRef, bSwapVertRef, fXMapper, fYMapper)
    {
        o.onmousedown   = Drag.start;
 
        o.hmode         = bSwapHorzRef ? false : true ;
        o.vmode         = bSwapVertRef ? false : true ;
 
        o.root = oRoot && oRoot != null ? oRoot : o ;
 
        if (o.hmode  && isNaN(parseInt(o.root.style.left  ))) o.root.style.left   = "0px";
        if (o.vmode  && isNaN(parseInt(o.root.style.top   ))) o.root.style.top    = "0px";
        if (!o.hmode && isNaN(parseInt(o.root.style.right ))) o.root.style.right  = "0px";
        if (!o.vmode && isNaN(parseInt(o.root.style.bottom))) o.root.style.bottom = "0px";
 
        o.minX  = typeof minX != 'undefined' ? minX : null;
        o.minY  = typeof minY != 'undefined' ? minY : null;
        o.maxX  = typeof maxX != 'undefined' ? maxX : null;
        o.maxY  = typeof maxY != 'undefined' ? maxY : null;
 
        o.xMapper = fXMapper ? fXMapper : null;
        o.yMapper = fYMapper ? fYMapper : null;
 
        o.root.onDragStart  = new Function();
        o.root.onDragEnd    = new Function();
        o.root.onDrag       = new Function();
    },
 
    start : function(e)
    {
        var o = Drag.obj = this;
        e = Drag.fixE(e);
        var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
        var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
        o.root.onDragStart(x, y);
 
        o.lastMouseX    = e.clientX;
        o.lastMouseY    = e.clientY;
 
        if (o.hmode) {
            if (o.minX != null) o.minMouseX = e.clientX - x + o.minX;
            if (o.maxX != null) o.maxMouseX = o.minMouseX + o.maxX - o.minX;
        } else {
            if (o.minX != null) o.maxMouseX = -o.minX + e.clientX + x;
            if (o.maxX != null) o.minMouseX = -o.maxX + e.clientX + x;
        }
 
        if (o.vmode) {
            if (o.minY != null) o.minMouseY = e.clientY - y + o.minY;
            if (o.maxY != null) o.maxMouseY = o.minMouseY + o.maxY - o.minY;
        } else {
            if (o.minY != null) o.maxMouseY = -o.minY + e.clientY + y;
            if (o.maxY != null) o.minMouseY = -o.maxY + e.clientY + y;
        }
 
        document.onmousemove    = Drag.drag;
        document.onmouseup      = Drag.end;
 
        return false;
    },
 
    drag : function(e)
    {
        e = Drag.fixE(e);
        var o = Drag.obj;
 
        var ey  = e.clientY;
        var ex  = e.clientX;
        var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
        var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
        var nx, ny;
 
        if (o.minX != null) ex = o.hmode ? Math.max(ex, o.minMouseX) : Math.min(ex, o.maxMouseX);
        if (o.maxX != null) ex = o.hmode ? Math.min(ex, o.maxMouseX) : Math.max(ex, o.minMouseX);
        if (o.minY != null) ey = o.vmode ? Math.max(ey, o.minMouseY) : Math.min(ey, o.maxMouseY);
        if (o.maxY != null) ey = o.vmode ? Math.min(ey, o.maxMouseY) : Math.max(ey, o.minMouseY);
 
        nx = x + ((ex - o.lastMouseX) * (o.hmode ? 1 : -1));
        ny = y + ((ey - o.lastMouseY) * (o.vmode ? 1 : -1));
 
        if (o.xMapper)      nx = o.xMapper(y)
        else if (o.yMapper) ny = o.yMapper(x)
 
        Drag.obj.root.style[o.hmode ? "left" : "right"] = nx + "px";
        Drag.obj.root.style[o.vmode ? "top" : "bottom"] = ny + "px";
        Drag.obj.lastMouseX = ex;
        Drag.obj.lastMouseY = ey;
 
        Drag.obj.root.onDrag(nx, ny);
        return false;
    },
 
    end : function()
    {
        document.onmousemove = null;
        document.onmouseup   = null;
        Drag.obj.root.onDragEnd(    parseInt(Drag.obj.root.style[Drag.obj.hmode ? "left" : "right"]),
                                    parseInt(Drag.obj.root.style[Drag.obj.vmode ? "top" : "bottom"]));
        Drag.obj = null;
    },
 
    fixE : function(e)
    {
        if (typeof e == 'undefined') e = window.event;
        if (typeof e.layerX == 'undefined') e.layerX = e.offsetX;
        if (typeof e.layerY == 'undefined') e.layerY = e.offsetY;
        return e;
    }
}

//YouTube returns number of seconds for durations. This function will
//convert those to something more readable, like mm:ss
secondsToTime = function(secs) {
    minVar = Math.floor(secs.toFixed()/60).toFixed();  // The minutes
    secVar = (secs.toFixed() % 60).toFixed();
    if (minVar < 0) minVar = 0;
    if (secVar < 0) secVar = 0;
    if (minVar < 10) minVar = '0'+minVar;
    if (secVar < 10) secVar = '0'+secVar;
    return minVar+':'+secVar;
}

imageHover = function(){
	  $("ul.thumb li").hover(function() {
			$(this).css({'z-index' : '10'}); /*Add a higher z-index value so this image stays on top*/ 
			$(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
				.animate({
					marginTop: '-110px', /* The next 4 lines will vertically align this image */ 
					marginLeft: '-110px',
					top: '50%',
					left: '50%',
					width: '174px', /* Set new width */
					height: '174px', /* Set new height */
					padding: '20px'
				}, 200); /* this value of "200" is the speed of how fast/slow this hover animates */

			} , function() {
			$(this).css({'z-index' : '0'}); /* Set z-index back to 0 */
			$(this).find('img').removeClass("hover").stop()  /* Remove the "hover" class , then stop animation queue buildup*/
				.animate({
					marginTop: '0', /* Set alignment back to default */
					marginLeft: '0',
					top: '0',
					left: '0',
					width: '100px', /* Set width back to default */
					height: '100px', /* Set height back to default */
					padding: '5px'
				}, 400);
		});
	
};

