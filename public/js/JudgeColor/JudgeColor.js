function addCellAttr(rowId, val, rawObject, cm, rdata) 
{
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
                    case 'EG':
                        product_level = 'PDMAT_TSMC_CL_EG';
                        break;
                    case 'PG':
                        product_level = 'PDMAPG_TSMC_CL_PG';
                        break;
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
            if ( _productS["ELEMENT"] == cloumnName )
            {
                // Assay, Parameter A, Component A這些值小於SPEC 就是異常
                if(_productS["ELEMENT"] =='Assay (Purity)' || _productS["ELEMENT"] == 'Component A' || _productS["ELEMENT"] == 'Parameter A')
                {
                    if(parseFloat(_productS[product_level]) >  parseFloat(val))
                    {
                        sty = "style='font-size:14px; background-color:#9dbcfa'" ;
                    }

                }
                
                //其他大於SPEC就是異常
                else
                {
                    if (parseFloat(_productS[product_level]) <  parseFloat(val))
                    {
                        sty = "style='font-size:14px; background-color:#9dbcfa'" ;
                    }
                }   
            }
        }
        return sty;
    }
}


function judgeFailEvent(rowid){
    return new Promise( function(resolve) 
    {
        sessionStorage.setItem('RightClickID', rowid);

		var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 產品規格 ProductSPEC 》</span><br /><br />'
        + '<div id="jqxcombobox_SPEC" ></div>' 
        + '<div id="jqxToolBar_SPEC" style = margin:0px auto; text-align:justify ></div>'
        + '</br>'
        + '<table id= "ProductSPEC"></table>'
        + '</br>'
        +'</br>'
    
        //建立動態表格
        $("#confirmDialog").html(pcontent);
        $("#confirmDialog").dialog({
            width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
            resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
            show:{effect: "fade", duration: 140},
            hide:{effect: "clip", duration: 140},
            focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
            buttons : {
                "確定" : function() {
                     var tSPEC = 
                         sessionStorage.getItem('CustomerSPEC_table_name') + ',' +
                         sessionStorage.getItem('CustomerSPEC_table_col_name');
                                   
                    $(this).dialog("close");
                    resolve(  tSPEC );                                                         
                },          
            }
        });

        var sourceSPEC = [
            "TMAL",
            "TMALEG",
            "TMALTW",
            "TMALUM",
            "MO",
            "PDMAT",
            "CCTBA",
            "ALEXA",  
        ]
        var dictionary ={
            "TMALEG": "TMAL_EG",
            "TMALTW": "TMAL_TW",
            "TMALUM": "TMAL_UM",
            "TMAL": "TMAL",
            "MO":"MO",
            "PDMAT":"PDMAT",
            "CCTBA":"CCTBA",       
            "ALEXA":"ALEXA", 
        };

        $("#jqxcombobox_SPEC").jqxComboBox({ source: sourceSPEC, selectedIndex: -1, width: '200px', height: '25' });

        $('#jqxcombobox_SPEC').bind('select', function (event) {
            var args = event.args;
            var item = $('#jqxcombobox_SPEC').jqxComboBox('getItem', args.index);
            sessionStorage.setItem('CustomerSPEC_table_name' , dictionary[item.label]);    
            ShowTableDynamic(dictionary[item.label], 'false');  // //ShowTableDynamic  path:RightClick/RightClick.js
        });	
           
    });
    
}
