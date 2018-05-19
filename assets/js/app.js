require('bootstrap');
const $ = require('jquery');
const List = require('list.js');




var challengeList = new List('challenge-list', {
    valueNames: ['js-name','js-description','js-type', 'js-dateEnd','js-dateStart'],
    page: 5,
    pagination: true

});

