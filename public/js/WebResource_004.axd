NNP.registerNamespace('NNPControlToolkit');
NNPControlToolkit.Date = function() {

    this._dkSolar = null;
    this._dkGregorian = null;
    this._monthNames = null;
    this._shortestDayNames = null;
    //this._dayOfWeek = null;
    this._dayOfWeek = null;
    this._dayNames = null;
    this._monthsday = null;
    this._leapMonth = null;
    this._daysToMonth = null;
    this._date = null;
    this._day = null;
    this._year = null;
    this._month = null;
    this._timeZoneOffset = null;
    this._seconds = null;
    this._miliSeconds = null;
    this._minutes = null;
    this._hour = null;
    this._dateTime = null;
    this._time = null;
    this._firstDayOfWeek = null;
    this._init();
    if (arguments.length > 0) {
        this.setFullYear(arguments[0]);
        this.setMonth(arguments[1]);
        this.setDate(arguments[2]);
        this._dateChanged();
    }

};
NNPControlToolkit.Date.prototype = {
    _init: function() {
        this._dkSolar = 0;
        this._dkGregorian = 1;
        this._monthNames = ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"];
        this._shortestDayNames = ["ش", "ی", "د", "س", "چ", "پ", "ج"];
        this._dayOfWeek = { 0: 1, 1: 2, 2: 3, 3: 4, 4: 5, 5: 6, 6: 0 };
        this._dayNames = ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهار شنبه", "پنج شنبه", "جمعه"];
        this._monthsday = [[31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 30], [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]];
        this._leapMonth = [12, 2];
        this._daysToMonth = [[0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365], [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365]];
        var objDate = new Date();
        var date = this.getMDToSolar(objDate.getFullYear(), objDate.getMonth() + 1, objDate.getDate());
        this._date = date[2];
        this._day = this._dayOfWeek[objDate.getDay()];
        this._year = date[0];
        this._month = date[1];
        this._timeZoneOffset = objDate.getTimezoneOffset();
        this._seconds = objDate.getSeconds();
        this._miliSeconds = objDate.getMilliseconds();
        this._minutes = objDate.getMinutes();
        this._hour = objDate.getHours();
        this._dateTime = this.getDateTime();
        this._time = objDate.getTime();
        this._firstDayOfWeek = 0;
    },
    _dateChanged: function() {
        var date = this.getSolarToMD(this._year, this._month, this._date);
        var mdDate = new Date(date[0], date[1], date[2]);
        this._day = this._dayOfWeek[mdDate.getDay()];
        this._dateTime = this.getDateTime();
    }
    ,
    _isLeapYear: function(dateKind, year) {
        if (dateKind == this._dkSolar)
            return ((((year + 38) * 31) % 128) <= 30);
        else
            return (((year % 4) == 0) && (((year % 100) != 0) || ((year % 400) == 0)));
    },
    _daysOfMonth: function(dateKind, year, month) {
        var result;
        if ((year != 0) && ((month <= 12) && (month >= 1))) {
            result = this._monthsday[dateKind][month - 1];
            if ((month == this._leapMonth[dateKind]) && this._isLeapYear(dateKind, year)) result++;
        }
        else
            result = 0;
        return result;
    },
    _isDateValid: function(dateKind, year, month, day) {
        return ((year != 0) && (month >= 1) && (month <= 12) && (day >= 1) && day <= (this._daysOfMonth(dateKind, year, month)));
    },
    _daysToDate: function(dateKind, year, month, day) {
        var result;
        if (this._isDateValid(dateKind, year, month, day)) {
            result = this._daysToMonth[dateKind][month - 1] + day;
            if ((month > this._leapMonth[dateKind]) && this._isLeapYear(dateKind, year)) result++;
        }
        else
            result = 0;
        return result;
    },

    _dateOfDay: function(dateKind, days, year, month, day) {
        var result;
        var leapDay = 0;
        month = 0;
        day = 0;
        for (var m = 2; m <= 13; m++) {
            if ((m > this._leapMonth[dateKind]) && (this._isLeapYear(dateKind, year))) leapDay = 1;
            if (days <= (this._daysToMonth[dateKind][m - 1] + leapDay)) {
                month = m - 1;
                if (month <= this._leapMonth[dateKind]) leapDay = 0;
                day = days - (this._daysToMonth[dateKind][month - 1] + leapDay);
                break;
            }
        }
        if (this._isDateValid(dateKind, year, month, day))
            result = [year, month, day];
        else result = false;
        return result;
    },
    getMDToSolar: function(year, month, day) {
        var year, month, day;
        y = year;
        m = month;
        d = day;
        var leapDay, days, prevGregorianLeap, result;
        if (this._isDateValid(this._dkGregorian, y, m, d)) {
            prevGregorianLeap = this._isLeapYear(this._dkGregorian, y - 1);
            days = this._daysToDate(this._dkGregorian, y, m, d);
            y -= 622;
            if (this._isLeapYear(this._dkSolar, y)) leapDay = 1
            else leapDay = 0;
            if (prevGregorianLeap && (leapDay == 1)) days += 287
            else days += 286;
            if (days > (365 + leapDay)) {
                y++;
                days -= (365 + leapDay);
            }
            var _date = this._dateOfDay(this._dkSolar, days, y, m, d);
            result = [_date[0], _date[1], _date[2]];
        }
        else result = false;
        return result;
    }
    ,
    getSolarToMD: function(year, month, day) {
        var y, m, d;
        y = year;
        m = month;
        d = day;
        var leapDay, days, prevGregorianLeap, result;
        if (this._isDateValid(this._dkSolar, y, m, d)) {
            prevSolarLeap = this._isLeapYear(this._dkSolar, y - 1);
            days = this._daysToDate(this._dkSolar, y, m, d);
            y += 621;
            if (this._isLeapYear(this._dkGregorian, y)) leapDay = 1
            else leapDay = 0;
            if (prevSolarLeap && (leapDay == 1)) days += 80
            else days += 79;
            if (days > (365 + leapDay)) {
                y++;
                days -= (365 + leapDay);
            }
            var _date = this._dateOfDay(this._dkGregorian, days, y, m, d);
            result = [_date[0], _date[1], _date[2]];

        }
        else result = false;
        return result;
    }
    ,
    getDateTime: function() {
        return this._shortestDayNames[this._day] + " " + this._monthNames[this._month - 1] + " " +
        this._date + " " + this._hour + ":" + this._minutes + ":" + this._seconds + " UTC+" + this._timeZoneOffset + " " + this._year;
    },
    getDate: function() { return this._date; },
    getDay: function() {
        var d = new Date();
        var md = this.getSolarToMD(this._year, this._month, this._date);
        d.setDate(md[2]);
        d.setMonth(md[1] - 1);
        d.setFullYear(md[0]);
        this._day = this._dayOfWeek[d.getDay()];
        return this._day;

    }, localeFormat: function(format) {
        var result = "";
        switch (format) {
            case "D":
                result = this._date + " ";
                result += this._monthNames[this._month - 1] + " , ";
                result += this._year;
                return result;
                break;
        }
    },
    getFullYear: function() { return this._year; },
    getFirstDayOfWeek: function() { return this._firstDayOfWeek; },
    getHour: function() { return this._hour; },
    getMiliseconds: function() { return this._miliSeconds; },
    getMinutes: function() { return this._minutes; },
    getMonth: function() { return this._month; },
    getSeconds: function() { return this._seconds; },
    getToday: function() {
        var d = new Date()
        var so = this.getMDToSolar(d.getFullYear(), d.getMonth() + 1, d.getDate());
        this._date = so[2];
        this._month = so[1];
        this._year = so[0];
        return so[0] + "/" + so[1] + "/" + so[2];
    },
    getTime: function() { return this._time; },
    getTimezoneOffset: function() { return this._timeZoneOffset; },
    toDateString: function() { },
    toTimeString: function() { },
    toString: function() { },
    toMDDate: function() { },
    toSODate: function() { },
    setDate: function(date) {
        this._date = date;
    },
    setDay: function(day) { if (day > 7) return; this._day = day; },
    setFullYear: function(year) { this._year = year; },
    setHour: function(hour) { if (hour > 12) return; this._hour = hour; },
    setMiliseconds: function(miliseconds) { this._miliSeconds = miliseconds; },
    setMinuts: function(minuts) { if (minuts > 60) return; this._minutes = minuts; },
    setMonth: function(month) { if (month > 12) return; this._month = month; },
    setSeconds: function(seconds) { this._seconds = seconds; },
    setTime: function(time) { this._time = time; },
    addDay: function(value) {
        if (value > 0) {
            for (var i = 0; i < value; i++) {
                if (this._date + 1 > this._monthsday[0][this._month - 1]) {
                    this._date = this._date + 1 - this._monthsday[0][this._month - 1];
                    if (this._month + 1 > 12) {
                        this._year++;
                        this._month = this._month + 1 - 12;
                    }
                    else {
                        this._month++;
                    }
                }
                else {
                    this._date++;
                }
            }
        }
        else if (value < 0) {
            for (var i = value; i < 0; i++) {
                if (this._date - 1 <= 0) {
                    if (this._month - 2 < 0) {
                        this._month = 12;
                        this._year--;
                        this._date = this._monthsday[0][this._month - 1];
                    }
                    else {
                        this._month--;
                        this._date = this._monthsday[0][this._month - 1];
                    }
                }
                else this._date--;
            }
        }
    },
    addMonth: function(value) {
        if (this._month + value > 12) {
            this._month = this._month + value - 12;
            this._year++;
        }
        else this._month += value;

    },
    addYear: function(value) {
        this._year += value;

    }
}