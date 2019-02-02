void function ( exports, $, _, Backbone ) {

	var ES_LayerView = exports.ES_LayerView = B.View.extend({
		constructor: function ES_LayerView () {
			B.View.apply(this, arguments);
		},
		events: {
			mousedown: function () {
				this.model.set('selected', true);
				_(this.model.collection.without(this.model)).invoke('set', 'selected', false);
			},
			'focus input': function(e) {
				!this.model.get('selected') && _(this.model.collection.without(this.model)).invoke('set', 'selected', false);
				this.model.set('selected', true);
				e.stopPropagation();
			},
			'mousedown input': function(e) {
				!this.model.get('selected') && _(this.model.collection.without(this.model)).invoke('set', 'selected', false);
				this.model.set('selected', true);
				e.stopPropagation();
			},
		},
		modelEvents: {},
		bindings: [
			{
				type: 'class',
				attr: {
					'selected': 'selected'
				}
			}
		],

		updateIndex: function () {
			this.model.set('index', this.model.collection.length - this.$el.index());
		},
		initialize: function(){
			if ( typeof this.model.get('type') !== 'undefined' ) {
				var className = '';
				switch ( this.model.get('type') ) {
					case 'item':
						className = 'fa fa-square-o';
						break;
					case 'text':
						className = 'fa fa-font';
						break;
					case 'image':
						className = 'fa fa-image';
						break;
					case 'video':
						className = 'fa fa-film';
						break;
				}
				this.$('.item-type').addClass(className);
			}
			this.listenTo(this.model, 'remove', this.remove);
		}
	});

	var ES_LayersView = exports.ES_LayersView = B.CollectionView.extend({
		constructor: function ES_LayersView () {
			B.CollectionView.apply(this, arguments);
		},
		_reverseOrder: true,
		itemView: ES_LayerView,
		events: {
			'sortupdate': 'updateIndex',
			'scroll': function(e) {
				this.rootView.framesView.el.scrollTop = this.el.scrollTop;
			},
		},
		initialize: function () {
			//this.on('set:collection', function( collection ) {
			//	this.listenTo(collection, 'remove', this.reset);
			//})
			this.$el.sortable({
				distance: 10,
				handle: '.layer-drag-handle',
				revert: 100,
			});
		},
		updateIndex: function () {
			//console.log('update index');
			_(this.subViews).invoke('updateIndex');
			this.collection.sort();
		}
	});

}(this, jQuery, _, JSNES_Backbone);