var ViperTranslation = new function()
{
    var _strings = {};
    var _lang    = null;

    this.add = function(code, strings)
    {
        _strings[code] = strings;

    };

    this.isLoaded = function(code)
    {
        if (_strings[code]) {
            return true;
        }

        return false;
    };

    this.setLanguage = function(code)
    {
        _lang = code;

    };

    // Define the _() method.
    window._ = function(str) {
        if (_lang !== null && _strings[_lang]) {
            str = _strings[_lang][str] || str;
        }

        return str;
    };

};