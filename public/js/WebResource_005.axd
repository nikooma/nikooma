NNP.registerNamespace('NNPControlToolkit');
NNPControlToolkit.Animation = function() {

    this._element = null;
    this._modeType = { top: "top", bottom: "top", left: "left", right: "left" };
    this._mode = "top";
    this._startValue = 0;
    this._endValue = 0;

};
NNPControlToolkit.Animation.prototype = {

    _start: function() {


    },
    _stop: function() { },
    _setProperty: function(startValue, endValue, mode, element) {


        if (typeof startValue !== 'undefined') { this._startValue = startValue; } else return;
        if (typeof endValue !== 'undefined') { this._endValue = endValue; } else return;
        if (typeof mode !== 'undefined') { this._mode = mode; } else return;
        if (typeof element !== 'undefined') { this._element = element; } else return;

    }

};
var _pAnimation = null;
NNPControlToolkit.ParallelAnimation = function() {
    this._animations = new Array();
    this._isPlay = false;
    this._time = 0;
    this._completeValue = 0;
    _pAnimation = this;
}
NNPControlToolkit.ParallelAnimation.prototype = {
    _play: function() {

        for (var i = 0; i < _pAnimation._animations.length; i++) {

            var elt = _pAnimation._animations[i]._element;
            var mode = _pAnimation._animations[i]._mode;
            var startValue = _pAnimation._animations[i]._startValue;
            var endValue = _pAnimation._animations[i]._endValue;
            if (startValue < endValue) {
                elt.style[mode] = parseInt(elt.style[mode]) + 10 + "px";
            }
            else
            { elt.style[mode] = parseInt(elt.style[mode]) - 10 + "px"; }
        }
        _pAnimation._completeValue = _pAnimation._completeValue - 10;
        try {
            if (_pAnimation._completeValue > 0) {
                setTimeout(_pAnimation._play, 10);

            }
            else { _pAnimation._handler(); }
        } catch (ex) { }
    },
    _setAnimation: function(animation) {

        if (animation != null)
            this._animations.push(animation);
        this._completeValue = animation._startValue - animation._endValue;
        if (this._completeValue < 0)
            this._completeValue = this._completeValue * -1;
    },
    _setTime: function(time) {

        this._time = time;
    },
    _handler: function() { return this._handle(); }
    , _Addhandler: function(handle) { this._handle = handle; },
    _clearAnimation: function() { this._animations = new Array(); this._completeValue = 0; }
}