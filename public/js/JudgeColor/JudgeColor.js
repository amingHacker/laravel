function addCellAttr(rowId, val, rawObject, cm, rdata) {
            if(rawObject.determination == 'Fail' )
            {
                var product = '';
                var product_level = '';
                var cloumnName = getColumnNameFromDatabaseToChinese(cm["name"]);
    
                //Data from table
                switch (rawObject.product_name)
                {
                    case 'TMAL':
                        product = 'product_tmal';
                        switch (rawObject.level)
                        {
                            case 'LO':
                                product_level = 'TMALLO_LO';
                                break;
                            case 'EPU':
                                product_level = 'TMALEPU_EPU';
                                break;
                            case 'OT':
                                product_level = 'TMALOT_OT';
                                break;
                            case '4LED':
                                product_level = 'TMAL4LED_4LED';
                                break;
                            case 'PG':
                                product_level = 'TMALPG_PG';
                                break;
                            case 'EG':
                                product_level = 'TMALEG_EG';
                                break;
                            case 'TW':
                                product_level = 'TMALTW_TW';
                                break;
                            case 'EP':
                                product_level = 'TMALEP_EP';
                                break;
                        }
                        break;
                    case 'EMMA':
                        product = 'product_tmal';
                        product_level = 'EMMA_TSMCCL';
                        break;
                    case 'TMGA':
                        product = 'product_mo';
                        switch (rawObject.level)
                        {
                            case 'AG':
                                product_level = 'TMG_AG';
                                break;
                            case 'EP':
                                product_level = 'TMG_EP';
                                break;
                            case 'LEDC':
                                product_level = 'TMG_LEDC';
                                break;
                            case 'LEDP':
                                product_level = 'TMG_LEDP';
                                break;
                            case 'SP':
                                product_level = 'TMG_SP';
                                break;
                            case 'SE':
                                product_level = 'TMG_SE';
                                break;
                        }
                        break;
                    case 'TMIN':
                        product = 'product_mo';
                        switch (rawObject.level)
                        {
                            case 'EP':
                                product_level = 'TMIN_EP';
                                break;
                            case 'OS':
                                product_level = 'TMIN_forOsram';
                                break;
                        }
                        break;
                    case 'TEGA':
                        product = 'product_mo';
                        switch (rawObject.level)
                        {
                            case 'AG':
                                product_level = 'TEG_AG_EP';
                                break;
                            case 'EP':
                                product_level = 'TEG_AG_EP';
                                break;
                            case 'SE':
                                product_level = 'TEG_SE';
                                break;
                            case 'OS':
                                product_level = 'TEG_Osram';
                                break;
                        }
                        break;
                    case 'CPMG':
                        product = 'product_mo';
                        switch (rawObject.level)
                        {
                            case 'AG':
                                product_level = 'CPMG_AG_EP';
                                break;
                            case 'EP':
                                product_level = 'CPMG_AG_EP';
                                break;
                        }
                        break;
                    case 'DEZN':
                        product = 'product_mo';
                        product_level = 'CPMG_AG_EP';
                        break;
                    case 'DMZN':
                        product = 'product_mo';
                        product_level = 'CPMG_AG_EP';
                        break;
                    case 'CBR4':
                        product = 'product_mo';
                        switch (rawObject.level)
                        {
                            case 'AG':
                                product_level = 'CBR4_AG_EP';
                                break;
                            case 'EP':
                                product_level = 'CBR4_AG_EP';
                                break;
                            case '':
                                product_level = 'CBR4_AG_EP';
                                break;
                        }
                        break;
                    case 'BTCM':
                        product = 'product_mo';
                        switch (rawObject.level)
                        {
                            case 'EG':
                                product_level = 'BTCM_EG';
                                break;
                            case '':
                                product_level = 'BTCM_EG';
                                break;
                        } 
                        break;
                    case 'PDMAT': //not yet
                        product = 'product_pdmat';
                        switch (rawObject.level)
                        {
                
                        } 
                        break;
                    case 'CCTBA': //not yet
                        product = 'product_cctba';
                        break;
                    case 'ALEXA':
                        product = 'product_alexa';
                        switch (rawObject.level)
                        {
                            case 'EG':
                                product_level = 'ALEXA_TSMC_CL';
                                break;
                            case '':
                                product_level = 'ALEXA_TSMC_CL';
                                break;
                        } 
                        break;
                }
                var sty = "style='font-size:14px'";
    
                var value = val.split("<");
            
                val = value[value.length - 1];
               
                for(var j in productSpec[product])
                {
                    var _productS = productSpec[product][j];
                    if ( _productS["ELEMENT"] == cloumnName &&  parseFloat(_productS[product_level]) <  parseFloat(val) && _productS[product_level] != '-')
                    {
                        sty = "style='font-size:14px; background-color:#9dbcfa'" ;
                    }
                }
    
                return sty;
            }
        }