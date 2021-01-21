// Javascript Document// Javascript Document
(() => {
  return {
    data(){
      return {
        types: [{
          text: bbn._('Page'),
          value: 'pages'
        }, {
          text: bbn._('Post'),
          value: 'post'
        }],
        //for table note
        cols: [{
          field: 'title',
          title: bbn._('Title'),
        },{
          field: 'id_user',
          title: bbn._('Creator'),
          source: appui.app.users
        },{
          field: 'url',
          title: bbn._('URL'),
          render: this.renderUrl,
          cls: 'bbn-c'
        }, {
          field: 'content',
          title: bbn._('Content'),
          filterable: false,
          render: this.renderContent
        }, {
          field: 'creation',
          type: 'date',
          title: bbn._('Creation')
        },{
          field: 'start',
          type: 'datetime',
          title: bbn._('Pub. Start')
        }, {
          field: 'end',
          type: 'datetime',
          title: bbn._('Pub. End')
        }, {
          width : 80,
          field: 'version',
          title: bbn._('Version'),
          cls: 'bbn-c'
        }, {
          width : 30,
          field: 'files',
          title: '',
          render: this.renderFiles,
          cls: 'bbn-c'
        }, {
          width : 150,
          buttons: this.getBtns,
          title: bbn._('Actions'),
          cls: 'bbn-c'
        }]
      }
    },
    methods: {
      renderFiles(row){
        if(row.files && row.files.length){ 
          return '<i class="nf nf-mdi-attachment" title="'+row.files.length + ' '+ bbn._('media')+ '"><i>'
        }
        else{
          return '-'
        }
        bbn.fn.log(row.files)
      },
      renderContent(row){
        if ( row.content.length > 100 ) {
          return row.content.substring(0,100);
        }
        else{
          return row.content;
        }
      },
      //Methods call of the menu in toolbar
      //FILE
      insertNote(){
        this.getPopup().open({
          width: 800,
          height: '80%',
          title: bbn._('New Note'),
          source:{
            action: 'insert', 
            title: '', 
            start: null, 
            end: null, 
            url: '', 
            content: '', 
            files: []
          },
          component: this.$options.components['form'],
        })
      },
      getBtns(row){
        return [{
          action: this.editNote,
          icon: 'nf nf-fa-edit',
          notext: true
        }, {
          action: this.publishNote,
          icon: 'nf nf-fa-chain',
          notext: true,
          disabled: row.is_published
        }, {
          action: this.unpublishNote,
          icon: 'nf nf-fa-chain_broken',
          notext: true,
          disabled: !row.is_published
        },{
          action: this.addMedia,
          icon: 'nf nf-mdi-attachment',
          notext: true
        }, {
          action: this.deleteNote,
          icon: 'nf nf-fa-trash_o',
          notext: true
        }];
      },
      //open the browser from table
      addMedia(row){
        this.getPopup().open({
          title: bbn._('Media browser'),
          height: '80%',
          width: '80%',
          component: this.$options.components['browser'], 
          scrollable: false,
          source: row, 
          
        })
      },
      // methods each row of the table
      editNote(row){
        let src =  bbn.fn.extend(row,{
          action: 'update'
        });
        
        this.getPopup().open({
          width: 800,
          height: '80%',
          title: bbn._('Edit Note'),
          source: src,
          component: this.$options.components['form'],
        })
      },
      publishNote(row){
        let src =  bbn.fn.extend(row,{
          action: 'publish'
        });
        bbn.fn.happy('src')
        bbn.fn.log(src)
        this.getPopup().open({
          width: 800,
          height: '80%',
          title: bbn._('Publish Note'),
          source: src,
          component: this.$options.components['form'],
        })
      },
      unpublishNote(row){
        appui.confirm(bbn._('Are you sure to remove the publication from this note?'), () => {
          bbn.fn.post(this.source.root + 'cms/actions/unpublish',{id: row.id_note }, d =>{
            if ( d.success ){
              this.getRef('table').reload();
              appui.success(bbn._('Successfully deleted'));
            }
            else{
              appui.error(bbn._('Error in deleting'));
            }
          });
        });
      },
      deleteNote(row){
        appui.confirm(bbn._('Are you sure to delete this note?'), () => {
          bbn.fn.post(this.source.root + "cms/actions/delete",{id: row.id_note }, (d) =>{
            if ( d.success ){
              this.getRef('table').reload();
              appui.success(bbn._('Successfully deleted'));
            }
            else{
              appui.error(bbn._('Error in deleting'));
            }
          });
        });
      },
      //SHOW
      filterTable(type){
        let table = this.getRef('table'),
            idx = bbn.fn.search(table.currentFilters.conditions, 'field', 'type');
        if ( idx > -1 ){
          table.$set(table.currentFilters.conditions[idx], 'value', type);
        }
        else {
          table.currentFilters.conditions.push({
            field: 'type',
            value: type
          });
        }
      },
  
      // function of render
      renderUrl(row){
        if ( row.url !== null ){
          return '<a href="' + this.source.root + 'cms/preview/' + row.url +'" target="_blank">' + row.url + '</a>';
        }
        return '-';
      },
    },
    created(){
      appui.register('publications', this);
    },
    beforeDestroy(){
      appui.unregister('publications');
    },
    components: {
      'browser' :{
        props: ['source'],
        template: '<appui-note-media-browser @select="insertMedia" :select="true"></appui-note-media-browser>',
        data(){
          return {
            root: this.closest('bbn-container').getComponent().source.root
          }
        },
        computed:{
          selected(){
            return this.find('appui-note-media-browser').selected
          }
        },
        methods: {
          insertMedia(m){
            m.extension = '.' + m.content.extension
            /*if (m.content){
              m.content = JSON.stringify(m.content)
            }*/
            //case inserting media during update
						if ( this.source.id_note ){
              this.post(this.root + '/cms/actions/add_media', {
                id_note: this.source.id_note, 
                id_media: m.id, 
                version: this.source.version
              }, (d) => {
                if ( d.success ){
                  this.source.files.push(m)
                  appui.success(bbn._('Media correctly added to the note'));	        
                }
                else {
                  appui.success(bbn._('Something went wrong while adding the media to the note'));
                } 
              })
            }
            //case adding media while inserting note
						else{
              this.source.files.push(m)
            }
            this.closest('bbn-popup').close()
          }
        },
      },
      'toolbar' : {
        template: '#toolbar',
        props: ['source'],
        data(){
          return {
            cp: appui.getRegistered('publications'),
          }
        }, 
        methods:{
          insertNote(){
            return this.cp.insertNote();
          }
        }
      },
      'form': {
        template: '#form',
        props: ['source'],
        data(){
          return {
            medias: [],
            url: this.closest('bbn-container').getComponent().source.root + "cms/actions/"+this.source.action,
            root: this.closest('bbn-container').getComponent().source.root,
            cp: appui.getRegistered('publications'),
            publish: false, 
          }
        },
        computed:{
          date(){
            return moment(moment().toISOString()).unix()
          }
        },
        methods: {
          addMedia(){
            this.getPopup().open({
              title: bbn._('Media browser'),
              height: '80%',
              width: '80%',
              component: this.cp.$options.components['browser'], 
              scrollable: false,
              source: this.source
            })
          },
          adjustURL(e){
            if (
              //does not adjust if the key pressed is '-' 
               (e.keyCode !== 189) &&
               (this.source.url.lastIndexOf('-') + 1 !== this.source.url.length )
             ){
              let tmp = this.source.url.replace('notes/post/', '');
              if ( tmp !== bbn.fn.makeURL(tmp)){
                this.source.url = 'notes/post/' + bbn.fn.makeURL(tmp) 
              }
            }
          },
          makeURL(){
            if ( this.source.url.length ){
              if ( this.source.url.indexOf('notes/post/') !== 0 ){
                bbn.fn.log('  qui dentro')
                this.source.url = 'notes/post/' + bbn.fn.makeURL(this.source.url)  
              }
              if ( this.source.url === 'notes/post/'){
                this.source.url = 'notes/post/' + bbn.fn.makeURL(this.source.title)  
              }
            }
            else{
              this.source.url = 'notes/post/' + bbn.fn.makeURL(this.source.title)
            }
          },
          validationForm(){
            if ( this.source.title.length ){
              if ( this.source.url ){
                if ( (this.source.url.lastIndexOf('-') + 1) === this.source.url.length ){
                  this.source.url = bbn.fn.makeURL(this.source.url)
                }
                return true;
              }
            }
            else{
              appui.error(bbn._('Enter a title for the note'));
              return false;
            }
          },
          afterSubmit(d){
            if ( d.success ){
              this.closest('bbn-container').getComponent().getRef('table').reload();
              appui.success(bbn._('Saved'));
            }
            else if(d.error && d.error.length) {
              appui.error(d.error)
              this.closest('bbn-container').getComponent().getRef('table').reload();
              
              
            }
          }
        },
        watch: {
          publish(val){
            if ( !val ){
              this.source.start = null;
              this.source.end = null; 
            }
            else{
              if ( !this.source.start ){
                this.source.start = moment().format("YYYY/MM/DD HH:mm:ss");
              }
            }
          }, 
        },
        mounted(){
          this.publish = (this.source.action === 'update') ? this.source.is_published : ((this.source.action === 'publish') ? true : false);
          this.source.url = this.source.url.length ? this.source.url : 'notes/post/' + bbn.fn.makeURL(this.source.title)
        }, 
      },
    }
  }
})();