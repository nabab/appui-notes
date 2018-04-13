(() => {
	return {
		props: {
			data: {
        type: [Object, Function],
        default(){
          return {};
        }
      },
			filterable: {
        type: Boolean,
        default: false
      },
			filters: {
				type: Object,
				default(){
					return {
						logic: 'AND',
						conditions: []
					};
				}
			},
			limit: {
        type: Number,
        default: 25
      },
			map: {
        type: Function
      },
			pageable: {
        type: Boolean,
        default: true
      },
      source: {
				type: [Array, String],
				default(){
					return [];
				}
			},
			toolbar: {
        type: [String, Array, Function, Object]
      },
			edit: {
				type: Function
			},
			remove: {
				type: Function
			},
			reply: {
				type: Function
			}
		},
		data(){
			return {
				currentData: [],
				currentLimit: this.limit,
				currentFilters: $.extend({}, this.filters),
				originalData: null,
				start: 0,
        total: 0,
				limits: [10, 25, 50, 100, 250, 500],
				isLoading: false,
        isAjax: typeof this.source === 'string'
			}
		},
		computed: {
			numPages(){
        return Math.ceil(this.total/this.currentLimit);
      },
			currentPage: {
        get(){
          return Math.ceil((this.start+1)/this.currentLimit);
        },
        set(val){
          this.start = val > 1 ? (val-1) * this.currentLimit : 0;
          this.updateData();
        }
      },
      toolbarButtons(){
        let r = [],
            ar = [];
        if ( this.toolbar ){
          ar = $.isFunction(this.toolbar) ?
            this.toolbar() : (
              Array.isArray(this.toolbar) ? this.toolbar.slice() : []
            );
          if ( Array.isArray(ar) ){
            $.each(ar, (i, a) => {
              let o = $.extend({}, a);
              if ( o.command ){
                o.command = () => {
                  this._execCommand(a);
                }
              }
              r.push(o);
            });
          }
        }
        return r;
      }
		},
		methods: {
      _execCommand(button, data, col, index){
        if ( button.command ){
          if ( $.isFunction(button.command) ){
            return button.command(data, col, index);
          }
          else if ( typeof(button.command) === 'string' ){
            switch ( button.command ){
              case 'insert':
                return this.insert(data, {title: bbn._('New row creation')});
              case 'edit':
                return this.edit(data, {title: bbn._('Row edition')}, index);
              case 'delete':
                return this.remove(index);
              case 'reply':
                return this.reply(index);
            }
          }
        }
        return false;
      },
      _map(data){
        return this.map ? $.map(data, this.map) : data;
      },
		  currentUser(){
		    return appui.app.userId;
      },
			sdate(d){
			  return moment(d).format('DD/MM/YY')
      },
      fdate(d){
        return moment(d).format('DD/MM/YY HH:mm:ss');
      },
      hour(d){
        return moment(d).format('HH:mm:ss')
      },
			updateData(withoutOriginal){
        if ( this.isAjax && !this.isLoading ){
          this.isLoading = true;
          this.$nextTick(() => {
            let data = {
              limit: this.currentLimit,
              start: this.start,
              data: this.data ? ($.isFunction(this.data) ? this.data() : this.data) : {}
            };
            if ( this.filterable ){
              data.filters = this.currentFilters;
            }
            bbn.fn.post(this.source, data, result => {
              this.isLoading = false;
              if (
                !result ||
                result.error ||
                ((result.success !== undefined) && !result.success)
              ){
                alert(result && result.error ? result.error : bbn._("Error in updateData"));
              }
              else {
                this.currentData = this._map(result.data || []);
                if ( this.editable ){
                  this.originalData = JSON.parse(JSON.stringify(this.currentData));
                }
                this.total = result.total || result.data.length || 0;
              }
            });
          });
        }
        else if ( Array.isArray(this.source) ){
          this.currentData = this._map(this.source);
          if ( this.isBatch && !withoutOriginal ){
            this.originalData = JSON.parse(JSON.stringify(this.currentData));
          }
          this.total = this.currentData.length;
        }
      },
      toggleReplies(row){
			  if ( row.num_replies ){
			    if ( row.showReplies ){
            row.showReplies = false;
            row.replies = false;
          }
          else {
            this.$set(row, 'showReplies', true);
          }
        }
      }
		},
		mounted(){
			this.$nextTick(() => {
        this.updateData();
      });
      this.ready = true;
		},
		components: {
      'appui-notes-forum-pager': {
        name: 'appui-notes-forum-pager',
        props: {
          source: {
            type: Object
          },
          pageable: {
            type: Boolean,
            default: true
          },
          ajaxUrl: {
            type: String
          },
          map: {
            type: Function
          },
          data: {
            type: Object,
            default(){
              return {};
            }
          }
        },
        data(){
          return {
            currentLimit: 25,
            originalData: null,
            start: 0,
            total: 0,
            limits: [10, 25, 50, 100, 250, 500],
            isLoading: false,
            isAjax: !!this.ajaxUrl
          }
        },
        computed: {
          numPages(){
            return Math.ceil(this.total / this.currentLimit);
          },
          currentPage: {
            get(){
              return Math.ceil((this.start + 1) / this.currentLimit);
            },
            set(val){
              this.start = val > 1 ? (val - 1) * this.currentLimit : 0;
              this.updateData();
            }
          }
        },
        methods: {
          _map(data){
            return this.map ? $.map(data, this.map) : data;
          },
          updateData(withoutOriginal){
            if ( this.isAjax && !this.isLoading ){
              this.isLoading = true;
              this.$nextTick(() =>{
                let data = {
                  limit: this.currentLimit,
                  start: this.start,
                  data: this.data
                };
                bbn.fn.post(this.ajaxUrl, data, result =>{
                  this.isLoading = false;
                  if (
                    !result ||
                    result.error ||
                    ((result.success !== undefined) && !result.success)
                  ){
                    alert(result && result.error ? result.error : bbn._("Error in updateData"));
                  }
                  else {
                    this.$set(this.source, 'replies', this._map(result.data || []));
                    if ( this.editable ){
                      this.originalData = JSON.parse(JSON.stringify(this.source.replies));
                    }
                    this.total = result.total || result.data.length || 0;
                  }
                });
              });
            }
            else if ( Array.isArray(this.source.replies) ){
              this.source.replies = this._map(this.source.replies);
              if ( this.isBatch && !withoutOriginal ){
                this.originalData = JSON.parse(JSON.stringify(this.source.replies));
              }
              this.total = this.source.replies.length;
            }
          }
        },
        mounted(){
          this.$nextTick(() =>{
            this.updateData();
          });
        }
      },
    }
	}
})();
