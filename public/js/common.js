//-----Version 2.940505---------
var mode = 1;
/* original
var FarsiCode   = new Array(63,1568,1569,1570,1571,1572,1573,109,104,102,1577,106,101,91,112,111,110,98,118,99,
115,97,119,113,120,122,117,121,1595,1596,1597,1598,1599,1600,116,114,91,103,108,107,
105,76,100,132,1611,1612,1613,1614,1615,1616,1617,1618,1619,1620,1621,1622,1623,1623,1625,1626,
1627,1628,1629,1630,1631,1632,1633,1634,1635,1636,1637,1638,1639,1640,1641,1642,1643,1644,1645,1646,
1647,1648,1649,1650,1651,1652,1653,1654,1655,1656,1657,1658,1659,1660,1661,92,1663,1664,1665,1666,
1667,1668,1669,93,1671,1672,1673,1674,1675,1676,1677,1678,1679,1680,1681,1682,1683,1684,1685,1686,
1687,124,1689,1690,1691,1692,1693,1694,1695,1696,1697,1698,1699,1700,1701,1702,1703,1704,1705,1706,
1707,1708,1709,1710,39,1712,1713,1714,1715,1716,1717,1718,1719,1720,1721,1722,1723,1724,1725,1726,
1727,1728,1729,1730,1731,1732,1733,1734,1735,1736,1737,1738,1739,100)
var EnglishCode = new Array(1711, 40, 41, 42, 43, 1608, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 1603, 60, 61, 62, 1567, 64, 1588, 1584, 1586,
1610, 1579, 1576, 1604, 1570, 1607, 1578, 1606, 1605, 1574, 1583, 1582, 1581, 1590, 1602, 1587, 1601, 85, 1585, 1589, 1591, 1594, 1592, 1580, 1688, 1670,
94,95,1662,1588,1584,1586,1610,1579,1576,1604,1575,1607,1578,1606,1605,1574,1583,1582,1581,1590,1602,1587,1601,1593,1585,1589,1591,1594,1592)
*/
var FarsiCode = new Array(63, 1568, 77, 72, 78, 86, 66, 109, 104, 102, 90, 106, 101, 91, 112, 111, 110, 98, 118, 99,
                            115, 97, 119, 113, 120, 122, 117, 121, 1595, 1596, 1597, 1598, 1599, 74, 116, 114, 91, 82, 108, 107,
                            105, 44, 100, 88, 81, 1612, 69, 65, 83, 68, 70, 1618, 1619, 1620, 1621, 1622, 1623, 1623, 1625, 1626,
                            1627, 1628, 1629, 1630, 1631, 1632, 1633, 1634, 1635, 1636, 1637, 1638, 1639, 1640, 1641, 1642, 1643, 1644, 1645, 1646,
                            1647, 1648, 1649, 1650, 1651, 1652, 1653, 1654, 1655, 1656, 1657, 1658, 1659, 1660, 1661, 92, 1663, 1664, 1665, 1666,
                            1667, 1668, 1669, 93, 1671, 1672, 1673, 1674, 1675, 1676, 1677, 1678, 1679, 1680, 1681, 1682, 1683, 1684, 1685, 1686,
                            1687, 67, 1689, 1690, 1691, 1692, 1693, 1694, 1695, 1696, 1697, 1698, 1699, 1700, 1701, 1702, 1703, 1704, 1705, 1706,
                            1707, 1708, 1709, 1710, 39, 1712, 1713, 1714, 1715, 1716, 1717, 1718, 1719, 1720, 1721, 1722, 1723, 1724, 1725, 1726,
                            1727, 71, 1729, 1730, 1731, 1732, 1733, 1734, 1735, 1736, 1737, 1738, 1739, 100)
var EnglishCode = new Array(1711, 40, 41, 42, 43, 1608, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 1603, 60, 61, 62, 1567, 64, 1588, 1584, 1688,
                            1610, 1579, 1576, 1604, 1570, 1607, 1578, 1606, 1605, 1574, 1583, 1582, 1581, 1590, 1602, 1587, 1601, 85, 1585, 1589, 1591, 1594, 1592, 1580, 1662, 1670,
                            94, 95, 1688, 1588, 1584, 1586, 1610, 1579, 1576, 1604, 1575, 1607, 1578, 1606, 1605, 1574, 1583, 1582, 1581, 1590, 1602, 1587, 1601, 1593, 1585, 1589, 1591, 1594, 1592)
//----------Client Grid---------
function GridValidatorTrim(s) {
    var m = s.match(/^\s*(\S+(\s+\S+)*)\s*$/);
    return (m == null) ? "" : m[1];
}
function bx(name) {
    return "[" + name + "]";
}

function ex(name) {
    return "[/" + name + "]";
}
//--------------------

function SearchBox(o, m, ln) {
    var defText = new Array("جستجو", "Search");
    if (m == 1) {
        if (o.value == defText[ln]) o.value = "";
    }
    else if (m == 2) {
        if (o.value == "") o.value = defText[ln];
    }
}
function SetTitleMainForm(param) {
    parent.parent.document.title = param;
}

function CloseWindow() {
    window.close();
}
function getKeyMode() {
    var parentWindow = window.parent;
    if (window.dialogArguments)
        parentWindow = window.dialogArguments;
    var img = "";
    if (document.getElementById("IMGLang")) img = document.getElementById("IMGLang").src;
    else if (parentWindow.document.getElementById("IMGLang")) img = parentWindow.document.getElementById("IMGLang").src;
    else if (parentWindow.window.parent.document.getElementById("IMGLang")) img = parentWindow.window.parent.document.getElementById("IMGLang").src;
    if (img.toLowerCase().indexOf('images/farsi.gif') >= 0) return 1;
    else if (img.toLowerCase().indexOf('images/english.gif') >= 0) return 0;
    else return -1;
}
function FarsiKeyDown() {
    if ((window.event.altKey) && (window.event.keyCode == 120 || window.event.keyCode == 16)) {
        if (getKeyMode() == 0) {
            //mode = 1 
            //window.defaultStatus="Farsi Mode"
            //document.geClassElementById("IMGLang").src = "Images/farsi.gif";
            var parentWindow = window.parent;
            if (window.dialogArguments)
                parentWindow = window.dialogArguments;
            if (document.getElementById("IMGLang")) document.getElementById("IMGLang").src = "Images/farsi.gif";
            else if (parentWindow.document.getElementById("IMGLang")) parentWindow.document.getElementById("IMGLang").src = "Images/farsi.gif";
            else if (parentWindow.window.parent.document.getElementById("IMGLang")) parentWindow.window.parent.document.getElementById("IMGLang").src = "Images/farsi.gif";



        }
        else if (getKeyMode() == 1) {
            //mode = 0 
            //window.defaultStatus="Normal Mode (English)"
            //document.geClassElementById("IMGLang").src = "Images/english.gif";
            var parentWindow = window.parent;
            if (window.dialogArguments)
                parentWindow = window.dialogArguments;
            if (document.getElementById("IMGLang")) document.getElementById("IMGLang").src = "Images/english.gif";
            else if (parentWindow.document.getElementById("IMGLang")) parentWindow.document.getElementById("IMGLang").src = "Images/english.gif";
            else if (parentWindow.window.parent.document.getElementById("IMGLang")) parentWindow.window.parent.document.getElementById("IMGLang").src = "Images/english.gif";

        }
        window.event.returnValue = false
        return
    }
    window.event.returnValue = true
}

