function gListS(listElem, incContent)
{
    var list = [];

    listElem = listElem || ViperUtil.getTag('ul,ol', ViperUtil.getid('content'))[0];

    for (var i = 0; i < listElem.childNodes.length; i++) {
        var node = listElem.childNodes[i];
        if (ViperUtil.isTag(node, 'li') === true) {
            var item     = 'li';
            var subLists = ViperUtil.getTag('ul,ol', node);
            if (subLists.length > 0) {
                item = {};
                item[ViperUtil.getTagName(subLists[0])] = gListS(subLists[0], incContent);
            }

            if (incContent) {
                if (typeof item === 'string') {
                    item = {};
                }

                var content = '';
                for (var child = node.firstChild; child; child = child.nextSibling) {
                    if (ViperUtil.isTag(child, 'ul') === true  || ViperUtil.isTag(child, 'ol') === true) {
                        break;
                    } else if (child.nodeType === ViperUtil.TEXT_NODE) {
                        content += child.data;
                    } else if (child.outerHTML) {
                        content += child.outerHTML;
                    } else {
                        var tmp = document.createElement('div');
                        tmp.appendChild(ViperUtil.cloneNode(child));
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
        var elem = ViperUtil.getClass('Viper-button Viper-' + btn, ViperUtil.getClass('ViperTP-bar')[0])[0];
        if (ViperUtil.hasClass(elem, 'Viper-disabled') === false) {
            if (ViperUtil.hasClass(elem, 'Viper-active') === true) {
                btns.vitp[btn] = 'active';
            } else {
                btns.topToolbar[btn] = true;
            }
        }
    }

    if (ViperUtil.hasClass(ViperUtil.getClass('ViperITP')[0], 'Viper-visible') !== true) {
        btns.vitp = false;
    } else {
        for (var btn in btns.vitp) {
            var elem = ViperUtil.getClass('Viper-button Viper-' + btn, ViperUtil.getClass('ViperITP')[0])[0];
            if (elem) {
                if (ViperUtil.hasClass(elem, 'Viper-disabled') === false) {
                    if (ViperUtil.hasClass(elem, 'Viper-active') === true) {
                        btns.vitp[btn] = 'active';
                    } else {
                        btns.vitp[btn] = true;
                    }
                } else {
                    btns.vitp[btn] = false;
                }
            }
        }
    }

    return btns;

}//end gListBStatus()
