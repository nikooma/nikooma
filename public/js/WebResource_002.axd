NNP.registerNamespace('NNPControlToolkit');
NNPControlToolkit.Calendar = function(element) {
    this._textbox = NNP.$get(element + "_TextDate");
    this._textbox.className = "ajax__calendar_textBox";
    this._id = element;
    this._format = "d";
    this._dateFormat = null;
    this._language = null;
    this._languageBody = null;
    this._cssClass = "ajax__calendar";
    this._enabled = true;
    this._button = NNP.$get("btn_ShowCalendar");
    this._selectedDate = { day: null, month: null, year: null };
    this._selectedDateEn = { day: null, month: null, year: null };
    this._todaysDate = null;
    this._width = 170;
    this._height = 139;
    this._firstDayOfWeek = null;
    this._dkSolar = 0;
    this._dkGregorian = 1;
    this._monthsCode = [[3, 1, -1, -3], [11, 9, 7, 5], [19, 17, 15, 13]];
    this._daysCode = [[6, 6, 4, 4, 2, 2, 0], [17, 15, 13, 11, 9, 7, 5], [25, 23, 21, 19, 17, 15, 13]];
    this._daysOfMonths = [[31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29], [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]];
    this._leapMonth = [12, 2];
    this._daysToMonth = [[0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365], [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365]];
    this._modes = { "days": null, "months": null, "years": null };
    this._modeOrder = { "days": 0, "months": 1, "years": 2 };
    this._daysTitle = ["ج", "پ", "چ", "س", "د", "ی", "ش"];
    this._daysTitleEnShortest = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
    this._daysTitleEn = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thurstay", "Friday", "Saturday"];
    this._daysTitleCodeEn = { "Su": 0, "Mo": 1, "Tu": 2, "We": 3, "Th": 4, "Fr": 5, "Sa": 6 };
    this._daysTitleCodeFa = { 5: 3, 4: 2, 3: 1, 2: 0, 1: 6, 0: 5, 6: 4 };
    this._daysTitleFa = { 0: "جمعه", 1: "پنجشنبه", 2: "چهارشنبه", 3: "سه شنبه", 4: "دوشنبه", 5: "یکشنبه", 6: "شنبه" };
    this._monthTitle = ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"];
    this._monthTitleEn = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    this._monthTitleEnShortest = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    this._mode = "days";
    this._isOpen = false;

    this._container = null;
    this._header = null;
    this._fotter = null;
    this._prevArrow = null;
    this._nextArrow = null;
    this._title = null;
    this._body = null;
    this._today = null;
    this._days = null;
    this._daysTable = null;
    this._daysTableHeader = null;
    this._daysBody = null;
    this._months = null;
    this._monthsTable = null;
    this._monthsBody = null;
    this._years = null;
    this._yearsTable = null;
    this._yearsBody = null;
    this._visibleDate = null;
    this._topmovepluse = null;
    this._topmoveminus = null;
    this._animation = null;
    this._hourOffsetForDst = 12;
    this._textbox$delegate = {
        onkeydown: NNP.createDelegate(this, this._textbox_onkeydown)
    }
    this._cell$delegates = {
        click: NNP.createDelegate(this, this._cell_onclick)
    }

};
NNPControlToolkit.Calendar.prototype = {
    _initial: function(e) {
        this._topmovepluse = new NNPControlToolkit.Animation();
        this._topmoveminus = new NNPControlToolkit.Animation();
        this._animation = new NNPControlToolkit.ParallelAnimation();
        NNP.stopPropagation(e);
        NNP.$addHandler(document, 'click', NNP.createDelegate(this, function() { this._dispose(); }));
        this._buildCalendar();
        this._buildHeader();
        this._buildBody();
        this._buildFooter();
        this._set_today();

        if (this._textbox.value != "") {
            var dateformat = /^(([1-9][0-9][0-9][0-9])\/([0-1][0-2]|[0][0-9]|[0-9])\/([1-2][0-9]|[0][0-9]|[0-9]|[3][0-1]))$/;
            if (dateformat.test(NNP.makeEnglishNum(this._textbox.value.toString()))) {
                var sDate = this._textbox.value.split('/');
                //maha
                if (sDate[0] < '1800') { this._textbox.setAttribute('language', 'Fa'); }
                else
                if (NNP.isEnglishChar(sDate[0])) {
                    this._textbox.setAttribute('language', 'En');
                }
                else { this._textbox.setAttribute('language', 'Fa'); }

                if (this._textbox.getAttribute('language') == "Fa") {
                    this._selectedDate.year = parseInt(NNP.makeEnglishNum(sDate[0]));
                    if (sDate[1].substr(0, 1).toString() == NNP.makeFarsiNum("0").toString())
                    { this._selectedDate.month = parseInt(NNP.makeEnglishNum(sDate[1].substr(1, 1))); }
                    else {
                        this._selectedDate.month = parseInt(NNP.makeEnglishNum(sDate[1]));
                    }
                    if (sDate[2].substr(0, 1).toString() == NNP.makeFarsiNum("0").toString()) {
                        this._selectedDate.day = parseInt(NNP.makeEnglishNum(sDate[2].substr(1, 1)));
                    }
                    else {
                        this._selectedDate.day = parseInt(NNP.makeEnglishNum(sDate[2]));
                    }
                }
                else if (this._textbox.getAttribute('language') == "En") {
                    this._selectedDateEn.year = parseInt(sDate[0]);
                    this._selectedDateEn.month = parseFloat(sDate[1]) - 1;
                    this._selectedDateEn.day = parseFloat(sDate[2]);
                }
            }
        }
        if (this._textbox.getAttribute('langtype') == "MD")
        { this._dateFormat = "MD"; }
        else if (this._textbox.getAttribute('langtype') == "Hijri")
        { this._dateFormat = "Hijri"; }
        else { this._dateFormat = null; }
        this._language = this._textbox.getAttribute('language');
        this._Invalidate();
    },
    getLanguageTitle: function(lang) {
        if (lang == "Fa")
            return "میلادی";
        else return "شمسی";
    }
    ,
    _Invalidate: function() {
        if (NNP.Browser.name != 'Microsoft Internet Explorer' && NNP.Browser.name != 'Safari')
            this._languageBody.textContent = this.getLanguageTitle(this._language);
        else this._languageBody.innerText = this.getLanguageTitle(this._language);
        this._languageBody.style.color = "#ffffff";
        if (this._language == "Fa") {
            switch (this._mode) {
                case "days":
                    this._set_today_title();
                    for (var i = 0; i < this._daysTableHeaderRow.cells.length; i++) {
                        this._daysTableHeaderRow.cells[i].firstChild.innerHTML = this._daysTitle[i];
                        this._daysTableHeaderRow.cells[i].firstChild.title = "";//maha96 this._daysTitleFa[i];
                    }
                    var visibleDate = new NNPControlToolkit.Date(this._selectedDate.year, this._selectedDate.month, 1);
                    this._firstDayOfWeek = visibleDate.getFirstDayOfWeek();
                    daysToBacktrack = visibleDate.getDay() - this._firstDayOfWeek;
                    if (daysToBacktrack <= 0)
                        daysToBacktrack += 7;
                    var startDate = new NNPControlToolkit.Date(visibleDate.getFullYear(), visibleDate.getMonth(), visibleDate.getDate());
                    startDate.addDay(-daysToBacktrack);
                    var currentDate = startDate;
                    for (var week = 0; week < 6; week++) {
                        var weekRow = this._daysBody.rows[week];
                        for (var dayOfWeek = 6; dayOfWeek >= 0; dayOfWeek--) {

                            var dayCell = weekRow.cells[dayOfWeek].firstChild;
                            var fdate = [currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()];
                            if (this._dateFormat == null) {
                                dayCell.date = NNP.makeFarsiNum(fdate[0]) + "/" + NNP.makeFarsiNum(fdate[1]) + "/" + NNP.makeFarsiNum(fdate[2]);
                            }
                            else if (this._dateFormat == "Hijri") {
                                dayCell.date = NNP.makeFarsiNum(fdate[0]) + "/" + NNP.makeFarsiNum(fdate[1]) + "/" + NNP.makeFarsiNum(fdate[2]);
                            }
                            else if (this._dateFormat == "MD") {
                                var D = new NNPControlToolkit.Date();
                                cdate = D.getSolarToMD(parseFloat(NNP.makeEnglishNum(fdate[0])), parseFloat(NNP.makeEnglishNum(fdate[1])), parseFloat(NNP.makeEnglishNum(fdate[2])));
                                dayCell.date = cdate[0] + "/" + cdate[1] + "/" + cdate[2];
                            }
                            //else weekRow.cells[dayOfWeek].className = "";
                            if (fdate[1] != this._selectedDate.month)
                                weekRow.cells[dayOfWeek].className = "ajax__calendar_day_other";
                            else if (fdate[0] + "/" + fdate[1] + "/" + fdate[2] == this._selectedDate.year + "/" + this._selectedDate.month + "/" + this._selectedDate.day)
                            { weekRow.cells[dayOfWeek].className = "ajax__calendar_day_active"; }
                            else weekRow.cells[dayOfWeek].className = "";
                            //maha1395 dayCell.title = this._daysTitleFa[dayOfWeek] + " , " + currentDate.localeFormat("D");
                            dayCell.innerHTML = NNP.makeFarsiNum(fdate[2]);
                            currentDate = new NNPControlToolkit.Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());
                            currentDate.addDay(1);
                        }
                    }
                    this._title.innerHTML = NNP.makeFarsiNum(this._selectedDate.year) + "," + this._monthTitle[this._selectedDate.month - 1];
                    this._title.date = this._selectedDate.year + "/" + this._selectedDate.month + "/" + this._selectedDate.day;
                    break;
                case "months":
                    for (var i = 0; i < this._monthsBody.rows.length; i++) {
                        for (var j = 0; j < this._monthsBody.rows[i].cells.length; j++) {

                            var _monthCell = this._monthsBody.rows[i].cells[j].firstChild;
                            _monthCell.month = this._monthsCode[i][j] - (i * 4) + j;
                            _monthCell.date = this._monthsCode[i][j] - (i * 4) + j;
                            _monthCell.innerHTML = "<br />" + this._monthTitle[this._monthsCode[i][j] - (i * 4) + j];
                            if (_monthCell.date + 1 == this._selectedDate.month)
                                this._monthsBody.rows[i].cells[j].className = "ajax__calendar_month_active";
                            else this._monthsBody.rows[i].cells[j].className = "";
                        }
                    }
                    this._title.innerHTML = NNP.makeFarsiNum(this._selectedDate.year);
                    this._title.date = this._selectedDate.year;
                    break;
                case "years":
                    var backTrach = this._selectedDate.year % 10;
                    var startYear = this._selectedDate.year - backTrach;
                    var tmpstartYear = this._selectedDate.year - backTrach;
                    for (var i = 0; i < this._yearsBody.rows.length; i++) {
                        for (var j = 0; j < this._yearsBody.rows[i].cells.length; j++) {

                            var yearCell = this._yearsBody.rows[i].cells[j].firstChild;
                            yearCell.innerHTML = "<br />" + NNP.makeFarsiNum(startYear);
                            if (startYear == this._selectedDate.year)
                                this._yearsBody.rows[i].cells[j].className = "ajax__calendar_year_active";
                            else this._yearsBody.rows[i].cells[j].className = "";
                            yearCell.date = startYear;
                            yearCell.title = NNP.makeFarsiNum(startYear);
                            startYear++;
                        }
                    }
                    this._title.innerHTML = NNP.makeFarsiNum(tmpstartYear) + "-" + NNP.makeFarsiNum((parseInt(tmpstartYear) + 11));
                    this._title.date = NNP.makeFarsiNum(tmpstartYear) + "-" + NNP.makeFarsiNum((parseInt(tmpstartYear) + 11));
                    break;
            }
        }
        else if (this._language == "En") {
            switch (this._mode) {
                case "days":
                    this._set_today_title();
                    for (var i = 0; i < this._daysTableHeaderRow.cells.length; i++) {
                        this._daysTableHeaderRow.cells[i].firstChild.innerHTML = this._daysTitleEnShortest[i];
                        this._daysTableHeaderRow.cells[i].firstChild.title = this._daysTitleEn[i];
                    }
                    var visibleDate = new Date(this._selectedDateEn.year, this._selectedDateEn.month, this._selectedDateEn.day);
                    visibleDate.setDate(1);
                    this._firstDayOfWeek = 0;
                    daysToBacktrack = visibleDate.getDay() - this._firstDayOfWeek;
                    if (daysToBacktrack <= 0)
                        daysToBacktrack += 7;
                    var startDate = new Date(visibleDate.getFullYear(), visibleDate.getMonth(), visibleDate.getDate() - daysToBacktrack);
                    //startDate.addDay();
                    var currentDate = startDate;
                    for (var week = 0; week < 6; week++) {
                        var weekRow = this._daysBody.rows[week];
                        for (var dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {

                            var dayCell = weekRow.cells[dayOfWeek].firstChild;
                            var fdate = [currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()];

                            //else weekRow.cells[dayOfWeek].className = "";
                            if (fdate[1] != this._selectedDateEn.month)
                                weekRow.cells[dayOfWeek].className = "ajax__calendar_day_other";
                            else if (fdate[0] + "/" + fdate[1] + "/" + fdate[2] == this._selectedDateEn.year + "/" + this._selectedDateEn.month + "/" + this._selectedDateEn.day)
                            { weekRow.cells[dayOfWeek].className = "ajax__calendar_day_active"; }
                            else weekRow.cells[dayOfWeek].className = "";

                            if (this._dateFormat == null) {
                                if (NNP.Browser.name == 'Safari')
                                    dayCell.date = currentDate.getFullYear() + "/" + currentDate.getMonth() + "/" + currentDate.getDate();
                                else
                                    dayCell.date = currentDate.toLocaleDateString();
                            }
                            else if (this._dateFormat == "Hijri") {
                                var D = new NNPControlToolkit.Date();
                                cdate = D.getMDToSolar(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());
                                dayCell.date = NNP.makeFarsiNum(parseFloat(cdate[0])) + "/" + NNP.makeFarsiNum(parseFloat(cdate[1])) + "/" + NNP.makeFarsiNum(parseFloat(cdate[2]));
                            }
                            else if (this._dateFormat == "MD") {
                                if (NNP.Browser.name == 'Safari')
                                    dayCell.date = currentDate.getFullYear() + "/" + currentDate.getMonth() + "/" + currentDate.getDate();
                                else
                                    dayCell.date = currentDate.toLocaleDateString();
                            }
                            //maha1395 dayCell.title = currentDate.toLocaleDateString();
                            dayCell.innerHTML = NNP.makeEnglishNum(fdate[2]);
                            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() + 1, this._hourOffsetForDst);
                            //currentDate.addDay(1);
                        }

                    }
                    this._title.innerHTML = this._selectedDateEn.year + "," + this._monthTitleEn[this._selectedDateEn.month];
                    this._title.date = this._selectedDateEn.year + "/" + this._selectedDateEn.month + "/" + this._selectedDateEn.day;
                    break;
                case "months":
                    for (var i = 0; i < this._monthsBody.rows.length; i++) {
                        for (var j = 0; j < this._monthsBody.rows[i].cells.length; j++) {
                            var _monthCell = this._monthsBody.rows[i].cells[j].firstChild;
                            _monthCell.month = (i * 4) + j;
                            _monthCell.date = (i * 4) + j;
                            _monthCell.innerHTML = "<br />" + this._monthTitleEnShortest[(i * 4) + j];
                            if (_monthCell.date + 1 == this._selectedDateEn.month)
                                this._monthsBody.rows[i].cells[j].className = "ajax__calendar_month_active";
                            else this._monthsBody.rows[i].cells[j].className = "";
                        }
                    }
                    this._title.innerHTML = this._selectedDateEn.year;
                    this._title.date = this._selectedDateEn.year;
                    break;
                case "years":
                    var backTrach = this._selectedDateEn.year % 10;
                    var startYear = this._selectedDateEn.year - backTrach;
                    var tmpstartYear = this._selectedDateEn.year - backTrach;
                    for (var i = 0; i < this._yearsBody.rows.length; i++) {
                        for (var j = 0; j < this._yearsBody.rows[i].cells.length; j++) {

                            var yearCell = this._yearsBody.rows[i].cells[j].firstChild;
                            yearCell.innerHTML = "<br />" + startYear;
                            if (startYear == this._selectedDateEn.year)
                                this._yearsBody.rows[i].cells[j].className = "ajax__calendar_year_active";
                            else this._yearsBody.rows[i].cells[j].className = "";
                            yearCell.date = startYear;
                            yearCell.title = startYear;
                            startYear++;
                        }
                    }
                    this._title.innerHTML = tmpstartYear + "-" + (parseInt(tmpstartYear) + 11);
                    this._title.date = tmpstartYear + "-" + (parseInt(tmpstartYear) + 11);
                    break;
            }
        }
    }
    ,
    _get_todaysDate: function() {
        var a = new Date();
        var nnpDate = new NNPControlToolkit.Date();
        nnpDate.getToday();
        var todaysdate = [nnpDate.getFullYear(), nnpDate.getMonth(), nnpDate.getDate()];
        return todaysdate;
    },
    _set_today_title: function() {
        var fdate = this._get_todaysDate();
        var edate = new Date();
        if (this._textbox.getAttribute('language') == "Fa") {
            this._today.innerHTML = "امروز : " + fdate[2] + " , " + this._monthTitle[fdate[1] - 1] + " , " + fdate[0];
            this._today.date = NNP.makeFarsiNum(fdate[0]) + "/" + NNP.makeFarsiNum(fdate[1]) + "/" + NNP.makeFarsiNum(fdate[2]);
           //maha1395 this._today.title = NNP.makeFarsiNum(fdate[0]) + "/" + NNP.makeFarsiNum(fdate[1]) + "/" + NNP.makeFarsiNum(fdate[2]);

        }
        else if (this._textbox.getAttribute('language') == "En") {
            this._today.innerHTML = "Today : " + edate.getFullYear() + " , " + this._monthTitleEnShortest[edate.getMonth()] + " , " + edate.getDate();
            this._today.date = edate.getFullYear() + "/" + edate.getMonth() + "/" + edate.getDate();
           //maha1395 this._today.title = edate.getFullYear() + "/" + (parseFloat(edate.getMonth()) + 1) + "/" + edate.getDate();

        }
    }
    ,
    _set_today: function() {
        var fdate = this._get_todaysDate();
        var edate = new Date();
        if (this._textbox.getAttribute('language') == "Fa") {
            this._today.innerHTML = "امروز : " + fdate[2] + " , " + this._monthTitle[fdate[1] - 1] + " , " + fdate[0];
            this._today.date = NNP.makeFarsiNum(fdate[0]) + "/" + NNP.makeFarsiNum(fdate[1]) + "/" + NNP.makeFarsiNum(fdate[2]);
            this._today.title = NNP.makeFarsiNum(fdate[0]) + "/" + NNP.makeFarsiNum(fdate[1]) + "/" + NNP.makeFarsiNum(fdate[2]);

        }
        else if (this._textbox.getAttribute('language') == "En") {
            this._today.innerHTML = "Today : " + edate.getFullYear() + " , " + this._monthTitleEnShortest[edate.getMonth()] + " , " + edate.getDate();
            this._today.date = edate.getFullYear() + "/" + edate.getMonth() + "/" + edate.getDate();
            this._today.title = edate.getFullYear() + "/" + (parseFloat(edate.getMonth()) + 1) + "/" + edate.getDate();

        }
        this._selectedDate.year = fdate[0];
        this._selectedDate.month = fdate[1];
        this._selectedDate.day = fdate[2]; this._selectedDateEn.year = edate.getFullYear();
        this._selectedDateEn.month = edate.getMonth();
        this._selectedDateEn.day = edate.getDate();
    }
    ,
    _switchMonth: function(type) {
        if (type == "prev") {
            switch (this._mode) {
                case "years":
                    this._selectedDate.year -= 10;
                    this._selectedDateEn.year -= 10;
                    break;
                case "months":
                    this._selectedDate.year--;
                    this._selectedDateEn.year--;
                    break;
                case "days":
                    if (this._selectedDate.month - 1 <= 0) {
                        this._selectedDate.month = 12;
                        this._selectedDate.year--;
                    } else this._selectedDate.month--;
                    if (this._selectedDateEn.month - 1 < 0) {
                        this._selectedDateEn.month = 11;
                        this._selectedDateEn.year--;
                    } else this._selectedDateEn.month--;
                    break;
            }
            var newElement = this._modes[this._mode];
            var oldElement = newElement.cloneNode(true);
            this._body.appendChild(oldElement);
            this._animation._clearAnimation();
            NNP.setLocation(newElement, { x: 170, y: 0 });
            NNP.setVisible(newElement, true);
            this._topmovepluse._setProperty(this._width, 0, "left", newElement);
            this._animation._setAnimation(this._topmovepluse);
            NNP.setLocation(oldElement, { x: 0, y: 0 });
            NNP.setVisible(oldElement, true);
            this._topmoveminus._setProperty(0, -this._width, "left", oldElement);
            this._animation._Addhandler(NNP.createDelegate(this, function() { this._body.removeChild(oldElement); oldElement = null; this._modes[this._mode] = newElement; }));
            this._animation._setAnimation(this._topmoveminus);
            this._animation._setTime(1);
            this._animation._play();
        }
        else if (type == "next") {
            switch (this._mode) {
                case "years":
                    this._selectedDate.year += 10;
                    this._selectedDateEn.year += 10;
                    break;
                case "months":
                    this._selectedDate.year++;
                    this._selectedDateEn.year++;
                    break;
                case "days":
                    if (this._selectedDate.month + 1 > 12) {
                        this._selectedDate.month = 1;
                        this._selectedDate.year++;
                    } else this._selectedDate.month++;
                    if (this._selectedDateEn.month + 1 > 11) {
                        this._selectedDateEn.month = 0;
                        this._selectedDateEn.year++;
                    } else this._selectedDateEn.month++;
                    break;
            }
            var newElement = this._modes[this._mode];
            var oldElement = newElement.cloneNode(true);
            this._body.appendChild(oldElement);
            this._animation._clearAnimation();
            NNP.setLocation(newElement, { x: -170, y: 0 });
            NNP.setVisible(newElement, true);
            this._topmovepluse._setProperty(-this._width, 0, "left", newElement);
            this._animation._setAnimation(this._topmovepluse);
            NNP.setLocation(oldElement, { x: 0, y: 0 });
            NNP.setVisible(oldElement, true);
            this._topmoveminus._setProperty(0, this._width, "left", oldElement);
            this._animation._Addhandler(NNP.createDelegate(this, function() { this._body.removeChild(oldElement); oldElement = null; this._modes[this._mode] = newElement; }));
            this._animation._setAnimation(this._topmoveminus);
            this._animation._setTime(1);
            this._animation._play();
        }
        this._Invalidate();
    },
    _switchMode: function(mode) {
        if (this._mode == mode) { return; }
        var moveDown = this._modeOrder[this._mode] < this._modeOrder[mode];
        var oldElement = this._modes[this._mode];
        var newElement = this._modes[mode];
        this._animation._clearAnimation();
        this._mode = mode;
        if (moveDown) {
            NNP.setLocation(newElement, { x: 0, y: -this._height });
            NNP.setVisible(newElement, true);

            this._topmovepluse._setProperty(-this._height, 0, "top", newElement);
            this._animation._setAnimation(this._topmovepluse);
            NNP.setLocation(oldElement, { x: 0, y: 0 });
            NNP.setVisible(oldElement, true);

            this._topmoveminus._setProperty(0, this._height, "top", oldElement);
            this._animation._setAnimation(this._topmoveminus);
        }
        else {
            NNP.setLocation(oldElement, { x: 0, y: 0 });
            NNP.setVisible(oldElement, true);
            this._topmovepluse._setProperty(0, -this._height, "top", oldElement);
            this._animation._setAnimation(this._topmovepluse);

            NNP.setLocation(newElement, { x: 0, y: this._height });
            NNP.setVisible(newElement, true);
            this._topmoveminus._setProperty(this._height, 0, "top", newElement);
            this._animation._setAnimation(this._topmoveminus);

        } this._animation._setTime(1);
        this._animation._play();
        this._Invalidate();
    }
    ,
    _cell_onclick: function(e) {

        if (!this._enabled) return;
        var e = e || window.event;
        NNP.stopPropagation(e);
        var target = e.srcElement || e.target;
        switch (target.mode) {
            case "prev":
                this._switchMonth("prev");
                break;
            case "next":
                this._switchMonth("next");
                break;
            case "title":
                switch (this._mode) {
                    case "days": this._switchMode("months"); break;
                    case "months": this._switchMode("years"); break;
                }
                break;
            case "month":
                if (this._language == "Fa")
                    this._selectedDate.month = target.month + 1;
                else this._selectedDateEn.month = target.month;
                this._switchMode("days");
                this._Invalidate();
                break;
            case "year":
                if (this._language == "Fa")
                    this._selectedDate.year = target.date;
                else this._selectedDateEn.year = target.date;
                this._switchMode("months");
                this._Invalidate();
                break;
            case "day":
                this._selectedDate.day = NNP.makeEnglishNum(target.date.split('/')[2]);
                this._textbox.value = (this._language == "Fa") ? this.get_CurrectDate(target.date) : target.date;
                this._dispose();
                break;
            case "today":
                this._selectedDate.day = NNP.makeEnglishNum(target.date.split('/')[2]);
                this._textbox.value = (this._language == "Fa") ? this.get_CurrectDate(target.date) : target.date;
                this._dispose();
                break;
            case "lang":
                if (this._language == "En") {
                    this._language = "Fa";
                    if (NNP.Browser.name != 'Microsoft Internet Explorer' && NNP.Browser.name != 'Safari')
                        target.textContent = this.getLanguageTitle(this._language);
                    else target.innerText = this.getLanguageTitle(this._language);
                    this._textbox.setAttribute('language', this._language);
                }
                else if (this._language == "Fa") {
                    this._language = "En";
                    if (NNP.Browser.name != 'Microsoft Internet Explorer' && NNP.Browser.name != 'Safari')
                        target.textContent = this.getLanguageTitle(this._language);
                    else target.innerText = this.getLanguageTitle(this._language);
                    this._textbox.setAttribute('language', this._language);
                }
                this._Invalidate();
                break;
        }
    },
    get_CurrectDate: function(value) {
        var arrvalue = value.split('/');
        var y = arrvalue[0];
        var m = arrvalue[1];
        var d = arrvalue[2];

        if (parseInt(NNP.makeEnglishNum(d)) < 10)
        { d = NNP.makeFarsiNum("0").toString() + d.toString(); }
        if (parseInt(NNP.makeEnglishNum(m)) < 10)
        { m = NNP.makeFarsiNum("0").toString() + m.toString(); }

        return y.toString() + "/" + m.toString() + "/" + d.toString();
    }
    ,
    get_id: function() { return this._id },

    _event_handler_onclick: function() {
        if (this._daysBody) {
            for (var i = 0; i < this._daysBody.rows.length; i++) {
                var row = this._daysBody.rows[i];
                for (var j = 0; j < row.cells.length; j++) {
                    row.cells[j].firstChild.className = "ajax__calendar ajax__calendar_day";
                }
            }
        }
        this.className = "ajax__calendar ajax__calendar_day_active";
    },

    _dispose: function() {
        var id = this.get_id();
        if (NNP.$get(id + "_container")) {
            if (this._textbox.attributes.CalendarPosition.value == "Top")
                NNP.$rem(id + "_container", id + "_tdCalendarBaseTop");
            else NNP.$rem(id + "_container", id + "_tdCalendarBase");
        }
    },
    _buildCalendar: function() {

        var elt = this._textbox;
        var id = this.get_id();
        if (elt.attributes.CalendarPosition.value == "Top") {
            this._container = NNP.createElementFromTemplate({
                nodeName: "div",
                properties: { id: id + "_container" },
                cssClasses: [this._cssClass]
            }, NNP.$get(id + "_tdCalendarBaseTop"));
            this._container.style.marginTop = "-190px";
        }
        else {
            this._container = NNP.createElementFromTemplate({
                nodeName: "div",
                properties: { id: id + "_container" },
                cssClasses: [this._cssClass]
            }, NNP.$get(id + "_tdCalendarBase"));
        }
        this._popupDiv = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: {
                id: id + "_popupDiv"
            },
            cssClasses: ["ajax__calendar ajax__calendar_container"],
            visible: true
        }, this._container);
    },
    _buildHeader: function() {
        var id = this.get_id();

        this._header = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: id + "_header" },
            cssClasses: ["ajax__calendar ajax__calendar_header"]
        }, this._popupDiv);

        var prevArrowWrapper = NNP.createElementFromTemplate({ nodeName: "div" }, this._header);
        this._prevArrow = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: {
                id: id + "_prevArrow",
                mode: "prev"
            },
            events: this._cell$delegates,
            cssClasses: ["ajax__calendar ajax__calendar_prev"]
        }, prevArrowWrapper);

        var nextArrowWrapper = NNP.createElementFromTemplate({ nodeName: "div" }, this._header);
        this._nextArrow = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: {
                id: id + "_nextArrow",
                mode: "next"
            },
            events: this._cell$delegates,
            cssClasses: ["ajax__calendar ajax__calendar_next"]
        }, nextArrowWrapper);

        var titleWrapper = NNP.createElementFromTemplate({ nodeName: "div" }, this._header);
        this._title = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: {
                id: id + "_title",
                mode: "title"
            },
            events: this._cell$delegates,
            cssClasses: ["ajax__calendar ajax__calendar_title"]
        }, titleWrapper);
    },
    _buildBody: function() {

        this._body = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: this.get_id() + "_body" },
            cssClasses: ["ajax__calendar ajax__calendar_body"]
        }, this._popupDiv);

        this._buildDays();
        this._buildMonths();
        this._buildYears();
    },
    _buildFooter: function() {
        var id = this.get_id();
        this._fotter = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: id + "_fotter" },
            cssClasses: ["ajax__calendar ajax__calendar_fotter"]
        }, this._popupDiv);

        var languageSwitcher = NNP.createElementFromTemplate({ nodeName: "div" }, this._fotter);
        this._languageBody = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: {
                id: id + "_langSwitch",
                mode: "lang"
            },
            events: this._cell$delegates,
            cssClasses: ["ajax__calendar ajax__calendar_lang"]
        }, languageSwitcher);

        var todayWrapper = NNP.createElementFromTemplate({ nodeName: "div" }, this._fotter);
        this._today = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: {
                id: this.get_id() + "_today",
                mode: "today"
            },
            events: this._cell$delegates,
            cssClasses: ["ajax__calendar ajax__calendar_footer", "ajax__calendar ajax__calendar_today"]
        }, todayWrapper);
    }
    ,
    _buildDays: function() {

        var id = this.get_id();

        this._days = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: id + "_days" },
            cssClasses: ["ajax__calendar ajax__calendar_days"]
        }, this._body);
        this._modes["days"] = this._days;

        this._daysTable = NNP.createElementFromTemplate({
            nodeName: "table",
            properties: {
                id: id + "_daysTable",
                cellPadding: 0,
                cellSpacing: 0,
                border: 0,
                style: { margin: "auto" }
            }
        }, this._days);

        this._daysTableHeader = NNP.createElementFromTemplate({ nodeName: "thead", properties: { id: id + "_daysTableHeader"} }, this._daysTable);
        this._daysTableHeaderRow = NNP.createElementFromTemplate({ nodeName: "tr", properties: { id: id + "_daysTableHeaderRow"} }, this._daysTableHeader);
        for (var i = 0; i < 7; i++) {
            var dayCell = NNP.createElementFromTemplate({ nodeName: "td" }, this._daysTableHeaderRow);
            var dayDiv = NNP.createElementFromTemplate({
                nodeName: "div",
                cssClasses: ["ajax__calendar ajax__calendar_dayname"],
                innerHTML: this._daysTitle[i]
            }, dayCell);
        }

        this._daysBody = NNP.createElementFromTemplate({ nodeName: "tbody", properties: { id: id + "_daysBody"} }, this._daysTable);
        for (var i = 0; i < 6; i++) {
            var daysRow = NNP.createElementFromTemplate({ nodeName: "tr" }, this._daysBody);
            for (var j = 0; j < 7; j++) {
                var dayCell = NNP.createElementFromTemplate({ nodeName: "td" }, daysRow);
                var dayDiv = NNP.createElementFromTemplate({
                    nodeName: "div",
                    properties: {
                        mode: "day",
                        id: id + "_day_" + i + "_" + j,
                        innerHTML: i
                    },
                    events: this._cell$delegates,
                    cssClasses: ["ajax__calendar ajax__calendar_day"]
                }, dayCell);


            }
        }
    },
    _buildMonths: function() {
        var id = this.get_id();

        this._months = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: id + "_months" },
            cssClasses: ["ajax__calendar ajax__calendar_months"],
            visible: false
        }, this._body);
        this._modes["months"] = this._months;

        this._monthsTable = NNP.createElementFromTemplate({
            nodeName: "table",
            properties: {
                id: id + "_monthsTable",
                cellPadding: 0,
                cellSpacing: 0,
                direction: "ltr",
                border: 0,
                style: { margin: "auto" }
            }
        }, this._months);
        this._monthsBody = NNP.createElementFromTemplate({ nodeName: "tbody", properties: { id: id + "_monthsBody"} }, this._monthsTable);
        for (var i = 0; i < 3; i++) {
            var monthsRow = NNP.createElementFromTemplate({ nodeName: "tr" }, this._monthsBody);
            for (var j = 0; j < 4; j++) {
                var monthCell = NNP.createElementFromTemplate({ nodeName: "td" }, monthsRow);
                var monthDiv = NNP.createElementFromTemplate({
                    nodeName: "div",
                    properties: {
                        id: id + "_month_" + i + "_" + j,
                        mode: "month",
                        month: this._monthsCode[i][j] - (i * 4) + j,
                        date: this._monthsCode[i][j] - (i * 4) + j,
                        innerHTML: "<br />" + this._monthTitle[this._monthsCode[i][j] - (i * 4) + j]/*+ dtf.AbbreviatedMonthNames[(i * 4) + j]*/
                    },
                    events: this._cell$delegates,
                    cssClasses: ["ajax__calendar ajax__calendar_month"]
                }, monthCell);
            }
        }
    },
    _buildYears: function() {
        var id = this.get_id();

        this._years = NNP.createElementFromTemplate({
            nodeName: "div",
            properties: { id: id + "_years" },
            cssClasses: ["ajax__calendar ajax__calendar_years"],
            visible: false
        }, this._body);
        this._modes["years"] = this._years;

        this._yearsTable = NNP.createElementFromTemplate({
            nodeName: "table",
            properties: {
                id: id + "_yearsTable",
                cellPadding: 0,
                cellSpacing: 0,
                border: 0,
                style: { margin: "auto" }
            }
        }, this._years);

        this._yearsBody = NNP.createElementFromTemplate({ nodeName: "tbody", properties: { id: id + "_yearsBody"} }, this._yearsTable);
        for (var i = 0; i < 3; i++) {
            var yearsRow = NNP.createElementFromTemplate({ nodeName: "tr" }, this._yearsBody);
            for (var j = 0; j < 4; j++) {
                var yearCell = NNP.createElementFromTemplate({ nodeName: "td" }, yearsRow);
                var yearDiv = NNP.createElementFromTemplate({
                    nodeName: "div",
                    properties: {
                        id: id + "_year_" + i + "_" + j,
                        mode: "year",
                        year: ((i * 4) + j) - 1,
                        innerHTML: "<br />" + ((i * 4) + j) - 1
                    },
                    events: this._cell$delegates,
                    cssClasses: ["ajax__calendar ajax__calendar_year"]
                }, yearCell);
            }
        }
    }
}
function DateValidator(source, arguments) {
    var a = NNP.makeEnglishNum(arguments.Value);
    var dateformat = /^(([1-9][0-9][0-9][0-9])\/([1][0-2]|[0][1-9]|[1-9])\/([1-2][0-9]|[0-9]|[0][1-9]|[3][0-1]))$/;
    //original var dateformat = /^(([1-9][0-9][0-9][0-9])\/([0-1][0-2]|[0][0-9]|[0-9])\/([1-2][0-9]|[0-9]|[0][0-9]|[3][0-1]))$/;
    arguments.IsValid = dateformat.test(a);
    return;
}
function getFarsi(id) {
    //alert("asd");
    //var e = window.event;
    //e.keyCode = NNP.makeFarsiNum(e.keyCode);

    if (document.getElementById(id).getAttribute('language') == "Fa") {
        if ((window.event.keyCode >= 48) && (window.event.keyCode <= 57)) {
            window.event.keyCode = window.event.keyCode + 1728;
        }
        else if ((window.event.keyCode == 47)) //  '/' char
        {
            //don't change key code
        }
        else {
            window.event.keyCode = 0;
        }
    }
}