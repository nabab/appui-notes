(() => {
  return {
    data(){
      return {        
        root: appui.plugins['appui-notes'] + '/',
        //configuration for menu in toolbar
        sourceMenu: [{
            text: bbn._('New'),
            items: [{
              icon: 'nf nf-fa-plus',
              text: "<i class='nf nf-fa-plus'></i>" + bbn._('Page'),
              action: this.insertPage
            }]
          },{            
            text: bbn._('Show'),           
            items: [{
              icon: 'nf nf-fa-search',
              text: "<i class='nf nf-fa-search'></i>" + bbn._('Find'),
              action: this.filterTable
            }]            
          },{
            text: bbn._('Tools'),
            items: [{
              icon: 'nf nf-mdi-import',
              text: "<i class='nf nf-mdi-import'></i>" + bbn._('Import'),
              action: this.importPage
            }, {
              icon: 'nf nf-mdi-export',
              text: "<i class='nf nf-mdi-export'></i>" + bbn._('Export'),
              action: this.exportPage              
            }]
        }], 
        //for table note
        cols: [{ 
            field: 'title',            
            title: bbn._('Title'),
          }, {
            width: 150,
            field: 'id_user',            
            title: bbn._('Creator'),
            source: appui.app.users
          },{
            width: 300,
            field: 'url',
            title: bbn._('URL'),
            render: this.renderUrl,
            cls: 'bbn-c'
          }, {
            width: 600,
            field: 'content',            
            title: bbn._('Content'),            
            filterable: false
          }, {
            width: 100,           
            field: 'creation',            
            type: 'date',            
            title: bbn._('Creation')            
          }, {
            width : 50,
            field: 'version',            
            title: bbn._('Version'),
            cls: 'bbn-c'
        }]
      }
    },
    methods: {  
      //Methods call of the menu in toolbar    
      //FILE
      insertPage(){
        this.getPopup().open({
          width: 800,
          height: 600,
          title: bbn._('New Note'),
          component: this.$options.components['new-page'],
        })
      },
      //SHOW
      filterTable(){
        alert("Filter");
      },
      //TOOLS
      importPage(){
        this.getPopup().open({
          width: '90%',
          height: '90%',
          scrollable: false,
          title: bbn._('New Note'),
          component: this.$options.components['import-page'],
          source: this.source
        })
      },
      exportPage(){
        alert("Export Page")
      },
      // function of render
      renderUrl(row){
        if ( row.url !== null ){
          return '<a href="' + row.url +'">' + row.url + '</a>';
        }
        return '-';
      },
    },
    components: {
      'new-page': {
        template: '#appui-notes-new-page',
        props: ['source'],              
        data(){
          return {        
            root: appui.plugins['appui-notes'],        
            formData: {
              title: '',
              start: '',
              end: '',
              content: '',
              url: ''
            }              
          }
        },              
        methods: {
          validationForm(){
            if ( this.formData.title.length ){
              return true;
            }
            else{
              appui.error(bbn._('Enter a title for the note'));
              return false;
            }
          },            
          afterSubmit(d){      
            if ( d.success ){
              appui.success(bbn._('Saved'));
            }
            else {
              appui.error();
            }
          }
        }     
      },
      'import-page': {
        template: '#appui-notes-import-page',
        props: ['source'],
        data(){
          return {     
            root: appui.plugins['appui-notes'] + '/',
            selected : false,
            //for table wp_posts
            colsTable: [
              { 
                field: "ID",
                title: bbn._("ID"),            
                cls: "bbn-c",                          
                width: 50    
              }, {              
                field: 'post_type',            
                title: bbn._('Type'),
                cls: 'bbn-c',
                source: this.source.types
              }, {              
                field: 'post_name',            
                title: bbn._('Post name'),            
                cls: 'bbn-c'              
              }, {           
                field: 'url_complete',
                title: bbn._('URL'),  
                render: this.renderUrl,
                minWidth : 300
              }, {              
                field: 'post_title',            
                title: bbn._('Post title')
              }, {
                field: 'post_content',
                title: bbn._('Content'),
                cls: 'bbn-c',
                minWidth : 300,
                filterable: false
              }, {
                field: 'display_name',
                title: bbn._('Author'),
                width: 150,
              }, {
                field: 'post_date',            
                title: bbn._('Date'),
                type: 'date',
                width : 90,
              }, {
                field: 'post_date_gmt',
                title: bbn._('Date GMT'),
                type: 'date',
                width: 90,
              }, {
                field: 'post_modified',            
                title: bbn._('Modified'),
                type: 'date',
                width: 90,
              }, {
                field: 'post_status',
                title: bbn._('Post Status'),            
                width: 100,
                cls: "bbn-c",
                source: this.source.statuses
              }
            ]     
          }
        },
        methods:{
          selectPost(){            
            this.$set(this, 'selected', true);
          },
          unselectPost(){
            if ( this.$refs.table.currentSelected.length === 1 ){
              this.$set(this, 'selected', false);
            }
          },
          renderUrl(row){
            if ( row.url !== null ){
              return '<a href="' + row.url +'">' + row.url + '</a>';
            }
            return '-';
          },
          closePopUp(){
            this.closest('bbn-floater').close();            
          },
          importPage(){
            let table = this.$refs.table,
                importPages = [];            
            bbn.fn.each( table.currentSelected, (idx,i)=>{
              importPages.push(table.currentData[idx]['data']);
            });

            if ( importPages.length ){
              this.confirm(bbn._('Are you sure you import the posts?'), () => {
                this.post(this.root+'actions/publications/import',{imports: importPages}, d =>{
                  if ( d.success ){
                    appui.success(bbn._('Import performed'));
                    this.$nextTick(()=>{
                      this.closest('bbn-container').getComponent().$refs.table.reload();
                    });
                  }
                  else{
                    appui.success(bbn._('Error Import'));
                  }
                  this.$nextTick(()=>{
                    this.closePopUp();
                  });
                })
              });              
            }            
          }         
        }          
      }
    }
  }
})();