function MakeFarsiKey(FarsiIt) {
    if (FarsiIt == 1) {
        if (mode == 0) {
            mode = 1;
            //window.defaultStatus="Farsi Mode"	
            document.geClassElementById("Top1_IMGLang").src = "/JBIS/Images/farsi.gif";
        }
    }
    else {
        if (mode == 1) {
            mode = 0;
            //window.defaultStatus="Normal Mode (English)" 
            document.geClassElementById("Top1_IMGLang").src = "/JBIS/Images/english.gif";
        }
    }
    return;
}

function FarsiKeyPress() {
    var key = window.event.keyCode;
    window.event.keyCode = converKeyCode(key, window.event);
    window.event.returnValue = true
}
function converKeyCode(key, event) {
    var keyCode = key;
    mode = getKeyMode();
    //if( key > 127  return
    if (key == 46) {
        //window.event.returnValue= true
        return 46;
    }
    if (mode == 1) if ((key > 38) && (key < 123)) keyCode = EnglishCode[key - 39];
    if ((mode == 1) && (key == 1740)) keyCode = 1610;

    if (mode == 0) if (key == 1604) keyCode = 103;
    else if (mode == 0) if ((key > 1566) && (key < 1741)) keyCode = FarsiCode[key - 1567];
    //if ((mode == 0) && (key == 1610)) keyCode = 100;
    //new maha
    //همزه--ء
    if ((mode == 1) && (event.shiftKey) && (key == 77)) keyCode = 1569;
    //،
    if ((mode == 1) && (event.shiftKey) && (key == 84)) keyCode = 1548;

    //I,K,L,O,P,U,T,Y
    if ((mode == 0) && (event.shiftKey)) {
        if (key == 93) keyCode = 73;
        if (key == 171) keyCode = 75;
        if (key == 187) keyCode = 76;
        if (key == 91) keyCode = 79;
        if (key == 92) keyCode = 80;
        if (key == 44) keyCode = 85;
        if (key == 1548) keyCode = 84;
        if (key == 1563) keyCode = 89;
    }
    return keyCode;
}

//----------------------------------------------
function windowModal2(windowpath, w, h, obj) {
    wr = window.showModalDialog(windowpath, obj, 'help:no;dialogHeight:' + h + 'pt;dialogWidth:' + w + 'pt;center:yes;resizable:no;status:no;');
    //wr = window.open(windowpath);
    //win = window.open(windowpath);
    return wr;
    //if (win==null)alert('بر روي كامپيوتر شما برنامه اي به نام Ad Blocker نصب است كه جلوي نمايش گزارش وضعيت را مي گيرد');

}
//----------------------------------------------
function ForceFarsiNum() {
    if ((window.event.keyCode >= 48) && (window.event.keyCode <= 57)) {
        window.event.keyCode = window.event.keyCode + 1728;
    }
    else if (window.event.keyCode == 46) {
    }
    else {
        window.event.keyCode = 0;
    }
}
function ForceFarsiNum1() {
    if ((window.event.keyCode >= 48) && (window.event.keyCode <= 57)) {
        window.event.keyCode = window.event.keyCode + 1728;
    }
}

