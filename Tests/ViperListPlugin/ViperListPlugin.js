function gListS(listElem, incContent)
{
    var list = [];

    listElem = listElem || dfx.getTag('ul,ol', dfx.getId('content'))[0];

    for (var i = 0; i < listElem.childNodes.length; i++) {
        var node = listElem.childNodes[i];
        if (dfx.isTag(node, 'li') === true) {
            var item     = 'li';
            var subLists = dfx.getTag('ul,ol', node);
            if (subLists.length > 0) {
                item = {};
                item[dfx.getTagName(subLists[0])] = gListS(subLists[0], incContent);
            }

            if (incContent) {
                if (typeof item === 'string') {
                    item = {};
                }

                var content = '';
                for (var child = node.firstChild; child; child = child.nextSibling) {
                    if (dfx.isTag(child, 'ul') === true  || dfx.isTag(child, 'ol') === true) {
                        break;
                    } else if (child.nodeType === dfx.TEXT_NODE) {
                        content += child.data;
                    } else if (child.outerHTML) {
                        content += child.outerHTML;
                    } else {
                        var tmp = document.createElement('div');
                        tmp.appendChild(child.cloneNode(true));
                        content += tmp.innerHTML;
                        tmp      = null;
                    }
                }

                item.content = content;
            }//end if

            list.push(item);
        }
    }

    return list;

}//end gListS()

function gListBStatus()
{
    var btns = {
        topToolbar: {
            listUL: false,
            listOL: false,
            listIndent: false,
            listOutdent: false,
        },
        vitp: {
            listUL: null,
            listOL: null,
            listIndent: null,
            listOutdent: null,
        }
    };

    for (var btn in btns.topToolbar) {
        var elem = dfx.getClass('Viper-button ' + btn, dfx.getClass('ViperTP-bar')[0])[0];
        if (elem && dfx.hasClass(elem, 'disabled') === false) {
            if (dfx.hasClass(elem, 'active') === true) {
                btns.vitp[btn] = 'active';
            } else {
                btns.topToolbar[btn] = true;
            }
        }
    }

    for (var btn in btns.vitp) {
        var elem = dfx.getClass('Viper-button ' + btn, dfx.getClass('ViperITP')[0])[0];
        if (elem) {
            if (dfx.hasClass(elem, 'disabled') === false) {
                if (dfx.hasClass(elem, 'active') === true) {
                    btns.vitp[btn] = 'active';
                } else {
                    btns.vitp[btn] = true;
                }
            } else {
                btns.vitp[btn] = false;
            }
        }
    }

    return btns;

}//end gListBStatus()
