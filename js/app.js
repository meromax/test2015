Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.panel.*',
    'Ext.data.JsonReader',
    'Ext.layout.container.Border'
]);


Ext.onReady(function(){


    /********************************************************************************************/
    /**** DEFINE MODELS *************************************************************************/
    /********************************************************************************************/
    Ext.define('Users',{
        extend: 'Ext.data.Model',
        proxy: {
            type: 'ajax',
            reader: 'json'
        },
        fields: [
            'user_id',
            'name',
            'education',
            'city'
        ]
    });

    Ext.define('Cities', {
        extend: 'Ext.data.Model'
    });

    Ext.define('Educations', {
        extend: 'Ext.data.Model'
    });


    /********************************************************************************************/
    /**** FILTERS *******************************************************************************/
    /********************************************************************************************/
    var citiesForm = Ext.create('Ext.form.Panel', {
        bodyBorder: true,
        border: true,
        height:180,
        title: 'Список городов',
        bodyPadding: 5,
        renderTo: 'cities-container'
    });

    function initCitiesFilter(){
        var conn = Ext.create('Ext.data.Connection');
        var resul = {
            success: false,
            msg: ''
        };
        conn.request({
            url: '/users/index/get-check-cities',
            method: 'POST',
            callback: function(options,succ,response){
                resul = Ext.JSON.decode(response.responseText);
                if(succ){
                    var myData = resul.items;
                    var count=0;
                    Ext.each(myData || [], function(item) {
                        var tmpCheckBox = [{
                            xtype: 'checkbox',
                            boxLabel: item.title,
                            name: item.title,
                            inputValue: item.id,
                            id: 'cities_check'+item.id
                        }];
                        citiesForm.insert(citiesForm.items.length, tmpCheckBox);
                        Ext.get('cities_check'+item.id).on('click', function(e, t, o){
                            if(item.checked){
                                item.checked = false;
                            } else {
                                item.checked = true;
                            }
                            setNewStoreToGrid();
                        }, null);
                        citiesForm.doLayout();
                    }, this);
                } else {
                    Ext.Msg.alert('Failure',resul.msg);
                }
            }
        });
    }

    initCitiesFilter();

    var educationForm = Ext.create('Ext.form.Panel', {
        bodyBorder: true,
        border: true,
        height:180,
        title: 'Список ученых степеней',
        bodyPadding: 10,
        renderTo: 'education-container'
    });

    function initEducationFilter(){
        var conn = Ext.create('Ext.data.Connection');
        var resul = {
            success: false,
            msg: ''
        };
        conn.request({
            url: '/users/index/get-check-educations',
            method: 'POST',
            callback: function(options,succ,response){
                resul = Ext.JSON.decode(response.responseText);
                if(succ){
                    var myData = resul.items;
                    var count=0;
                    Ext.each(myData || [], function(item) {
                        var tmpCheckBox = [{
                            xtype: 'checkbox',
                            boxLabel: item.title,
                            name: item.title,
                            inputValue: item.id,
                            id: 'edu_check'+item.id
                        }];
                        educationForm.insert(citiesForm.items.length, tmpCheckBox);
                        //console.info(Ext.get('edu_check'+item.id).component.checked);
                        Ext.get('edu_check'+item.id).on('click', function(e, t, o){
                            setNewStoreToGrid();
                        }, null);
                        educationForm.doLayout();
                    }, this);
                    //Ext.Msg.alert('Success',resul.msg);
                } else {
                    Ext.Msg.alert('Failure',resul.msg);
                }
            }
        });
    }
    initEducationFilter();

    function setNewStoreToGrid(){
        var filterIds = [];

        var citiesCheckboxesList = citiesForm.items.items;
        var educationCheckboxesList = educationForm.items.items;
        var checkboxesList = citiesCheckboxesList.concat(educationCheckboxesList);

        Ext.each(checkboxesList,function(item,i){
            //console.info(item.checked);
            if(item.checked){
                filterIds.push(item.id);
            }
        });
        sendFilterData(filterIds.join(','));

    }

    function resetFilter(){
        var citiesCheckboxesList = citiesForm.items.items;
        var educationCheckboxesList = educationForm.items.items;
        var checkboxesList = citiesCheckboxesList.concat(educationCheckboxesList);
        Ext.each(checkboxesList,function(item,i){
            item.checked=false;
            item.dirty=false;
            console.info(item);
            item.removeCls(" x-form-cb-checked x-form-dirty");
        });
        grid.reconfigure(usersListDefault, gridFields);
    }

    function sendFilterData(ids){
        var conn = Ext.create('Ext.data.Connection');
        var resul = {
            success: false,
            msg: ''
        };
        conn.request({
            url: '/users/index/filter',
            method: 'POST',
            params: {
                "ids" : ids
            },
            callback: function(options,succ,response){
                resul = Ext.JSON.decode(response.responseText);
                if(succ){
                    var myData = resul.items;
                    usersList.loadData(myData);
                    grid.reconfigure(usersList, gridFields);
                } else {
                    Ext.Msg.alert('Failure',resul.msg);
                }
            }
        });
    }


    /********************************************************************************************/
    /**** GRID **********************************************************************************/
    /********************************************************************************************/

    var usersList = Ext.create('Ext.data.Store', {
        filterOnLoad: false,
        storeId: 'usersListID',
        model: 'Users',
        autoLoad: 'true',
        proxy: {
            type: 'ajax',
            url: '/users/index/index',
            reader: {
                type: 'json',
                totalProperty: 'total'
            }
        }
    });

    var usersListDefault = Ext.create('Ext.data.Store', {
        filterOnLoad: false,
        storeId: 'usersListDefaultID',
        model: 'Users',
        autoLoad: 'true',
        proxy: {
            type: 'ajax',
            url: '/users/index/default',
            reader: {type: 'json'}
        }
    });

    var educationStore = Ext.create('Ext.data.Store', {
        filterOnLoad: false,
        storeId: 'educationStoreID',
        model: 'Educations',
        autoLoad: 'false',
        proxy: {
            type: 'ajax',
            url: '/users/index/education',
            reader: {type: 'json'}
        }
    });

    var educationCombo = Ext.create('Ext.form.ComboBox', {
        fields:['id','title'],
        triggerAction: 'all',
        lazyRender: true,
        listClass: 'x-combo-list-small',
        //emptyText: 'Select Field...',
        editable: false,
        forceSelection: true,
        valueField: 'title',
        displayField: 'title',
        typeAhead: false,
        store: educationStore,
        mode: 'local'
    });

    educationCombo.on('select', function(combo, record, index) {
        var userID = grid.getSelectionModel().getSelection()[0].data.user_id;
        var educationID = record.id;
        updateEducation(userID, educationID);
    });

    function updateEducation(userID, educationID){
        var conn = Ext.create('Ext.data.Connection');
        var resul = {
            success: false,
            msg: ''
        };
        conn.request({
            url: '/users/index/save-education',
            method: 'POST',
            params: {
                "userID" : userID,
                "educationID" : educationID
            },
            callback: function(options,succ,response){
                resul = Ext.JSON.decode(response.responseText);
                if(succ){
                    //Ext.Msg.alert('Данные успешно сохранены!',"Вы успешно изменили ученую степень для пользователя!");
                } else {
                    Ext.Msg.alert('Failure',resul.msg);
                }
            }
        });
    }

    var gridFields =
        [
            {text: "ID", width: '10%', dataIndex: 'user_id', sortable: true},
            {text: "ПОЛЬЗОВАТЕЛЬ", width: 200,dataIndex: 'name', sortable: true},
            {text: "УЧЕНАЯ СТЕПЕНЬ", width: 200, dataIndex: 'education', editor: educationCombo},
            {text: "ГОРОД",  flex: 1, dataIndex: 'city', sortable: true}
        ]

    var grid = Ext.create('Ext.grid.Panel', {
        store :usersList,
        columns: gridFields,
        forceFit: true,

        selType: 'cellmodel',


        plugins: [
            Ext.create('Ext.grid.plugin.CellEditing', {
                clicksToEdit: 1
            })
        ],
        split: true,
        layout: 'fit',
        region: 'north'
    });

    var usersPanel = Ext.create('Ext.Panel', {
        renderTo: 'users_container',
        frame: false,
        title: 'Список пользователей',
        width: '100%',
        layout: 'fit',
        items: [
            grid, {
                id: 'detailPanel',
                region: 'center',
                bodyPadding: 7,
                bodyStyle: "background: #ffffff;",
                html: ''
            }]
    });


});