function ForceFarsiDate() {
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
function ForceFarsiDate1() {
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
function MakeEnglishDate(s) {
    var s2 = "";
    for (i = 0; i < s.length; i++) {
        c = s.charCodeAt(i);
        if ((c >= 1776) && (c <= 1785)) {
            c = c - 1728;
        }
        s2 += String.fromCharCode(c);
    }
    return s2;
}

function MakeEnglishDate1(s) {
    var s2 = "";
    for (i = 0; i < s.length; i++) {
        c = s.charCodeAt(i);
        if ((c >= 1776) && (c <= 1785)) {
            c = c - 1728;
        }

        s2 += String.fromCharCode(c);
    }
    return s2;
}
function MakeFarsiNum(s) {
    var s2 = "";
    for (i = 0; i < s.length; i++) {
        c = s.charCodeAt(i);
        if ((c >= 48) && (c <= 57)) {
            c = c + 1728;
        }

        s2 += String.fromCharCode(c);
    }
    //alert(s2);
    return s2;
}
function MakeEnglishNum(s) {
    return MakeEnglishDate(s);
}
function isDouble(value) { return (parseDouble(value) == value); }


function checkFormOnSubmit() {
    l = document.all.length;
   
    var res = true;
    for (ii = 0; ii < l; ii++) {

        objid = document.all.item(ii).id;
        if ((objid != null) && (objid != '')) {
            var obj = document.getElementById(objid);
            var val = document.getElementById(objid).value;
            if (val != null && !(objid.toLowerCase().indexOf('df') > 0 || objid.toLowerCase().indexOf('dc') > 0 || objid.toLowerCase().indexOf('dt') > 0)) {
                if ((obj.getAttribute('req') != null) && (obj.disabled != true))
                    if (obj.getAttribute('req') == 'true' && val == '') {
                        if ((obj.style.backgroundColor) != '#ffbfff') {
                            obj.style.backgroundColor = '#ffbfff';

                            document.getElementById(objid).outerHTML = document.getElementById(objid).outerHTML + '<font style="font-family:Tahoma;font-size: 9pt;" color=red>&nbsp;ضروری&nbsp;</font>';
                        }
                        res = false;
                    }
                    else {
                        obj.style.backgroundColor = 'white';
                    }
                if (obj.getAttribute('numtype') != null)
                    if (obj.getAttribute('numtype') != 'text') {
                        if (obj.getAttribute('numtype') == 'int') {
                            if (isNaN(val)) {
                                if ((obj.style.backgroundColor) != '#ffbfff') {
                                    obj.style.backgroundColor = '#ffbfff';

                                    document.getElementById(objid).outerHTML = document.getElementById(objid).outerHTML + '<font style="font-family:Tahoma;font-size: 9pt;" color=red>&nbsp;عدد وارد شود&nbsp;</font>';
                                }
                                res = false;
                            }
                            else {
                                _val = parseFloat(val);
                                if (obj.getAttribute('min') != null)
                                    if (!isNaN(obj.getAttribute('min'))) {
                                        min = parseFloat(obj.getAttribute('min'));
                                        if (_val < min) {
                                            if ((obj.style.backgroundColor) != '#ffbfff') {
                                                obj.style.backgroundColor = '#ffbfff';

                                                document.getElementById(objid).outerHTML = document.getElementById(objid).outerHTML + '<font style="font-family:Tahoma;font-size: 9pt;" color=red>&nbsp;کمتر از حد مجاز&nbsp;</font>';
                                            }
                                            res = false;
                                        }
                                    }

                                if (obj.getAttribute('max') != null)
                                    if (!isNaN(obj.getAttribute('max'))) {
                                        max = parseFloat(obj.getAttribute('max'));
                                        if (_val > max) {
                                            if ((obj.style.backgroundColor) != '#ffbfff') {
                                                obj.style.backgroundColor = '#ffbfff';
                                                document.getElementById(objid).outerHTML = document.getElementById(objid).outerHTML + '<font style="font-family:Tahoma;font-size: 9pt;" color=red>&nbsp;بیشتر از حد مجاز&nbsp;</font>';
                                            }
                                            res = false;
                                        }
                                    }

                            }
                        }


                    }

                if (obj.getAttribute('date') != null)
                    if (obj.getAttribute('date') == 'true' && (!isValidDate(val))) {
                        if ((obj.style.backgroundColor) != '#ffbfff') {
                            obj.style.backgroundColor = '#ffbfff';

                            document.getElementById(objid).outerHTML = document.getElementById(objid).outerHTML + '<font style="font-family:Tahoma;font-size: 9pt;" color=red>&nbsp;تاريخ نادرست&nbsp;</font>';
                        }
                        res = false;


                    }
                if (obj.getAttribute('time') != null) {
                    min = obj.getAttribute('min');
                    if (min == null) min = '';
                    max = obj.getAttribute('max');
                    if (max == null) max = '';
                    if (obj.getAttribute('time') == 'true' && (!isValidTime(val, min, max))) {
                        if (obj.style.backgroundColor != '#ffbfff') {
                            obj.style.backgroundColor = '#ffbfff';

                            document.getElementById(objid).outerHTML = document.getElementById(objid).outerHTML + '<font color=red>&nbsp;ساعت نادرست&nbsp;</font>';

                        }
                        res = false;
                    }
                }
            }
        }
    }
    //if(!res)alert('موارد مشخص شده با رنگ قرمز بايد پر شود');
    return res;
}

function ValidateTime(val, arguments) {

    min = "00:00";
    max = "24:59";
    s = arguments.Value;

    arguments.IsValid = true
    var s = MakeEnglishNum(s);
    if (s == "") { arguments.IsValid = true; return; };
    var ss = s.split(":");
    //only 2 part
    if (ss.length != 2) { arguments.IsValid = false; return; }
    if ((ss[1].length > 2) || (ss[0].length > 2)) { arguments.IsValid = false; return; }
    var hour = parseInt(ss[0]);
    var minute = parseInt(ss[1]);
    if (isNaN(minute) || isNaN(hour)) { arguments.IsValid = false; return; }
    if ((minute < 0) || (minute > 59)) { arguments.IsValid = false; return; }
    if ((hour < 0) || (hour > 24)) { arguments.IsValid = false; return; }
    if (min == "") min = "00:00";
    if (max == "") max = "24:59";
    ss = min.split(":");
    var minH = parseInt(ss[0]);
    var minM = parseInt(ss[1]);
    ss = max.split(":");
    var maxH = parseInt(ss[0]);
    var maxM = parseInt(ss[1]);
    if ((hour * 60 + minute) < (minH * 60 + minM)) { arguments.IsValid = false; return; }
    if ((hour * 60 + minute) > (maxH * 60 + maxM)) { arguments.IsValid = false; return; }

}
//این تابع فرمت را چک کرده و محدوده ساعت را چک نمی کند
function ValidateTimeFormat(val, arguments) {

    min = "00:00";
    max = "9999:59";
    s = arguments.Value;

    arguments.IsValid = true
    var s = MakeEnglishNum(s);
    if (s == "") { arguments.IsValid = true; return; };
    var ss = s.split(":");
    //only 2 part
    if (ss.length != 2) { arguments.IsValid = false; return; }
    if ((ss[1].length > 2)/* || (ss[0].length > 2)*/) { arguments.IsValid = false; return; }
    var hour = parseInt(ss[0]);
    var minute = parseInt(ss[1]);
    if (isNaN(minute) || isNaN(hour)) { arguments.IsValid = false; return; }
    if ((minute < 0) || (minute > 59)) { arguments.IsValid = false; return; }
    if ((hour < 0) || (hour > 9999)) { arguments.IsValid = false; return; }
    if (min == "") min = "00:00";
    if (max == "") max = "9999:59";
    ss = min.split(":");
    var minH = parseInt(ss[0]);
    var minM = parseInt(ss[1]);
    ss = max.split(":");
    var maxH = parseInt(ss[0]);
    var maxM = parseInt(ss[1]);
    if ((hour * 60 + minute) < (minH * 60 + minM)) { arguments.IsValid = false; return; }
    if ((hour * 60 + minute) > (maxH * 60 + maxM)) { arguments.IsValid = false; return; }

}

function isValidTime(s, min, max) {

    var s = MakeEnglishNum(s);
    if (s == "") return true;
    var ss = s.split(":");
    //only 2 part
    if (ss.length != 2) return false;
    if ((ss[1].length > 2) || (ss[0].length > 2)) return false;
    var hour = parseInt(ss[0]);
    var minute = parseInt(ss[1]);
    if (isNaN(minute) || isNaN(hour)) return false;
    if ((minute < 0) || (minute > 59)) return false;
    if ((hour < 0) || (hour > 24)) return false;
    if (min == "") min = "00:00";
    if (max == "") max = "24:59";
    ss = min.split(":");
    var minH = parseInt(ss[0]);
    var minM = parseInt(ss[1]);
    ss = max.split(":");
    var maxH = parseInt(ss[0]);
    var maxM = parseInt(ss[1]);
    if ((hour * 60 + minute) < (minH * 60 + minM)) return false;
    if ((hour * 60 + minute) > (maxH * 60 + maxM)) return false;
    return true;
}

function isValidDate(s) {
    var s = MakeEnglishDate(s);
    if (s == "") return true;
    var ss = s.split("/");
    //only 3 part
    if (ss.length != 3) return false;
    if ((ss[1].length > 2) || (ss[2].length > 2) || (ss[0].length > 4)) return false;
    if (ss[0] == '08') ss[0] = '8';
    if (ss[0] == '09') ss[0] = '9';
    if (ss[1] == '08') ss[1] = '8';
    if (ss[1] == '09') ss[1] = '9';
    if (ss[2] == '08') ss[2] = '8';
    if (ss[2] == '09') ss[2] = '9';

    var dday = parseInt(ss[2]);
    var dmonth = parseInt(ss[1]);
    var dyear = parseInt(ss[0]);

    if ((isNaN(dday)) || (isNaN(dmonth)) || (isNaN(dyear))) return false;
    if (ss[0].length == 3) return false;
    if (ss[0].length == 4)
        if ((dyear < 1300) || (dyear > 1490)) return false;
    if ((dmonth < 1) || (dmonth > 12)) return false;
    if ((dday < 1) || (dday > 31)) return false;
    if ((dmonth >= 7) && (dmonth <= 11))
        if (dday > 30) return false;
    if (dmonth == 12)
        if (dday > 30) return false;
    return true;
}

function DateValidator11(source, arguments) {

    var s = MakeEnglishDate(arguments.Value);
    //	var s = arguments.Value;
    //alert(s);
    if (s == "") {
        arguments.IsValid = true;
        return;
    }

    var ss = s.split("/");
    //only 3 part

    if (ss.length != 3) {
        arguments.IsValid = false;
        return;
    }


    if ((ss[1].length > 2) || (ss[2].length > 2) || (ss[0].length > 4)) {
        arguments.IsValid = false;
        return;
    }

    if (ss[0] == '08') ss[0] = '8';
    if (ss[0] == '09') ss[0] = '9';
    if (ss[1] == '08') ss[1] = '8';
    if (ss[1] == '09') ss[1] = '9';
    if (ss[2] == '08') ss[2] = '8';
    if (ss[2] == '09') ss[2] = '9';
    var dday = parseInt(ss[2]);
    var dmonth = parseInt(ss[1]);
    var dyear = parseInt(ss[0]);

    if ((isNaN(dday)) || (isNaN(dmonth)) || (isNaN(dyear))) {
        arguments.IsValid = false;
        return;
    }

    if (ss[0].length == 3) {
        arguments.IsValid = false;
        return;
    }
    if (ss[0].length == 4) {
        if ((dyear < 1300) || (dyear > 1490)) {
            arguments.IsValid = false;
            return;
        }
    }
    if ((dmonth < 1) || (dmonth > 12)) {
        arguments.IsValid = false;
        return;
    }


    if ((dday < 1) || (dday > 31)) {
        arguments.IsValid = false;
        return;
    }


    if ((dmonth >= 7) && (dmonth <= 11)) {
        if (dday > 30) {
            arguments.IsValid = false;
            return;
        }
    }

    if (dmonth == 12) {
        if (dday > 30) {
            arguments.IsValid = false;
            return;
        }
    }

    arguments.IsValid = true;
    return;
}
/************************* LIST BOX *************************************************/
function WriteOptionsToHiddenEdit(_objCBox, _objEditBox) {

    str = "";
    if (_objCBox.length > 0) str = _objCBox.options[0].value;
    for (i = 1; i < _objCBox.length; i++)
        str += " , " + _objCBox.options[i].value;

    _objEditBox.value = str;
}

function DelOption(s) {
    _obj = document.geClassElementById(s);
    index = _obj.selectedIndex;
    if (index > -1) {
        _obj.options[index] = null;
    }

    if (_obj.length > 0) {
        if (index - 1 >= 0)
            _obj.selectedIndex = index - 1;
        else
            _obj.selectedIndex = 0;
    }

}

var PrevSelect = -2;
function TableClick(i, j, grid) {
    if (i == -1) return;
    if (PrevSelect != -2) {
        //grid.rows(PrevSelect).style.backgroundColor = '#ffffff';//'#fff7e7';
        //grid.rows(PrevSelect).style.color = '#003399';
        k = (PrevSelect % 2);

        if (k == 0) grid.rows(PrevSelect).className = 'GridAlternating';
        else grid.rows(PrevSelect).className = 'GridItem';

    }
    PrevSelect = i + 1;
    //grid.rows(i+1).style.backgroundColor = '#f5f5dc';
    //grid.rows(i+1).style.color = '#20b2aa';
    grid.rows(i + 1).className = 'highlight GridRowSelected';
    //document.getElementById("Erorr1_SelectedRowId").value = grid.rows(PrevSelect).cells(0).innerText;
}

var selectedPost = 0;
function checkRowExist(i, grid) {

    if (i == -1) return;
    for (k = 0; k < grid.rows.length; k++) {
        if (grid.rows(k).cells(0).innerHTML == i) return true;
    }
    return false;

}

function checkListExist(i, listbox) {

    if (i == -1) return;
    for (k = 0; k < listbox.options.length; k++) {
        if (listbox.options[k].value == i) return true;
    }
    return false;

}


function RemovefromListbox(listbox) {

    var index = listbox.selectedIndex;

    if (index > -1) {
        listbox.options[index] = null;
    }

    if (listbox.length > 0) {
        if (index - 1 >= 0)
            listbox.selectedIndex = index - 1;
        else
            listbox.selectedIndex = 0;
    }
}

function TableClickRefrenc(i, j, grid) {

    if (i == -1) return;
    for (k = 1; k < grid.rows.length; k++) {
        if (grid.rows(k).cells(0).innerHTML == i) {
            grid.rows(k).className = 'highlight GridRowSelected';
            selectedPost = grid.rows(k).cells(0).innerHTML;
        }
        else grid.rows(k).className = 'GridItem';

    }

}
//client row click function
// gridName + SelectedRowId hidden field must be in page

function RowObject(grid, row, prevRowSelect, SelectedRowIndex) {
    this.grid = grid;
    this.row = row;
    this.prevRowSelect = prevRowSelect;
    this.SelectedRowIndex = SelectedRowIndex;
    this.Style = "";
    this.RowClick = function () {
        if (this.row == undefined) return false;
        if (this.grid == undefined) return false;
        if (typeof this.grid == 'string')
            this.grid = document.getElementById(this.grid);
        else
            this.grid = document.getElementById(this.grid.id);
        if (this.grid == null) return false;
        if (this.row > this.grid.rows.length) this.row = 0;
        if (this.grid.rows.length == 1) return false;
        //13931004
        //var GridSize = document.getElementById('DbnavigatorPage1_txtGridSize').value;
        var GridSize = 15;
        if (document.getElementById('DbnavigatorPage1_txtGridSize')) GridSize = document.getElementById('DbnavigatorPage1_txtGridSize').value;

        this.SelectedRowIndex = this.row;
        if (this.row == -1) return false;
        if ((this.prevRowSelect != -2) && (this.prevRowSelect < this.grid.rows.length)) {
            k = (this.prevRowSelect % 2);
            if (k == 0) this.grid.rows[this.prevRowSelect].className = 'GridAlternating' + this.Style;
            else this.grid.rows[this.prevRowSelect].className = 'GridItem' + this.Style;
        }

        this.prevRowSelect = this.row + 1;
        if (this.prevRowSelect >= this.grid.rows.length) this.prevRowSelect = this.grid.rows.length - 1;
        this.grid.rows[this.prevRowSelect].className = 'highlight GridRowSelected' + this.Style;
        //13931004
        if (document.getElementById('DbnavigatorPage1_lblCurrentPage')) {
            var index = (parseInt(document.getElementById('DbnavigatorPage1_lblCurrentPage').value) - 1) * GridSize;
            document.getElementById('DbnavigatorPage1_lblCurrentItem').value = (this.prevRowSelect + index);
        }

        return true;
    }

}


var prevRowSelect = -2;
var SelectedRowIndex;

function ___RowClick(grid, row) {
    var GridSize = document.all.DBNavigator1_txtGridSize.value;
    SelectedRowIndex = row;
    if (row == -1) return;
    if ((prevRowSelect != -2) && (prevRowSelect < grid.rows.length)) {
        k = (prevRowSelect % 2);

        if (k == 0) grid.rows(prevRowSelect).className = 'GridAlternating';
        else grid.rows(prevRowSelect).className = 'GridItem';
    }
    prevRowSelect = row + 1;
    grid.rows(row + 1).className = 'highlight GridRowSelected';
    document.getElementById(grid.id + "Serial").value = grid.rows(prevRowSelect).cells(0).innerText;
    // عدد 10 مساوي اندازه صفحه مي باشد
    //var index = (parseInt(document.all.DBNavigator1_lblCurrentPage.value) - 1) * 10;
    var index = (parseInt(document.all.DBNavigator1_lblCurrentPage.value) - 1) * GridSize;
    document.all.DBNavigator1_lblCurrentItem.value = (prevRowSelect + index);
}

function RowClick2(grid, row) {
    // Use This Function For Detail Function
    SelectedRowIndex2 = row;
    if (row == -1) return;
    if ((prevRowSelect != -2) && (prevRowSelect < grid.rows.length)) {
        k = (prevRowSelect % 2);

        if (k == 0) grid.rows(prevRowSelect).className = 'GridAlternating';
        else grid.rows(prevRowSelect).className = 'GridItem';
    }
    prevRowSelect = row + 1;
    grid.rows(row + 1).className = 'highlight GridRowSelected';
    document.getElementById(grid.id + "Serial").value = grid.rows(prevRowSelect).cells(0).innerText;
}


function GridKeyUp(grid, row) {
    var key;
    key = window.event.keyCode;
    if (key == 38) {
        if (SelectedRowIndex > 0)
            SelectedRowIndex = SelectedRowIndex - 1;
        RowClick(grid, SelectedRowIndex);
    }
    else if (key == 40) {
        if (SelectedRowIndex < document.all.DataGrid1.rows.length - 2)
            SelectedRowIndex = SelectedRowIndex + 1
        RowClick(grid, SelectedRowIndex);
    }

}
var SelectedRowIndex1;
function GridKeyUp1(grid, row) {
    var key;
    key = window.event.keyCode;
    if (key == 38) {
        if (SelectedRowIndex1 > 0)
            SelectedRowIndex1 = SelectedRowIndex1 - 1;
        RowClick1(grid, SelectedRowIndex1);
    }
    else if (key == 40) {
        if (SelectedRowIndex1 < document.all.DataGrid1.rows.length - 2)
            SelectedRowIndex1 = SelectedRowIndex1 + 1
        RowClick1(grid, SelectedRowIndex1);
    }
}

var SelectedRowIndex2;
function GridKeyUp2(grid, row) {
    var key;
    key = window.event.keyCode;
    if (key == 38) {
        if (SelectedRowIndex2 > 0)
            SelectedRowIndex2 = SelectedRowIndex2 - 1;
        RowClick2(grid, SelectedRowIndex2);
    }
    else if (key == 40) {
        if (SelectedRowIndex2 < document.getElementById(grid.id).rows.length - 2)
            SelectedRowIndex2 = SelectedRowIndex2 + 1
        RowClick2(grid, SelectedRowIndex2);
    }
}

// عدم دسترسي به اطلاعات پرونده
function btnfrmMngrAccess_onclick() {
    Serial = document.all.ucFormManager1_txtDataSerial.value;
    obj = new Object();
    wr = windowModal2('../DMS/PostAccessForm.aspx?FormName=FolderDataAccess&Serial=' + Serial, 600, 400, obj);
}


function navigatePage() {
    var key
    key = window.event.keyCode
    if (key != 13) {
        return true;
    }
    else {
        __doPostBack('DBNavigator1$btnGo', '')
        return false;
    }
}
function NavigateRow() {
    var key
    key = window.event.keyCode
    if (key != 13) {
        return true;
    }
    else {
        __doPostBack('DBNavigator1$btnGoRow', '')
        return false;
    }
}

function Print() {
    window.print();
    //	window.open('../DMS/DocumentResualtfrm.aspx?Serial=' + param,'','toolbar=yes,width=900,scrollbars=yes,resizable=yes,status=yes', false);      

}
function CheckReq(fname) {
    if (document.getElementById(fname).value == '')
    { alert('لطفا اطلاعات مورد نیاز را تکمیل نمایید'); return false; }
    else return true;
}
function Navigate(url) {
    document.all.main.src = url;

}
function CorrectCharCode() {
    var key;
    key = window.event.keyCode;
    if (key == 1740) window.event.keyCode = 1610;
    window.event.returnValue = true
}
function CloseAndRebind() {

    if (parent.frmnnpcontrol != null) {
        parent.frmnnpcontrol._acceptButton.refreshGrid('UnFilter');
        parent.frmnnpcontrol.close();
    }
    else {
        parent.refreshGrid('UnFilter');
        parent.TogglePopupPanel('no', '', 0, 0, '');
    }
    return;
}
function CancelEdit() {
    if (parent.frmnnpcontrol != null)
        parent.frmnnpcontrol.close();
    else
        parent.TogglePopupPanel('no', '', 0, 0, '');
}

function SetPopupPanelSetting() {
    divCaptionm = document.getElementById('PopupPanelHeader');
    divCaptionm.style.cursor = "move";
    formContent = document.getElementById('PopupPanelContent');
    function SetEvent() {
        document.onmousemove = function (event) {
            var e = event || window.event;

            if (isDrag) {
                var x = e.clientX + xx;
                var y = e.clientY + yy;
                formContent.style.left = x;
                formContent.style.top = y;
                formContent.style.filter = 'alpha(opacity=80)';
            }
        };
        document.onmouseup = function () {
            isDrag = false;
            formContent.style.filter = 'alpha(opacity=100)';


        };
        divCaptionm.onmousedown = function (event) {
            var e = window.event;

            if (e.button == 1 && flagSize == 0) {
                xx = formContent.offsetLeft - e.clientX;
                yy = formContent.offsetTop - e.clientY;
                isDrag = true;
            }
        };
    }
    SetEvent();
}
isDrag = false; form = null; formContent = null; flagSize = 0; xx = 0; yy = 0;

/*function TogglePopupPanel(title, url, width, height, iconurl) {


if (!form) {

form = document.createElement("DIV");
form.style.display = "none";
form.innerHTML = "<iframe class='PopupPanelModalArea' frameborder='0' scrolling='0' id='PopupPanelModalArea' dir='rtl'></iframe>" +
"<div id='PopupPanelContent'  class='PopupPanel'>" +
"<table border='0' cellpadding='0' cellspacing='0' height='100%' width='100%'>" +
"<tr height='22px' id='PopupPanelHeader' ><td  class='PopupPanelHeaderRight'><img class='PopupPanelImgBlank'/></td>" +
"<td class='PopupPanelHeader'><img  onclick=TogglePopupPanel('no','',0,0,'') class='PopupPanelImgClose'  title='Close' /></td>" +
"<td class='PopupPanelHeader' width='100%' > <p class='TitleBar' id='TitleText' align='center' >عنوان فرم</p> </td>" +
"<td class='PopupPanelHeader'><img  id='PopUpIcon'  src='CSS/MyWindow/Img/Maximize.gif' style='cursor: hand;' title='' /></td>" +
"<td class='PopupPanelHeaderLeft' >&nbsp;</td></tr><tr>" +
"<td colspan=5 style='border-right: #3b5a82 1pt solid; border-top: #3b5a82 1pt solid; border-left: #3b5a82 1pt solid; border-bottom: #3b5a82 1pt solid;'>" +
"<iframe frameborder='0' scrolling='0' id='Contentframe' dir='rtl' style='height: 100%;width:100%'></iframe></td></tr></table></div>";
document.body.appendChild(form);
SetPopupPanelSetting()
}

var panelContainer = form;  //document.getElementById("PopupPanel");
document.getElementById('TitleText').innerText = title;
if (panelContainer.style.display == "none") {
panelContainer.style.display = "";
document.getElementById('Contentframe').src = url;
document.getElementById('PopupPanelContent').style.width = width;
document.getElementById('PopupPanelContent').style.height = height;
var x = 800;
var y = 600;
/*if (screen){
x = (screen.availWidth - width) / 2;
y = (screen.availHeight - height) / 2;
}*/
/*if (document.body) {
x = (document.body.clientWidth - width) / 2;
y = (document.body.clientHeight - height) / 2;
}
document.getElementById('PopupPanelContent').style.left = x;
document.getElementById('PopupPanelContent').style.top = y;
if (iconurl != '') document.getElementById('PopUpIcon').src = iconurl;
//document.getElementById('PopupPanelModalArea').focus();
//document.body.onfocus = function() { document.getElementById('PopupPanelModalArea').focus(); };
}
else {
panelContainer.style.display = "none";
document.getElementById('Contentframe').src = "";
document.body.onfocus = function() { return true; };
}
}

original
function TogglePopupPanel(title,url,width,height,iconurl)
{

var panelContainer = document.getElementById("PopupPanel");
document.getElementById('TitleText').innerText=title;
if (panelContainer.style.display == "none")
{
panelContainer.style.display = "";
document.getElementById('Contentframe').src=url;
document.getElementById('PopupPanelContent').style.width=width;
document.getElementById('PopupPanelContent').style.height=height;	
var x =800;
var y = 600;
//if (screen){
//    x = (screen.availWidth - width) / 2;
//    y = (screen.availHeight - height) / 2;
//}
if (document.body){
x = (document.body.clientWidth - width) / 2;
y = (document.body.clientHeight - height) / 2;
}       
document.getElementById('PopupPanelContent').style.left=x;
document.getElementById('PopupPanelContent').style.top=y;
if (iconurl != '') document.getElementById('PopUpIcon').src = iconurl;
//document.getElementById('PopupPanelModalArea').focus();
//document.body.onfocus = function() { document.getElementById('PopupPanelModalArea').focus(); };
}
else
{
panelContainer.style.display = "none";
document.getElementById('Contentframe').src="";
document.body.onfocus = function() { return true; };
}
}
*/

//Golshan
function trim(str, chars) {
    return ltrim(rtrim(str, chars), chars);
}
function ltrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
function rtrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function getQueryStrings() {
    var argList = new Object();
    if (window.location != null && window.location.search.length > 1) {
        var urlParms = window.location.search.substring(1);
        var argPairs = urlParms.split('&');
        for (var i = 0; i < argPairs.length; i++) {
            var pos = argPairs[i].indexOf('=')
            if (pos == -1) continue;
            else {
                var argName = argPairs[i].substring(0, pos);
                var argVal = decodeURI(argPairs[i].substring(pos + 1));
                if (argVal.indexOf('+') != -1)
                    argVal = argVal.replace(/\+/g, ' ');
                argList[argName] = unescape(argVal);
            }
        }
    }
    return argList;
}
function isEnterPressed(e) {
    var _char
    if (e && e.which) {
        e = e;
        _char = e.which;
    }
    else {
        e = event;
        _char = e.keyCode;
    }
    if (_char == 13) return true;
    else return false;
};

//Genral Function
var timeID2;
/*maha 1393
function AfterLoadPage() {

    window.clearTimeout(timeID2);
    if (document.readyState == "interactive" || document.readyState == "complete") {

        if (document.body) {
            document.body.onkeypress = function () { return FarsiKeyPress(); }
            document.body.onkeydown = function () { return FarsiKeyDown(); }
        }
    }
    else setTimersAfterLoadPage();
}
function setTimersAfterLoadPage() {

    timeID2 = window.setTimeout("AfterLoadPage()", 200);
}
setTimersAfterLoadPage();
*/

//maha
var _form = null;
function TogglePopupPanel(title, url, width, height, iconurl) {

    if (title != 'no') {
        _form = new NNPControlToolkit.Form();
        _form.show(title, url, width, height, iconurl);
    } else { _form.close(); };
}
function TogglePopupDiv(title, divid, width, height, iconurl) {
    if (title != 'no') {
        //if (NNPform != null) NNPform.close();
        if (_form == null)
            _form = new NNPControlToolkit.Form();
        _form._isdivpanel = 1;
        _form.show(title, divid, width, height, iconurl);
    } else _form.close();
}
//savadinejad
/*var NNPform = null;
function TogglePopupPanel(title, url, width, height, iconurl) {
if (title != 'no') {
if (NNPform != null) NNPform.Free();
NNPform = new NNP.Form();
NNPform.show(title, url, width, height, iconurl);
} else NNPform.close();
}*/
var NNPformChild = null;
function TogglePopupPanelChild(title, url, width, height, iconurl) {
    if (title != 'no') {
        if (NNPformChild != null) NNPformChild.Free();
        NNPformChild = new NNP.Form();
        NNPformChild.show(title, url, width, height, iconurl);
    } else NNPformChild.close();
}


//Detect Browser Type and version
var BrowserDetect = {
    init: function () {
        this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
        this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
        this.OS = this.searchString(this.dataOS) || "an unknown OS";
    },
    searchString: function (data) {
        for (var i = 0; i < data.length; i++) {
            var dataString = data[i].string;
            var dataProp = data[i].prop;
            this.versionSearchString = data[i].versionSearch || data[i].identity;
            if (dataString) {
                if (dataString.indexOf(data[i].subString) != -1)
                    return data[i].identity;
            }
            else if (dataProp)
                return data[i].identity;
        }
    },
    searchVersion: function (dataString) {
        var index = dataString.indexOf(this.versionSearchString);
        if (index == -1) return;
        return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
    },
    dataBrowser: [
		{
		    string: navigator.userAgent,
		    subString: "Chrome",
		    identity: "Chrome"
		},
		{
		    string: navigator.userAgent,
		    subString: "OmniWeb",
		    versionSearch: "OmniWeb/",
		    identity: "OmniWeb"
		},
		{
		    string: navigator.vendor,
		    subString: "Apple",
		    identity: "Safari",
		    versionSearch: "Version"
		},
		{
		    prop: window.opera,
		    identity: "Opera"
		},
		{
		    string: navigator.vendor,
		    subString: "iCab",
		    identity: "iCab"
		},
		{
		    string: navigator.vendor,
		    subString: "KDE",
		    identity: "Konqueror"
		},
		{
		    string: navigator.userAgent,
		    subString: "Firefox",
		    identity: "Firefox"
		},
		{
		    string: navigator.vendor,
		    subString: "Camino",
		    identity: "Camino"
		},
		{		// for newer Netscapes (6+)
		    string: navigator.userAgent,
		    subString: "Netscape",
		    identity: "Netscape"
		},
		{
		    string: navigator.userAgent,
		    subString: "MSIE",
		    identity: "Explorer",
		    versionSearch: "MSIE"
		},
		{
		    string: navigator.userAgent,
		    subString: "Gecko",
		    identity: "Mozilla",
		    versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
		    string: navigator.userAgent,
		    subString: "Mozilla",
		    identity: "Netscape",
		    versionSearch: "Mozilla"
		}
    ],
    dataOS: [
		{
		    string: navigator.platform,
		    subString: "Win",
		    identity: "Windows"
		},
		{
		    string: navigator.platform,
		    subString: "Mac",
		    identity: "Mac"
		},
		{
		    string: navigator.userAgent,
		    subString: "iPhone",
		    identity: "iPhone/iPod"
		},
		{
		    string: navigator.platform,
		    subString: "Linux",
		    identity: "Linux"
		}
    ]

};


function getObjInnerText(obj) {
    BrowserDetect.init();
    try {
        if (BrowserDetect.browser == 'Explorer') { // IE;
            return obj.innerText.trim();
        }
        else {
            return obj.textContent.trim();
        }
    }
    catch (err) {
        alert(err);
    }
}


function setObjInnerText(obj, textvalue) {
    BrowserDetect.init();
    try {
        if (BrowserDetect.browser == 'Explorer') //IE
            obj.innerText = textvalue;
        else obj.textContent = textvalue;
    }
    catch (err)
    { alert(err) };
}


function checkDur(StartDate, EndDate, DayNo) {
    var s = window.location.href.toLowerCase();
    var DateDiffer = '';
    if (StartDate && EndDate) {
        if (EndDate < StartDate) {
            alert("!!!تاریخ پایان کمتر از تاریخ شروع می باشد");
        }
        var StartYear = MakeEnglishDate(StartDate).substring(0, 4);
        var EndYear = MakeEnglishDate(EndDate).substring(0, 4);
        var StartCountDay = DateCount(MakeEnglishDate(StartDate));
        var EndCountDay = DateCount(MakeEnglishDate(EndDate));

        if (StartCountDay > EndCountDay + (EndYear - StartYear) * 360) DateDiffer = '';
        else DateDiffer = (EndYear - StartYear) * 360 + (EndCountDay - StartCountDay + 1);

        document.getElementById(DayNo).value = DateDiffer;
    }

}

function DurationTime(StartTime, EndTime, DurTime) {
    var st;
    var et;
    if (StartTime != "__:__" && EndTime != "__:__") {
        if (isNaN(StartTime) && isNaN(EndTime)) {
            st = StartTime;
            et = EndTime;
            var ss = st.split(":");
            var sHour = parseInt(ss[0], 10);
            var sMin = parseInt(ss[1], 10);
            var startTime = sHour * 60 + sMin;

            var ee = et.split(":");
            var endHour = parseInt(ee[0], 10);
            var endMin = parseInt(ee[1], 10);
            var endTime = endHour * 60 + endMin;

            if (endTime > startTime) {
                var dur = String(parseInt(endTime - startTime) / 60);
                var a = dur.split(".");
                var hour = String(parseInt(a[0], 10));
                if (hour.length == 1)
                    hour = '0' + hour;
                if (a[1] != null)
                    var min = String(parseInt(endTime - startTime) % 60);
                else
                    min = '00';
                if (min.length == 1)
                    min = '0' + min;
                var duration = String(hour) + ":" + min;
                document.getElementById(DurTime).value = duration;
            }
            else
                alert('ساعت پایان کمتر از ساعت شروع می باشد');
        }
    }
}
function DateCount(s) {
    var ss = s.split("/");
    if (ss[0] == '08') ss[0] = '8';
    if (ss[0] == '09') ss[0] = '9';
    if (ss[1] == '08') ss[1] = '8';
    if (ss[1] == '09') ss[1] = '9';
    if (ss[2] == '08') ss[2] = '8';
    if (ss[2] == '09') ss[2] = '9';

    var dday = parseInt(ss[2]);
    var dmonth = parseInt(ss[1]);
    var dyear = parseInt(ss[0]);

    if ((dmonth <= 6) && (dday == 31)) dday = 31;
    if ((dmonth == 12) && (dday == 29)) dday = 29;

    if ((dmonth <= 6)) return 31 * (dmonth - 1) + dday;
    if ((dmonth > 6 && dmonth <= 12)) {
        var c = 6 * 31;
        return c + (dmonth - 7) * 30 + dday;
    }
    //    if ((dmonth <= 6) && (dday == 31)) dday = 30;
    //    if ((dmonth == 12) && (dday == 29)) dday = 30;

    //    return 30 * (dmonth - 1) + dday;
}

function MakeEnglishDate(s) {
    var s2 = "";
    for (i = 0; i < s.length; i++) {
        c = s.charCodeAt(i);
        if ((c >= 1776) && (c <= 1785)) {
            c = c - 1728;
        }

        s2 += String.fromCharCode(c);
    }
    return s2;
}


function alert2(msg) { alert(msg); }


function isNumberOnly() {
    var charCode = event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function FormatNumberBy3(num, decpoint, sep) {
    // check for missing parameters and use defaults if so
    if (arguments.length == 2) {
        sep = ",";
    }
    if (arguments.length == 1) {
        sep = ",";
        decpoint = ".";
    }
    // need a string for operations
    num = num.toString();
    // separate the whole number and the fraction if possible
    a = num.split(decpoint);
    x = a[0]; // decimal
    y = a[1]; // fraction
    z = "";


    if (typeof (x) != "undefined") {
        // reverse the digits. regexp works from left to right.
        for (i = x.length - 1; i >= 0; i--)
            z += x.charAt(i);
        // add seperators. but undo the trailing one, if there
        z = z.replace(/(\d{3})/g, "$1" + sep);
        if (z.slice(-sep.length) == sep)
            z = z.slice(0, -sep.length);
        x = "";
        // reverse again to get back the number
        for (i = z.length - 1; i >= 0; i--)
            x += z.charAt(i);
        // add the fraction back in, if it was there
        if (typeof (y) != "undefined" && y.length > 0)
            x += decpoint + y;
    }
    return x;
}
function Confirm_Delete(deltype) {
    return confirm(" حذف" + deltype + "آیا مطمئن هستید؟");
}

function alltrim(str) {
    return str.replace(/^\s+|\s+$/g, '');
}

function validatefloat(sender, args) {
    var input = document.getElementById(sender.controltovalidate).value;
    var len = input.length;
    var str = "";
    for (var i = 0; i <= input.length - 1; i++) {
        chCode = input.charCodeAt(i);
        if ((chCode >= 1776) && (chCode <= 1785))  //farsi numbers 
            str = str + String.fromCharCode(chCode - 1728);
        else if ((chCode >= 48) && (chCode <= 57)) // english numbers
            str = str + String.fromCharCode(chCode);
        else if ((chCode == 44)) // charachter  ',' replace with charachter '.'
            str = str + String.fromCharCode(46);

        else str = str + String.fromCharCode(chCode);
    }

    var valid;
    var val;
    val = "exp3";
    switch (val) {
        case "exp1":
            valid = test1(str);
            break;
        case "exp2":
            valid = test2(str);
            break;
        case "exp3":
            valid = test3(str);
            break;
        default:
            valid = false;
    }
    function test1(str) {
        str = alltrim(str);
        return /^[-+]?[0-9]+(\.[0-9]+)?$/.test(str);
    }
    function test2(str) {
        str = alltrim(str);
        return /^[-+]?\d+(\.\d+)?$/.test(str);
    }
    function test3(str) {
        str = alltrim(str);
        return /^[-+]?\d{1,3}(\.\d{1,3})?$/.test(str);
    }
    args.IsValid = (valid) ? true : false;
}

function LockHeaders(_grid) {

    for (var x = 1; x <= 30; x++)
        if ((document.getElementById('id' + _grid + '-1c_' + x) != null) && (document.getElementById('div-datagrid') != null))
            document.getElementById('id' + _grid + '-1c_' + x).style.top = document.getElementById('div-datagrid').scrollTop;
}


function mod(a, b) { return a - (b * Math.floor(a / b)); }
/*
JavaScript functions for the Fourmilab Calendar Converter

by John Walker  --  September, MIM
http://www.fourmilab.ch/documents/calendar/

This program is in the public domain.
*/
function leap_gregorian(year) {
    return ((year % 4) == 0) &&
            (!(((year % 100) == 0) && ((year % 400) != 0)));
}
var GREGORIAN_EPOCH = 1721425.5;
function gregorian_to_jd(year, month, day) {
    return (GREGORIAN_EPOCH - 1) +
           (365 * (year - 1)) +
           Math.floor((year - 1) / 4) +
           (-Math.floor((year - 1) / 100)) +
           Math.floor((year - 1) / 400) +
           Math.floor((((367 * month) - 362) / 12) +
           ((month <= 2) ? 0 :
                               (leap_gregorian(year) ? -1 : -2)
           ) +
           day);
}
function jd_to_gregorian(jd) {
    var wjd, depoch, quadricent, dqc, cent, dcent, quad, dquad,
        yindex, dyindex, year, yearday, leapadj;

    wjd = Math.floor(jd - 0.5) + 0.5;
    depoch = wjd - GREGORIAN_EPOCH;
    quadricent = Math.floor(depoch / 146097);
    dqc = mod(depoch, 146097);
    cent = Math.floor(dqc / 36524);
    dcent = mod(dqc, 36524);
    quad = Math.floor(dcent / 1461);
    dquad = mod(dcent, 1461);
    yindex = Math.floor(dquad / 365);
    year = (quadricent * 400) + (cent * 100) + (quad * 4) + yindex;
    if (!((cent == 4) || (yindex == 4))) {
        year++;
    }
    yearday = wjd - gregorian_to_jd(year, 1, 1);
    leapadj = ((wjd < gregorian_to_jd(year, 3, 1)) ? 0
                                                  :
                  (leap_gregorian(year) ? 1 : 2)
              );
    month = Math.floor((((yearday + leapadj) * 12) + 373) / 367);
    day = (wjd - gregorian_to_jd(year, month, 1)) + 1;

    return new Array(year, month, day);
}

function leap_islamic(year) {
    return (((year * 11) + 14) % 30) < 11;
}
var ISLAMIC_EPOCH = 1948439.5;
function islamic_to_jd(year, month, day) {
    return (day +
            Math.ceil(29.5 * (month - 1)) +
            (year - 1) * 354 +
            Math.floor((3 + (11 * year)) / 30) +
            ISLAMIC_EPOCH) - 1;
}
function jd_to_islamic(jd) {
    var year, month, day;

    jd = Math.floor(jd) + 0.5;
    year = Math.floor(((30 * (jd - ISLAMIC_EPOCH)) + 10646) / 10631);
    month = Math.min(12,
                Math.ceil((jd - (29 + islamic_to_jd(year, 1, 1))) / 29.5) + 1);
    day = (jd - islamic_to_jd(year, month, 1)) + 1;
    return new Array(year, month, day);
}

function leap_persian(year) {
    return ((((((year - ((year > 0) ? 474 : 473)) % 2820) + 474) + 38) * 682) % 2816) < 682;
}
var PERSIAN_EPOCH = 1948320.5;
function persian_to_jd(year, month, day) {
    var epbase, epyear;

    epbase = year - ((year >= 0) ? 474 : 473);
    epyear = 474 + mod(epbase, 2820);

    return day +
            ((month <= 7) ?
                ((month - 1) * 31) :
                (((month - 1) * 30) + 6)
            ) +
            Math.floor(((epyear * 682) - 110) / 2816) +
            (epyear - 1) * 365 +
            Math.floor(epbase / 2820) * 1029983 +
            (PERSIAN_EPOCH - 1);
}
function jd_to_persian(jd) {
    var year, month, day, depoch, cycle, cyear, ycycle,
        aux1, aux2, yday;
    jd = Math.floor(jd) + 0.5;
    depoch = jd - persian_to_jd(475, 1, 1);
    cycle = Math.floor(depoch / 1029983);
    cyear = mod(depoch, 1029983);
    if (cyear == 1029982) {
        ycycle = 2820;
    } else {
        aux1 = Math.floor(cyear / 366);
        aux2 = mod(cyear, 366);
        ycycle = Math.floor(((2134 * aux1) + (2816 * aux2) + 2815) / 1028522) +
                    aux1 + 1;
    }
    year = ycycle + (2820 * cycle) + 474;
    if (year <= 0) {
        year--;
    }
    yday = (jd - persian_to_jd(year, 1, 1)) + 1;
    month = (yday <= 186) ? Math.ceil(yday / 31) : Math.ceil((yday - 6) / 30);
    day = (jd - persian_to_jd(year, month, 1)) + 1;
    return new Array(year, month, day);
}

function LockGridHeaders(grid) {
   
    return;
    if (grid == null) return;
    for (var x = 1; x <= grid.rows[0].cells.length; x++) {
      
        if (document.getElementById('id' + grid.id + '-1c_' + x) != null) {
            /*w = document.getElementById('id' + grid.id + '-1c_' + x).clientWidth;
            t = document.getElementById('id' + grid.id + '-1c_' + x).offsetTop;
            l = document.getElementById('id' + grid.id + '-1c_' + x).offsetLeft;
            document.getElementById('id' + grid.id + '-1c_' + x).style.position = 'fixed';
            $('#' + 'id' + grid.id + '-1c_' + x).width(w);
            $('#' + 'id' + grid.id + '-1c_' + x).left(l);
            $('#' + 'id' + grid.id + '-1c_' + x).top(t);*/
            //document.getElementById('id' + grid.id + '-1c_' + x).style.position = 'absolut';
            document.getElementById('id' + grid.id + '-1c_' + x).style.top = 0;       }
    }
}

//--این تابع در همه بروزرها درست کار کرده و سطرها را ثابت می کند
gridonload = function (GridId) {
    var ScrollHeight = 300;
    var grid = document.getElementById(GridId);
    var gridWidth = grid.offsetWidth - 15;
    var gridHeight = grid.offsetHeight;
    var headerCellWidths = new Array();
    for (var i = 0; i < grid.getElementsByTagName("TH").length; i++) {
        headerCellWidths[i] = grid.getElementsByTagName("TH")[i].offsetWidth;
    }
    grid.parentNode.appendChild(document.createElement("div"));
    var parentDiv = grid.parentNode;

    var table = document.createElement("table");
    for (i = 0; i < grid.attributes.length; i++) {
        if (grid.attributes[i].specified && grid.attributes[i].name != "id") {
            table.setAttribute(grid.attributes[i].name, grid.attributes[i].value);
        }
    }
    table.style.cssText = grid.style.cssText;
    table.style.width = gridWidth + "px";
    table.appendChild(document.createElement("tbody"));
    table.getElementsByTagName("tbody")[0].appendChild(grid.getElementsByTagName("TR")[0]);
    var cells = table.getElementsByTagName("TH");

    var gridRow = grid.getElementsByTagName("TR")[0];
    for (var i = 0; i < cells.length; i++) {
        var width;
        if (headerCellWidths[i] > gridRow.getElementsByTagName("TD")[i].offsetWidth) {
            width = headerCellWidths[i];
        }
        else {
            width = gridRow.getElementsByTagName("TD")[i].offsetWidth;
        }
        cells[i].style.width = parseInt(width - 3) + "px";
        gridRow.getElementsByTagName("TD")[i].style.width = parseInt(width - 3) + "px";
    }
    parentDiv.removeChild(grid);
    var dummyHeader = document.createElement("div");
    dummyHeader.appendChild(table);
    parentDiv.appendChild(dummyHeader);
    var scrollableDiv = document.createElement("div");
    if (parseInt(gridHeight) > ScrollHeight) {
        gridWidth = parseInt(gridWidth) + 17;
    }
    scrollableDiv.style.cssText = "overflow:auto;height:" + ScrollHeight + "px;width:" + gridWidth + "px";
    scrollableDiv.appendChild(grid);
    parentDiv.appendChild(scrollableDiv);
}
//----------

function replaceCharacters(origString1) {
    var origString = origString1;
    var inChar = 'ی';
    var outChar = 'ي';
    var newString = origString.split(inChar);
    newString = newString.join(outChar);
    outChar = 'ک';
    inChar = 'ك';
    origString = newString;
    newString = origString.split(inChar);
    newString = newString.join(outChar);
    return newString;
}
