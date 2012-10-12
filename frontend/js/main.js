// Setup

var BigBrother = {
	Models: {},
	Collections: {},
	Views: {},
	Instances: {},
	Variables: {},
}

// Models

BigBrother.Models.User = Backbone.Model.extend({	
});

// Collections

BigBrother.Collections.Users = Backbone.Collection.extend({
	model: BigBrother.Models.User,
        url: '/bigbrother/api/personas'
});

// Views

BigBrother.Views.UserList = Backbone.View.extend({
	el: '#gente',

	initialize: function() {
		this.collection = new BigBrother.Collections.Users();
		this.collection.bind('reset',this.render,this);
		this.collection.bind('add',this.render,this);
		this.collection.fetch();
	},

	render: function() {
		var self = this;
		self.collection.each(function(model){
			self.addOne(model);
		});
	},

	addOne: function(model) {
		var view = new BigBrother.Views.UserListItem({model: model});
		$(this.el).append(view.render().el);
	},
});

BigBrother.Views.UserListItem = Backbone.View.extend({
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
BigBrother.Router = Backbone.Router.extend({

    routes: {
        "": "initialize"
    },

    initialize: function () {
    	var view = new BigBrother.Views.UserList();
    },
});

$(function(){
	var router = new BigBrother.Router();
	Backbone.history.start();
})
