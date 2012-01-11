ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_1 = {
    hasCss: true,

    res_1_1_1: function(element, code, callback) {
        var div = document.createElement('div');
        dfx.addClass(div, 'ViperAP-WCAG2_Principle1_Guideline1_1_1');

        if (code.techniques[0] === 'H37') {
            dfx.setHtml(div, '<p>Add an alt attribute to your img element. This should describe the purpose or content of the image.</p>');
            var content     = document.createElement('div');
            var editingCont = document.createElement('div');
            dfx.addClass(editingCont, 'editing');

            var clone = element.cloneNode(true);
            dfx.addClass(clone, 'thumb');
            content.appendChild(clone);

            var alt = ViperTools.createTextbox('', 'Alt', true, false);
            editingCont.appendChild(alt);

            var applyChanges = ViperTools.createButton('Apply Changes', false, 'Apply Changes', false, '', function() {
                element.setAttribute('alt', alt.lastChild.value);
            });
            editingCont.appendChild(applyChanges);

            content.appendChild(editingCont);
            div.appendChild(content);
        }//end if

        callback.call(this, div);
    }

};
