/**
 * +--------------------------------------------------------------------+
 * | This Squiz Viper file is Copyright (c) Squiz Australia Pty Ltd     |
 * | ABN 53 131 581 247                                                 |
 * +--------------------------------------------------------------------+
 * | IMPORTANT: Your use of this Software is subject to the terms of    |
 * | the Licence provided in the file licence.txt. If you cannot find   |
 * | this file please contact Squiz (www.squiz.com.au) so we may        |
 * | provide you a copy.                                                |
 * +--------------------------------------------------------------------+
 */

(function(window) {

    function Viper(id, options, callback, editables)
    {
        this.id           = id;
        this._document    = document;
        this._browserType = null;
        this._specialKeys = [];
        this._prevRange   = null;
        this.enabled      = false;
        this.inlineMode   = false;

        this.HistoryManager = null;
        this.PluginManager  = null;
        this.Tools               = null;

        this._settings = {};

        this._viperElementHolder = null;
        this._subElementActive   = false;
        this._mainElem           = null;
        this._registeredElements = [];
        this._attributeGetModifiers = [];
        this._attributeSetModifiers = [];
        this._mouseDownEvent        = null;
        this._retrievingValues      = 0;

        // This var is used to store the range of Viper before it loses focus. Any plugins
        // that steal focus from Viper element can use getPreviousRange.
        this._viperRange = null;

        // Callback methods which are added by external objects.
        this.callbacks = {};

        if (!options) {
            options = {};
        }

        this.setSetting('emptyTableCellContent', '<br />');

        this.init();

        if (editables && editables.length > 0) {
            this.registerEditableElements(editables);
            for (var i = 0; i < editables.length; i++) {
                (function(editableElement) {
                    Viper.Util.addEvent(editableElement, 'mousedown', function(e) {
                        self.setEditableElement(editableElement);
                    });
                }) (editables[i]);
            }
        }

        if (options) {
            var self = this;
            this._processOptions(options, function() {
                if (callback) {
                    callback.call(self, self);
                }
            });
        }
    }

    Viper.document = document;
    Viper.window   = window;

    Viper.prototype = {

        /**
         * Initialise Viper.
         *
         * @return {void}
         */
        init: function()
        {
            this.Tools           = new Viper.Tools(this);
            this.HistoryManager  = new Viper.HistoryManager(this);
            this.PluginManager   = new Viper.PluginManager(this);
            this.KeyboardHandler = new Viper.KeyboardHandler(this);

            Viper.Selection._viper = this;

            this.registerCallback('Viper:setHtmlContent', 'Viper', function(content, callback) {
                callback.call(this, content);
                return function() {};
            });

        },

        destroy: function()
        {
            this.fireCallbacks('Viper:destroy');
            this.setEnabled(false);
            Viper.Util.removeEvent(Viper.Util.getDocuments(), '.' + this.getEventNamespace());

            if (this._viperElementHolder) {
                Viper.Util.remove(this._viperElementHolder);
            }

        },

        getId: function()
        {
            return this.id;

        },

        _processOptions: function(options, callback)
        {
            var self = this;
            for (var op in options) {
                var fn = 'set' + Viper.Util.ucFirst(op);
                if (fn === 'setSetting') {
                    delete options[op];
                    // Reserved.
                    continue;
                }

                if (Viper.Util.isFn(this[fn]) === true) {
                    this[fn](options[op], function() {
                        delete options[op];
                        self._processOptions(options, callback);
                    });
                    return;
                }

                fn = '_' + fn;
                if (Viper.Util.isFn(this[fn]) === true) {
                    this[fn](options[op], function() {
                        delete options[op];
                        self._processOptions(options, callback);
                    });
                    return;
                } else {
                    this.setSetting(op, options[op]);
                    delete options[op];
                    self._processOptions(options, callback);
                    return;
                }
            }//end for

            callback.call(this);

        },

        getPluginManager: function()
        {
            return this.PluginManager;

        },

        getHistoryManager: function()
        {
            return this.HistoryManager;

        },

        getKeyboardHandler: function()
        {
            return this.KeyboardHandler;

        },

        setSetting: function(setting, value)
        {
            this._settings[setting] = value;

            var fn = 'set' + Viper.Util.ucFirst(setting);
            if (Viper.Util.isFn(this[fn]) === true) {
                this[fn].call(this, value);
            }

        },

        /**
         * Sets the given settings.
         *
         * @param {object}  settings Setting name and value list.
         * @param {boolean} clean    If true then the original settings will be wiped out.
         *
         * @return void
         */
        setSettings: function(settings, clean)
        {
            if (clean === true) {
                this._settings = {};
            }

            for (var setting in settings) {
                this.setSetting(setting, settings[setting]);
            }

        },

        getSetting: function(setting)
        {
            return this._settings[setting];

        },

        getSettings: function()
        {
            return Viper.Util.clone(this._settings);

        },

        /**
         * Sets the custom class of this Viper instance.
         */
        setCustomClass: function(className)
        {
            this._settings['customClass'] = className;
            if (this._viperElementHolder) {
                Viper.Util.addClass(this._viperElementHolder, className)
            }

        },

        getDefaultBlockTag: function()
        {
            var defaultBlockTag = this.getSetting('defaultBlockTag');
            if (Viper.Util.isset(defaultBlockTag) === true) {
                return defaultBlockTag;
            }

            return 'p';

        },

        _setLanguage: function(lang, callback)
        {
            if (!lang) {
                return;
            }

            var code = null;
            var src  = null;
            if (typeof(lang) === 'object' && lang.code) {
                code = lang.code;
                src  = lang.src;
            } else {
                code = lang;
            }

            if (code) {
                // If given code is in en-au (language code - country code) format then just use the language code.
                code = code.replace(/-\w+/, '');
            }

            if (code === 'en') {
                callback.call(this);
                return;
            }

            if (!src) {
                src = this.getViperPath().replace(/\/build$/, '') + '/build/Translation/' + code + '.js';
            }

            if (Viper.Translation.isLoaded(code) === false && src) {
                Viper.Util.loadScript(src, function() {
                    Viper.Translation.setLanguage(code);
                    callback.call(this);
                }, 2000);
            } else {
                Viper.Translation.setLanguage(code);
                callback.call(this);
            }

        },

        /**
         * Adds a Viper related element to Viper elements holder.
         *
         * Plugins should use this method to add their elements to DOM.
         */
        addElement: function(element)
        {
            if (!element) {
                return;
            }

            if (!this._viperElementHolder) {
                this._viperElementHolder = this._createElementHolder();
            }

            this._viperElementHolder.appendChild(element);

        },

        _createElementHolder: function()
        {
            var holder = document.createElement('div');
            Viper.document.body.appendChild(holder);

            // Add browser type.
            var browser = Viper.Util.getBrowserType();
            var version = Viper.Util.getBrowserVersion();

            if (browser && version) {
                Viper.Util.addClass(holder, 'Viper-browser-' + browser);
                Viper.Util.addClass(holder, 'Viper-browserVer-' + browser + version);
            }

            if (this._settings.customClass) {
                Viper.Util.addClass(holder, this._settings.customClass);
            }

            return holder;

        },

        getElementHolder: function()
        {
            if (!this._viperElementHolder) {
                this._viperElementHolder = this._createElementHolder();
            }

            return this._viperElementHolder;

        },

        /**
         * Set Viper mode.
         *
         * If Viper is using "inline" mode then some of the actions will be disabled
         *
         * @param {string} mode The Viper mode (inline or block).
         *
         * @return {void}
         */
        setMode: function(mode)
        {
            if (mode === 'inline') {
                this.inlineMode = true;
            } else {
                this.inlineMode = false;
            }

        },

        /**
         * Returns the current browser type.
         *
         * @return {string}
         */
        getBrowserType: function()
        {
            if (this._browserType === null) {
                var tests = ['trident', 'msie', 'firefox', 'chrome', 'safari'];
                var tln   = tests.length;
                for (var i = 0; i < tln; i++) {
                    var r = new RegExp(tests[i], 'i');
                    if (r.test(navigator.userAgent) === true) {
                        if (tests[i] === 'trident') {
                            // No MSIE token for IE11+.
                            this._browserType = 'msie';
                        } else {
                            this._browserType = tests[i];
                        }

                        return this._browserType;
                    }
                }

                this._browserType = 'other';
            }

            return this._browserType;

        },

        /**
         * Returns the version of the current browser.
         *
         * @return {integer}
         */
        getBrowserVersion: function()
        {
            var browsers = ['MSIE', 'Trident', 'Chrome', 'Safari', 'Firefox'];
            var c        = browsers.length;
            var uAgent   = navigator.userAgent;

            var browserName = null;
            for (var i = 0; i < c; i++) {
                var nameIndex = uAgent.indexOf(browsers[i]);
                if (nameIndex >= 0) {
                    browserName = browsers[i];
                    break;
                }
            }

            if (!browserName) {
                return null;
            }

            if (browserName === 'Safari') {
                browserName = 'Version';
            }

            var re = null;
            if (browserName === 'MSIE') {
                re = new RegExp('MSIE (\\d+)');
            } else if (browserName === 'Trident') {
                re = new RegExp('rv:(\\d+)');
            } else {
                re = new RegExp(browserName + '/(\\d+)');
            }

            var matches = re.exec(uAgent);
            if (!matches) {
                return null;
            }

            return parseInt(matches[1]);

        },

        /**
         * Returns the path to the Viper JS file directory.
         *
         * Plugins can use this to load extra JS files.
         *
         * @return {string} Path to JS file directory.
         */
        getViperPath: function()
        {
            // TODO: This path may need to be set incase a different file name is used.
            var scripts = document.getElementsByTagName('script');
            var path    = null;
            var c       = scripts.length;
            for (var i = 0; i < c; i++) {
                if (scripts[i].src) {
                    if (scripts[i].src.match(/\/Lib\/Viper\.js.*/)) {
                        path = scripts[i].src.replace(/\/Lib\/Viper\.js.*/,'');
                        break;
                    } else if (scripts[i].src.match(/\/viper-combined\.js.*/)) {
                        path = scripts[i].src.replace(/\/viper-combined\.js.*/,'');
                        break;
                    } else if (scripts[i].src.match(/\/viper\.js.*/)) {
                        path = scripts[i].src.replace(/\/viper\.js.*/,'');
                        break;
                    }
                }
            }

            return path;

        },

        getEventNamespace: function()
        {
            return 'viper-' + this.id;

        },

        /**
         * Adds the events required for mouse navigating and key navigating/typing.
         *
         * @return {void}
         */
        _addEvents: function(elem)
        {
            if (!elem) {
                elem = this.element;
            }

            this._document = elem.ownerDocument;
            Viper.document = this._document;
            if (this._document.defaultView) {
                Viper.window = this._document.defaultView;
            } else {
                Viper.window = window;
            }

            var namespace = this.getEventNamespace();

            Viper.Util.removeEvent(Viper.Util.getDocuments(), '.' + namespace);
            this._removeEvents(elem);
            var self = this;

            if (Viper.Util.isBrowser('msie', '<11') === true) {
                Viper.Util.addEvent(elem, 'mouseup.' + namespace, function(e) {
                    return self.mouseUp(e);
                });
            } else {
                Viper.Util.addEvent(Viper.Util.getDocuments(), 'mouseup.' + namespace, function(e) {
                    return self.mouseUp(e);
                });
            }

            Viper.Util.addEvent(Viper.Util.getDocuments(), 'mousedown.' + namespace, function(e) {
                return self.mouseDown(e);
            });

            this.KeyboardHandler.init();

            Viper.Util.addEvent(elem, 'blur.' + namespace, function(e) {
                if (!self._viperRange) {
                    self._viperRange = self._currentRange;
                }
            });

            // This is necessary for IE, because IE does not return the current range when drop event fires.
            var _dragRange = null;
            Viper.Util.addEvent(elem, 'dragstart.' + namespace, function(e) {
                _dragRange = self.getViperRange();
            });

            Viper.Util.addEvent(elem, 'drop.' + namespace, function(e) {
                Viper.Util.preventDefault(e);

                e.originalEvent.dataTransfer.dropEffect = 'move';

                // Get the range using the mouse pointer (drop location).
                var range        = self.getRangeFromCoords(e.originalEvent.clientX, e.originalEvent.clientY);
                var dataTransfer = e.originalEvent.dataTransfer;
                var origRange    = null;

                if (origRange !== null) {
                    origRange = _dragRange.cloneRange();
                }

                // Call the callback functions with dataTransfer object, range and original event.
                if (self.fireCallbacks('Viper:dropped', {dataTransfer: dataTransfer, range: range.cloneRange(), e: e, origRange: origRange}) === false) {
                    return false;
                }

                var textPlain = null;
                if (dataTransfer.types) {
                    for (var i = 0; i < dataTransfer.types.length; i++) {
                        try {
                            var data = {
                                data: dataTransfer.getData(dataTransfer.types[i]),
                                range: range,
                                origRange: _dragRange
                            };
                        } catch (e) {
                            continue;
                        }

                        if (dataTransfer.types[i] === 'text/plain' || dataTransfer.types[i] === 'Text') {
                            textPlain = data;
                        }

                        // Fire callbacks for each data type.
                        if (self.fireCallbacks('Viper:dropped:' + dataTransfer.types[i], data) === false) {
                            return false;
                        }
                    }
                } else if (Viper.Util.isBrowser('msie', '8') === true) {
                    textPlain = dataTransfer.getData('text');
                     try {
                        var data = {
                            data: textPlain,
                            range: range,
                            origRange: _dragRange
                        };
                    } catch (e) {
                    }

                    if (self.fireCallbacks('Viper:dropped:Text', data) === false) {
                        return false;
                    }
                }

                // Nothing handled this drop try text/plain.
                if (textPlain !== null && textPlain.data) {
                    Viper.Selection.addRange(range);
                    self.insertNodeAtCaret(document.createTextNode(textPlain.data));
                }

                return false;
            });

            Viper.Util.addEvent(elem, 'focus.' + namespace, function(e) {
                if (self.fireCallbacks('Viper:viperElementFocused') === false) {
                    return;
                }

                self.highlightToSelection();
            });

            if (navigator.userAgent.match(/iPad/i) !== null) {
                // On the iPad we need to detect selection changes every few ms.
                setInterval(function() {
                    self.fireSelectionChanged();
                }, 500);

                // Add scaling.
                Viper.Util.addEvent(window, 'gestureend', function() {
                    var elements = Viper.Util.getClass('Viper-scalable');
                    var c        = elements.length;
                    for (var i = 0; i < c; i++) {
                        var scale = Viper.Tools.scaleElement(elements[i]);
                        self.fireCallbacks('Viper:elementScaled', {
                            element: elements[i],
                            scale: scale
                        });
                    }
                });
            }

        },

        /**
         * Removes the events required for mouse navigating and key navigating/typing.
         *
         * @return void
         */
        _removeEvents: function(elem)
        {
            if (!elem) {
                elem = this.element;
            }

            Viper.Util.removeEvent(elem, '.' + this.getEventNamespace());

        },

        /**
         * Enables or disables Viper.
         *
         * @param boolean enabled If true viper will be enabled, otherwise it will be
         *                        disabled.
         */
        setEnabled: function(enabled)
        {
            this._viperRange = null;

            var range = null;
            if (enabled === true && this.enabled === false) {
                this._addEvents();
                this.enabled = true;

                // Word-wrap attribute changes when contentEditable is set to true.
                this._setRadOnlyStyles()

                this.element.setAttribute('contentEditable', true);
                Viper.Util.setStyle(this.element, 'outline', 'none');

                if (Viper.Util.isBrowser('msie', '<11') === true) {
                    try {
                        range = this.getCurrentRange();
                        range.setStart(this.element, 0);
                        range.collapse(true);
                        Viper.Selection.addRange(range);
                    } catch (e) {
                        // Most likely a hidden element.
                    }
                } else {
                    this.focus();
                }

                if (!range) {
                    range = this.getCurrentRange();
                }

                if (this.rangeInViperBounds(range) === false) {
                    this.initEditableElement();
                }

                var editableChild = range._getFirstSelectableChild(this.element);
                if (!editableChild) {
                    // Check if any of these elements exist in the content.
                    var tags = 'iframe,img,object,table';
                    if (Viper.Util.getTag(tags, this.element).length === 0) {
                        var blockElement = null;
                        for (var node = this.element.firstChild; node; node = node.nextSibling) {
                            if (Viper.Util.isBlockElement(node) === true
                                && Viper.Util.isStubElement(node) === false
                            ) {
                                blockElement = node;
                                break;
                            }
                        }

                        if (blockElement) {
                            if (Viper.Util.isBrowser('msie') !== true) {
                                Viper.Util.setHtml(blockElement, '<br />');
                            } else {
                                blockElement.appendChild(document.createTextNode(' '));
                            }

                            editableChild = range._getFirstSelectableChild(this.element);
                        } else {
                            var tagName = this.getDefaultBlockTag();
                            if (!tagName) {
                                Viper.Util.setHtml(this.element, '');
                            } else {
                                blockElement = document.createElement(tagName);
                                Viper.Util.setHtml(blockElement, '&nbsp;');
                                this.element.appendChild(blockElement);
                                editableChild = range._getFirstSelectableChild(this.element);
                            }
                        }//end if
                    }//end if
                } else if (Viper.Util.isBrowser('firefox') === true) {
                    range.setStart(editableChild, 0);
                    range.collapse(true);
                    Viper.Selection.addRange(range);
                }//end if

                this.fireCallbacks('Viper:enabled');
            } else if (enabled === false && this.enabled === true) {
                // Back to final mode.
                this.cleanDOM(this.element);

                if (Viper.Util.trim(Viper.Util.getNodeTextContent(this.element)) === '') {
                    if (Viper.Util.isBrowser('msie') === true && Viper.Util.getTag('*', this.element).length === 0) {
                        // This check is to prevent iframe elements stuffing up the whole browser screen in IE8 when
                        // they are the only content on the page. Makes no sense but when
                        // did IE ever make sense?
                        this.initEditableElement();
                    }
                }

                this.element.setAttribute('contentEditable', false);
                Viper.Util.setStyle(this.element, 'outline', 'invert');
                this._removeEvents();
                this.enabled = false;

                // Fire disabled with previous state set to enabled.
                this.fireCallbacks('Viper:disabled', true);
            } else if (enabled === false) {
                // Fire disabled with previous state set to disabled.
                this.fireCallbacks('Viper:disabled', false);
            }//end if

        },

        enable: function()
        {
            this.setEnabled(true);

        },

        disable: function()
        {
            this.setEnabled(false);

        },

        /**
         * Returns true if Viper is enabled false otherwise.
         *
         * @return {boolean}
         */
        isEnabled: function()
        {
            return this.enabled;

        },

        /**
         * Sets the read only (contenteditable=false) styles so they remain the same when its set to true.
         */
        _setRadOnlyStyles: function () {
            if (!this.element) {
                return;
            }

            var styles = ['word-wrap'];
            for (var i = 0; i < styles.length; i++) {
                var value = Viper.Util.getComputedStyle(this.element, styles[i]);
                Viper.Util.setStyle(this.element, styles[i], value);
            }

        },

        /**
         * Sets the element that should be editable. The current element that is
         * editable will become non-editable.
         *
         * If you wish to have two elements that are editable simutaneously, then
         * construct to viper instances.
         *
         * @param DomElement elem The element to become editable.
         *
         * @return void
         */
        setEditableElement: function(elem)
        {
            var self = this;

            if (this.element === elem) {
                return;
            }

            // Load default plugin set if nothing has been set yet.
            if (this.PluginManager.getPlugins() === null) {
                this._useDefaultPlugins();
            }

            this._viperRange = null;

            if (this.element) {
                this.element.setAttribute('contentEditable', false);
                Viper.Util.setStyle(this.element, 'outline', 'invert');
            }

            this.setSubElementState(null, false);

            this.setEnabled(false);
            this.element = elem;
            Viper.Util.setViperElement(elem);

            if (Viper.Util.inArray(elem, this._registeredElements) === false) {
                this.registerEditableElement(elem);
            }

            this.setEnabled(true);
            this.HistoryManager.setActiveElement(elem);
            this.inlineMode = false;
            elem.setAttribute('contentEditable', true);
            Viper.Util.setStyle(elem, 'outline', 'none');

            this.fireCallbacks('Viper:editableElementChanged', {element: elem});

            // Create a text field that is off screen that will handle tabbing in to Viper.
            var tabTextfield  = Viper.Util.getid(this.getId() + '-tabTextfield');
            if (!tabTextfield) {
                tabTextfield = document.createElement('input');
                tabTextfield.type = 'text';
                tabTextfield.id   = this.getId() + '-tabTextfield';
                Viper.Util.setStyle(tabTextfield, 'left', '-9999px');
                Viper.Util.setStyle(tabTextfield, 'top', '-9999px');
                Viper.Util.setStyle(tabTextfield, 'position', 'absolute');
                Viper.Util.insertBefore(this.element, tabTextfield);
            }

            Viper.Util.addEvent(tabTextfield, 'focus', function(e) {
                tabTextfield.blur();
                self.setEnabled(true);

                self.element.focus();

                self.fireCallbacks('Viper:clickedInside', e);
                self.initEditableElement();

                var range = self.getCurrentRange();

                var selectable = range._getFirstSelectableChild(self.element);
                if (!selectable) {
                    var brTags = Viper.Util.getTag('br', self.element);
                    if (brTags.length > 0) {
                        range.selectNode(brTags[0]);
                    }
                }

                if (selectable) {
                    range.setEnd(selectable, 0);
                    range.setStart(selectable, 0);
                }

                range.collapse(true);
                Viper.Selection.addRange(range);
                self.fireSelectionChanged(range, true);
            });

            // If the document of this editable is different to Viper then add the highlight class to that document.
            if (document !== elem.ownerDocument) {
                var style       = elem.ownerDocument.createElement('style');
                style.innerHTML = '.__viper_selHighlight {background-color: #CCC !important;}';
                elem.ownerDocument.head.appendChild(style);
            }

        },

        registerEditableElements: function(elements)
        {
            for (var i = 0; i < elements.length; i++) {
                this.registerEditableElement(elements[i]);
            }

        },

        registerEditableElement: function(element)
        {
            this.initEditableElement(element);
            this._registeredElements.push(element);

        },

        initEditableElement: function(elem)
        {
            var elem = elem || this.element;
            if (!elem) {
                return;
            }

            if (Viper.Util.isBrowser('msie', '<11') === true) {
                // Find iframe elements for youtube.com videos to add wmode=opaque to query
                // string so that the video does not sit on top of the editor window in IE.
                var iframeTags = Viper.Util.getTag('iframe', elem);
                for (var i = 0; i < iframeTags.length; i++) {
                    var src = iframeTags[i].getAttribute('src');
                    if (src && src.match('youtube') && !src.match('wmode=opaque')) {
                        src = Viper.Util.addToQueryString(src, {wmode: 'opaque'});
                        iframeTags[i].src = src;
                    }
                }

                // Add wmode=transparent to old object code.
                var embedTags = Viper.Util.getTag('embed', elem);
                for (var i = 0; i < embedTags.length; i++) {
                    if (Viper.Util.isTag(embedTags[i].parentNode, 'object') === true) {
                        var paramTag = document.createElement('param');
                        paramTag.setAttribute('name', 'wmode');
                        paramTag.setAttribute('value', 'transparent');
                        Viper.Util.insertBefore(embedTags[i], paramTag);
                        embedTags[i].setAttribute('wmode', 'transparent');
                    }
                }
            }//end if

            var tmp     = Viper.document.createElement('div');
            var content = this.getContents(elem);
            content     = this._closeStubTags(content);
            Viper.Util.setHtml(tmp, content);

            if ((Viper.Util.trim(Viper.Util.getNodeTextContent(tmp)).length === 0 || Viper.Util.getHtml(tmp) === '&nbsp;')
                && Viper.Util.getTag('*', tmp).length === 0
            ) {
                // Check for stub elements.
                var tags         = Viper.Util.getTag('*', tmp);
                var hasStubElems = false;
                Viper.Util.foreach(tags, function(i) {
                    if (Viper.Util.isStubElement(tags[i]) === true) {
                        hasStubElems = true;
                        return false;
                    }
                });

                if (hasStubElems !== true) {
                    // Insert initial P tags.
                    var range    = this.getCurrentRange();
                    var blockTag = this.getDefaultBlockTag();
                    if (!blockTag) {
                        Viper.Util.setHtml(elem, '');
                        elem.appendChild(document.createTextNode(' '));
                    } else {
                        var emptyCont = '<br/>';
                        if (Viper.Util.isBrowser('msie', '<9') === true) {
                            emptyCont = '&nbsp;';
                        }

                        Viper.Util.setHtml(elem, Viper.Util.getHtml(elem) +  '<' + blockTag + '>' + emptyCont + '</' + blockTag + '>');
                    }

                    try {
                        range.setStart(elem.firstChild, 0);
                        range.setEnd(elem.firstChild, 0);
                        range.collapse(false);
                        Viper.Selection.addRange(range);
                    } catch (e) {
                        // Ignore.
                    }
                }
            } else {
                var cleanedContent = this.cleanHTML(content);
                if (cleanedContent !== content) {
                    Viper.Util.setHtml(elem, cleanedContent);
                }

                var defaultTagName = this.getDefaultBlockTag();
                if (defaultTagName) {
                    var nodesToRemove = [];
                    var childNode     = elem.firstChild;
                    while (childNode) {
                        var child = childNode;
                        childNode = child.nextSibling;
                        if ((Viper.Util.isBlockElement(child) === true && Viper.Util.isStubElement(child) === false)
                            || (child.nodeType !== Viper.Util.ELEMENT_NODE && child.nodeType !== Viper.Util.TEXT_NODE)
                            || Viper.Util.isTag(child, 'hr') === true
                            || Viper.Util.isTag(child, 'iframe') === true
                            || Viper.Util.isTag(child, 'object') === true
                        ) {
                            continue;
                        } else if (child.nodeType === Viper.Util.TEXT_NODE && Viper.Util.trim(child.data) === '') {
                            nodesToRemove.push(child);
                            continue;
                        }

                        var p = null;
                        if (child.previousSibling && Viper.Util.isTag(child.previousSibling, defaultTagName) === true) {
                            p = child.previousSibling;
                        } else {
                            p = document.createElement(defaultTagName);
                            Viper.Util.insertBefore(child, p);
                        }

                        if (child.nodeType === Viper.Util.TEXT_NODE) {
                            child.data = Viper.Util.trim(child.data);
                        }

                        p.appendChild(child);
                    }//end for

                    Viper.Util.remove(nodesToRemove);

                    var range           = this.getCurrentRange();
                    var firstSelectable = range._getFirstSelectableChild(elem);
                    if (!firstSelectable && elem.childNodes.length > 0) {
                        for (var i = 0; i < elem.childNodes.length; i++) {
                            var child = elem.childNodes[i];
                            if (Viper.Util.isBlockElement(child) === true
                                && Viper.Util.isStubElement(child) === false
                                && Viper.Util.getHtml(child) === ''
                            ) {
                                Viper.Util.setHtml(child, '&nbsp;');
                            }
                        }
                    }
                }//end if
            }//end if

        },

        getEditableElement: function()
        {
            return this.element;

        },

        resetPlugins: function()
        {
            this._useDefaultPlugins();

        },

        _useDefaultPlugins: function()
        {
            // Default plugins (all Viper plugins).
            var plugins = 'ViperCoreStylesPlugin|ViperInlineToolbarPlugin|ViperHistoryPlugin|ViperListPlugin|ViperFormatPlugin|ViperToolbarPlugin|ViperCopyPastePlugin|ViperImagePlugin|ViperLinkPlugin|ViperAccessibilityPlugin|ViperSourceViewPlugin|ViperSearchReplacePlugin|ViperLangToolsPlugin|ViperCharMapPlugin|ViperCursorAssistPlugin|ViperReplacementPlugin|ViperTableEditorPlugin';
            this.PluginManager.setPlugins(plugins.split('|'));

            // Default button ordering.
            var buttons = [
                ['bold', 'italic', 'subscript', 'superscript', 'strikethrough', 'class'], 'removeFormat', ['justify', 'formats', 'headings'], ['undo', 'redo'], ['unorderedList', 'orderedList', 'indentList', 'outdentList'], 'insertTable', 'image', 'hr', ['insertLink', 'removeLink', 'anchor'], 'insertCharacter', 'searchReplace', 'langTools', 'accessibility', 'sourceEditor'
            ];
            this.getPluginManager().setPluginSettings('ViperToolbarPlugin', {buttons: buttons});

            var inlineToolbarButtons = [['bold', 'italic', 'class'], ['justify', 'formats', 'headings'], ['unorderedList', 'orderedList', 'indentList', 'outdentList'], ['insertLink', 'removeLink', 'anchor'], ['image', 'imageMove']];
            this.getPluginManager().setPluginSettings('ViperInlineToolbarPlugin', {buttons: inlineToolbarButtons});

            // Accessibility Plugin, standard.
            this.getPluginManager().setPluginSettings('ViperAccessibilityPlugin', {standard: 'WCAG2AA'});

            this.setSetting('defaultBlockTag', this.getDefaultBlockTag());

        },

        setSubElementState: function(elem, active)
        {
            if (active === true) {
                if (this._subElementActive === true && this.element !== elem) {
                    this.setSubElementState(this.element, false);
                }

                if (this._subElementActive !== true) {
                    this._mainElem         = this.element;
                    this.element           = elem;
                    this._subElementActive = true;
                    this.element.setAttribute('contentEditable', true);
                    Viper.Util.setStyle(this.element, 'outline', 'none');
                    this._addEvents();
                    this.fireCallbacks('subElementEnabled', elem);
                }
            } else if (this.element && this._subElementActive === true) {
                this.element.setAttribute('contentEditable', false);
                Viper.Util.setStyle(this.element, 'outline', 'invert');
                this._removeEvents();
                var pelem    = this.element;
                this.element = this._mainElem;
                this._subElementActive = false;
                this._mainElem         = null;
                this.fireCallbacks('subElementDisabled', pelem);
            }//end if

        },

        getViperElement: function()
        {
            if (this._subElementActive === true) {
                return this._mainElem;
            }

            return this.element;

        },

        getViperElementDocument: function()
        {
            return this.element.ownerDocument;

        },

        getViperSubElement: function()
        {
            if (this._subElementActive === true) {
                return this.element;
            }

            return null;

        },

        /**
         * Returns the current range.
         *
         * Note that this range may be out side of Viper element.
         *
         * @return {Viper.DOMRange} The Vipe DOMRange object.
         */
        getCurrentRange: function()
        {
            var range          = Viper.Selection.getRangeAt(0);
            this._currentRange = range.cloneRange();
            return range;

        },

        /**
         * Returns the range that was set before Viper lost focus.
         *
         * Plugins that steal focus from the Viper element may need to give the focus
         * back to Viper element and also select the text/node that selected before they
         * took the focus. In that case this method should be used instead of the
         * getCurrentRange.
         *
         * @return {Viper.DOMRange} The Vipe DOMRange object.
         */
        getViperRange: function(element)
        {
            if (Viper.Util.isBrowser('msie') === false) {
                this.highlightToSelection(element);
            }

            if (this._viperRange) {
                return this._viperRange;
            }

            return this.getCurrentRange();

        },

        resetViperRange: function(range)
        {
            range            = range || null;
            this._viperRange = range;

        },

        /**
         * Selects the specified element.
         *
         * @param {DOMNode} element The element to select.
         */
        selectElement: function(element)
        {
            var range = this.getViperRange();
            range.selectNode(element);
            Viper.Selection.addRange(range);

        },

        selectAll: function(elem)
        {
            elem      = elem || this.getViperElement();
            var range = this.getViperRange();

            if (!elem.firstChild) {
                return;
            }

            var start = elem.firstChild;
            if (start.nodeType !== Viper.Util.TEXT_NODE) {
                start = document.createTextNode('');
                Viper.Util.insertBefore(elem.firstChild, start);
            }

            var end = elem.lastChild;
            if (end.nodeType !== Viper.Util.TEXT_NODE) {
                end = document.createTextNode('');
                Viper.Util.insertAfter(elem.lastChild, end);
            }

            range.setStart(start, 0);
            range.setEnd(end, end.data.length);
            Viper.Selection.addRange(range);

        },

        getNodeSelection: function(range)
        {
            range = range || this.getViperRange();

            var nodeSelection = range.getNodeSelection();
            var node          = this.fireCallbacks('Viper:getNodeSelection', {range: range});

            if (node) {
                nodeSelection = node;
            }

            return nodeSelection;

        },

        addAttributeGetModifier: function (callback)
        {
            this._attributeGetModifiers.push(callback);

        },

        addAttributeSetModifier: function (callback)
        {
            this._attributeSetModifiers.push(callback);

        },

        /**
         * Returns the value of the specified attribute of an eleement.
         *
         * Plugins can use the addAttributeModifier method to change the value that this method returns.
         *
         * @param {DOMNode}  element   The element to update.
         * @param {string}   attribute The attribute name.
         *
         * @return {string}
         */
        getAttribute: function (element, attribute)
        {
            var value = element.getAttribute(attribute);

            var modifiersCount = this._attributeGetModifiers.length;
            if (modifiersCount > 0) {
                for (var i = 0; i < modifiersCount; i++) {
                    value = this._attributeGetModifiers[i].call(this, element, attribute, value);
                }
            }

            return value;

        },

        /**
         * Sets the attribute of an element.
         *
         * If the specified value is empty and the attribute value is empty then
         * attribute will be removed from the element.
         *
         * @param {DOMNode}  element   The element to update.
         * @param {string}   attribute The attribute name.
         * @param {string}   value     The value of the attribute.
         */
        setAttribute: function(element, attribute, value, keepEmptyAttribute)
        {
            if (!element || !element.setAttribute) {
                return;
            }

            if (!value && keepEmptyAttribute !== true && Viper.Util.hasAttribute(element, attribute) === true) {
                element.removeAttribute(attribute);

                this.fireCallbacks('Viper:attributeRemoved', {element: element, attribute: attribute});

                if (Viper.Util.isTag(element, 'span') === true
                    && element.attributes
                    && element.attributes.length === 0
                ) {
                    var range        = this.getViperRange();
                    var selectedNode = range.getNodeSelection();

                    var firstSelectable = null;
                    var lastSelectable  = null;
                    if (selectedNode === element) {
                        // Select again.
                        firstSelectable = range._getFirstSelectableChild(element);
                        lastSelectable  = range._getLastSelectableChild(element);
                    }

                    while (element.firstChild) {
                        Viper.Util.insertBefore(element, element.firstChild);
                    }

                    Viper.Util.remove(element);

                    if (firstSelectable && lastSelectable) {
                        range.setStart(firstSelectable, 0);
                        range.setEnd(lastSelectable, lastSelectable.data.length);
                        Viper.Selection.addRange(range);
                        this.resetViperRange(range);
                    }
                }//end if
            } else if (value || keepEmptyAttribute === true) {
                var self           = this;
                var notModified    = true;
                var modifiersCount = this._attributeSetModifiers.length;
                if (modifiersCount > 0) {
                    this._retrievingValues++;
                    var doneCount          = 0;
                    for (var i = 0; i < modifiersCount; i++) {
                        notModified = this._attributeSetModifiers[i].call(
                            this,
                            element,
                            attribute,
                            value,
                            function() {
                                doneCount++;
                                if (doneCount === modifiersCount) {
                                    self._retrievingValues--;
                                    if (self._valuesRetrievedCallback) {
                                        self._valuesRetrievedCallback.call(self);
                                    }
                                }
                            }
                        );
                    }

                    if (notModified !== false) {
                        element.setAttribute(attribute, value);
                        self._retrievingValues--;
                        if (self._valuesRetrievedCallback) {
                            self._valuesRetrievedCallback.call(self);
                        }
                    }
                } else {
                    element.setAttribute(attribute, value);
                }//end if
            }//end if

        },

        /**
         * Find the next good position for the caret outside of the sourceElement.
         *
         * This method should be used when removing an element where caret is in.
         * If no valid elements found a new element will be created using the defaultBlockTag setting.
         */
        moveCaretAway: function(sourceElement, back)
        {
            back      = back || false;
            var range = this.getViperRange();
            return range.moveCaretAway(sourceElement, this.getViperElement(), this.getDefaultBlockTag(), back);

        },


        /**
         * Returns the caret coords.
         *
         * @return {object} The x and y position of the caret.
         */
        getCaretCoords: function()
        {
            // TODO: Change this to range coords.
            var coords = {};
            try {
                var bookmark = this.createBookmark();
                Viper.Util.setStyle(bookmark.end, 'display', 'inline');
                coords = Viper.Util.getElementCoords(bookmark.end);
                Viper.Util.remove(bookmark.start);
                Viper.Util.remove(bookmark.end);
            } catch (e) {
                coords = {
                    x: -1,
                    y: -1
                };
            }

            return coords;

        },


        /**
         * Returns the range object for the given coords.
         *
         * @param {integer} x The x coord.
         * @param {integer} y The y coord.
         *
         * @return {DOMRange}
         */
        getRangeFromCoords: function(x, y)
        {
            var doc = this.getViperElement().ownerDocument;
            var range = null;
            if (doc.caretRangeFromPoint) {
                // Webkit.
                var rangeObj = doc.caretRangeFromPoint(x, y);
                range        = new Viper.MozRange(rangeObj);
            } else if (doc.caretPositionFromPoint) {
                // Firefox.
                var rangeObj = doc.caretPositionFromPoint(x, y);
                range        = this.getCurrentRange().cloneRange();
                range.setStart(rangeObj.offsetNode, rangeObj.offset);
                range.collapse(true);
            } else if (doc.body.createTextRange) {
                var rangeObj = doc.body.createTextRange();
                try {
                    rangeObj.moveToPoint(x, y);
                } catch (e) {
                }

                range = new Viper.IERange(rangeObj);

                if (Viper.doc.createRange) {
                    rangeObj         = Viper.doc.createRange();
                    var ieToMozRange = new Viper.MozRange(rangeObj);
                    ieToMozRange.setStart(range.startContainer, range.startOffset);
                    ieToMozRange.collapse(true);
                    range = ieToMozRange;
                }
            }//end if

            return range;

        },


        /**
         * Returns the element at the specified coords.
         *
         * @param {integer} x The x coord.
         * @param {integer} y The y coord.
         *
         * @return {DOMNode}
         */
        getElementAtCoords: function(x, y)
        {
            var elem = null;
            var doc  = this.getViperElement().ownerDocument;
            if (doc.caretRangeFromPoint) {
                // Webkit.
                var range = doc.caretRangeFromPoint(x, y);
                if (range) {
                    if (range.startContainer === range.endContainer
                        && range.startOffset === range.endOffset
                    ) {
                        if ((range.startContainer.nodeType !== Viper.Util.TEXT_NODE) && (range.startOffset < range.startContainer.childNodes.length)) {
                            elem = range.startContainer.childNodes[range.startOffset];
                        } else {
                            elem = range.startContainer;
                        }
                    }
                }
            } else if (doc.caretPositionFromPoint) {
                // Firefox.
                var range = doc.caretPositionFromPoint(x, y);
                if (range) {
                    if (Viper.Util.isBlockElement(range.offsetNode) === true) {
                        var offset = range.offset;
                        if (offset >= range.offsetNode.childNodes.length) {
                            offset = (range.offsetNode.childNodes.length - 1);
                        }

                        elem = range.offsetNode.childNodes[offset];
                    } else {
                        elem = range.offsetNode;
                    }
                }
            } else if (doc.body.createTextRange) {
                // IE.
                var range = doc.body.createTextRange();
                try {
                    range.moveToPoint(x, y);
                } catch (e) {
                    // Thrown usualy when the point is on an element like img.
                    return document.elementFromPoint(x, y);
                }

                elem = range.parentElement();
            }//end if

            return elem;

        },

        /**
         * Returns true if given selection is in side the Viper element false otherwise.
         *
         * @param {Viper.DOMRange} range The range object to check.
         *
         * @return {boolean} True if range is inside Viper element.
         */
        rangeInViperBounds: function(range)
        {
            range = range || this.getCurrentRange();
            if (range === null || this.isOutOfBounds(range.startContainer) || this.isOutOfBounds(range.endContainer)) {
                return false;
            }

            return true;

        },

        /**
         * Checks if specified element is inside Viper element.
         *
         * @param {DOMNode} element The element to test.
         *
         * @return {boolean} True if the element is inside Viper element.
         */
        isOutOfBounds: function(element)
        {
            if (element === this.element || Viper.Util.isChildOf(element, this.element) === true) {
                return false;
            } else if (this._subElementActive === true && (element === this._mainElem || Viper.Util.isChildOf(element, this._mainElem) === true)) {
                return false;
            }

            return true;

        },

        isWholeViperElementSelected: function(range)
        {
            range = range || this.getViperRange();
            if (range.collapsed === false) {
                var viperElement    = this.getViperElement();
                var firstSelectable = range._getFirstSelectableChild(viperElement);
                if ((firstSelectable === range.startContainer || viperElement === range.startContainer) && range.startOffset === 0) {
                    var prevContainer   = range.getPreviousContainer(range.startContainer, null, false, true);
                    if (this.isOutOfBounds(prevContainer) === false) {
                        return false;
                    }

                    var nextContainer = range.getNextContainer(range.endContainer, null, false, true);
                    if (this.isOutOfBounds(nextContainer) === false) {
                        return false;
                    }

                    var lastSelectable  = range._getLastSelectableChild(viperElement);
                    if ((range.endContainer === viperElement && range.endOffset >= viperElement.childNodes.length)
                        || (range.endContainer === lastSelectable && range.endOffset === lastSelectable.data.length)
                    ) {
                        return true;
                    } else if (Viper.Util.isBrowser('msie', '8') === true
                        && range.endContainer === viperElement
                        && range.startContainer === firstSelectable
                        && range.startOffset === 0
                        && range.endOffset === 0
                    ) {
                        return true;
                    }
                }
            }

            return false;

        },

        /**
         * Inserts a node after the current caret position.
         *
         * If the current selection is not collapsed, then the contents currently
         * selected will be deleted before inserting the specified node The new caret
         * position will exist after the inserted node.
         *
         * @param DOMNode node The node to insert.
         *
         * @return void
         */
        insertNodeAtCaret: function(node, range)
        {
            range = range || this.getViperRange();

            // If we have any nodes highlighted, then we want to delete them before
            // inserting the new text.
            if (range.collapsed !== true) {
                if (Viper.Util.isBrowser('chrome') === true
                    && range.startOffset === 0
                    && range.startContainer === range._getFirstSelectableChild(this.element)
                    && range.endOffset === (this.element.childNodes.length - 1)
                ) {
                    // Whole editable container.
                    Viper.Util.setHtml(this.element, '');
                } else {
                    range.deleteContents();
                    Viper.Selection.addRange(range);
                }

                if (Viper.Util.trim(Viper.Util.getHtml(this.element)) === '') {
                    this.initEditableElement();
                }

                range = this.getCurrentRange();

                if (range.startContainer === range.endContainer
                    && this.element === range.startContainer
                    && range.startOffset === range.endOffset
                    && range.startOffset === 0
                ) {
                    // The whole editable element is selected. Need to remove everything
                    // and init its contents.
                    Viper.Util.empty(this.element);
                    this.initEditableElement();

                    // Update the range.
                    var firstSelectable = range._getFirstSelectableChild(this.element);
                    range.setStart(firstSelectable, 0);
                    range.collapse(true);
                }
            } else if (Viper.Util.isStubElement(range.startContainer.parentNode) === true) {
                var newNode = Viper.document.createTextNode('');
                Viper.Util.insertBefore(range.startContainer.parentNode, newNode);
                Viper.Util.remove(range.startContainer.parentNode);
                range.setStart(newNode, 0);
                range.collapse(true);
                Viper.Selection.addRange(range);
            }//end if

            if (typeof node === 'string') {
                if (node === '\r') {
                    return;
                }

                var newNode  = Viper.document.createTextNode(node);
                var noBlock  = true;
                newRange = range;

                if (newRange.collapsed === true
                    && newRange.startContainer.parentNode
                    && newRange.startContainer.parentNode.firstChild.nodeType === Viper.Util.TEXT_NODE
                    && newRange.startContainer.parentNode.firstChild === newRange.startContainer.parentNode.lastChild
                    && Viper.Util.trim(newRange.startContainer.parentNode.firstChild.data) === ''
                ) {
                    newRange.setStart(newRange.startContainer.parentNode.firstChild, 0);
                    newRange.collapse(true);
                    newRange.startContainer.parentNode.firstChild.data = '';
                } else if (newRange.collapsed === true
                    && Viper.Util.isStubElement(newRange.startContainer) === true
                ) {
                    var tmpTextNode = Viper.document.createTextNode('');
                    Viper.Util.insertBefore(newRange.startContainer, tmpTextNode);
                    Viper.Util.remove(newRange.startContainer);
                    newRange.setStart(tmpTextNode, 0);
                    newRange.collapse(true);
                }

                if (this.fireCallbacks('Viper:nodesInserted', {node: newNode, range: newRange}) === false) {
                    noBlock = false;
                }

                if (noBlock === false) {
                    return false;
                }

                this.contentChanged();
                return;
            } else {
                // We need to import nodes from a document fragment into the current
                // this._document, so that we don't have document fragments within our this._document,
                // as they don't have parentNodes and are hard to work with.
                if (node.nodeType === Viper.Util.DOCUMENT_FRAGMENT_NODE) {
                    if (Viper.Util.isBrowser('msie', '<11') === true) {
                        // Insert a marker span tag to the caret positioon.
                        range.rangeObj.pasteHTML('<span id="__viperMarker"></span>');
                        var marker = Viper.Util.getid('__viperMarker');

                        // Put the node contents after the marker.
                        Viper.Util.insertAfter(marker, node);

                        // Remove the marker.
                        Viper.Util.remove(marker);
                        range.collapse(false);
                        return;
                    } else {
                        var newNode = null;
                        var clen    = node.childNodes.length;
                        for (var i = 0; i < clen; i++) {
                            var child = node.childNodes[i];

                            // We need to skip text nodes that don't represent any content
                            // as if they exist as the last node in the fragment, we won't
                            // be able to set the end of the range to that node.
                            if (child.nodeType === Viper.Util.TEXT_NODE) {
                                if (Viper.Util.trim(child.data) === '') {
                                    continue;
                                }
                            }

                            newNode = Viper.document.importNode(child, true);
                            range.insertNode(newNode);

                            // We need to move to the end of the new node after insertion.
                            // Otherwise next node will be inserted before this one.
                            range.selectNode(newNode);
                            range.collapse(false);
                        }//end for

                        node = newNode;
                        range.moveEnd('character', -1);
                        range.moveEnd('character', 1);
                        range.collapse(false);
                        return;
                    }//end if
                } else if (Viper.Util.isStubElement(range.startContainer) === true) {
                    Viper.Util.insertBefore(range.startContainer, node);
                } else {
                    range.insertNode(node);
                }//end if

                range.setEndAfter(node, (this._getNodeOffset(node) + 1));
                range.collapse(false);
            }//end if

        },

        /**
         * Inserts the specified text after the current caret location.
         *
         * If the current selection is not collapsed, then the contents currently
         * selected will be deleted before inserting the specified node The new caret
         * position will exist after the inserted node.
         *
         * @param string text The text to insert.
         *
         * @return void
         */
        insertTextAtCaret: function(text)
        {
            if (typeof text !== 'string') {
                throw('InvalidArgumentException: text must be a string');
            }

            return this.insertNodeAtCaret(text);

        },

        /**
         * Removes the selection contents and returns the updated range.
         *
         * @return DOMRange
         */
        deleteRangeContent: function()
        {
            var range = this.getViperRange();
            if (this.KeyboardHandler.handleDelete() !== false) {
                range.deleteContents();
                Viper.Selection.addRange(range);
            }

            // Get the updated range.
            range = this.getViperRange();
            return range;

        },

        /**
         * Returns the offset where the node exists in the parent's childNodes property.
         *
         * @param DomNode node The node to obtain the offset for.
         *
         * @return integer
         */
        _getNodeOffset: function(node)
        {
            var nodes = node.parentNode.childNodes;
            var ln    = nodes.length;
            for (var i = 0; i < ln; i++) {
                if (nodes[i] === node) {
                    return i;
                }
            }

        },

        /**
         * Creates an element that cannot be edited.
         */
        createUneditableElement: function (options) {
            if (!options) {
                options = {};
            }

            var tagName = options.tagName || 'span';
            var content = options.content || '';

            var elem = document.createElement(tagName);

            // Disable editing.
            Viper.Util.attr(elem, 'contenteditable', false);

            Viper.Util.setHtml(elem, content);

            if (options.attributes) {
                for (var attrName in options.attributes) {
                    Viper.Util.attr(elem, attrName, options.attributes[attrName]);
                }
            }

            return elem;

        },

        makeElementUneditable: function (element) {
            Viper.Util.attr(element, 'contenteditable', false);

        },

        /**
         * This is not as simple as wrapping a selection with the specified node.
         * For example, if the specified node is a STRONG tag, which is an inline
         * ELEMENT_NODE then it cannot be a parent to block element (i.e. P, DIV).
         */
        surroundContents: function(tag, attributes, range, keepSelection)
        {
            range = range || this.getCurrentRange();

            if (range.collapsed === true) {
                return;
            }

            if (this.rangeInViperBounds(range) !== true) {
                return;
            }

            var otag           = tag;
            var startContainer = range.getStartNode();
            var endContainer   = range.getEndNode();
            var nodeSelection  = range.getNodeSelection(null, true);

            // Selected contents from same node.
            if (nodeSelection) {
                // Get the most outer surrounding parent which is not a block element.
                var parents = Viper.Util.getSurroundingParents(nodeSelection, null, 'inline', this.getViperElement());
                if (parents.length > 0 || Viper.Util.isBlockElement(nodeSelection) === false && Viper.Util.isStubElement(nodeSelection) === false) {
                    if (parents.length > 0) {
                        nodeSelection = parents.pop();
                    }

                    var node = Viper.document.createElement(tag);
                    this._setWrapperElemAttributes(node, attributes);
                    Viper.Util.insertBefore(nodeSelection, node);
                    node.appendChild(nodeSelection);

                    if (keepSelection !== true) {
                        range.setStart(range._getFirstSelectableChild(node), 0);
                        range.setEnd(range._getLastSelectableChild(node), range._getLastSelectableChild(node).data.length);
                        Viper.Selection.addRange(range);
                    }

                    return node;
                }
            }

            if (startContainer === endContainer) {
                if (startContainer.nodeType === Viper.Util.TEXT_NODE) {
                    // Selection is a text node.
                    // Just wrap the contents with the specified node.
                    var node = Viper.document.createElement(tag);
                    this._setWrapperElemAttributes(node, attributes);

                    var rangeContent = range.toString();
                    Viper.Util.setNodeTextContent(node, rangeContent);

                    range.deleteContents();
                    range.insertNode(node);

                    if (keepSelection !== true) {
                        range.setStart(node.firstChild, 0);
                        range.setEnd(node.firstChild, node.firstChild.data.length);
                        Viper.Selection.addRange(range);
                    }

                    return node;
                } else {
                    var self = this;
                    this._wrapElement(startContainer.childNodes[range.startOffset], tag, null, attributes);
                }//end if
            } else {
                if (nodeSelection && Viper.Util.isBlockElement(nodeSelection) === false && nodeSelection.nodeType !== Viper.Util.TEXT_NODE) {
                    var newElement = document.createElement(otag);
                    this._setWrapperElemAttributes(newElement, attributes);

                    while (nodeSelection.firstChild) {
                        newElement.appendChild(nodeSelection.firstChild);
                    }

                    nodeSelection.appendChild(newElement);

                    range.selectNode(newElement);
                    Viper.Selection.addRange(range);

                    return newElement;
                } else if (startContainer.nodeType === Viper.Util.TEXT_NODE
                    && this.getViperElement().firstChild === startContainer
                    && Viper.Util.trim(startContainer.data) === ''
                ) {
                    startContainer = range._getFirstSelectableChild(this.getViperElement());
                }

                var startBlockParent = Viper.Util.getFirstBlockParent(startContainer);
                if (!endContainer) {
                    if (range.endContainer === this.getViperElement()
                        && range.endContainer.childNodes
                        && !range.endContainer.childNodes[range.endOffset]
                    ) {
                        endContainer = range._getLastSelectableChild(this.getViperElement());
                    } else {
                        endContainer = startContainer;
                    }
                }

                var rangeContents  = range.getHTMLContentsObj();
                var endBlockParent = Viper.Util.getFirstBlockParent(endContainer);
                var bookmark       = this.createBookmark();

                if (startBlockParent === endBlockParent
                    && !nodeSelection
                ) {
                    if (!bookmark.start.previousSibling
                        && bookmark.start.parentNode !== startBlockParent
                    ) {
                        // Move bookmark outside of its parent.
                        Viper.Util.insertBefore(bookmark.start.parentNode, bookmark.start);
                    }

                    if (!bookmark.end.nextSibling
                        && bookmark.end.parentNode !== endBlockParent
                    ) {
                        // Move bookmark outside of its parent.
                        Viper.Util.insertAfter(bookmark.end.parentNode, bookmark.end);
                    }

                    var elements = Viper.Util.getElementsBetween(bookmark.start, bookmark.end);
                    Viper.Util.remove(elements);

                    if (!bookmark.start.nextSibling) {
                        var parent = bookmark.start.parentNode;
                        while (!parent.nextSibling) {
                            parent = parent.parentNode;
                        }

                        Viper.Util.insertAfter(parent, bookmark.start);
                    }

                    if (!bookmark.end.previousSibling) {
                        var parent = bookmark.end.parentNode;
                        while (!parent.previousSibling) {
                            parent = parent.parentNode;
                        }

                        Viper.Util.insertBefore(parent, bookmark.end);
                    }

                    var newElement = null;
                    if (otag !== 'span'
                        && bookmark.start.previousSibling
                        && Viper.Util.isTag(bookmark.start.previousSibling, otag) === true
                    ) {
                        // If the previous element is the same tag then just join to it.
                        newElement = bookmark.start.previousSibling;
                        newElement.appendChild(bookmark.start);
                        while (rangeContents.firstChild) {
                            newElement.appendChild(rangeContents.firstChild);
                        }

                        newElement.appendChild(bookmark.end);
                    } else if (otag !== 'span'
                        && bookmark.end.nextSibling
                        && Viper.Util.isTag(bookmark.end.nextSibling, otag) === true
                    ) {
                        // If the next element is the same tag then just join to it.
                        newElement = bookmark.end.nextSibling;
                        if (newElement.firstChild) {
                            Viper.Util.insertBefore(newElement.firstChild, bookmark.end);
                        } else {
                            newElement.appendChild(bookmark.end);
                        }

                        while (rangeContents.lastChild) {
                            Viper.Util.insertBefore(newElement.firstChild, rangeContents.lastChild);
                        }

                        Viper.Util.insertBefore(newElement.firstChild, bookmark.start);
                    } else {
                        // Create a new element.
                        newElement = document.createElement(otag);
                        Viper.Util.insertAfter(bookmark.start, newElement);

                        while (rangeContents.firstChild) {
                            newElement.appendChild(rangeContents.firstChild);
                        }
                    }//end if

                    this._setWrapperElemAttributes(newElement, attributes);

                    // Remove same nested tags.
                    var nestedTags      = Viper.Util.getTag(otag, newElement);
                    var nestedTagsCount = nestedTags.length;
                    for (var i = 0; i < nestedTagsCount; i++) {
                        if (this.isBookmarkElement(nestedTags[i]) === true || otag === 'span') {
                            continue;
                        }

                        while (nestedTags[i].firstChild) {
                            Viper.Util.insertBefore(nestedTags[i], nestedTags[i].firstChild);
                        }

                        Viper.Util.remove(nestedTags[i]);
                    }

                    if (keepSelection !== true) {
                        this.selectBookmark(bookmark);
                    } else {
                        Viper.Util.remove(bookmark.start);
                        Viper.Util.remove(bookmark.end);
                    }

                    return newElement;
                }//end if

                var startContainer = null;
                var endContainer   = null;
                startContainer     = bookmark.start.previousSibling;
                endContainer       = bookmark.end.nextSibling;
                if (!endContainer) {
                    // If the bookmark.end is at the end of another tag move it outside.
                    var bookmarkEnd = bookmark.end.parentNode;
                    while (bookmarkEnd) {
                        if (bookmark.start.parentNode === bookmarkEnd.parentNode) {
                            Viper.Util.insertAfter(bookmarkEnd, bookmark.end);
                            break;
                        } else if (bookmark.end.nextSibling || bookmarkEnd === this.getViperElement()) {
                            // Not the last node in this parent so we cannot move it.
                            break;
                        } else {
                            Viper.Util.insertAfter(bookmarkEnd, bookmark.end);
                            if (bookmark.end.nextSibling) {
                                break;
                            } else {
                                bookmarkEnd = bookmark.end.parentNode;
                            }
                        }
                    }

                    endContainer = Viper.document.createTextNode('');
                    Viper.Util.insertAfter(bookmark.end, endContainer);
                }//end if

                if (!startContainer) {
                    // If the bookmark.end is at the end of another tag move it outside.
                    var bookmarkStart = bookmark.start.parentNode;
                    while (bookmarkStart) {
                        if (bookmark.end.parentNode === bookmarkStart.parentNode) {
                            Viper.Util.insertBefore(bookmarkStart, bookmark.start);
                            break;
                        } else if (bookmarkStart.previousSibling || bookmarkStart === this.getViperElement()) {
                            // Not the last node in this parent so we cannot move it.
                            break;
                        }

                        bookmarkStart = bookmarkStart.parentNode;
                    }

                    startContainer = Viper.document.createTextNode('');
                    Viper.Util.insertBefore(bookmark.start, startContainer);
                }

                var elements = Viper.Util.getElementsBetween(startContainer, endContainer);
                var c        = elements.length;
                var self     = this;

                for (var i = 0; i < c; i++) {
                    this._wrapElement(elements[i], tag, null, attributes);
                }

                if (keepSelection !== true) {
                    this.selectBookmark(bookmark);
                } else {
                    Viper.Util.remove(bookmark.start);
                    Viper.Util.remove(bookmark.end);
                }
            }//end if

        },

        /**
         * Wraps specified tag name around parent node.
         *
         * @param DomNode  parent   A domNode that needs to be wrapped by new tag.
         * @param string   tag      Name of the tag to create.
         * @param function callback A callback function that will be called when a
         *                          new tag is created.
         */
        _wrapElement: function(parent, tag, callback, attributes)
        {
            if (!parent) {
                return;
            } else if (Viper.Util.attr(parent, 'viperbookmark')) {
                return;
            } else if (parent.nodeType === Viper.Util.COMMENT_NODE) {
                if (callback) {
                    callback.call(this, parent);
                }

                return;
            }

            if (!attributes && Viper.Util.getParents(parent, tag).length > 0) {
                // This element is already inside the specified tag.
                // TODO: This may cause problems with spans etc and may need to check
                // specific attributes as well.
                // Also, what if we do want to wrap the element anyway? Have force option?
                return;
            }

            if (parent.nodeType === Viper.Util.TEXT_NODE) {
                if (Viper.Util.isBlank(parent.data) !== true) {
                    if (parent.previousSibling && parent.previousSibling.nodeType === Viper.Util.TEXT_NODE) {
                        if (parent.previousSibling.nodeValue === '') {
                            Viper.Util.remove(parent.previousSibling);
                        }
                    }

                    // If the previous/next sibling is type of specified tag then
                    // add this text node to that sibling.
                    if (parent.previousSibling
                        && Viper.Util.isTag(parent.previousSibling, tag) === true
                        && !Viper.Util.attr(parent.previousSibling, 'viperbookmark')
                        && (!attributes || attributes.cssClass !== '__viper_selHighlight')
                    ) {
                        // Add it to the preivous sibling.
                        parent.previousSibling.appendChild(parent);
                    } else if (parent.nextSibling
                        && Viper.Util.isTag(parent.nextSibling, tag) === true
                        && !Viper.Util.attr(parent.nextSibling, 'viperbookmark')
                        && (!attributes || attributes.cssClass !== '__viper_selHighlight')
                    ) {
                        if (parent.nextSibling.firstChild) {
                            // Add it before the first child of the next sibling.
                            Viper.Util.insertBefore(parent.nextSibling.firstChild, parent);
                        } else {
                            // Add it to the next sibling.
                            parent.nextSibling.appendChild(parent);
                        }
                    } else {
                        // Create the tag and add it to DOM.
                        var elem = Viper.document.createElement(tag);
                        this._setWrapperElemAttributes(elem, attributes);

                        Viper.Util.setNodeTextContent(elem, parent.nodeValue);
                        Viper.Util.insertBefore(parent, elem);
                        Viper.Util.remove(parent);

                        if (callback) {
                            callback.call(this, elem);
                        }
                    }//end if
                } else if (parent.previousSibling
                    && Viper.Util.isTag(parent.previousSibling, tag) === true
                    && !Viper.Util.attr(parent.previousSibling, 'viperbookmark')
                ) {
                    parent.previousSibling.appendChild(parent);
                }//end if
            } else if (Viper.Util.isStubElement(parent) === false) {
                if (Viper.Util.isBlockElement(parent) === false && Viper.Util.hasBlockChildren(parent) === false) {
                    if (Viper.Util.isTag(parent, tag) !== true) {
                        // Does not have any block elements, so we can
                        // wrap the content inside the specified tag.
                        if (parent.previousSibling
                            && parent.previousSibling.tagName
                            && parent.previousSibling.tagName.toLowerCase() === tag
                            && Viper.Util.isBlockElement(parent) === false
                            && !Viper.Util.attr(parent.previousSibling, 'viperbookmark')) {
                            parent.previousSibling.appendChild(parent);
                        } else {
                            var elem = Viper.document.createElement(tag);
                            this._setWrapperElemAttributes(elem, attributes);

                            Viper.Util.insertBefore(parent, elem);
                            elem.appendChild(parent);
                            this.removeTagFromChildren(elem, tag);

                            if (callback) {
                                callback.call(this, elem);
                            }
                        }
                    } else if (!parent.firstChild) {
                        // This is the tag we want however its empty, remove it.
                        parent.parentNode.removeChild(parent);
                    } else if (parent.previousSibling
                        && Viper.Util.isTag(parent.previousSibling, tag) === true
                        && !Viper.Util.attr(parent.previousSibling, 'viperbookmark')
                    ) {
                        // This is the tag we are looking for but there is already one
                        // of these tags before this one so move its children to that tag.
                        while (parent.firstChild) {
                            parent.previousSibling.appendChild(parent.firstChild);
                        }

                        parent.parentNode.removeChild(parent);
                    }//end if
                } else {
                    // Because the node contains block level elements
                    // we have to find the non block elements and wrap content around them.
                    var c        = parent.childNodes.length;
                    var children = [];
                    for (var i = 0; i < c; i++) {
                        children.push(parent.childNodes[i]);
                    }

                    for (var i = 0; i < c; i++) {
                        this._wrapElement(children[i], tag, callback, attributes);
                    }
                }//end if
            }//end if

        },

        _setWrapperElemAttributes: function(element, attributes)
        {
            if (!element || !attributes) {
                return;
            }

            if (attributes.cssClass) {
                Viper.Util.addClass(element, attributes.cssClass);
            }

            if (attributes.attributes) {
                for (var attr in attributes.attributes) {
                    this.setAttribute(element, attr, attributes.attributes[attr]);
                }
            }

        },


        /**
         * Removes all matching tags from the parent element.
         * Note: This does not remove the contents of the matching elements,
         * it joins them to sibling elements.
         */
        removeTagFromChildren: function(parent, tag, incParent)
        {
            var c          = parent.childNodes.length;
            var childNodes = [];
            for (var i = 0; i < c; i++) {
                childNodes.push(parent.childNodes[i]);
            }

            for (var i = 0; i < c; i++) {
                var child = childNodes[i];
                if (child.nodeType === Viper.Util.ELEMENT_NODE) {
                    this.removeTagFromChildren(child, tag, true);
                }
            }

            if (incParent === true) {
                this.removeTag(parent, tag);
            }

        },

        removeTag: function(elem, tag)
        {
            if (elem.parentNode && elem.parentNode.nodeType === Viper.Util.ELEMENT_NODE) {
                if (elem.nodeType === Viper.Util.ELEMENT_NODE) {
                    if (elem.tagName.toLowerCase() === tag) {
                        var span = null;
                        while (elem.firstChild) {
                            if (span !== null) {
                                span.appendChild(elem.firstChild);
                            } else {
                                Viper.Util.insertBefore(elem, elem.firstChild);
                            }
                        }

                        Viper.Util.remove(elem);
                    }
                }//end if
            }//end if

        },

        removeStylesBetweenElems: function(start, end, style, range)
        {
            var elems = Viper.Util.getElementsBetween(start, end, range);
            elems.unshift(start);
            var len = elems.length;
            for (var i = 0; i < len; i++) {
                this.removeTagFromChildren(elems[i], style, true);
            }

        },

        removeStyle: function(style, nodeSelection)
        {
            var range         = this.getViperRange();
            range             = this.adjustRange(range);
            var startNode     = range.getStartNode();
            var endNode       = range.getEndNode();
            var viperElement  = this.getViperElement();
            var nodeSelection = nodeSelection || range.getNodeSelection();

            if (nodeSelection) {
                var startSelNode = range._getFirstSelectableChild(nodeSelection);
                var endSelNode   = range._getLastSelectableChild(nodeSelection);

                // A whole node is selected. Remove all nested style tags and the node it self its the same tag.
                var styleTags = Viper.Util.getTag(style, nodeSelection);
                var sln       = styleTags.length;
                for (var i = 0; i < sln; i++) {
                    while (styleTags[i].firstChild) {
                        Viper.Util.insertBefore(styleTags[i], styleTags[i].firstChild);
                    }

                    Viper.Util.remove(styleTags[i]);
                }

                // Check the surrounding parents.
                var surrounding = Viper.Util.getSurroundingParents(nodeSelection, style, null, this.getViperElement());
                for (var i = 0; i < surrounding.length; i++) {
                    if (Viper.Util.isTag(surrounding[i], style) === true) {
                        while (surrounding[i].firstChild) {
                            Viper.Util.insertBefore(surrounding[i], surrounding[i].firstChild);
                        }

                        Viper.Util.remove(surrounding[i]);
                    }
                }

                if (Viper.Util.isTag(nodeSelection, style) === true) {
                    // This node is the style tag, move all its child nodes and delete it.
                    while (nodeSelection.firstChild) {
                        Viper.Util.insertBefore(nodeSelection, nodeSelection.firstChild);
                    }

                    Viper.Util.remove(nodeSelection);
                }

                // Check if it has a parent with this style, if not stop here.
                if (Viper.Util.getParents(nodeSelection, style, this.getViperElement()).length === 0) {
                    range.setStart(startSelNode, 0);
                    range.setEnd(endSelNode, endSelNode.data.length);

                    Viper.Selection.addRange(range);
                    return;
                }
            }//end if

            // Create bookmark and update the start and end nodes incase bookmark updated the range.
            var bookmark = this.createBookmark(range);
            startNode    = range.getStartNode();
            endNode      = range.getEndNode();

            if (startNode.nodeType === Viper.Util.TEXT_NODE
                && Viper.Util.trim(startNode.data) === ''
                && startNode === viperElement.firstChild
            ) {
                // Firefox sets the first child to be a textNode with \n as its content
                // if whole content is selected. Get the first selectable child.
                startNode = range._getFirstSelectableChild(viperElement);

                if (Viper.Util.isBrowser('msie') === true) {
                    range.setStart(startNode, 0);
                }
            }

            if (!endNode) {
                endNode = startNode;
            }

            this.removeStylesBetweenElems(startNode, endNode, style, range);

            var startParents = Viper.Util.getParents(bookmark.start, style, this.element);
            var endParents   = Viper.Util.getParents(bookmark.end, style, this.element);

            if (startParents.length === 0 && endParents.length === 0) {
                // Start and End is not inside of style tag, so we are done.
                Viper.Selection.addRange(range);
                this.removeBookmarks();
                return;
            }

            // Bookmark and get the top style parents.
            var startTopParent = startParents.pop();
            var endTopParent   = endParents.pop();

            if (startTopParent === endTopParent) {
                var start     = Viper.Util.cloneNode(startTopParent);
                var selection = Viper.Util.cloneNode(startTopParent);
                var end       = Viper.Util.cloneNode(startTopParent);

                // First remove everything from start bookmark to last child.
                var lastChild    = Viper.Util.getLastChildTextNode(start);
                var elemsBetween = Viper.Util.getElementsBetween(this.getBookmark(start, 'start'), lastChild);
                elemsBetween.push(this.getBookmark(start, 'start'));
                elemsBetween.push(this.getBookmark(start, 'end'));
                elemsBetween.push(lastChild);
                Viper.Util.remove(elemsBetween);

                // Remove everything from first child to end bookmark.
                var firstChild   = Viper.Util.getFirstChildTextNode(end);
                var elemsBetween = Viper.Util.getElementsBetween(firstChild, this.getBookmark(end, 'end'));
                elemsBetween.push(this.getBookmark(end, 'end'));
                elemsBetween.push(this.getBookmark(end, 'start'));
                elemsBetween.push(firstChild);
                Viper.Util.remove(elemsBetween);

                // Remove everything before and after bookmark start and end.
                var firstChild   = Viper.Util.getFirstChildTextNode(selection);
                var elemsBetween = Viper.Util.getElementsBetween(firstChild, this.getBookmark(selection, 'start'));
                elemsBetween.push(firstChild);
                Viper.Util.remove(elemsBetween);
                var lastChild    = Viper.Util.getLastChildTextNode(selection);
                var elemsBetween = Viper.Util.getElementsBetween(this.getBookmark(selection, 'end'), lastChild);
                elemsBetween.push(lastChild);
                Viper.Util.remove(elemsBetween);

                var div = Viper.document.createElement('div');
                div.appendChild(selection);
                this.removeTagFromChildren(div, style, true);

                Viper.Util.removeEmptyNodes(start);
                Viper.Util.removeEmptyNodes(end);

                Viper.Util.removeEmptyNodes(div, function(elToDel) {
                    if (Viper.Util.isTag(elToDel, 'span') === true
                        && Viper.Util.hasClass(elToDel, 'viperBookmark') === true
                    ) {
                        // Do not remove bookmark.
                        return false;
                    }
                });

                if (start.firstChild) {
                    if (Viper.Util.isBlank(Viper.Util.getNodeTextContent(start)) !== true) {
                        Viper.Util.insertBefore(startTopParent, start);
                    } else {
                        while (start.firstChild) {
                            Viper.Util.insertBefore(startTopParent, start.firstChild);
                        }
                    }
                }

                Viper.Util.insertBefore(startTopParent, div.childNodes);

                if (end.firstChild) {
                    if (Viper.Util.isBlank(Viper.Util.getNodeTextContent(end)) !== true) {
                        Viper.Util.insertBefore(startTopParent, end);
                    } else {
                        while (end.firstChild) {
                            Viper.Util.insertBefore(startTopParent, end.firstChild);
                        }
                    }
                }

                Viper.Util.remove(startTopParent);

                var originalBookmark = {
                    start: this.getBookmark(this.element, 'start'),
                    end: this.getBookmark(this.element, 'end')
                };

                this.selectBookmark(originalBookmark);
                return;
            }//end if

            // Start of selection is in the style tag.
            if (startTopParent) {
                var clone = Viper.Util.cloneNode(startTopParent);

                // Remove everything from bookmark to lastChild (inclusive).
                var lastChild    = Viper.Util.getLastChildTextNode(startTopParent);
                var elemsBetween = Viper.Util.getElementsBetween(bookmark.start, lastChild);
                elemsBetween.push(bookmark.start);
                elemsBetween.push(lastChild);
                Viper.Util.remove(elemsBetween);

                // From the cloned node, remove everything from firstChild to start bookmark.
                var firstChild = Viper.Util.getFirstChildTextNode(clone);
                elemsBetween   = Viper.Util.getElementsBetween(firstChild, this.getBookmark(clone, 'start'));
                elemsBetween.push(firstChild);
                Viper.Util.remove(elemsBetween);

                // Wrap the clone in to a div then remove its style tag.
                var div = Viper.document.createElement('div');
                div.appendChild(clone);
                this.removeTagFromChildren(div, style);
                Viper.Util.insertAfter(startTopParent, div.childNodes);

                if (Viper.Util.isTag(startTopParent, style) === true) {
                    this.removeEmptyNodes(startTopParent);
                    if (startTopParent.childNodes.length === 0) {
                        Viper.Util.remove(startTopParent);
                    }
                }
            }//end if

            // End of selection is in the style tag.
            if (endTopParent) {
                var clone = Viper.Util.cloneNode(endTopParent);

                // Remove everything from firstChild to bookmark (inclusive).
                var firstChild   = Viper.Util.getFirstChildTextNode(endTopParent);
                var elemsBetween = Viper.Util.getElementsBetween(firstChild, bookmark.end);
                elemsBetween.push(firstChild);
                Viper.Util.remove(elemsBetween);

                // From the cloned node, remove everything from end bookmark to lastChild.
                var lastChild = Viper.Util.getLastChildTextNode(clone);
                elemsBetween  = Viper.Util.getElementsBetween(this.getBookmark(clone, 'end'), lastChild);
                elemsBetween.push(lastChild);
                Viper.Util.remove(elemsBetween);

                // Wrap the clone in to a div then remove its style tag.
                var div = Viper.document.createElement('div');
                div.appendChild(clone);
                this.removeTagFromChildren(div, style);
                Viper.Util.insertBefore(endTopParent, div.childNodes);

                if (Viper.Util.isTag(endTopParent, style) === true) {
                    this.removeEmptyNodes(endTopParent);
                    if (endTopParent.childNodes.length === 0) {
                        Viper.Util.remove(endTopParent);
                    }
                }
            }//end if

            var originalBookmark = {
                start: this.getBookmark(this.element, 'start'),
                end: this.getBookmark(this.element, 'end')
            };

            this.selectBookmark(originalBookmark);

        },

        /**
         * Sets the caret position right after the given node.
         *
         * If node does not have a text node sibling then it will be created.
         *
         * @param {DOMNode} node DOMNode to use.
         *
         * @return {boolean} True if it was successful.
         */
        setCaretAfterNode: function(node)
        {
            if (!node || !node.parentNode) {
                return false;
            }

            var range = this.getCurrentRange();
            if (node.nextSibling && node.nextSibling.nodeType === Viper.Util.TEXT_NODE) {
                // Next sibling is a textnode so move the caret to that node.
                node = node.nextSibling;
            } else {
                var text = null;
                if (node.nextSibling) {
                    text = Viper.Util.getFirstChildTextNode(node.nextSibling);
                }

                if (!text) {
                    // Create a new text node and set the caret to that node.
                    text = Viper.document.createTextNode(String.fromCharCode(160));
                    Viper.Util.insertAfter(node, text);
                }

                node = text;
            }

            range.setStart(node, 0);
            range.collapse(true);
            Viper.Selection.addRange(range);

            this.fireCaretUpdated();

            return true;

        },

        createSpaceNode: function()
        {
            var node = null;
            if (Viper.Util.isBrowser('msie', '<11') === true) {
                node = Viper.document.createTextNode(String.fromCharCode(160));
            } else {
                node = Viper.document.createTextNode(' ');
            }

            return node;

        },

        /**
         * Inserts the newNode after the specified node.
         *
         * Fires 'Viper:beforeInsertAfter' event before inserting the new node so that
         * plugins can prevent or modify node insertion.
         *
         * Also fires 'Viper:nodesChanged' on node.parentNode.
         *
         * @param {DOMNode} node    The node to insert after.
         * @param {DOMNode} newNode The node to insert.
         *
         * @return void
         */
        insertAfter: function(node, newNode)
        {
            // Fire beforeInsertAfter.
            this.fireCallbacks('Viper:beforeInsertAfter', {node: node, newNode: newNode});

            Viper.Util.insertAfter(node, newNode);

            this.contentChanged(true);

        },

        /**
         * Inserts the newNode before the specified node.
         *
         * Fires 'Viper:beforeInsertBefore' event before inserting the new node so that
         * plugins can prevent or modify node insertion.
         *
         * Also fires 'Viper:nodesChanged' on node.parentNode.
         *
         * @param {DOMNode} node    The node to insert before.
         * @param {DOMNode} newNode The node to insert.
         *
         * @return void
         */
        insertBefore: function(node, newNode)
        {
            // Fire beforeInsertAfter.
            this.fireCallbacks('Viper:beforeInsertBefore', {node: node, newNode: newNode});

            Viper.Util.insertBefore(node, newNode);

            this.contentChanged(true);

        },


        selectBookmark: function(bookmark)
        {
            this.blurActiveElement();

            var range       = this.getCurrentRange();
            var startPos    = null;
            var endPos      = null;
            var startOffset = 0;
            var endOffset   = 0;
            if (bookmark.start.nextSibling === bookmark.end
                || Viper.Util.getElementsBetween(bookmark.start, bookmark.end).length === 0
            ) {
                // Bookmark is collapsed.
                // Pick the best node to select. Make sure that if next sibling is block element the previous sibling is not
                // then use the previous sibling.
                if (bookmark.end.nextSibling
                    && (Viper.Util.isBlockElement(bookmark.end.nextSibling) === false || !bookmark.start.previousSibling || Viper.Util.isBlockElement(bookmark.start.previousSibling))
                ) {
                    if ((Viper.Util.isTag(bookmark.end.nextSibling, 'span') !== true || Viper.Util.hasClass(bookmark.end.nextSibling, 'viperBookmark') === false)) {
                        if (Viper.Util.isStubElement(bookmark.end.nextSibling) === false) {
                            startPos = Viper.Util.getFirstChildTextNode(bookmark.end.nextSibling);
                        } else if (Viper.Util.isTag(bookmark.end.nextSibling, 'br') === true) {
                            startPos = bookmark.end.nextSibling;
                        } else {
                            startPos = document.createTextNode('');
                            Viper.Util.insertAfter(bookmark.end, startPos);
                        }
                    } else {
                        startPos = document.createTextNode('');
                        Viper.Util.insertAfter(bookmark.end, startPos);
                    }
                } else if (bookmark.start.previousSibling) {
                    startPos = Viper.Util.getFirstChildTextNode(bookmark.start.previousSibling);
                    if (startPos && startPos.nodeType === Viper.Util.TEXT_NODE) {
                        startOffset = startPos.length;
                    }
                } else {
                    // Create a text node in parent.
                    bookmark.end.parentNode.appendChild(Viper.document.createTextNode(''));
                    startPos = Viper.Util.getFirstChildTextNode(bookmark.end.nextSibling);
                }
            } else {
                if (bookmark.start.nextSibling) {
                    // Find the next non empty text node.
                    startPos = Viper.Util.getFirstChildTextNode(bookmark.start.nextSibling);
                    if (startPos && startPos.nodeType === Viper.Util.TEXT_NODE) {
                        while (startPos && startPos.data.length === 0 && startPos.nextSibling) {
                            startPos = Viper.Util.getFirstChildTextNode(startPos.nextSibling);
                        }
                    } else {
                        // Handle situation where there is no first text node.
                        var tmpTextNode = document.createTextNode('');
                        Viper.Util.insertBefore(bookmark.start.nextSibling, tmpTextNode);
                        startPos    = tmpTextNode;
                        startOffset = 0;
                    }
                } else {
                    if (!bookmark.start.previousSibling) {
                        var tmp = Viper.document.createTextNode('');
                        Viper.Util.insertBefore(bookmark.start, tmp);
                    }

                    startPos    = Viper.Util.getLastChildTextNode(bookmark.start.previousSibling);
                    startOffset = startPos.length;
                }

                if (bookmark.end.previousSibling) {
                    // Find the previous non empty text node.
                    endPos = Viper.Util.getLastChildTextNode(bookmark.end.previousSibling);
                    if (endPos && endPos.nodeType === Viper.Util.TEXT_NODE) {
                        while (endPos && endPos.data.length === 0 && endPos.previousSibling) {
                            endPos = Viper.Util.getLastChildTextNode(endPos.previousSibling);
                        }

                        if (endPos.data) {
                            endOffset = endPos.data.length;
                        }
                    } else {
                        // Handle situation where there is no last text node.
                        var tmpTextNode = document.createTextNode('');
                        Viper.Util.insertAfter(bookmark.end.previousSibling, tmpTextNode);
                        endPos    = tmpTextNode;
                        endOffset = 0;
                    }
                } else {
                    endPos    = Viper.Util.getFirstChildTextNode(bookmark.end.nextSibling);
                    endOffset = 0;
                }
            }//end if

            Viper.Util.remove([bookmark.start, bookmark.end]);

            if (endPos === null) {
                range.setStart(startPos, startOffset);
                range.setEnd(startPos, startOffset);
                range.collapse(false);
            } else {
                var length = 0;

                if (Viper.Util.isStubElement(startPos) === true) {
                    // Image etc.
                    Viper.Selection.removeAllRanges();
                    range.selectNode(startPos);
                } else if (Viper.Util.isStubElement(endPos) === true) {
                    // Image etc.
                    Viper.Selection.removeAllRanges();
                    range.selectNode(endPos);
                } else {
                    // Normalise text nodes and select bookmark.
                    while (startPos && startPos.previousSibling && startPos.previousSibling.nodeType === Viper.Util.TEXT_NODE) {
                        startOffset += startPos.previousSibling.data.length;

                        if (endPos === startPos) {
                            endOffset += startPos.previousSibling.data.length;
                        }

                        startPos.data = startPos.previousSibling.data + startPos.data;
                        Viper.Util.remove(startPos.previousSibling);
                    }

                    while (endPos && endPos.nextSibling && endPos.nextSibling.nodeType === Viper.Util.TEXT_NODE) {
                        endPos.data += endPos.nextSibling.data;
                        Viper.Util.remove(endPos.nextSibling);
                    }

                    if (endPos.previousSibling === startPos) {
                        endOffset     += startPos.data.length;
                        startPos.data += endPos.data;
                        Viper.Util.remove(endPos);
                        endPos = startPos;
                    } else {
                        while (endPos.previousSibling && endPos.previousSibling.nodeType === Viper.Util.TEXT_NODE) {
                            endPos.data = endPos.previousSibling.data + endPos.data;
                            endOffset  += endPos.previousSibling.data.length;

                            if (endPos.previousSibling === startPos) {
                                startPos = endPos;
                            }

                            Viper.Util.remove(endPos.previousSibling);
                        }

                        if (endPos !== startPos) {
                            while (startPos.nextSibling && startPos.nextSibling.nodeType === Viper.Util.TEXT_NODE) {
                                startPos.data += startPos.nextSibling.data;
                                Viper.Util.remove(startPos.nextSibling);
                            }
                        }
                    }//end if

                    Viper.Selection.removeAllRanges();
                    range.setEnd(endPos, endOffset);
                    range.setStart(startPos, startOffset);
                    range.setEnd(endPos, endOffset);
                    range.setStart(startPos, startOffset);
                }//end if
            }//end if

            try {
                if (this.isEditableInIframe() === true) {
                    this.focus();
                }

                Viper.Selection.addRange(range);
            } catch (e) {
                // IE may throw exception for hidden elements..
            }

            return range;

        },

        getBookmark: function(parent, type)
        {
            var bookmarks = Viper.Util.getClass('viperBookmark_' + type, parent);
            var elem      = bookmarks.shift();

            // Remove rest of the bookmarks if there are any..
            Viper.Util.remove(bookmarks);

            return elem;

        },

        getBookmarkById: function(bookmarkid, parent)
        {
            parent = parent || this.getViperElement();
            var bookmarks = Viper.Util.find(parent, '[data-bookmarkid="' + bookmarkid + '"]');
            if (bookmarks.length !== 2) {
                return null;
            }

            var bookmark = {
                start: bookmarks[0],
                end: bookmarks[1]
            }

            return bookmark;

        },

        isBookmarkElement: function(element)
        {
            if (Viper.Util.hasClass(element, 'viperBookmark') === true) {
                return true;
            }

            return false;

        },

        removeBookmarks: function(elem, removeContent)
        {
            elem = elem || this.element;

            if (removeContent === true) {
                // Also remove the content thats bookmarked.
                var starts = Viper.Util.find(elem, '.viperBookmark_start');
                var ends   = Viper.Util.find(elem, '.viperBookmark_end');
                for (var i = 0; i < starts.length; i++) {
                    var bookmark = {
                        start: starts[i],
                        end: ends[i]
                    };

                    this.removeBookmark(bookmark);
                }
            }

            Viper.Util.remove(Viper.Util.getClass('viperBookmark', elem, 'span'));

        },

        /**
         * Removes the specified bookmark and the contents in it.
         */
        removeBookmark: function(bookmark, keepParent)
        {
            if (!bookmark.start || !bookmark.end) {
                return false;
            }

            var viperElement = this.getViperElement();
            var elems        = Viper.Util.getElementsBetween(bookmark.start, bookmark.end);
            elems.push(bookmark.start, bookmark.end);
            var parents = Viper.Util.$(elems).parents();

            // Remove elements between the bookmarks.
            Viper.Util.remove(elems);

            if (keepParent !== true) {
                // Remove any parent element that is now empty.
                for (var i = 0; i < parents.length; i++) {
                    if (parents[i] === viperElement) {
                        break;
                    }

                    if (Viper.Util.elementIsEmpty(parents[i]) === true) {
                        Viper.Util.remove(parents[i]);
                    }
                }
            }

        },

        createBookmark: function(range, keepOldBookmarks, bookmarkid)
        {
            // Remove all bookmarks?
            if (keepOldBookmarks !== true) {
                this.removeBookmarks(this.element);
            }

            var currRange      = range || this.getViperRange();
            var range          = currRange.cloneRange();
            var startContainer = range.startContainer;
            var endContainer   = range.endContainer;
            var startOffset    = range.startOffset;
            var endOffset      = range.endOffset;

            if (range.startContainer
                && range.startContainer === range.endContainer
                && Viper.Util.isTag(range.startContainer, 'br') === true
            ) {
                var prevSibling = range.startContainer.previousSibling;
                var nextSibling = range.startContainer.nextSibling;
                if (prevSibling && prevSibling.nodeType === Viper.Util.TEXT_NODE) {
                    range.setStart(prevSibling, prevSibling.data.length);
                } else if (nextSibling && nextSibling.nodeType === Viper.Util.TEXT_NODE) {
                    range.setStart(nextSibling, 0);
                } else {
                    var tmpNode = document.createTextNode('');
                    Viper.Util.insertBefore(range.startContainer, tmpNode);
                    range.setStart(tmpNode, 0);
                }

                range.collapse(true);
                Viper.Selection.addRange(range);
            } else if ((Viper.Util.isBrowser('firefox') === true || Viper.Util.isBrowser('msie') === true)
                && startContainer === endContainer
                && startOffset === 0
                && startContainer === this.getViperElement()
                && endOffset >= endContainer.childNodes.length
            ) {
                var firstSelectable = range._getFirstSelectableChild(this.getViperElement());
                var lastSelectable  = range._getLastSelectableChild(this.getViperElement());
                if (firstSelectable && lastSelectable) {
                    startContainer = firstSelectable;
                    startOffset    = 0;
                    range.setStart(firstSelectable, 0);
                    range.setEnd(lastSelectable, lastSelectable.data.length);
                }
            }//end if

            var endBookmark           = Viper.document.createElement('span');
            endBookmark.style.display = 'none';
            Viper.Util.setHtml(endBookmark, '&nbsp;');
            Viper.Util.addClass(endBookmark, 'viperBookmark viperBookmark_end');
            endBookmark.setAttribute('viperBookmark', 'end');

            if (bookmarkid) {
                endBookmark.setAttribute('data-bookmarkid', bookmarkid);
            }

             // Create the start bookmark.
            var startBookmark           = Viper.document.createElement('span');
            startBookmark.style.display = 'none';
            Viper.Util.addClass(startBookmark, 'viperBookmark viperBookmark_start');
            Viper.Util.setHtml(startBookmark, '&nbsp;');
            startBookmark.setAttribute('viperBookmark', 'start');

            if (bookmarkid) {
                startBookmark.setAttribute('data-bookmarkid', bookmarkid);
            }

            var viperElement  = this.getViperElement();
            var nodeSelection = range.getNodeSelection();
            if (nodeSelection === viperElement) {
                // Whole Viper element is selected.
                if (!viperElement.firstChild) {
                    // There are no contents.
                    viperElement.appendChild(startBookmark);
                    viperElement.appendChild(endBookmark);
                } else {
                    Viper.Util.insertBefore(viperElement.firstChild, startBookmark);
                    Viper.Util.insertAfter(viperElement.lastChild, endBookmark);
                }
            } else {
                // Collapse to the end of range.
                range.collapse(false);

                var startNode = range.getStartNode();
                range.insertNode(endBookmark);
                if (Viper.Util.isChildOf(endBookmark, this.element) === false) {
                    this.element.appendChild(endBookmark);
                }

                // Move the range to where it was before.
                if (startContainer.parentNode) {
                    // This check is to pevent IE11 stuffing up empty text nodes when range is collapsed.
                    range.setStart(startContainer, startOffset);
                    range.collapse(true);
                }

                try {
                    if (startContainer.parentNode) {
                        range.insertNode(startBookmark);
                    } else {
                        Viper.Util.insertBefore(endBookmark, startBookmark);
                    }

                    // Make sure start and end are in correct position.
                    if (startBookmark.previousSibling === endBookmark) {
                        // Reverse..
                        Viper.Util.insertBefore(endBookmark, startBookmark);
                    }
                } catch (e) {
                    // NS_ERROR_UNEXPECTED: I believe this is a Firefox bug.
                    // It seems like if the range is collapsed and the text node is empty
                    // (i.e. length = 0) then Firefox tries to split the node for no reason and fails...
                    Viper.Util.insertBefore(endBookmark, startBookmark);
                }

                if (Viper.Util.isChildOf(startBookmark, this.element) === false) {
                    if (this.element.firstChild) {
                        Viper.Util.insertBefore(this.element.firstChild, startBookmark);
                    } else {
                        // Should not happen...
                        this.element.appendChild(startBookmark);
                    }
                }

                if (Viper.Util.isBrowser('chrome') === true || Viper.Util.isBrowser('safari') === true) {
                    // Sigh.. Move the range where its suppose to be instead of Webkit deciding that it should
                    // move the end of range to the begining of the next sibling -.-.
                    if (!endBookmark.previousSibling) {
                        var node = endBookmark.parentNode.previousSibling;
                        while (node) {
                            if (node.nodeType !== Viper.Util.TEXT_NODE || Viper.Util.isBlank(node.data) === false) {
                                break;
                            }

                            node = node.previousSibling;
                        }

                        if (node === startBookmark.parentNode) {
                            startBookmark.parentNode.appendChild(endBookmark);
                        }
                    }
                }

                if (!endBookmark.previousSibling) {
                    var tmp = Viper.document.createTextNode('');
                    Viper.Util.insertBefore(endBookmark, tmp);
                }

                // The original range object must be changed.
                if (!startBookmark.nextSibling) {
                    var tmp = Viper.document.createTextNode('');
                    Viper.Util.insertAfter(startBookmark, tmp);
                }

                currRange.setStart(startBookmark.nextSibling, 0);
                currRange.setEnd(endBookmark.previousSibling, (endBookmark.previousSibling.length || 0));

                // Check if the bookmark is inside a special element.
                if (nodeSelection && this.isSpecialElement(nodeSelection) === true) {
                    // Move it outside of the special key.
                    Viper.Util.insertBefore(nodeSelection, startBookmark);
                    Viper.Util.insertAfter(nodeSelection, endBookmark);
                }
            }//end if

            var bookmark = {
                start: startBookmark,
                end: endBookmark
            };

            return bookmark;

        },

        /**
         * Creates a bookmark using the Viper highlight.
         *
         * @return object
         */
        createBookmarkFromHighlight: function(outer)
        {
            var highlights = this.getHighlights();
            if (highlights.length === 0) {
                return null;
            }

            var startBookmark           = Viper.document.createElement('span');
            startBookmark.style.display = 'none';
            Viper.Util.addClass(startBookmark, 'viperBookmark viperBookmark_start');
            Viper.Util.setHtml(startBookmark, '&nbsp;');
            startBookmark.setAttribute('viperBookmark', 'start');

            var outerParent = null;
            if (outer === true && highlights.length === 1) {
                // If the highlight is one element and outer is set to true then
                // create the bookmark at most outer surrounding parent.
                outerParent = Viper.Util.getTopSurroundingParent(highlights[0]);
                if (outerParent) {
                    Viper.Util.insertBefore(outerParent, startBookmark);
                }
            }

            if (!outerParent) {
                Viper.Util.insertBefore(highlights[0], startBookmark);
            }

            var endBookmark           = Viper.document.createElement('span');
            endBookmark.style.display = 'none';
            Viper.Util.setHtml(endBookmark, '&nbsp;');
            Viper.Util.addClass(endBookmark, 'viperBookmark viperBookmark_end');
            endBookmark.setAttribute('viperBookmark', 'end');

            if (outerParent) {
                Viper.Util.insertAfter(outerParent, endBookmark);
            } else {
                Viper.Util.insertAfter(highlights[(highlights.length - 1)], endBookmark);
            }

            var bookmark = {
                start: startBookmark,
                end: endBookmark
            };

            return bookmark;

        },

        insertNodeAtBookmark: function(node, bookmark, noSelect)
        {
            if (!bookmark || !node) {
                return;
            }

            Viper.Util.insertBefore(bookmark.start, node);

            if (noSelect !== true) {
                // Select the bookmark.
                this.selectBookmark(bookmark);
            }

        },

        splitNodeAtRange: function(tag, range, copyMidTags)
        {
            range = range || this.getCurrentRange();

            var bookmark = this.createBookmark(range);
            return this.splitNodeAtBookmark(tag, bookmark, copyMidTags);

        },

        /**
            <p>
                sdfsdfsdf <em><strong>ddd<strong><em>sdfkj*sdhf</em>sdfsdfsdf</strong>xxxx</strong></em>
            </p>

            =>
            <p>
                sdfsdfsdf <em><strong>ddd<strong><em>sdfkj</em></strong></strong>
                *<strong>ddd<strong><em>sdhf</em>sdfsdfsdf</strong>xxxx</strong></em>
        */
        splitNodeAtBookmark: function(tag, bookmark, copyMidTags)
        {
            if (!bookmark) {
                return;
            }

            // Get the parent node with specified tag.
            var node      = bookmark.start.parentNode;
            var foundNode = null;
            while (node && node !== this.element) {
                if (Viper.Util.isTag(node, tag) === true) {
                    // Note, we do not want to break out of the loop yet..
                    // Need to find the most outer parent with specified tag.
                    foundNode = node;
                }

                node = node.parentNode;
            }

            var prevNode = null;
            var nextNode = null;
            var midNode  = null;

            if (foundNode === null) {
                // Parent with specified tag was not found.
                prevNode = bookmark.start.previousSibling;
                nextNode = bookmark.end.nextSibling;

                if (!prevNode && !nextNode) {
                    prevNode = Viper.document.createTextNode('');
                    Viper.Util.insertBefore(bookmark.start, prevNode);
                    nextNode = prevNode;
                }
            } else {
                // Construct the end section, which is selection from end bookmark to
                // the end of the found node.
                var selStart = document.createTextNode('');
                var selEnd   = document.createTextNode('');

                Viper.Util.insertAfter(bookmark.end, selStart);
                Viper.Util.insertAfter(foundNode, selEnd);

                var range = this.getViperRange();
                range.setStart(selStart, 0);
                range.setEnd(selEnd, 0);
                var endContents = range.extractContents();

                var tmp = document.createElement('div');
                while (endContents.firstChild) {
                    tmp.appendChild(endContents.firstChild);
                }

                var nextNode = null;
                if (Viper.Util.elementIsEmpty(tmp) === false) {
                    while (tmp.lastChild) {
                        nextNode = tmp.lastChild;
                        Viper.Util.remove(tmp.lastChild);
                        Viper.Util.insertAfter(selEnd, nextNode);
                    }
                }

                Viper.Util.empty(tmp);

                // Get the mid contents without the specified tag.
                Viper.Util.insertBefore(bookmark.start, selStart);
                Viper.Util.insertAfter(foundNode, selEnd);
                range.setStart(selStart, 0);
                range.setEnd(selEnd, 0);
                var midContents = range.extractContents();

                while (midContents.firstChild) {
                    tmp.appendChild(midContents.firstChild);
                }

                var tagsToRemove = Viper.Util.getTag(tag, tmp);
                for (var i = 0; i < tagsToRemove.length; i++) {
                    while (tagsToRemove[i].firstChild) {
                        Viper.Util.insertBefore(tagsToRemove[i], tagsToRemove[i].firstChild);
                    }

                    Viper.Util.remove(tagsToRemove);
                }

                while (tmp.lastChild) {
                    Viper.Util.insertAfter(foundNode, tmp.lastChild);
                }

                var prevNode = foundNode;

                Viper.Util.remove(selEnd);

                try {
                    selStart.data = '';
                } catch (e) {
                    selStart = document.createTextNode('');
                }

                Viper.Util.insertAfter(bookmark.start, selStart);
                midNode = selStart;
            }//end if

            this.selectBookmark(bookmark);

            return {
                prevNode: prevNode,
                nextNode: nextNode,
                midNode: midNode
            };

        },

        /**
         * Highlights the current Viper selection.
         *
         * This method is useful when Viper loses focus and selection needs to be shown,
         * E.g. when a textbox takes focus the Viper selection will be lost, this method
         * will be similar to bookmarking a selection but visible to the user.
         *
         * If the range is collaped nothing will be highlighted.
         *
         * @return {DOMNode}
         */
        highlightSelection: function()
        {
            var highlights = Viper.Util.getClass('__viper_selHighlight', this.element);
            if (highlights.length > 0) {
                return false;
            }

            var range = this.getViperRange();
            if (this.rangeInViperBounds(range) === false) {
                return false;
            }

            var selectedNode = range.getNodeSelection();

            if (selectedNode && selectedNode === this.element) {
                // Viper Element cannot be selected.
                selectedNode = null;
            }

            if (selectedNode && selectedNode.nodeType === Viper.Util.ELEMENT_NODE) {
                Viper.Util.addClass(selectedNode, '__viper_selHighlight __viper_cleanOnly');
            } else if (range.collapsed === true) {
                var span = document.createElement('span');
                Viper.Util.addClass(span, '__viper_selHighlight');
                Viper.Util.setStyle(span, 'border-right', '1px solid #000');

                if (Viper.Util.isStubElement(range.startContainer) === false) {
                    range.insertNode(span);
                    var parentNode = span.parentNode;
                } else {
                    parentNode = range.startContainer.parentNode;
                }

                if (parentNode) {
                    var tagName = Viper.Util.getTagName(parentNode);
                    if (Viper.Util.inArray(tagName, ['table', 'tbody', 'tr']) === true) {
                        Viper.Util.remove(span);
                    }
                }
            } else if (range.startContainer
                && range.endContainer
                && range.endContainer.previousSibling === range.startContainer.nextSibling
                && Viper.Util.isTag(range.startContainer.nextSibling, 'img') === true
                && Viper.Util.isTag(range.endContainer.previousSibling, 'img') === true
            ) {
                // This is for early IE version where range is set before and after an image. Still want to just highlight
                // the image element instead of using surroundContents below.
                Viper.Util.addClass(range.startContainer.nextSibling, '__viper_selHighlight __viper_cleanOnly');
            } else {
                var attributes = {
                    cssClass: '__viper_selHighlight'
                };

                var span = document.createElement('span');
                span.setAttribute('class', '__viper_selHighlight');
                this.surroundContents('span', attributes, range, true);
            }//end if

        },

        highlightToSelection: function(element)
        {
            element = element || this.element;

            // There should be one...
            var highlights = Viper.Util.getClass('__viper_selHighlight', element);
            if (highlights.length === 0) {
                return false;
            }

            var range     = this.getCurrentRange();
            var c         = highlights.length;
            var startNode = false;
            var child     = null;

            if (c === 1 && Viper.Util.hasClass(highlights[0], '__viper_cleanOnly') === true) {
                Viper.Util.removeClass(highlights[0], '__viper_cleanOnly');
                Viper.Util.removeClass(highlights[0], '__viper_selHighlight');
                if (!highlights[0].getAttribute('class')) {
                    highlights[0].removeAttribute('class');
                }

                if (element === this.element) {
                    range.selectNode(highlights[0]);
                    Viper.Selection.addRange(range);
                }

                return true;
            }

            for (var i = 0; i < c; i++) {
                if (highlights[i].firstChild) {
                    while (highlights[i].firstChild) {
                        child = highlights[i].firstChild;
                        Viper.Util.insertBefore(highlights[i], child);

                        if (!startNode) {
                            // Set the selection start.
                            startNode = child;
                            range.setStart(child, 0);
                        }
                    }

                    Viper.Util.remove(highlights[i]);

                    if (i === (c - 1)) {
                        if (child.nodeType === Viper.Util.TEXT_NODE) {
                            range.setEnd(child, child.data.length);
                        } else if (startNode === child) {
                            range.selectNode(startNode);
                        } else {
                            var lastSelectable = range._getLastSelectableChild(child);
                            range.setEnd(lastSelectable, lastSelectable.data.length);
                        }
                    }
                } else {
                    if (highlights[i].nextSibling && highlights[i].nextSibling.nodeType === Viper.Util.TEXT_NODE) {
                        var nextSibling = highlights[i].nextSibling;
                        if (!startNode) {
                            range.setStart(nextSibling, 0);
                            startNode = nextSibling;
                        }

                        Viper.Util.remove(highlights[i]);

                        if (i === (c - 1)) {
                            range.setEnd(nextSibling, 0);
                        }
                    } else {
                        var textNode = document.createTextNode('');
                        Viper.Util.insertAfter(highlights[i], textNode);
                        range.setStart(textNode, 0);
                        range.collapse(true);

                        Viper.Util.remove(highlights[i]);

                        if (i === (c - 1)) {
                            range.setEnd(textNode, 0);
                        }
                    }//end if
                }//end if
            }//end for

            if (element === this.element) {
                Viper.Selection.addRange(range);
                this._viperRange = range.cloneRange();
            }

            return true;

        },

        removeHighlights: function(element)
        {
            element = element || this.element;

            // There should be one...
            var highlights = this.getHighlights(element);
            if (highlights.length === 0) {
                return;
            }

            for (var i = 0; i < highlights.length; i++) {
                var highlight = highlights[i];

                if (Viper.Util.hasClass(highlight, '__viper_cleanOnly') === true) {
                    Viper.Util.removeClass(highlight, '__viper_cleanOnly');
                    Viper.Util.removeClass(highlight, '__viper_selHighlight');
                    if (!highlight.getAttribute('class')) {
                        highlight.removeAttribute('class');
                    }
                } else {
                    while (highlight.firstChild) {
                        child = highlight.firstChild;
                        Viper.Util.insertBefore(highlight, child);
                    }

                    Viper.Util.remove(highlight);
                }
            }//end for

            return true

        },

        getHighlights: function(element)
        {
            element = element || this.element;

            // There should be one...
            var highlights = Viper.Util.getClass('__viper_selHighlight', element);
            return highlights;

        },

        isViperHighlightElement: function(element)
        {
            if (Viper.Util.isTag(element, 'span') === true
                && Viper.Util.hasClass(element, '__viper_selHighlight') === true
            ) {
                return true;
            }

            return false;

        },

        isSpecialElement: function(element)
        {
            var isSpecialElem = false;
            isSpecialElem     = this.getPluginManager().isSpecialElement(element);
            return isSpecialElem;

        },

        fireSelectionChanged: function(range, forceUpdate)
        {
            if (!range) {
                range = this.getViperRange();
                try {
                    range = this.adjustRange(range);
                } catch (e) {
                }
            }

            if (!this._prevRange
                || forceUpdate === true
                || this._prevRange.startContainer !== range.startContainer
                || this._prevRange.endContainer !== range.endContainer
                || this._prevRange.startOffset !== range.startOffset
                || this._prevRange.endOffset !== range.endOffset
                || this._prevRange.collapsed !== range.collapsed
            ) {
                this._prevRange = range;

                if (this._retrievingValues > 0) {
                    var self = this;
                    this._valuesRetrievedCallback = function() {
                        self.fireCallbacks('Viper:selectionChanged', range);
                    };
                } else {
                    this._valuesRetrievedCallback = null;
                    this.fireCallbacks('Viper:selectionChanged', range);
                }
            }

        },

        /**
         * Returns true if the given key event is using a registered special key.
         *
         * Special keys allow plugins to modify the key events when a specific key is pressed.
         *
         * @param {event} e The DOM key event.
         */
        isSpecialKey: function(e)
        {
            return Viper.Util.inArray(e.which, this._specialKeys);

        },

        /**
         * Registers a special key.
         *
         * Special keys allow plugins to modify the key events when a specific key is pressed.
         *
         * @param {integer} keyCode The key code for the key event.
         */
        addSpecialKey: function(keyCode)
        {
            this._specialKeys.push(keyCode);

        },

        mouseDown: function(e)
        {
            this._mouseDownEvent = e;
            if (e.which === 3) {
                this.fireCallbacks('Viper:rightMouseDown', e);
                return false;
            }

            var target = Viper.Util.getMouseEventTarget(e);
            var inside = true;

            if (this.element !== target && Viper.Util.isChildOfElems(target, [this.element]) !== true) {
                inside = false;

                // Ask plugins if its one of their element.
                var pluginName = this._getPluginForElement(target);
                if (!pluginName && Viper.Util.isChildOfElems(target, [this._viperElementHolder]) !== true) {
                    this.setEnabled(false);
                    return this.fireCallbacks('Viper:clickedOutside', e);
                } else {
                    return true;
                }
            } else if (this.enabled === false) {
                this.setEnabled(true);
            }

            this.removeHighlights();

            this.fireCallbacks('Viper:clickedInside', e);
            this.fireCaretUpdated();

            // Mouse down in active element.
            if (this.fireCallbacks('Viper:mouseDown', e) === false) {
                Viper.Util.preventDefault(e);
                return false;
            }

            if (inside !== true || this.removeHighlights() !== true) {
                var self = this;
                setTimeout(function() {
                    var range = null;
                    try {
                        range = self.adjustRange();
                    } catch (e) {
                    }

                    // Delay calling the fireSelectionChanged to get the updated range.
                    self.fireSelectionChanged(range);
                }, 5);
            }

            this._viperRange = null;

        },

        mouseUp: function(e)
        {
            if (e.which === 3) {
                this.fireCallbacks('Viper:rightMouseUp', e);
                return false;
            }

            if (this.fireCallbacks('Viper:mouseUp', e) === false) {
                Viper.Util.preventDefault(e);
                return false;
            }

            var target     = Viper.Util.getMouseEventTarget(e);
            var pluginName = this._getPluginForElement(target);
            if (pluginName || Viper.Util.isChildOfElems(target, [this._viperElementHolder]) === true) {
                return;
            }

            // This setTimeout is very strange indeed. We need to wait a bit for browser
            // to update the selection object..
            var self = this;
            setTimeout(function() {
                var range = null;
                try {
                    range = self.adjustRange();
                } catch (e) {
                }

                if (range
                    && range.collapsed === true
                    && range.startContainer
                    && range.startContainer.nodeType === 9
                    && (Viper.Util.isBrowser('msie') === true || Viper.Util.isBrowser('edge') === true)
                ) {
                    // If clicked inside the previous selection then IE takes a lot
                    // longer to update the caret position so if the range is collapsed
                    // wait nearly half a second to trigger the selection changed
                    // event. The delay is only required when the startContainer is set as the
                    // document node.
                    setTimeout(function() {
                        var x = self.getCurrentRange();
                        self.fireSelectionChanged(self.adjustRange(), true);
                    }, 450);
                } else {
                    if (Viper.Util.isBrowser('msie', '>=11') === true
                        || Viper.Util.isBrowser('edge') === true
                    ) {
                        if (range.startContainer !== range.endContainer
                            && range.startContainer.nodeType === Viper.Util.TEXT_NODE
                            && range.startOffset === range.startContainer.data.length
                            && range.startContainer.nextSibling
                            && range.startContainer.nextSibling.nodeType == Viper.Util.ELEMENT_NODE
                        ) {
                            // Handle <p>text [<strong>text] </strong></p> -> <p>text <strong>[text] </strong></p>.
                            var firstChild = range._getFirstSelectableChild(range.startContainer.nextSibling);
                            if (firstChild && firstChild.nodeType === Viper.Util.TEXT_NODE) {
                                range.setStart(firstChild, 0);
                                Viper.Selection.addRange(range);
                            }
                        }

                    }

                    self.fireSelectionChanged(range, true);
                }
            }, 8);

        },

        /**
         * Adjusts the given range so a better selection is made.
         *
         * @param {Viper.DOMRange} The range object.
         *
         * @return {Viper.DOMRange} The updated range.
         */
        adjustRange: function(range)
        {
            range = range || this.getViperRange();
            if (range.collapsed !== false) {
                if (Viper.Util.isBrowser('msie', '9') === true) {
                    if (range.startContainer === range.endContainer) {
                        if (range.startContainer.nodeType === Viper.Util.ELEMENT_NODE) {
                            if (range.startOffset === range.startContainer.childNodes.length) {
                                var child = range.startContainer.childNodes[range.startContainer.childNodes.length - 1];
                                if (Viper.Util.isStubElement(child) === false && child.nodeType === Viper.Util.ELEMENT_NODE) {
                                    var sel = range._getLastSelectableChild(child);
                                    if (sel && sel.nodeType === Viper.Util.TEXT_NODE) {
                                        range.setEnd(sel, sel.data.length);
                                        range.collapse(false);
                                        Viper.Selection.addRange(range);
                                    }
                                }
                            }
                        }
                    }
                }

                return range;
            }

            // A few range adjustments for double click word selection etc.
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();

            if (!endNode && startNode && Viper.Util.isStubElement(startNode) === true) {
                return range;
            }

            if (!endNode && range.startContainer && range.startContainer.nodeType === Viper.Util.ELEMENT_NODE) {
                var lastSelectable = range._getLastSelectableChild(range.startContainer);
                if (lastSelectable) {
                    endNode            = lastSelectable;
                    range.endContainer = endNode;
                    range.endOffset    = endNode.data.length;
                    Viper.Selection.addRange(range);
                }
            }

            if (endNode && endNode.nodeType === Viper.Util.TEXT_NODE
                && range.endOffset === 0
                && endNode !== startNode
                && endNode.previousSibling
                && endNode.previousSibling.nodeType !== Viper.Util.TEXT_NODE
            ) {
                // When a word at the end of a tag is double clicked then move the
                // end of the range to the last selectable child of that tag.
                var textChild = range._getLastSelectableChild(endNode.previousSibling);
                if (textChild) {
                    range.setEnd(textChild, textChild.data.length);
                    Viper.Selection.addRange(range);
                }
            }

            if (Viper.Util.isBrowser('firefox') === true) {
                if (startNode && startNode.nodeType === Viper.Util.TEXT_NODE
                    && endNode && endNode.nodeType === Viper.Util.TEXT_NODE
                    && startNode.data.length === range.startOffset
                    && range.endOffset === 0
                    && startNode.nextSibling
                    && startNode.nextSibling === endNode.previousSibling
                    && startNode.nextSibling.nodeType !== Viper.Util.TEXT_NODE
                ) {
                    // When a word is double clicked and the word is wrapped with a tag
                    // e.g. strong then select the strong tag.
                    var firstSelectable = range._getFirstSelectableChild(startNode.nextSibling);
                    var lastSelectable  = range._getLastSelectableChild(startNode.nextSibling);
                    range.setStart(firstSelectable, 0);
                    range.setEnd(lastSelectable, lastSelectable.data.length);
                    Viper.Selection.addRange(range);
                } else if (startNode && startNode.nodeType === Viper.Util.TEXT_NODE
                    && endNode && endNode.nodeType === Viper.Util.TEXT_NODE
                    && startNode.data.length === range.startOffset
                    && startNode !== endNode
                    && startNode.nextSibling
                    && startNode.nextSibling.nodeType !== Viper.Util.TEXT_NODE
                ) {
                    // A range starts at the end of a text node and the next sibling
                    // is not a text node so move the range inside the first selectable
                    // child of the next sibling. This usually happens in FF when you
                    // double click a word which is at the start of a strong/em/u tag,
                    // we move the range inside the tag.
                    var firstSelectable = range._getFirstSelectableChild(startNode.nextSibling);
                    if (firstSelectable) {
                        range.setStart(firstSelectable, 0);
                        Viper.Selection.addRange(range);
                    }
                }
            } else if (startNode
                && endNode
                && startNode.nodeType === Viper.Util.TEXT_NODE
                && endNode.nodeType === Viper.Util.TEXT_NODE
                && range.startOffset === 0
                && range.endOffset === endNode.data.length
            ) {
                if (range.endOffset === 0 && !endNode.previousSibling) {
                    // In Webkit, when a whole paragraph is selected sometimes the range
                    // starts from the beginning of the next paragraph causing range to
                    // span two paragraphs.. If this is the case then move the range...
                    var lastSelectable = range._getLastSelectableChild(endNode.parentNode.previousSibling.previousSibling);
                    if (lastSelectable) {
                        range.setEnd(lastSelectable, lastSelectable.data.length);
                        Viper.Selection.addRange(range);
                    }
                } else if (range.endOffset > 0
                    && Viper.Util.isBlank(Viper.Util.trim(endNode.data)) === true
                    && range.commonAncestorContainer === this.getViperElement()
                    && range.commonAncestorContainer.firstElementChild === range.commonAncestorContainer.lastElementChild
                    && range._getFirstSelectableChild(range.commonAncestorContainer, startNode)
                    && range._getLastSelectableChild(range.commonAncestorContainer, endNode)
                ) {
                    // This is the case where selection starts from first selectable and ends at last selectable
                    // where last selectable is empty text node after a block element.
                    // E.g. <viperEl><div><p>[aaa</p><p>bbb</p></div>    ]</viperEl>
                    // Range should be adjusted to select the common parent.
                    range.selectNode(range.commonAncestorContainer.firstElementChild);
                    Viper.Selection.addRange(range);
                }
            } else if (endNode && endNode.nodeType === Viper.Util.ELEMENT_NODE && Viper.Util.isTag(endNode, 'br') === true) {
                // Firefox adds br tags at the end of new paragraphs sometimes selecting
                // text from somewhere in paragraph to the end of paragraph causes
                // selection issues.
                if (endNode.previousSibling) {
                    var child = range._getLastSelectableChild(endNode.previousSibling);
                    if (child) {
                        range.setEnd(child, child.data.length);
                        Viper.Selection.addRange(range);
                    }
                }
            } else if (range.startContainer.nodeType === Viper.Util.TEXT_NODE
                && range.endContainer.nodeType === Viper.Util.ELEMENT_NODE
                && range.endOffset === 0
                && range.startOffset === range.startContainer.data.length
            ) {
                range.collapse(true);
                Viper.Selection.addRange(range);
            }//end if

            return range;

        },

        focus: function()
        {
            if (this.element) {
                try {
                    if (Viper.Util.isBrowser('msie') === true || Viper.Util.isBrowser('edge') === true) {
                        var range = this.getViperRange();
                        Viper.Selection.addRange(range);

                        this.fireCaretUpdated();
                        this.fireCallbacks('Viper:focused');
                        return;
                    }

                    var elementScrollCoords = Viper.Util.getElementScrollCoords(this.element);
                    var scrollCoords        = Viper.Util.getScrollCoords(Viper.Util.getDocumentWindow());
                    this.element.focus();

                    var range = this.getViperRange();
                    Viper.Selection.addRange(range);

                    // IE and Webkit fix.
                    this.element.scrollTop  = elementScrollCoords.y;
                    this.element.scrollLeft = elementScrollCoords.x;
                    Viper.window.scrollTo(scrollCoords.x, scrollCoords.y);

                    this.fireCaretUpdated();

                    this.fireCallbacks('Viper:focused');
                } catch (e) {
                    // Catch the IE error: Can't move focus to control because its invisible.
                }//end try
            }//end if

        },

        isEditableInIframe: function(element)
        {
            element = element || this.element;

            if (document !== element.ownerDocument) {
                return true;
            }

            return false;

        },

        blurActiveElement: function()
        {
            if (document.activeElement
                && document.activeElement !== this.element
                && document.activeElement.blur
                && document.activeElement !== document.body
            ) {
                // Call the blur method of the active element incase its an input box etc
                // which causes problems on IE when range is set below.
                // Note that the above activeElement != body check is to prevent the best
                // browser in the world changing focus to another window..
                document.activeElement.blur();
            }

        },

        fireCaretUpdated: function(range)
        {
            range = range || this.getCurrentRange();
            this.fireCallbacks('caretPositioned', {range: range});

        },

        fireNodesChanged: function(nodes)
        {
            if (!nodes) {
                nodes = [this.element];
            }

            this.getViperRange().clearNodeSelectionCache();

            this.fireCallbacks('Viper:nodesChanged', nodes);

            if (nodes.length === 1 && nodes[0] && nodes[0].nodeType === Viper.Util.TEXT_NODE) {
                this.HistoryManager.add('Viper', 'text_change');
            } else {
                this.HistoryManager.add();
            }

        },

        contentChanged: function(selectionNotChanged, range)
        {
            range = range || null;

            if (selectionNotChanged !== true) {
                this.fireSelectionChanged(range, true);
            }

            this.fireNodesChanged();

        },

        _getPluginForElement: function(element)
        {
            return this.getPluginManager().getPluginForElement(element);

        },

        registerCallback: function(type, namespace, callback)
        {
            if (Viper.Util.isFn(callback) === false) {
                return;
            }

            if (Viper.Util.isArray(type) === true) {
                for (var i = 0; i < type.length; i++) {
                    this.registerCallback(type[i], namespace, callback);
                }

                return;
            }

            if (!this.callbacks[type]) {
                this.callbacks[type] = {
                    namespaces: {},
                    others: []
                };
            }

            if (namespace) {
                this.callbacks[type].namespaces[namespace] = callback;
            } else {
                this.callbacks[type].others.push(callback);
            }

        },

        fireCallbacks: function(type, data, doneCallback)
        {
            var callbackList = [];
            if (this.callbacks[type]) {
                // Put the callbacks in an array.
                for (var namespace in this.callbacks[type].namespaces) {
                    if (this.callbacks[type].namespaces.hasOwnProperty(namespace) === true) {
                        var callback = this.callbacks[type].namespaces[namespace];
                        if (callback) {
                            callbackList.push(callback);
                        }
                    }
                }

                var len = this.callbacks[type].others.length;
                for (var i = 0; i < len; i++) {
                    callbackList.push(this.callbacks[type].others[i]);
                }
            }

            return this._fireCallbacks(callbackList, data, doneCallback);

        },

        _fireCallbacks: function(callbacks, data, doneCallback, retVal)
        {
            if (callbacks.length === 0 || retVal === false) {
                if (doneCallback) {
                    doneCallback.call(this, data, retVal);
                }

                return retVal;
            }

            var callback = callbacks.shift();
            if (callback) {
                var self = this;
                try {
                    var retVal = callback.call(this, data, function(retVal) {
                        self._fireCallbacks(callbacks, data, doneCallback, retVal);
                    });

                    // TODO: need a better way to handle callback only events.
                    if (Viper.Util.isFn(retVal) === true) {
                        return;
                    }
                } catch (e) {
                    console.error(e, callback, e.stack);
                }

                return this._fireCallbacks(callbacks, data, doneCallback, retVal);
            }

        },

        removeCallback: function(type, namespace)
        {
            if (!type) {
                if (namespace) {
                    // Remove all events for specified namespace.
                    for (var type in this.callbacks) {
                        if (this.callbacks.hasOwnProperty(type) === true) {
                            this.removeCallback(type, namespace);
                        }
                    }
                }
            } else if (this.callbacks[type]) {
                if (namespace) {
                    if (this.callbacks[type].namespaces[namespace]) {
                        delete this.callbacks[type].namespaces[namespace];
                    }
                } else {
                    // Remove all.
                    delete this.callbacks[type];
                }
            }

        },


        /**
         * Gets the clean source code of the element.
         *
         * @return string.
         */
        getHtml: function(elem, settings)
        {
            elem = elem || this.element;

            if (typeof elem === 'string') {
                var tmp = elem;
                elem    = Viper.document.createElement('div');
                Viper.Util.setHtml(elem, tmp);
            }

            if (!elem) {
                return '';
            }

            var originalSettings = this.getSettings();

            if (!settings) {
                // When getHtml is called the final output of empty table cells should
                // be &nbsp; to make them look fine in all browsers.
                this.setSetting('emptyTableCellContent', '&nbsp;');
            } else {
                this.setSettings(settings);
            }

            // Clone the element so we dont modify the actual contents.
            var clone = Viper.Util.cloneNode(elem);

            this.removeHighlights(clone);
            this.removeEmptyNodes(clone);

            // Remove special Viper elements.
            this._removeViperElements(clone);

            // TODO: What if some of the plugins need to run after plugin X, Y, Z
            // e.g. Keyword plugin?
            // Plugins can hookin to this method to modify the HTML
            // before Viper returns its HTML contents.
            this.fireCallbacks('Viper:getHtml', {element: clone});
            var html = Viper.Util.getHtml(clone);
            html     = this.cleanHTML(html);

            var defaultBlockTag = this.getDefaultBlockTag();
            if (html === '' && defaultBlockTag) {
                html = '<' + defaultBlockTag + '></' + defaultBlockTag + '>';
            }

            html = html.replace(/<\/viper:param>/ig, '');
            html = html.replace(/<viper:param /ig, '<param ');
            html = html.replace(/<:object/ig, '<object');
            html = html.replace(/<\/:object/ig, '</object');

            html = html.replace(/__viper_attr_/g, '');

            // Revert to original settings.
            this.setSettings(originalSettings, true);

            return html;

        },

        getRawHTML: function(elem)
        {
            elem = elem || this.element;
            return Viper.Util.getHtml(elem);

        },

        setRawHTML: function(html)
        {
            Viper.Util.setHtml(this.element, html);

        },

        /**
         * Gets the HTML (not source) contents of the editable element.
         * Returned value contains Viper specific elements.
         *
         * @return string.
         */
        getContents: function(elem)
        {
            elem = elem || this.element;

            // Clone the element so we dont modify the actual contents.
            var clone = Viper.Util.cloneNode(elem);

            // Remove special Viper elements.
            this._removeViperElements(clone);

            // Plugins can hookin to this method to modify the HTML
            // before Viper returns its HTML contents.
            this.fireCallbacks('getContents', {element: clone});
            var html = Viper.Util.getHtml(clone);

            if (Viper.Util.isBrowser('msie') === true) {
                html = html.replace(/<:object /ig, '<object ');
                html = html.replace(/<\/:object>/ig, '</object>');
            }

            return html;

        },

        _removeViperElements: function(elem)
        {
            var bookmarks = Viper.Util.getClass('viperBookmark', elem);
            if (bookmarks) {
                Viper.Util.remove(bookmarks);
            }

            // Remove viper selection.
            var highlights = Viper.Util.getClass('__viper_selHighlight', elem);
            for (var i = 0; i < highlights.length; i++) {
                if (Viper.Util.hasClass(highlights[i], '__viper_cleanOnly') !== true) {
                    while (highlights[i].firstChild) {
                        Viper.Util.insertBefore(highlights[i], highlights[i].firstChild);
                    }

                    Viper.Util.remove(highlights[i]);
                } else {
                    Viper.Util.removeClass(highlights[i], '__viper_selHighlight');
                    Viper.Util.removeClass(highlights[i], '__viper_cleanOnly');
                    if (!highlights[0].getAttribute('class')) {
                        highlights[0].removeAttribute('class');
                    }
                }
            }

        },

        /**
         * Sets the Viper content that may contain Viper specified elements.
         */
        setContents: function(contents)
        {
            if (typeof contents === 'string') {
                this.element.innerHTML = contents;
            } else if (contents) {
                this.element.appendChild(contents);
            }

            this.fireCallbacks('setContents', {element: this.element});

            this.initEditableElement();

        },

        /**
         * Sets the Viper content, content cannot contain Viper specific elements.
         */
        setHtml: function(contents, callback)
        {
            var self = this;
            this.fireCallbacks('Viper:setHtmlContent', contents, function(data, newContents) {
                self._setHTML(newContents, callback);
            });

        },

        _setHTML: function(contents, callback)
        {
            var clone = Viper.document.createElement('div');

            if (typeof contents === 'string') {
                clone.innerHTML = contents;
                Viper.Util.remove(Viper.Util.getTag('script', clone));
            } else if (contents) {
                clone.appendChild(contents);
            }

            this._viperRange = null;

            var range          = this.getCurrentRange();
            var lastSelectable = range._getLastSelectableChild(clone);
            if (lastSelectable && lastSelectable.nodeType === Viper.Util.TEXT_NODE) {
                lastSelectable.data = Viper.Util.rtrim(lastSelectable.data);
            }

            this.removeEmptyNodes(clone);

            var self = this;
            this.fireCallbacks('Viper:setHtml', {element: clone}, function() {
                var html = Viper.Util.getHtml(clone);
                if (Viper.Util.isBrowser('msie', 8) === true) {
                    // IE8 has problems with param tags, it removes them from the content
                    // so Viper needs to change the tag name when content is being set
                    // and change it back to original when content is being retrieved.
                    html = html.replace(/<\/param>/ig, '</viper:param>');
                    html = html.replace(/<param /ig, '<viper:param ');
                }

                self.element.innerHTML = html;
                self.initEditableElement();

                self.contentChanged();
                if (callback) {
                    callback.call(this);
                }
            });

        },

        _closeStubTags: function (content)
        {
            var re  = /<(area|base|basefont|br|hr|input|img|link|meta|embed|viper:param|param)((\s+\w+(\s*=\s*(?:"[^">]*"|\'[^\'>]+\'))?)+)?\s*>/ig;
            content = content.replace(re, "<$1$2 />");
            return content;

        },

        cleanHTML: function(content, attrBlacklist)
        {
            attrBlacklist = attrBlacklist || ['sizset'];

            content = content.replace(/<(p|div|h1|h2|h3|h4|h5|h6|li)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>\s*/ig, "<$1$2>");
            content = content.replace(/\s*<\/(p|div|h1|h2|h3|h4|h5|h6|li)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>/ig, "</$1$2>");
            content = this._closeStubTags(content);
            content = content.replace(/<\/?\s*([A-Z\d:]+)/g, function(str) {
                return str.toLowerCase();
            });

            content = this.replaceEntities(content);

            // Regex to get list of HTML tags.
            var subRegex = '\\s+([_\\-:\\w]+)(?:\\s*=\\s*("(?:[^"]+)?"|\'(?:[^\']+)?\'|[^\'">\\s]+))?';

            // Regex to get list of attributes in an HTML tag.
            var tagRegex  = new RegExp('(<[\\w:]+)(?:' + subRegex + ')+\\s*(\/?>)', 'g');
            var attrRegex = new RegExp(subRegex, 'g');

            content = content.replace(tagRegex, function(match, tagStart, a, tagEnd) {
                match = match.replace(attrRegex, function(a, attrName, attrValue) {
                    // All attribute names must be lowercase.
                    attrName = attrName.toLowerCase();

                    if (Viper.Util.inArray(attrName, attrBlacklist) === true) {
                        // This attribute is not allowed.
                        return '';
                    } else if (attrName.indexOf(':') >= 0) {
                        return '';
                    } else if (attrName.match(/^sizcache\d+$/)) {
                        return '';
                    }

                    if (attrName === 'style') {
                        // Style attribute value must be lowercase.
                        attrValue = attrValue.toLowerCase();
                    }

                    // Remove single and double quotes and then wrap the value with
                    // double quotes.
                    if (attrValue) {
                        attrValue = Viper.Util.trim(attrValue, '"\'');
                    } else {
                        attrValue = '';
                    }

                    var res = ' ' + attrName + '="' + attrValue + '"';
                    return res;
                });

                return match;
            });

            return content;

        },

        /**
         * Cleans the contents of the given DOM element.
         *
         * @param {DOMNode} elem    The element to clean, if not specified Viper element is used.
         * @param {string}  tagName If specified only this type of tag is cleaned.
         *
         * @return {void}
         */
        cleanDOM: function(elem, tagName)
        {
            if (!elem) {
                elem = this.element;
            }

            // Remove attributes with empty values.
            Viper.Util.removeAttr(Viper.Util.find(elem, '[style=""]'), 'style');
            Viper.Util.removeAttr(Viper.Util.find(elem, '[class=""]'), 'class');

            this.removeNotAllowedAttributes(elem);

            this._cleanDOM(elem, tagName, true);

            if (Viper.Util.isBlockElement(elem) === true) {
                var range    = this.getViperRange(elem);
                var lastElem = range._getLastSelectableChild(elem);
                if (lastElem && lastElem.nodeType === Viper.Util.TEXT_NODE) {
                    lastElem.data = Viper.Util.rtrim(lastElem.data.replace(/(&nbsp;)*$/, ''));
                }
            }

        },

        /**
         * Removes attributes that are not allowed in Viper.
         *
         * @param {DOMNode} elem The element to clean.
         *
         * @return {void}
         */
        removeNotAllowedAttributes: function(elem)
        {
            // Find elements with contenteditable attribute and remove then.
            var notAllowedAttributes = ['contenteditable'];
            for (var i = 0; i < notAllowedAttributes.length; i++) {
                Viper.Util.removeAttr(Viper.Util.find(elem, '[' + notAllowedAttributes[i] + ']'), notAllowedAttributes[i]);
            }

        },

        _cleanDOM: function(elem, tagName, topLevel)
        {
            if (!elem) {
                return;
            }

            if (elem.firstChild && Viper.Util.isTag(elem, 'pre') !== true) {
                this._cleanDOM(elem.firstChild, tagName);
            }

            if (elem === this.element || topLevel === true) {
                return;
            }

            var nextSibling = elem.nextSibling;
            this._cleanNode(elem, tagName);

            if (nextSibling) {
                this._cleanDOM(nextSibling, tagName);
            }

        },

        _cleanNode: function(node, tag)
        {
            if (node === this.element) {
                return;
            }

            if (node.nodeType === Viper.Util.ELEMENT_NODE) {
                var tagName = node.tagName.toLowerCase();
                if (tag && tag !== tagName) {
                    return;
                } else if (node.className !== '' || node.id !== '') {
                    // If the node has CSS classes or ID set then do not remove it.
                    switch (tagName) {
                        case 'textarea':
                        case 'form':
                        case 'input':
                        case 'button':
                        case 'select':
                        case 'label':
                            // Form fields must be removed.
                            Viper.Util.remove(node);
                        break;

                        default:
                            // Keep node.
                        break;
                    }

                    return;
                }

                switch (tagName) {
                    case 'br':
                        if (!node.nextSibling
                            || (node.hasAttribute && node.hasAttribute('_moz_dirty'))
                        ) {
                            if (!node.previousSibling
                                && (Viper.Util.isTag(node.parentNode, 'td') === true
                                || Viper.Util.isTag(node.parentNode, 'th') === true)
                            ) {
                                // This BR element is the only child of the table cell,
                                // depending on emptyTableCellContent, set the cell's
                                // content.
                                var emptyTableCellContent = this.getSetting('emptyTableCellContent');
                                Viper.Util.setHtml(node.parentNode, emptyTableCellContent);
                                return;
                            }

                            // Remove all BR tags and spaces just before this one.
                            var prev = node.previousSibling;
                            while (prev) {
                                if (Viper.Util.isTag(prev, 'br') === true
                                    || (prev.nodeType === Viper.Util.TEXT_NODE && Viper.Util.trim(prev.nodeValue) === '')
                                ) {
                                    var removeNode = prev;
                                    prev       = prev.previousSibling;
                                    Viper.Util.remove(removeNode);
                                } else {
                                    break;
                                }
                            }

                            if (tag) {
                                var newNode = Viper.document.createTextNode(' ');
                                Viper.Util.insertBefore(node, newNode);
                            }

                            Viper.Util.remove(node);
                        } else {
                            // Also remove the br tags that are at the end of an element.
                            // They are usually added to give the empty element height/width.
                            var next   = node.nextSibling;
                            var brLast = true;
                            while (next) {
                                if (next.nodeType !== Viper.Util.TEXT_NODE || Viper.Util.trim(next.nodeValue) !== '') {
                                    brLast = false;
                                    break;
                                }

                                next = next.nextSibling;
                            }

                            if (brLast === true) {
                                // Rmove all BR tags just before this one.
                                var prev = node.previousSibling;
                                while (prev) {
                                    if (Viper.Util.isTag(prev, 'br') === true
                                        || (prev.nodeType === Viper.Util.TEXT_NODE && Viper.Util.trim(prev.nodeValue) === '')
                                    ) {
                                        var removeNode = prev;
                                        prev       = prev.previousSibling;
                                        Viper.Util.remove(removeNode);
                                    } else {
                                        break;
                                    }
                                }

                                Viper.Util.remove(node);
                            }
                        }//end if
                    break;

                    case 'a':
                        if (!node.getAttribute('name') && !node.firstChild) {
                            Viper.Util.remove(node);
                        }
                    break;

                    case 'td':
                    case 'th':
                    case 'caption':
                        var html = Viper.Util.trim(Viper.Util.getHtml(node));
                        if (html === '' || Viper.Util.trim(html.replace(/&nbsp;/g, '')) === '') {
                            Viper.Util.setHtml(node, '&nbsp;');
                        }
                    break;

                    case 'textarea':
                    case 'form':
                    case 'input':
                    case 'button':
                    case 'select':
                    case 'label':
                        Viper.Util.remove(node);
                    break;

                    case 'strong':
                    case 'em':
                        if (Viper.Util.isTag(node.parentNode, tagName) === true) {
                            // Same as parent tag, move child nodes out and remove this
                            // node.
                            while (node.firstChild) {
                                Viper.Util.insertBefore(node, node.firstChild);
                            }

                            Viper.Util.remove(node);
                            break;
                        } else if (node.previousSibling && Viper.Util.isTag(node.previousSibling, tagName) === true) {
                            while (node.firstChild) {
                                node.previousSibling.appendChild(node.firstChild);
                            }

                            Viper.Util.remove(node);
                            break;
                        }

                    default:
                        var cont = Viper.Util.trim(Viper.Util.getHtml(node));
                        if ((Viper.Util.isStubElement(node) === false
                            && !node.firstChild)
                            || cont === '&nbsp;'
                            || (cont === '' && Viper.Util.isTag(node, ['p', 'div']))
                        ) {
                            Viper.Util.remove(node);
                        }
                    break;
                }//end switch
            } else if (node.nodeType === Viper.Util.TEXT_NODE && !tag) {
                if (Viper.Util.isTag(node.parentNode, 'td') === false) {
                    if (Viper.Util.trim(node.data, "\f\n\r\t\v\u2028\u2029") === '') {
                        Viper.Util.remove(node);
                    } else if (Viper.Util.trim(node.data) === '' && node.data.indexOf("\n") === 0) {
                        Viper.Util.remove(node);
                    } else if (node.data.match(/\n\s+\S+\n\s+/) !== null && !node.previousSibling && !node.nextSibling) {
                        node.data = Viper.Util.trim(node.data);
                    } else {
                        var nbsp = String.fromCharCode(160);

                        // Remove extra spaces from the node.
                        node.data = node.data.replace(/^\s+/g, ' ');
                        node.data = node.data.replace(/\s+$/g, ' ');
                        node.data = node.data.replace(/\s*\n\s*/g, ' ');

                        // TODO: We should normalise these text nodes before calling this method. This way there is no
                        // reason to do this check here as there will be no sibling text nodes.
                        if (node.data.charAt(0) === ' '
                           && node.previousSibling
                           && node.previousSibling.nodeType === Viper.Util.TEXT_NODE
                           && (node.previousSibling.data.charAt(node.previousSibling.data.length - 1) === nbsp
                           || node.previousSibling.data.charAt(node.previousSibling.data.length - 1) === ' ')
                        ) {
                           node.data = node.data.replace(/^\s+/g, nbsp);
                        }

                        if (node.data.charAt(node.data.length - 1) === ' '
                            && node.nextSibling
                            && node.nextSibling.nodeType === Viper.Util.TEXT_NODE
                            && (node.nextSibling.data.charAt(0) === ' '
                            || node.nextSibling.data.charAt(0) === nbsp)
                        ) {
                            node.data = node.data.replace(/\s+$/g, nbsp);
                        }

                        // Replace two spaces with two &nbsp;.
                        node.data = node.data.replace(/\s{2,2}/g, nbsp + nbsp);
                    }
                } else {
                    node.data = node.data.replace(/^\n+\s*$/m, '');
                }
            }//end if

        },

        removeEmptyNodes: function(element, content)
        {
            if (content && !element) {
                element = document.createElement('div');
                Viper.Util.setHtml(element, content);
            } else if (!content) {
                if (!element) {
                    element = this.element;
                }
            } else {
                return;
            }

            this.cleanDOM(element);

            return element;

        },

        replaceEntities: function(html)
        {
            // Replace special Word characters with HTML ones..
            var specialCharcodes = {
                '8211': '&ndash;',
                '8212': '&mdash;',
                '8226': '*'
            };

            for (var code in specialCharcodes) {
                html = html.replace(new RegExp(String.fromCharCode(code), 'g'), specialCharcodes[code]);
            }

            return Viper.Util.replaceCommonNamedEntities(html);

        },

        removeElem: function(elem)
        {
            if (Viper.Util.isArray(elem) === true) {
                var eln = elem.length;
                for (var i = 0; i < eln; i++) {
                    this.removeElem(elem[i]);
                }
            } else if (elem) {
                var parent = elem.parentNode;
                Viper.Util.remove(elem);
                if (parent) {
                    for (var node = parent.firstChild; node; node = node.nextSibling) {
                        if (node.nodeType !== Viper.Util.TEXT_NODE || node.nodeValue.length !== 0) {
                            // Not empty.
                            return;
                        }
                    }

                    // If parent is now empty then remove it.
                    Viper.Util.remove(parent);
                }
            }

        }
    };

    // Add Viper to global namespace.
    window.Viper = Viper;

}) (window);
