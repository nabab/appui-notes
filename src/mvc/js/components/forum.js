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
			imageDom: {
				type: String
			},
			downloadUrl: {
				type: String
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
			  currentUser: appui.app.userId,
				currentData: [],
				currentLimit: this.limit,
				currentFilters: $.extend({}, this.filters),
				originalData: null,
				start: 0,
        total: 0,
				limits: [10, 25, 50, 100, 250, 500],
				isLoading: false,
        isAjax: typeof this.source === 'string',
				mediaFileType: appui.options.media_types.file.id,
        mediaLinkType: appui.options.media_types.link.id
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
		  shorten: bbn.fn.shorten,
      _execCommand(button, data){
        if ( button.command ){
          if ( $.isFunction(button.command) ){
            return button.command(data);
          }
          else if ( typeof(button.command) === 'string' ){
            switch ( button.command ){
              case 'insert':
                return this.insert(data);
              case 'edit':
                return this.edit(data);
              case 'delete':
                return this.remove(data);
              case 'reply':
                return this.reply(data);
            }
          }
        }
        return false;
      },
      _map(data){
        return this.map ? $.map(data, this.map) : data;
      },
      sdate(d){
        //return moment(d).format('DD/MM/YY')
        return bbn.fn.fdate(d, true);
      },
      fdate(d){
        //return moment(d).format('DD/MM/YY HH:mm:ss');
        return bbn.fn.fdate(d, true);
      },
      hour(d){
        return moment(d).format('HH:mm:ss')
      },
      usersNames(creator, users, number){
        let ret = appui.app.getUserName(creator.toLowerCase()) || bbn._('Unknow'),
            u;
        if ( users ){
          u = users.split(',');
          if ( number ){
            return u.length + 1;
          }
          u.forEach((v) => {
            ret += ', ' + appui.app.getUserName(v.toLowerCase()) || bbn._('Unknow');
          });
        }
        return number ? 0 : ret;
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
                bbn.fn.alert(result && result.error ? result.error : bbn._("Error in updateData"));
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
      downloadMedia(id){
        if ( id && this.downloadUrl ){
          bbn.fn.post_out(this.downloadUrl + id);
        }
      },
		},
		mounted(){
			this.$nextTick(() => {
        this.updateData();
      });
      this.ready = true;
		},
		components: {
		  'appui-notes-forum-topic': {
        name: 'appui-notes-forum-topic',
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            forum: bbn.vue.closest(this, 'appui-notes-forum'),
            currentLimit: this.limit,
            start: 0,
            total: 0,
            limits: [10, 25, 50, 100, 250, 500],
            isLoading: false,
            showReplies: false,
            contentContainerHeight: 'auto'
          }
        },
        computed: {
          cutContentContainer(){
            return this.contentContainerHeight !== 'auto';
          }
        },
        methods: {
          toggleReplies(){
            if ( this.source.num_replies ){
              if ( this.showReplies ){
                this.showReplies = false;
                this.source.replies = false;
              }
              else {
                this.showReplies = true;
              }
            }
          }
        },
        mounted(){
          this.$nextTick(() => {
            if ( $(this.$refs.contentContainer).height() > 35 ){
              this.contentContainerHeight = '35px';
            }
          });
        },
        components: {
          'appui-notes-forum-post': {
            name: 'appui-notes-forum-post',
            props: {
              source: {
                type: Object
              }
            },
            data(){
              return {
                topic: bbn.vue.closest(this, 'appui-notes-forum-topic')
              }
            }
          },
          'appui-notes-forum-pager': {
            name: 'appui-notes-forum-pager',
            props: {
              source: {
                type: Object
              }
            },
            data(){
              return {
                topic: bbn.vue.closest(this, 'appui-notes-forum-topic'),
                currentLimit: 25,
                originalData: null,
                start: 0,
                total: 0,
                limits: [10, 25, 50, 100, 250, 500],
                isLoading: false
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
              },
              isAjax(){
                return this.topic.forum.isAjax;
              },
              pageable(){
                return this.topic.forum.pageable;
              }
            },
            methods: {
              updateData(withoutOriginal){
                if ( this.isAjax && !this.isLoading ){
                  this.isLoading = true;
                  this.$nextTick(() =>{
                    let data = {
                      limit: this.currentLimit,
                      start: this.start,
                      data: {id_alias: this.source.id}
                    };
                    bbn.fn.post(this.topic.forum.source, data, result =>{
                      this.isLoading = false;
                      if (
                        !result ||
                        result.error ||
                        ((result.success !== undefined) && !result.success)
                      ){
                        bbn.fn.alert(result && result.error ? result.error : bbn._("Error in updateData"));
                      }
                      else {
                        this.$set(this.source, 'replies', this.topic.forum._map(result.data || []));
                        if ( this.editable ){
                          this.originalData = JSON.parse(JSON.stringify(this.source.replies));
                        }
                        this.total = result.total || result.data.length || 0;
                        this.source.num_replies = this.total;
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
                  this.source.num_replies = this.total;
                }
              }
            },
            mounted(){
              this.$nextTick(() =>{
                this.updateData();
              });
            }
          }
        }
      }
    }
	}
})();
