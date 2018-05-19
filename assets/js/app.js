require('bootstrap');
const $ = require('jquery');
const List = require('list.js');




var monkeyList = new List('test-list', {
    valueNames: ['js-name','js-description','js-type', 'js-dateEnd','js-dateStart'],
    page: 2,
    pagination: true

});

