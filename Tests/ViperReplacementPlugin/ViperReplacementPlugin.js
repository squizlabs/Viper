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
        var elem = Viper.Util.getClass('Viper-button Viper-' + btn, Viper.Util.getClass('ViperTP-bar')[0])[0];
        if (Viper.Util.hasClass(elem, 'Viper-disabled') === false) {
            if (Viper.Util.hasClass(elem, 'Viper-active') === true) {
                btns.topToolbar[btn] = 'active';
            } else {
                btns.topToolbar[btn] = true;
            }
        }
    }

    if (Viper.Util.hasClass(Viper.Util.getClass('ViperITP')[0], 'Viper-visible') !== true) {
        btns.vitp = false;
    } else {
        for (var btn in btns.vitp) {
            var elem = Viper.Util.getClass('Viper-button Viper-' + btn, Viper.Util.getClass('ViperITP')[0])[0];
            if (elem) {
                if (Viper.Util.hasClass(elem, 'Viper-disabled') === false) {
                    if (Viper.Util.hasClass(elem, 'Viper-active') === true) {
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
