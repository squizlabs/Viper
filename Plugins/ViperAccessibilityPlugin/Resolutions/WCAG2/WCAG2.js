ViperAccessibilityPlugin_WCAG2 = {
    viper: null,

    getReferenceContent: function(issue, callback, vap)
    {
        this.viper = vap.viper;

        var code = this._parseCode(issue.code);

        var content = '<strong>' + code.standard + ' References</strong><br>';
        content    += '<em>Principle: </em> <a target="_blank" href="http://www.w3.org/TR/WCAG20/#' + code.principleName + '">' + dfx.ucFirst(code.principleName) + '</a><br>';
        content    += '<em>Techniques: </em> ';

        var techStrs = [];
        for (var i = 0; i < code.techniques.length; i++) {
            techStrs.push('<a target="_blank" href="http://www.w3.org/TR/WCAG20-TECHS/' + code.techniques[i] + '">' + code.techniques[i] + '</a>');
        }

        content += techStrs.join(', ');

        var element = document.createElement('div');
        dfx.setHtml(element, content);
        dfx.addClass(element, 'issueWcag');

        callback.call(this, element);

    },

    getResolutionContent: function(issue, callback, vap)
    {
        this.viper = vap.viper;

        var code = this._parseCode(issue.code);

        var objName = 'ViperAccessibilityPlugin_WCAG2_Principle' + code.principle + '_Guideline' + code.guideline.replace('.', '_');
        var obj     = window[objName];
        if (obj) {
            var fn = obj['res_' + code.section.replace('.', '_')];
            if (dfx.isFn(fn) === true) {
                fn.call(obj, issue.element, issue, code, callback, vap.viper);
            }

            return;
        }

        var url  = vap.viper.getViperPath();
        url     += 'Plugins/ViperAccessibilityPlugin/Resolutions/WCAG2/';
        url     += 'Principle' + code.principle + '/Guideline' + code.guideline.replace('.', '_');

        var scriptUrl = url + '/resolutions.js';
        var cssUrl    = url + '/resolutions.css';

        var self    = this;
        var objName = 'ViperAccessibilityPlugin_WCAG2_Principle' + code.principle + '_Guideline' + code.guideline.replace('.', '_');
        vap.loadObject(scriptUrl, objName, function(obj) {
            if (!obj) {
                callback.call(this);
                return;
            }

            if (obj.hasCss === true) {
                vap.includeCss(cssUrl);
            }

            obj.parent = self;

            var fn = obj['res_' + code.section.replace('.', '_')];
            if (dfx.isFn(fn) === true) {
                fn.call(obj, issue.element, issue, code, callback, vap.viper);
            } else {
                callback.call(this);
            }
        });

    },

    createActionButton: function(action, widgetids, title, enabled)
    {
        title   = title || 'Apply Changes';

        var disabled = !enabled;
        var tools    = this.viper.ViperTools;
        var buttonid = dfx.getUniqueId();
        var button   = tools.createButton(buttonid, title, title, '', action, disabled);

        if (widgetids) {
            for (var i = 0; i < widgetids.length; i++) {
                if (!widgetids[i]) {
                    continue;
                }

                this.viper.registerCallback('ViperTools:changed:' + widgetids[i], 'ViperAccessibilityPlugin:wcag2', function() {
                    tools.enableButton(buttonid);
                });
            }
        }

        return button;

    },

    getContent: function(instructionsContent, actionsContent)
    {
        instructionsContent = instructionsContent || '';
        actionsContent      = actionsContent || '';

        var content = '<div class="resolutionInstructions">' + instructionsContent + '</div>';
        content    += '<div class="resolutionActions"><div class="editing">' + actionsContent + '</div></div>';
        return content;

    },

    _parseCode: function(code)
    {
        var sections = code.split('.');
        var parsed   = {};
        parsed.standard = sections[0];

        if (sections[1].indexOf('Principle') === 0) {
            var principle = sections[1].replace('Principle', '');
            var principleName = '';
            switch (principle) {
                case '1':
                    principleName = 'perceivable';
                break;

                case '2':
                    principleName = 'operable';
                break;

                case '3':
                    principleName = 'understandable';
                break;

                case '4':
                    principleName = 'robust';
                break;
            }

            parsed.principle     = principle;
            parsed.principleName = principleName;
        }

        if (sections[2].indexOf('Guideline') === 0) {
            parsed.guideline = sections[2].replace('Guideline', '').replace('_', '.');
        }

        parsed.section = sections[3].replace('_', '.');

        parsed.techniques = [];

        var techniques = sections.splice(4).join('.');
        var techniques = techniques.split(',');
        for (var i = 0; i < techniques.length; i++) {
            parsed.techniques.push(techniques[i]);
        }

        return parsed;

    }

};
