NNP.registerNamespace('NNPControlToolkit');
NNPControlToolkit.Form = function() {

    this._id = "form1" + new Date().getMilliseconds().toString();
    this._form = null;
    this._customFunction = null;
    this._customWindow = null;
    this._returnValue = null;
    this._backScreenControl = null;
    this._header = null;
    this._iframe = null;
    this._hidText = null;
    this._dialogbody = null;
    this._body = null;
    this._caption = null;
    this._captionControl = null;
    this._text = null;
    this._textControl = null;
    this._imageControl = null;
    this._image = null;
    this._src = null;
    this._dialogResult = null;
    this._acceptButton = null;
    this._cancleButton = null;
    this._width = null;
    this._height = null;
    this._visible = null;
    this._backScreenColor = null;
    this._enableBackScreen = null;
    this._opacity = null;
    this._top = null;
    this._left = null;
    //Golshan
    this._isdivpanel = 0;
    this._okdialogclick$delegates = {
        click: NNP.createDelegate(this, this._okdialog_onclick)
    }
    this._cancledialogclick$delegates = {
        click: NNP.createDelegate(this, this._cancledialog_onclick)
    }
    this._drag$delegates = {
        mousedown: NNP.createDelegate(this, this._drag_onmousedown),
        click: NNP.createDelegate(this, this._drag_onclick)
    }
    this._click$delegates = {
        click: NNP.createDelegate(this, this._close_onclick)
    }

};
NNPControlToolkit.Form.prototype = {
    show: function(text, src, width, height, img) {
        this.buildbackScreen();
        this.buildform();
        this.buildheader();
        this.buildbody();
        this.set_text();
        this._src = src;
        if (typeof (text) != "undefined")
        { this.set_text(text); }
        if (typeof (src) != "undefined") {
            if (this._isdivpanel == 1) {
                this.set_innerHTML(src);
                if (height == 0) height = document.getElementById(src).offsetHeight + 30;
                if (width == 0) width = document.getElementById(src).offsetWidth;
            }
            else
                this.set_src(src);
        }
        if (typeof (width) != "undefined")
        { this.set_width(width); }
        if (typeof (height) != "undefined")
        { this.set_height(height); }
        if (typeof (img) != "undefined")
        { if (img != "") { this._imageControl.style.backgroundImage = "url(" + img + ")"; } }
        this.get_centerPage();
        //maha95
        if (height > $(window).height()) {
            this.set_height($(window).height() - 40);
            this._form.style.top = "20px";
        }
        else
            this._form.style.top = ($(window).height() - height) / 2 + "px";
        //
    },
    showdialog: function(text, caption, width, height, icon, buttons) {
        this.buildbackScreen();
        this.buildform();
        this.buildheader();
        this.builddialogbody(buttons);
        this.set_text();
        if (typeof (caption) != "undefined")
        { this.set_text(caption); }
        if (typeof (text) != "undefined")
        { this.set_caption(text); }
        if (typeof (src) != "undefined")
        { this.set_src(src); }
        if (typeof (width) != "undefined")
        { this.set_width(width); }
        if (typeof (height) != "undefined")
        { this.set_height(height); }
        if (typeof (icon) != "undefined")
        { if (icon != "") { this._imageControl.style.backgroundImage = "url(" + icon + ")"; } }
        this.get_centerPage();
        //maha95
        if (height > $(window).height()) {
            this.set_height($(window).height() - 40);
            this._form.style.top = "20px";
        }
        else
            this._form.style.top =($(window).height() - height )/2 + "px";
        //
    }
    ,
    buildbackScreen: function() {
        this._backScreenControl = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_backScreen" }
        }, document.body);
        NNP.setElementOpacity(this._backScreenControl, 0.4);
        this._backScreenControl.style.width = "100%";
        this._backScreenControl.style.height = "100%";
        this._backScreenControl.style.backgroundColor = "#f4efbd";
        //maha befor this._backScreenControl.style.position = "fixed";
        //maha13950629 for BS this._backScreenControl.style.position = "absolute";
        this._backScreenControl.style.position = "fixed";
        this._backScreenControl.style.top = "0px";
        this._backScreenControl.style.left = "0px";
        this._backScreenControl.style.zIndex = "1900";



    },
    buildform: function() {
        this._form = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_form" },
            cssClasses: ["ajax__form_form"]
        }, document.body);
        this._hidText = NNP.createElementFromTemplate({
            nodeName: "input",
            properties: { id: this._id + "_form", type: "text" }
        }, this._form);
        this._hidText.style.display = 'none';
    },
    buildheader: function() {
        this._header = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_header" },
            cssClasses: ["ajax__form_header"],
            events: this._drag$delegates
        }, this._form);
        var headerBody = NNP.createElementFromTemplate({
            nodeName: "table",
            properties: { id: this._id + "_headerbody", border: 0, cellPadding: 0, cellSpacing: 0 },
            cssClasses: ["ajax__form_headerbody"]
        }, this._header);
        var headerRow = headerBody.insertRow(0);
        headerRow.className = "ajax__form_headerRow";
        var ind = 0;
        var headerCellLeftl = headerRow.insertCell(ind);
        headerCellLeftl.className = "ajax__form_headerCellLeftl";
        ind++;
        var headerCellLeft = headerRow.insertCell(ind);
        ind++;
        var headerCellMiddle = headerRow.insertCell(ind);
        headerCellMiddle.className = "ajax__form_headerCellMiddle";
        ind++;
        var headerCellRight = headerRow.insertCell(ind);
        headerCellRight.className = "ajax__form_headerCellRight";
        ind++;
        var headerCellRightr = headerRow.insertCell(ind);
        headerCellRightr.className = "ajax__form_headerCellRightr";
        headerCellLeft.className = "ajax__form_headerCellLeft";
        this._imageControl = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_image" },
            cssClasses: ["ajax__form_imageControl"]
        }, headerCellLeft);
        this._textControl = NNP.createElementFromTemplate({
            nodeName: "span",
            properties: { id: this._id + "_span" },
            cssClasses: ["ajax__form_textControl"]
        }, headerCellLeft);
        headerCellRight.style.width = "16px";
        var closeButton = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_close", title: "" },//خروج
            cssClasses: ["ajax__form_close"],
            events: this._click$delegates
        }, headerCellRight);
    },
    builddialogbody: function(buttons) {
        buttons = buttons.split('|');
        this._body = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_body" },
            cssClasses: ["ajax__form_body"]
        }, this._form);
        this._dialogbody = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_dialogbody" },
            cssClasses: ["ajax__form_body"]
        }, this._body);
        var topdialog = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_topdialog" },
            cssClasses: ["ajax__form_topdialog"]
        }, this._dialogbody);
        var bottomdialog = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_bottomdialog" },
            cssClasses: ["ajax__form_bottomdialog"]
        }, this._dialogbody);
        this._captionControl = NNP.createElementFromTemplate({
            nodeName: "span",
            properties: { id: this._id + "_captionText" },
            cssClasses: ["ajax__form_captionText"]
        }, topdialog);
        for (var i = 0; i < buttons.length; i++) {
            switch (buttons[i].toUpperCase()) {
                case "OK":
                    var btnok = NNP.createElementFromTemplate({
                        nodeName: "input",
                        properties: { id: this._id + "_btnok", type: "button", value: "تایید" },
                        events: this._okdialogclick$delegates
                    }, bottomdialog);
                    break;
                case "CANCLE":
                    var btncancle = NNP.createElementFromTemplate({
                        nodeName: "input",
                        properties: { id: this._id + "_btncancle", type: "button", value: "انصراف" },
                        events: this._cancledialogclick$delegates
                    }, bottomdialog);
                    break;
            }
        }
    },
    buildbody: function() {
        this._body = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this._id + "_body" },
            cssClasses: ["ajax__form_body"]
        }, this._form);
        this._iframe = NNP.createElementFromTemplate({
            nodeName: "iframe",
            properties: { id: this._id + "_iframe",
                frameBorder: 0, frameSpacing: 0, border: 0
            },
            cssClasses: ["ajax__form_iframe"]
        }, this._body);

    }, _okdialog_onclick: function(e) {
        this.close(true);
    }
    , _cancledialog_onclick: function(e) {
        this.close(false);
    }
    , _close_onclick: function(e) {
        this.close();
    },
    _drag_onmousedown: function(e) {
        if (this._form.style.zIndex == 0)
            this._form.style.zIndex = 2000;
        this._form.style.zIndex = parseInt(this._form.style.zIndex) + 1;
        NNP.Drag(this._header.offsetParent, e || window.event);
    },
    _drag_onclick: function(e) {
        if (this._form.style.zIndex == 0)
            this._form.style.zIndex = 2000;
        this._form.style.zIndex = parseInt(this._form.style.zIndex) + 1;
    },
    set_id: function(id) { this._form.id = this._id = id; },
    set_text: function(text) { if (NNP.Browser.name != 'Microsoft Internet Explorer' && NNP.Browser.name != 'Safari') this._textControl.textContent = text; else this._textControl.innerText = text; this._text = text; },
    set_caption: function(caption) { if (NNP.Browser.name != 'Microsoft Internet Explorer' && NNP.Browser.name != 'Safari') this._captionControl.textContent = caption; else this._captionControl.innerText = caption; this._caption = caption; },
    set_width: function(width) { this._form.style.width = width + "px"; this._width = width; },
    set_height: function(height) {
        this._form.style.height = height + "px"; this._height = height;
        this.get_centerPage();
    },
    set_opacity: function(opacity) { this._form.style.filter = 'alpha(opacity=' + opacity + ')'; },
    get_centerPage: function() { this._form.style.left = NNP.GetCenterScreen(this._width, this._height).x + "px"; this._left = NNP.GetCenterScreen(this._width, this._height).x; this._form.style.top = NNP.GetCenterScreen(this._width, this._height).y + "px"; this._top = NNP.GetCenterScreen(this._width, this._height).y; },
    set_top: function(top) { this._form.style.top = NNP.GetCenterScreen(this._width, this._height).y + "px"; this._top = NNP.GetCenterScreen(this._width, this._height).y; },
    set_left: function(left) { this._form.style.left = NNP.GetCenterScreen(this._width, this._height).x + "px"; this._left = NNP.GetCenterScreen(this._width, this._height).x; },
    set_image: function(img) { if (img != "") { this._imageControl.style.backgroundImage = "url(" + img + ")"; } },
    set_src: function(src) { this._iframe.src = src; },
    set_innerHTML: function(src) {
            document.getElementById(src).style.visibility = 'visible';
            document.getElementById(src).style.display = '';
            this._form.appendChild(document.getElementById(src));
    },
    set_backScreenColor: function(backScreenColor) { },
    set_enableBackScreen: function(enableBackScreen) { },
    set_dialogResult: function(dialogResult) { },
    set_visible: function(visible) {
        if (visible) {
            this._form.style.display = "";
            this._backScreenControl.style.display = "";
        }
        else {
            this._form.style.display = "none";
            this._backScreenControl.style.display = "none";
        }
    },
    set_acceptButton: function(acceptButton) { },
    set_cancleButton: function(cancleButton) { },
    get_height: function() { return this._form.style.height; },
    get_width: function() { return this._form.style.width; },
    close: function(value) {
        this._hidText.style.display = '';
        this._hidText.focus();
        if (value != null) {
            this._returnValue = value;
        }
        else {
            this._returnValue = '';
        }
        if (this._isdivpanel == 1) {
            document.getElementById(this._src).style.display = "none";
            document.body.appendChild(document.getElementById(this._src));
            
            
        }

        NNP.$rem(this._backScreenControl.id, document.body);
        NNP.$rem(this._form.id, document.body);

        if (this._customFunction != null)
        { this._customFunction(); }
    }
};