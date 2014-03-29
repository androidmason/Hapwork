$(document).ready(function(){
    
  $('#searchbox').selectize({    
    valueField: 'url',
    labelField: 'firstname',
    searchField: 'firstname',
    options: [],
    create: false,
    render: {
	
        option: function(item, escape) {
                return '<div style="width:300px;float:left;">'+
          '<img id="dp" src="'+escape(item.profilepic)+'" width="75" height="75">' +
		  '<div id="data" style="float:center;">' +
			'<span id="name">'+escape(item.firstname)+'</span><br/>' +
			'<span id="talent">'+escape(item.talent)+'</span><br/>' +
			'<span id="city">'+escape(item.city)+'</span><br/>'+
			'</div>'+
		'</div>';
            }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
        $.ajax({
            url: 'http://www.hapwork.com/search',
            type: 'GET',
            dataType: 'json',
            data: {
                q: query
            },
            error: function() {
                callback();
            },
            success: function(res) {
                callback(res.data);
            }
        });
    },
	onChange: function(){
            window.location = this.items[0];
    }
  });
});