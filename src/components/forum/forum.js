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
			pinnable: {
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
      },
      topicButtons: {
        type: Array,
        default(){
          return [];
        }
      },
      replyButtons: {
        type: Array,
        default(){
          return [];
        }
      },
      canLock: {
        type: Boolean,
        default: true
      }
		},
		data(){
			return {
			  currentUser: appui.app.user.id,
				currentData: [],
				currentLimit: this.limit,
				currentFilters: bbn.fn.extend({}, this.filters),
				originalData: null,
				start: 0,
        total: 0,
				limits: [10, 25, 50, 100, 250, 500],
				isLoading: false,
        isAjax: typeof(this.source) === 'string',
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
          //ar = $.isFunction(this.toolbar) ?
          ar = typeof(this.toolbar) === 'function' ?
            this.toolbar() : (
              Array.isArray(this.toolbar) ? this.toolbar.slice() : []
            );
          if ( Array.isArray(ar) ){
            bbn.fn.each(ar, (a, i) => {
              let o = bbn.fn.extend({}, a);
              if ( o.action ){
                o.action = () => {
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
        if ( button.action ){
          //if ( $.isFunction(button.action) ){
          if ( typeof(button.action) === "function" ){  
            return button.action(data);
          }
          else if ( typeof(button.action) === 'string' ){            
            switch ( button.action ){
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
        //return this.map ? $.map(data, this.map) : data;
        return this.map ? bbn.fn.map(data, this.map) : data;
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
      hasEditUsers(users){
		    if ( users ){
          let u = users.split(',');
          if ( u.length > 1 ){
            return true;
          }
        }
        return false;
      },
      usersNames(creator, users, number){
        let ret = appui.app.getUserName(creator.toLowerCase()) || bbn._('Unknown'),
            u;
        if ( users ){
          u = users.split(',');
          if ( number ){
            return u.length;
          }
          if ( u.length > 1 ){
            u.forEach((v) => {
              if ( v !== creator ){
                ret += ', ' + appui.app.getUserName(v.toLowerCase()) || bbn._('Unknown');
              }
            });
          }
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
              data: this.data ? ( typeof(this.data) === "function" ? this.data() : this.data) : {}
            };
            if ( this.filterable ){
              data.filters = this.currentFilters;
            }
            this.post(this.source, data, result => {
              this.isLoading = false;
              if (
                !result ||
                result.error ||
                ((result.success !== undefined) && !result.success)
              ){
                appui.alert(result && result.error ? result.error : bbn._("Error while updating the data"));
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
          this.post_out(this.downloadUrl + id);
        }
      },
    },
    watch: {
      currentFilters: {
        deep: true,
        handler(){
          this.$nextTick(() => {
            this.updateData();
          });
        }
      },
      filters: {
        deep: true,
        handler(){
          this.$nextTick(() => {
            this.updateData();
          });
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
            contentContainerHeight: 'auto',
						possibleHiddenContent: false
          }
        },
        computed: {
          cutContentContainer(){
            return this.contentContainerHeight !== 'auto';
          },
          cutContent(){
            return bbn.fn.html2text(this.source.content).replace(/\n/g, ' ');
          }
        },
        methods: {
					showContentContainer(val){
						this.contentContainerHeight = val;
					},
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
            // if ( this.getRef('contentContainer').clientHeight > 35 ){
            if ( this.getRef('contentContainer').getClientRects()[0].height > 35 ){
              this.contentContainerHeight = '35px';
							this.possibleHiddenContent = true;
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
                    this.post(this.topic.forum.source, data, result =>{
                      this.isLoading = false;
                      if (
                        !result ||
                        result.error ||
                        ((result.success !== undefined) && !result.success)
                      ){
                        appui.alert(result && result.error ? result.error : bbn._("Error while updating the data"));
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