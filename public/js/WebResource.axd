if (!window) this.window = this;
window.NNP = {
    __namespace: true,
    __typeName: "NNP"
    ,
    getName: function() { return "NNP"; },
    __upperCaseTypes: {},
    createDelegate: function Function$createDelegate(instance, method) {
        return function() {
            return method.apply(instance, arguments);
        }
    }, setElementOpacity: function(element, value) {
        if (element.filters) {
            var filters = element.filters;
            var createFilter = true;
            if (filters.length !== 0) {
                var alphaFilter = filters['DXImageTransform.Microsoft.Alpha'];
                if (alphaFilter) {
                    createFilter = false;
                    alphaFilter.opacity = value * 100;
                }
            }
            if (createFilter) {
                element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + (value * 100) + ')';
            }
        }
        else {
            element.style.opacity = value;
        }
    },
    setWidth: function(element, value) {
        value.replace("px", "");
        element.style.width = value + "px";
    }
    ,
    setHeight: function(element, value) {
        value.replace("px", "");
        element.style.height = value + "px";
    }
    ,
    getCurrentStyle: function(element, attribute, defaultValue) {
        var currentValue = null;
        if (element) {
            if (element.currentStyle) {
                currentValue = element.currentStyle[attribute];
            } else if (document.defaultView && document.defaultView.getComputedStyle) {
                var style = document.defaultView.getComputedStyle(element, null);
                if (style) {
                    currentValue = style[attribute];
                }
            }

            if (!currentValue && element.style.getPropertyValue) {
                currentValue = element.style.getPropertyValue(attribute);
            }
            else if (!currentValue && element.style.getAttribute) {
                currentValue = element.style.getAttribute(attribute);
            }
        }

        if ((!currentValue || currentValue == "" || typeof (currentValue) === 'undefined')) {
            if (typeof (defaultValue) != 'undefined') {
                currentValue = defaultValue;
            }
            else {
                currentValue = null;
            }
        }
        return currentValue;
    }, applyProperties: function(target, properties) {
        for (var p in properties) {
            var pv = properties[p];
            if (pv != null && typeof pv === 'object') {
                var tv = target[p];
                this.applyProperties(tv, pv);
            } else {
                target[p] = pv;
            }
        }
    }, addCssClass: function(element, className) {
        if (element.className === '') {
            element.className = className;
        }
        else {
            element.className += ' ' + className;
        }
    }, addCssClasses: function(element, classNames) {
        for (var i = 0; i < classNames.length; i++) {
            this.addCssClass(element, classNames[i]);
        }
    },
    stopPropagation: function(e) {
        if (e && typeof e != 'undefined') {
            if (e.stopPropagation) {
                e.stopPropagation();
            }
            else if (e || window.event) {
                e = e || window.event;
                e.cancelBubble = true;
            }
        }

    },
    startPropagation: function(e) {
        if (e && typeof e != 'undefined') {
            if (e.startPropagation) {
                e.startPropagation();
            }
            else if (e || window.event) {
                e = e || window.event;
                e.cancelBubble = false;
            }
        }
    }
    , $addHandler: function(element, eventName, handler) {
        if (eventName === "error") throw Error.craete("error", "error eventName");
        if (!element._events) {
            element._events = {};
        }
        var eventCache = element._events[eventName];
        if (!eventCache) {
            element._events[eventName] = eventCache = [];
        }
        var browserHandler;
        if (element.addEventListener) {
            //            browserHandler = function(e) {
            //                return handler.call(element, new Sys.UI.DomEvent(e));
            //            }
            element.addEventListener(eventName, handler, false);
        }
        else if (element.attachEvent) {
            //            browserHandler = function() {
            //                var e = {};
            //                try { e = this._getWindow(element).event } catch (ex) { }
            //                return handler.call(element, new Sys.UI.DomEvent(e));
            //            }
            element.attachEvent('on' + eventName, handler);
        }
        eventCache[eventCache.length] = { handler: handler, browserHandler: browserHandler };
    },

    _getWindow: function(element) {
        var doc = element.ownerDocument || element.document || element;
        return doc.defaultView || doc.parentWindow;
    },
    $removeHandler: function(element, eventName, handler) {
        browserHandler = element[eventName];
        if (element.removeEventListener) {
            element.removeEventListener(eventName, browserHandler, false);
        }
        else if (element.detachEvent) {
            element.detachEvent('on' + eventName, browserHandler);
        }
    }
    ,
    $addHandlers: function(element, events, handlerOwner) {
        for (var name in events) {
            var handler = events[name];
            if (typeof (handler) !== 'function') throw Error.create(handler, "has not a fuction");
            if (handlerOwner) {
                handler = this.createDelegate(handlerOwner, handler);
            }
            this.$addHandler(element, name, handler);
        }
    }, isPosetive: function(num) {
        if (num < 0)
            return false;
        else return true;
    },
    makeFarsiNum: function(s) {
        var s2 = "";
        s = s.toString();
        for (i = 0; i < s.length; i++) {
            c = s.charCodeAt(i);
            if ((c >= 48) && (c <= 57)) {
                c = c + 1728;
            }

            s2 += String.fromCharCode(c);
        }
        return s2;
    },
    makeEnglishNum: function(s) {
        var s2 = "";
        s = s.toString();
        for (i = 0; i < s.length; i++) {
            c = s.charCodeAt(i);
            if ((c >= 1776) && (c <= 1785)) {
                c = c - 1728;
            }

            s2 += String.fromCharCode(c);
        }
        return s2;
    },
    setLocation: function(element, point) {
        element.style.top = point.y + "px";
        element.style.left = point.x + "px";
    },
    isEnglishChar: function(s) {
        s = s.toString();
        for (i = 0; i < s.length; i++) {
            c = s.charCodeAt(i);
            if ((c >= 48) && (c <= 57)) {
                return true;
            }
        }
    }
    ,
    setVisible: function(element, visible) {
        element.style.visibility = visible ? "" : "hidden";
    },
    GetCenterScreen: function(width, height) {
        var scrolledX, scrolledY;
        if (self.pageYOffset) {
            scrolledX = self.pageXOffset;
            scrolledY = self.pageYOffset;
        } else if (document.documentElement && document.documentElement.scrollTop) {
            scrolledX = document.documentElement.scrollLeft;
            scrolledY = document.documentElement.scrollTop;
        } else if (document.body) {
            scrolledX = document.body.scrollLeft;
            scrolledY = document.body.scrollTop;
        }
        var centerX, centerY;
        if (self.innerHeight) {
            centerX = self.innerWidth;
            centerY = self.innerHeight;
        } else if (document.documentElement && document.documentElement.clientHeight) {
            centerX = document.documentElement.clientWidth;
            centerY = document.documentElement.clientHeight;
        } else if (document.body) {
            centerX = document.body.clientWidth;
            centerY = document.body.clientHeight;
        }

        // Xwidth is the width of the div, Yheight is the height of the
        // div passed as arguments to the function:
        var center = new Object();
        center.x = scrolledX + (centerX - width) / 2;
        center.y = scrolledY + (centerY - height) / 2;
        return center;
    }, getSize: function(element) {
        if (!element) {
            throw NNP.Error.create('element', "element not defined");
        }
        return {
            width: element.offsetWidth,
            height: element.offsetHeight
        };
    },
    Drag: function(elementToDrag, event, position) {
        var startX = event.clientX, startY = event.clientY;
        var origX = elementToDrag.offsetLeft, origY = elementToDrag.offsetTop;
        var deltaX = startX - origX, deltaY = startY - origY;

        if (document.addEventListener) {
            document.addEventListener("mousemove", moveHandler, true);
            document.addEventListener("mouseup", upHandler, true);
        }
        else if (document.attachEvent) {
            elementToDrag.setCapture();
            elementToDrag.attachEvent("onmousemove", moveHandler);
            elementToDrag.attachEvent("onmouseup", upHandler);
            elementToDrag.attachEvent("onlosecapture", upHandler);
        }
        else {
            return;
        }

        event.stopPropagation ? event.stopPropagation() : event.cancelBubble = true;
        event.preventDefault ? event.preventDefault() : event.returnValue = false;

        function moveHandler(e) {
            if (!e) e = window.event;
            if (typeof (position) != "undefined") {
                if (position == "x") {
                    elementToDrag.style.left = (e.clientX - deltaX) + "px";

                }
                else
                { elementToDrag.style.top = (e.clientY - deltaY) + "px"; }
            } else {
                elementToDrag.style.left = (e.clientX - deltaX) + "px";
                elementToDrag.style.top = (e.clientY - deltaY) + "px";
            }


            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }

        function upHandler(e) {
            if (!e) e = window.event;

            if (document.removeEventListener) {
                document.removeEventListener("mouseup", upHandler, true);
                document.removeEventListener("mousemove", moveHandler, true);
            }
            else if (document.detachEvent) {
                elementToDrag.detachEvent("onlosecapture", upHandler);
                elementToDrag.detachEvent("onmouseup", upHandler);
                elementToDrag.detachEvent("onmousemove", moveHandler);
                elementToDrag.releaseCapture();
            }
            else {
                return;
            }

            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
    }
    ,
    getPosition: function(element) {
        //The counters for the total offset values.
        var left = 0;
        var top = 0;
        //Loop while this element has a parent.
        while (element.offsetParent) {
            //Sum the current offsets with the total.
            left += element.offsetLeft;
            top += element.offsetTop;
            //Switch position to this element's parent.
            element = element.offsetParent;
        }
        //Do a final increment in case there was no parent or if //the last parent has an offset.
        left += element.offsetLeft;
        top += element.offsetTop;
        //Return the values as x,y.
        return { x: left, y: top };
    }
    ,
    createElementFromTemplate: function(template, appendToParent, nameTable) {
        if (typeof (template.nameTable) != 'undefined') {
            var newNameTable = template.nameTable;
            if (String.isInstanceOfType(newNameTable)) {
                newNameTable = nameTable[newNameTable];
            }
            if (newNameTable != null) {
                nameTable = newNameTable;
            }
        }
        var elementName = null;
        if (typeof (template.name) !== 'undefined') {
            elementName = template.name;
        }
        var elt = document.createElement(template.nodeName);
        if (typeof (template.name) !== 'undefined' && nameTable) {
            nameTable[template.name] = elt;
        }
        if (typeof (template.parent) !== 'undefined' && appendToParent == null) {
            var newParent = template.parent;
            if (String.isInstanceOfType(newParent)) {
                newParent = nameTable[newParent];
            }
            if (newParent != null) {
                appendToParent = newParent;
            }
        }
        if (typeof (template.properties) !== 'undefined' && template.properties != null) {
            this.applyProperties(elt, template.properties);
        }
        if (typeof (template.cssClasses) !== 'undefined' && template.cssClasses != null) {
            this.addCssClasses(elt, template.cssClasses);
        }
        if (typeof (template.events) !== 'undefined' && template.events != null) {
            this.$addHandlers(elt, template.events);
        }
        if (typeof (template.visible) !== 'undefined' && template.visible != null) {
            this.setVisible(elt, template.visible);
        }
        if (appendToParent) {
            appendToParent.appendChild(elt);
        }
        if (typeof (template.opacity) !== 'undefined' && template.opacity != null) {
            this.setElementOpacity(elt, template.opacity);
        }
        if (typeof (template.children) !== 'undefined' && template.children != null) {
            for (var i = 0; i < template.children.length; i++) {
                var subtemplate = template.children[i];
                this.createElementFromTemplate(subtemplate, elt, nameTable);
            }
        }
        // return the created element
        return elt;
    }
};

NNP.$get = function(element) { return document.getElementById(element); }
NNP.$rem = function(element, parent) {
    if (typeof parent != "undefined") {
        if (typeof parent != 'object')
            parent = this.$get(parent);
    } else parent = document;
    if (typeof element != 'object')
        element = this.$get(element);
    parent.removeChild(element);
}
NNP.$append = function(element, parent) {
    if (parent != null) parent.appendChild(element);
    else document.body.appendChild(element);
}
NNP.__rootNamespaces = [NNP];
NNP.__registeredTypes = {};
NNP.Error = {
    __typeName: 'Error',
    __class: true,
    create: function Error$create(message, errorInfo) {
        var e = new Error(message);
        e.message = message;
        if (errorInfo) {
            for (var v in errorInfo) {
                e[v] = errorInfo[v];
            }
        }
        e.popStackFrame();
        return e;
    }
}
NNP.registerClass = function NNP$registerClass(typeName, baseType) {
    if (NNP.__registeredTypes[typeName]) throw NNP.Error.create("typeName" + typeName, "typeName" + typeName + " is Registered Twice.");
    if ((arguments.length > 1) && (typeof (baseType) === 'undefined')) throw NNP.Error.create('invalid argument baseType');
    this.prototype.constructor = this;
    this.__typeName = typeName;
    this.__class = true;
    if (baseType) {
        this.__baseType = baseType;
        this.__basePrototypePending = true;
    }
    NNP.__upperCaseTypes[typeName.toUpperCase()] = this;
    NNP.__registeredTypes[typeName] = true;
    return this;
}
NNP.registerNamespace = function NNP$registerNamespace(namespacePath) {
    var rootObject = window;
    var namespaceParts = namespacePath.split('.');
    for (var i = 0; i < namespaceParts.length; i++) {
        var currentPart = namespaceParts[i];
        var ns = rootObject[currentPart];
        if (ns && !ns.__namespace) {
            throw NNP.Error.create("namespacePath:" + namespacePath, "namespacePath " + typeName + " is Registered Twice.");
        }
        if (!ns) {
            ns = rootObject[currentPart] = {
                __namespace: true,
                __typeName: namespaceParts.slice(0, i + 1).join('.')
            };
            if (i === 0) {
                NNP.__rootNamespaces[NNP.__rootNamespaces.length] = ns;
            }
            var parsedName;
            try {
                parsedName = eval(ns.__typeName);
            }
            catch (e) {
                parsedName = null;
            }
            if (parsedName !== ns) {
                delete rootObject[currentPart];
                throw Error.create('namespacePath', "invalid NameSpace");
            }
            ns.getName = function ns$getName() { return this.__typeName; }
        }
        rootObject = ns;
    }
}
NNP.__rootNamespaces = [NNP];
NNP.__registeredTypes = {};

NNP.Browser = {};
NNP.Browser.InternetExplorer = {};
NNP.Browser.Firefox = {};
NNP.Browser.Safari = {};
NNP.Browser.Opera = {};
NNP.Browser.agent = null;
NNP.Browser.hasDebuggerStatement = false;
NNP.Browser.name = navigator.appName;
NNP.Browser.version = parseFloat(navigator.appVersion);
NNP.Browser.documentMode = 0;
if (navigator.userAgent.indexOf(' MSIE ') > -1) {
    NNP.Browser.agent = NNP.Browser.InternetExplorer;
    NNP.Browser.version = parseFloat(navigator.userAgent.match(/MSIE (\d+\.\d+)/)[1]);
    if (NNP.Browser.version >= 8) {
        if (document.documentMode >= 7) {
            NNP.Browser.documentMode = document.documentMode;
        }
    }
    NNP.Browser.hasDebuggerStatement = true;
}
else if (navigator.userAgent.indexOf(' Firefox/') > -1) {
    NNP.Browser.agent = NNP.Browser.Firefox;
    NNP.Browser.version = parseFloat(navigator.userAgent.match(/ Firefox\/(\d+\.\d+)/)[1]);
    NNP.Browser.name = 'Firefox';
    NNP.Browser.hasDebuggerStatement = true;
}
else if (navigator.userAgent.indexOf(' AppleWebKit/') > -1) {
    NNP.Browser.agent = NNP.Browser.Safari;
    NNP.Browser.version = parseFloat(navigator.userAgent.match(/ AppleWebKit\/(\d+(\.\d+)?)/)[1]);
    NNP.Browser.name = 'Safari';
}
else if (navigator.userAgent.indexOf('Opera/') > -1) {
    NNP.Browser.agent = NNP.Browser.Opera;
}
NNP.UI = {};
NNP.UI.DomElement = {};
NNP.UI.DomElement._getCurrentStyle = function(element) {

}
NNP.UI.Point = function(x, y) {
    var point = new Object();
    point.x = x;
    point.y = y;
    return point;
}
switch (NNP.Browser.agent) {
    case NNP.Browser.InternetExplorer:
        NNP.UI.DomElement.getLocation = function NNP$UI$DomElement$getLocation(element) {
            if (element.self || element.nodeType === 9) return new NNP.UI.Point(0, 0);
            var clientRect = element.getBoundingClientRect();
            if (!clientRect) {
                return new NNP.UI.Point(0, 0);
            }
            var documentElement = element.ownerDocument.documentElement;
            var offsetX = clientRect.left - 2 + documentElement.scrollLeft,
                offsetY = clientRect.top - 2 + documentElement.scrollTop;

            try {
                var f = element.ownerDocument.parentWindow.frameElement || null;
                if (f) {
                    var offset = (f.frameBorder === "0" || f.frameBorder === "no") ? 2 : 0;
                    offsetX += offset;
                    offsetY += offset;
                }
            }
            catch (ex) {
            }

            return new NNP.UI.Point(offsetX, offsetY);
        }
        break;
    case NNP.Browser.Safari:
        NNP.UI.DomElement.getLocation = function NNP$UI$DomElement$getLocation(element) {
            if ((element.window && (element.window === element)) || element.nodeType === 9) return new NNP.UI.Point(0, 0);
            var offsetX = 0;
            var offsetY = 0;
            var previous = null;
            var previousStyle = null;
            var currentStyle;
            for (var parent = element; parent; previous = parent, previousStyle = currentStyle, parent = parent.offsetParent) {
                currentStyle = NNP.UI.DomElement._getCurrentStyle(parent);
                var tagName = parent.tagName ? parent.tagName.toUpperCase() : null;
                if ((parent.offsetLeft || parent.offsetTop) &&
                    ((tagName !== "BODY") || (!previousStyle || previousStyle.position !== "absolute"))) {
                    offsetX += parent.offsetLeft;
                    offsetY += parent.offsetTop;
                }
            }
            currentStyle = NNP.UI.DomElement._getCurrentStyle(element);
            var elementPosition = currentStyle ? currentStyle.position : null;
            if (!elementPosition || (elementPosition !== "absolute")) {
                for (var parent = element.parentNode; parent; parent = parent.parentNode) {
                    tagName = parent.tagName ? parent.tagName.toUpperCase() : null;
                    if ((tagName !== "BODY") && (tagName !== "HTML") && (parent.scrollLeft || parent.scrollTop)) {
                        offsetX -= (parent.scrollLeft || 0);
                        offsetY -= (parent.scrollTop || 0);
                    }
                    currentStyle = NNP.UI.DomElement._getCurrentStyle(parent);
                    var parentPosition = currentStyle ? currentStyle.position : null;
                    if (parentPosition && (parentPosition === "absolute")) break;
                }
            }
            return new NNP.UI.Point(offsetX, offsetY);
        }
        break;
    case NNP.Browser.Opera:
        NNP.UI.DomElement.getLocation = function NNP$UI$DomElement$getLocation(element) {
            if ((element.window && (element.window === element)) || element.nodeType === 9) return new NNP.UI.Point(0, 0);
            var offsetX = 0;
            var offsetY = 0;
            var previous = null;
            for (var parent = element; parent; previous = parent, parent = parent.offsetParent) {
                var tagName = parent.tagName;
                offsetX += parent.offsetLeft || 0;
                offsetY += parent.offsetTop || 0;
            }
            var elementPosition = element.style.position;
            var elementPositioned = elementPosition && (elementPosition !== "static");
            for (var parent = element.parentNode; parent; parent = parent.parentNode) {
                tagName = parent.tagName ? parent.tagName.toUpperCase() : null;
                if ((tagName !== "BODY") && (tagName !== "HTML") && (parent.scrollLeft || parent.scrollTop) &&
                    ((elementPositioned &&
                    ((parent.style.overflow === "scroll") || (parent.style.overflow === "auto"))))) {
                    offsetX -= (parent.scrollLeft || 0);
                    offsetY -= (parent.scrollTop || 0);
                }
                var parentPosition = (parent && parent.style) ? parent.style.position : null;
                elementPositioned = elementPositioned || (parentPosition && (parentPosition !== "static"));
            }
            return new NNP.UI.Point(offsetX, offsetY);
        }
        break;
    default:
        NNP.UI.DomElement.getLocation = function NNP$UI$DomElement$getLocation(element) {
            if ((element.window && (element.window === element)) || element.nodeType === 9) return new NNP.UI.Point(0, 0);
            var offsetX = 0;
            var offsetY = 0;
            var previous = null;
            var previousStyle = null;
            var currentStyle = null;
            for (var parent = element; parent; previous = parent, previousStyle = currentStyle, parent = parent.offsetParent) {
                var tagName = parent.tagName ? parent.tagName.toUpperCase() : null;
                currentStyle = NNP.UI.DomElement._getCurrentStyle(parent);
                if ((parent.offsetLeft || parent.offsetTop) &&
                    !((tagName === "BODY") &&
                    (!previousStyle || previousStyle.position !== "absolute"))) {
                    offsetX += parent.offsetLeft;
                    offsetY += parent.offsetTop;
                }
                if (previous !== null && currentStyle) {
                    if ((tagName !== "TABLE") && (tagName !== "TD") && (tagName !== "HTML")) {
                        offsetX += parseInt(currentStyle.borderLeftWidth) || 0;
                        offsetY += parseInt(currentStyle.borderTopWidth) || 0;
                    }
                    if (tagName === "TABLE" &&
                        (currentStyle.position === "relative" || currentStyle.position === "absolute")) {
                        offsetX += parseInt(currentStyle.marginLeft) || 0;
                        offsetY += parseInt(currentStyle.marginTop) || 0;
                    }
                }
            }
            currentStyle = NNP.UI.DomElement._getCurrentStyle(element);
            var elementPosition = currentStyle ? currentStyle.position : null;
            if (!elementPosition || (elementPosition !== "absolute")) {
                for (var parent = element.parentNode; parent; parent = parent.parentNode) {
                    tagName = parent.tagName ? parent.tagName.toUpperCase() : null;
                    if ((tagName !== "BODY") && (tagName !== "HTML") && (parent.scrollLeft || parent.scrollTop)) {
                        offsetX -= (parent.scrollLeft || 0);
                        offsetY -= (parent.scrollTop || 0);
                        currentStyle = NNP.UI.DomElement._getCurrentStyle(parent);
                        if (currentStyle) {
                            offsetX += parseInt(currentStyle.borderLeftWidth) || 0;
                            offsetY += parseInt(currentStyle.borderTopWidth) || 0;
                        }
                    }
                }
            }
            return new NNP.UI.Point(offsetX, offsetY);
        }
        break;
}
NNP.NNPAjax = function() {
    var _this = this;
    this._url = "";
    this._customMethod = null;
    this._xmlHttpRequest = null;
}
NNP.NNPAjax.prototype = {
    execute: function() {
        this._initXmlHttp();
        this._xmlHttpRequest.onreadystatechange = this.createDelegate(this, this._xmlHttpRequestCompleted);
        this._xmlHttpRequest.open("GET", this._url, true);
        this._xmlHttpRequest.send(null);
    },
    createDelegate: function Function$createDelegate(instance, method) {
        return function() {
            return method.apply(instance, arguments);
        }
    }
    ,
    _initXmlHttp: function() {
        try {
            this._xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
            try {
                this._xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {
                this._xmlHttpRequest = null;
            }
        }
        if (!this._xmlHttpRequest && typeof XMLHttpRequest != 'undefined') {
            this._xmlHttpRequest = new XMLHttpRequest();
        }
    }
    ,
    _xmlHttpRequestCompleted: function() {
        if (this._xmlHttpRequest.readyState == 4) {
            try {

                this._customMethod(this._xmlHttpRequest.responseText);
                return;

            }
            catch (e) {
                alert(e);
            }
        }
    }
};