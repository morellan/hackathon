// Setup

var Hackathon = {
	Models: {},
	Collections: {},
	Views: {},
	Instances: {},
	Variables: {},
}

// Models

Hackathon.Models.User = Backbone.Model.extend({	
});

// Collections

Hackathon.Collections.Users = Backbone.Collection.extend({
	model: Hackathon.Models.User,
	url: '/bigbrother/api/personas'
});

// Views

Hackathon.Views.UserList = Backbone.View.extend({
	el: '#lista',

	initialize: function() {
		this.collection = new Hackathon.Collections.Users();
		this.collection.bind('reset',this.render,this);
		this.collection.bind('add',this.render,this);
		this.collection.fetch();
	},

	render: function() {
		$(this.el).html("");
		var self = this;
		self.collection.each(function(model){
			self.addOne(model);
		});
	},

	addOne: function(model) {
		var view = new Hackathon.Views.UserListItem({model: model});
		$(this.el).append(view.render().el);
	},
});

Hackathon.Views.UserListItem = Backbone.View.extend({
	template: _.template($('#tpl-tr').html()),

	initialize: function(){
		this.model.bind("change",this.render,this);
	},

	render: function(){
		$(this.el).html(this.template(this.model.toJSON()));
		return this;
	}
})

// Router
Hackathon.Router = Backbone.Router.extend({

    routes: {
        "": "initialize"
    },

    initialize: function () {
    	var view = new Hackathon.Views.UserList();
    },
});

$(function(){
	var router = new Hackathon.Router();
	Backbone.history.start();
})
